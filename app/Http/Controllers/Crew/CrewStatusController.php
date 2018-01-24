<?php

namespace App\Http\Controllers\Crew;

use App\Domain\Crews\Crew;
use App\Domain\Statuses\Status;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class CrewStatusController extends Controller
{
    /**
     * Show the most recent Status for this Crew
     *
     * @param $id
     */
    public function showCurrentStatus($id) {

        // Make sure this user is authorized...
        // TODO: Move authorization logic to a Policy
        if(Gate::denies('can-act-as-admin-for-crew', $id)) {
            // The current user does not have permission to perform admin functions for this crew
            // return redirect()->back()->withErrors("You're not authorized to access that crew!");
            echo "Access denied.";
        }

        $status = Status::first();

        echo "Looking for tailnumber: ".$status->statusable_name."<br />\n"
            .var_export($status, true);
    }

    /**
     * Display the Crew Status update form
     * Note: this form POSTS its response to the StatusController
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function newStatus(Request $request, $id)
    {
        // Retrieve the requested Crew
        $crew = Crew::findOrFail($id);

        // Make sure this user is authorized...
        if (Gate::denies('act-as-admin-for-crew', $id)) {
            return redirect()->back()->withErrors("You're not authorized to update that crew's status!");
        }

        // Retrieve the most recent status update to prepopulate the form (returns a 'new Status' if none exist)
        $last_status = $crew->status();

        // Convert the lat and lon from decimal-degrees into decimal-minutes
        // TODO: MOVE THIS FUNCTIONALITY INTO A COORDINATES CLASS
        if (!empty($last_status->latitude)) {
            $sign = $last_status->latitude >= 0 ? 1 : -1; // Keep track of whether the latitude is positive or negative
            $last_status->latitude_deg = floor(abs($last_status->latitude)) * $sign;
            $last_status->latitude_min = round((abs($last_status->latitude) - $last_status->latitude_deg) * 60.0, 4);

        } else {
            $last_status->latitude_deg = "";
            $last_status->latitude_min = "";
        }

        if (!empty($last_status->longitude)) {
            $sign = $last_status->longitude >= 0 ? 1 : -1; // Keep track of whether the longitude is positive or negative
            $last_status->longitude_deg = floor(abs($last_status->longitude)) * $sign * -1; // Convert to 'West-positive' reference
            $last_status->longitude_min = round((abs($last_status->longitude) - $last_status->longitude_deg) * 60.0, 4);
        } else {
            $last_status->longitude_deg = "";
            $last_status->longitude_min = "";
        }

        // Authorization complete - continue...
        // Display the status update form
        if (Auth::user()->isGlobalAdmin()) {
            $request->session()->flash('active_menubutton', 'crews'); // Tell the menubar which button to highlight
        } else {
            $request->session()->flash('active_menubutton', 'status'); // Tell the menubar which button to highlight
        }
        return view('status_forms/crew')->with('crew', $crew)->with('status', $last_status);
    }


    /**
     * Redirect to either:
     *   - The Crew Status Update form (CrewController@newStatus)
     *   - The Aircraft Status Update form for the most-recently updated aircraft that this Crew owns (AircraftController@newStatus)
     *
     * @param $id
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function redirectToStatusUpdate($id)
    {

        // Make sure this user is authorized...
        /*  if(Auth::user()->cannot('actAsAdminForCrew', $id)) {
                // The current user does not have permission to perform admin functions for this crew
                return redirect()->back()->withErrors("You're not authorized to access that crew!");
            }
        */
        // Authorization complete - continue...
        $crew = Crew::findOrFail($id);

        // Decide where to redirect in the following order:
        //   1. Go to a New Status for the resource that was most-recently updated by this user.
        //   2. If the Crew is statusable, go to the New Status form for the crew.
        //   3. If the Crew has aircrafts that are statusable, go to the New Status form for the Aircraft with highest alphabetical priority.
        //   4. If the Crew is supposed to have statusable aircrafts but none are assigned, go to the Edit Crew form with an error message.

        // Step 1
        $user = Auth::user();
        $last_status_from_user = $user->lastStatus();

        if (!is_null($last_status_from_user) && Gate::allows('act-as-admin-for-crew', $last_status_from_user->crewToUpdate())) {
            $route_params = $last_status_from_user->redirectToNewStatus();
            return redirect()->route($route_params['route_name'], $route_params['id']);
        } // Step 2
        elseif ($crew->is_not_an_aircraft_crew()) {
            return redirect()->route('new_status_for_crew', $id);
        } // Step 3|4
        elseif ($crew->is_an_aircraft_crew()) {
            // Look for the first Aircraft owned by this Crew
            $aircraft = $crew->aircrafts()->orderBy('tailnumber')->first();
            if (is_null($aircraft)) {
                // Step 4 (This crew is supposed to have aircrafts, but none were found)
                return redirect()->route('edit_crew', $id)->withErrors("You must add an aircraft to your crew before you can post a status update.");
            } else {
                // Step 3 (This crew has at least one aircraft)
                return redirect()->route('new_status_for_aircraft', $aircraft->tailnumber);
            }
        } else {
            // This crew has a statusable_entity OTHER than 'crew' or 'aircraft'
            // THIS FUNCTIONALITY STILL NEEDS TO BE CREATED
            return redirect()->route('edit_crew', $id)->withErrors("This Crew type hasn't been implemented yet - CrewController@redirectToStatusUpdate");
        }
    }
}