<?php

namespace App\Http\Controllers;

use App\Domain\Aircrafts\Aircraft;
use App\Domain\Crews\Crew;
use App\Domain\Statuses\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Form;
use App\Domain\Users\User;
use Illuminate\Support\MessageBag;

class CrewController extends Controller
{
    /**
     * Show the most recent Status for this Crew
     */
    public function showCurrentStatus($id) {

        // Make sure this user is authorized...
        if(Gate::denies('can-act-as-admin-for-crew', $id)) {
            // The current user does not have permission to perform admin functions for this crew
//            return redirect()->back()->withErrors("You're not authorized to access that crew!");
            echo "Access denied.";
        }

        $status = Status::first();

        echo "Looking for tailnumber: ".$status->statusable_name."<br />\n"
            .var_export($status, true);
    }

    /**
     * Display the Crew Status update form
     * Note: this form POSTS its response to the StatusController
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
        // MOVE THIS FUNCTIONALITY INTO A COORDINATES CLASS
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
     * $id  The ID of a Crew
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

    /**
     * Display all User Accounts for this Crew
     */
    public function accounts(Request $request, $id)
    {
        if (Gate::denies('act-as-admin-for-crew', $id)) {
            // The current user does not have permission to perform admin functions for this crew
            return redirect()->back()->withErrors("You're not authorized to access that crew!");
        }

        // Authorization complete - continue...
        $crew = Crew::findOrFail($id);
        $users = User::where('crew_id', $id)
            ->orderBy('name', 'asc')
            ->get();

        $request->session()->flash('active_menubutton', 'accounts'); // Tell the menubar which button to highlight
        return view('crews.accounts', ['crew' => $crew,
            'users' => $users]);
    }

    /**
     * Display a listing of all crews (requires a global_admin user)
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!Auth::user()->isGlobalAdmin()) {
            // Only Global Admins can access this
            return redirect()->back()->withErrors("Unauthorized");
        }

        $crews = Crew::orderBy('name', 'asc')->get();
        $request->session()->flash('active_menubutton', 'crews'); // Tell the menubar which button to highlight
        return view('crews.index', ['crews' => $crews]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Auth::user()->isGlobalAdmin()) {
            // Only Global Admins can access this
            return redirect()->back()->withErrors("Unauthorized");
        }

        return view('crews.new');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if (!Auth::user()->isGlobalAdmin()) {
            // Only Global Admins can access this
            return redirect()->back()->withErrors("Unauthorized");
        }

        $this->validate($request, [
            'name' => 'required|unique:crews|max:255']);

        // Form is valid, continue...
        $crew = new Crew(Input::all());
        $crew->statusable_type = $request->input('statusable_type'); // Must be fully namespaced, i.e. "App\Domain\Crews\Crew"

        if ($crew->save()) {
            return redirect()->route('crews_index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        return view('crew.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        //
        if ($crew = Crew::findorfail($id)) {
            // Make sure this user is authorized...
            if (Gate::denies('act-as-admin-for-crew', $id)) {
                // The current user does not have permission to perform admin functions for this crew
                return redirect()->back()->withErrors("You're not authorized to access that crew!");
            }

            // Authorization complete - continue...
            if (Auth::user()->isGlobalAdmin()) {
                $request->session()->flash('active_menubutton', 'crews'); // Tell the menubar which button to highlight
            } else {
                $request->session()->flash('active_menubutton', 'identity'); // Tell the menubar which button to highlight
            }

            // Decide whether to show the Aircraft section of the Edit Crew form:
            $show_aircraft = $crew->is_an_aircraft_crew();

            return view('crews.edit')->with('crew', $crew)->with('show_aircraft', $show_aircraft);
        }
        $errors = new MessageBag(['Crew' => ['That Crew doesn\'t exist.']]);
        //return redirect()->route('not_found')->withErrors($errors);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Make sure this user is authorized...
        if (Gate::denies('act-as-admin-for-crew', $id)) {
            // The current user does not have permission to perform admin functions for this crew
            return redirect()->back()->withErrors("You're not authorized to access that crew!");
        }

        // Authorization complete - continue...


        // Grab the form input
        $crew_fields = array_except($request->input('crew'), ['aircrafts']);

        $crew = Crew::find($id);

        // Deal with a logo file upload
        if ($request->hasFile('logo')) {
            if ($request->file('logo')->isValid()) {
                $filename = "crew_" . $id . "_logo.jpg";
                $request->file('logo')->move('logos', $filename);
                $crew_fields['logo_filename'] = '/logos/' . $filename;
            }
            // *** Add error handling for the file upload ***
        }

        // Save any changes to the Crew model
        $crew->update($crew_fields);
        // *** Add error handling/validation for the Crew model


        // Deal with the Aircraft fields:
        // For each Aircraft on the form, create new or update the existing Aircraft in the dB if necessary
        // (don't update the model if nothing has changed)
        $aircraft_fields = array();

        if (isset($request->input('crew')['aircrafts'])) {
            $aircraft_fields = $request->input('crew')['aircrafts'];
        }

        foreach ($aircraft_fields as $aircraft) {
            if (!empty($aircraft['tailnumber'])) {
                // Instantiate a new Aircraft - CONVERT TAILNUMBER TO ALL CAPS IN THE DATABASE
                $temp_heli = Aircraft::firstOrCreate(array('tailnumber' => strtoupper($aircraft['tailnumber'])));

                $aircraft['crew_id'] = $id;

                $temp_heli->updateIfChanged($aircraft);
                // An error occurred during updateIfChanged()
                // Go back to the form and display errors
                // return redirect()->route('edit_crew', $crew->id)
                //->withErrors($temp_heli->errors())
                //            ->withInput();
            }
        }

        // Everything completed successfully
        return redirect()->route('edit_crew', $crew->id)->with('alert', array('message' => 'Crew info saved!', 'type' => 'success'));
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Gate::denies('act-as-admin-for-crew', $id)) {
            // Only Global Admins can access this
            return redirect()->back()->withErrors("Unauthorized");
        }

        $crew = Crew::find($id);
        $crew_name = $crew->name;

        // Release all Aircrafts from this crew (null the crew_id field in the aircrafts table)
        if ($crew->is_an_aircraft_crew()) {
            $aircrafts = $crew->aircrafts;
            foreach ($aircrafts as $aircraft) {
                $aircraft->release();
            }
        }

        // Delete all Users belonging to this crew
        foreach ($crew->users as $user) {
            $user->delete();
        }

        $crew->delete();
        return redirect()->route('crews_index')->with('alert', array('message' => "'" . $crew_name . "' was deleted.", 'type' => 'success'));
    }
}
