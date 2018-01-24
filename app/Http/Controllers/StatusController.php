<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use App\Domain\Crews\Crew;
use App\Domain\Statuses\Status;

class StatusController extends Controller
{
    /**
     * This function responds to AJAX requests from the map to update all resources
     *
     * @return \Illuminate\Http\Response
     */
    public function currentForAllResources()
    {
        // 1. Retrieve the most recent Status for each resource that's been updated within the last 30 days.
        // 2. Package the response into a JSON object and return.

        $max_age = config('app.days_until_updates_expire');
        $earliest_date = Carbon::now()->subDays($max_age); // The oldest Status that will be displayed

        $resources = DB::table('statuses as newest')
                        ->leftjoin('statuses as newer', function($join) {
                            $join->on('newer.statusable_id','=','newest.statusable_id');
                            $join->on('newer.updated_at','>','newest.updated_at');
                            })
                        ->select('newest.*')
                        ->whereNull('newer.updated_at')
                        ->where('newest.updated_at','>=',$earliest_date)
                        ->get();

/*      Here's the raw SQL query for testing and debugging:

        select newest.* from
        statuses as newest
        left outer join statuses as newer
        on newer.statusable_id = newest.statusable_id
        and newer.updated_at > newest.updated_at
        where newer.updated_at IS NULL;
*/
        // sleep(4); // Test asynchronous loading on the map view
        return json_encode($resources);
    }

    /**
     * Store a newly created Status in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Accept a form post from either the Aircraft Status Form (route: 'new_status_for_aircraft')
        // or the Crew Status Form (route: 'new_status_for_crew')

        // Determine whether this is a status update for an Aircraft or a Crew
        // then store the ID of the Crew that owns this object.
        $classname = $request->get('statusable_type');
        $obj = $classname::find($request->get('statusable_id'));
        if(!$obj) {
            // The 'statusable_type' from the form is not one of the polymorphic 'statusable' classes.
            // Add the 'morphMany()' function to the desired class to make it statusable.
            return redirect()->back()->with('alert', array('message' => 'Status update failed! This status update is not linked to a statusable entity', 'type' => 'danger'));
        }
        $crew_id = $obj->get_crew_id();
        $crew = Crew::find($crew_id);

        // Make sure current user is authorized
        if(Auth::user()->cannot('act-as-admin-for-crew', $crew_id)) {
            // The current user does not have permission to perform admin functions for this crew
            return redirect()->back()->withErrors("You're not authorized to update that crew!");
        }
        // This User is authorized - continue...

        $this->validate($request, [
            'latitude_deg' => 'required',
            'latitude_min' => 'required',
            'longitude_deg' => 'required',
            'longitude_min' => 'required'
            ]);

        $latitude_dd = $this->decMinToDecDeg($request->get('latitude_deg'), $request->get('latitude_min'));
        $longitude_dd = $this->decMinToDecDeg($request->get('longitude_deg'), $request->get('longitude_min')) * -1.0; // Convert to 'Easting' (Western hemisphere is negative)

        // Form is valid, continue...
        $status = new Status(Input::all());

        // Add a period to the LabelText field - this is a a workaround for the ArcGIS server to be able to render a buffer around the shorthaulhelicopter features
        $status->label_text = ".";

        // Insert the identity of the User who created this Status update (the CURRENT user):
        $status->created_by_name = Auth::user()->name;
        $status->created_by_id = Auth::user()->id;

        // Insert the name of the Crew that owns this Status update (if this Status refers to a Crew, then 'crew_name' will be the same as 'statusable_name')
        $status->crew_name = Crew::find($crew_id)->name;

        // Insert the lat and lon in decimal-degree format
        $status->latitude = $latitude_dd;
        $status->longitude = $longitude_dd;

        // Change the 'statusable_type' variable to a fully-namespaced class name (the html form only submits the class name, but not the namespace)
        // i.e. Change 'Shorthaulhelicopter' to 'App\Shorthaulhelicopter'. This is required for the Status class to be able to retrieve the correct Aircraft (or Crew).
        //$status->statusable_type = "App\\".ucwords($status->statusable_type);

        $status->created_at = date('Y-m-d H:m:s'); // Temporarily set the timestamp so that it can be included in the popup (timestamp will be reset when $status is saved)

        // Build the HTML popup that will be displayed when this feature is clicked
        $status->popup_content = $this->generatePopup($status, $crew);

        // Attempt to save
        if($status->save()) {
            return redirect()->back()->with('alert', array('message' => 'Status update saved!', 'type' => 'success'));

        /*
            // Changes have been saved to the local database, now initiate an update on the remote ArcGIS Server...
            // Render a different popup view to be sent to the EGP, but don't save it locally
            $status->popup_content = $this->generatePopup($status, $crew, "egp");

            $objectids = ArcServer::findFeature($status);
            if($objectids === false) {
                // An error occurred in findFeature() - check 'laravel.log' for details
                return redirect()->back()->with('alert', array('message' => 'Status update was saved locally, but could not be sent to the EGP (findFeature error).', 'type' => 'danger'));
            }
            elseif(!isset($objectids[0]) || ($objectids[0] == '')) {
                // The server responded, but the request feature was not found - add it.
                $result = ArcServer::addFeature($status);
            }
            else {
                // The Feature being updated was found on the ArcGIS server - now update it.
                $objectid = $objectids[0];
                $result = ArcServer::updateFeature($objectid,$status);
            }
            
            // Check the ArcGIS server response to determine if the operation was successful or not.
            if(empty($result->error)) {
                return redirect()->back()->with('alert', array('message' => 'Status update saved!', 'type' => 'success'));
            }
            else {
                return redirect()->back()->with('alert', array('message' => 'Status update was saved locally, but could not be sent to the EGP: '.$result->error, 'type' => 'danger'));
            }
        */
        }
        return redirect()->back()->with('alert', array('message' => 'Status update failed!', 'type' => 'danger'));
    }


    private function generatePopup($status, $crew, $folder = "local") {
        // Constructs the HTML that will be displayed when this Update Feature is clicked on the map view
        // The HTML string must be stored in this object's 'popup_content' property, which corresponds directly with a database field
        // that is used by the ArcGIS server to generate the popup for each Feature.
        //
        // This function relies on a Blade view template existing in the /resources/views/map_popups/ folder for each Class that
        // can have a status (e.g. Shorthaulhelicopter.blade.php, etc)
        //
        // $folder designates the subfolder within the /views/map_popups/ folder that will be searched for a matching View template.
        // This allows a different View to be rendered for local display versus the one that sent to the EGP database. 
        //
        // All properties of the Status object must be defined before calling this method.
        $v = view('map_popups.'.$folder.".".$status->statusable_type_plain())->with("status",$status)->with("crew",$crew)->render();
        $v_no_whitespace = preg_replace('/\s+/', ' ', $v); // Remove line-breaks, new-line and repeated spaces

        return $v_no_whitespace;
    }

    protected function decMinToDecDeg($deg, $min) {
        // Convert a latitude or longitude from DD MM.MMMM (decimal minutes)
        // to DD.DDDDD (decimal degrees) format
        return round(($deg * 1.0) + ($min / 60.0), 6);
    }
}
