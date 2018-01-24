<?php

namespace App\Http\Controllers\Crew;

use App\Domain\Aircrafts\Aircraft;
use App\Domain\Crews\Crew;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\MessageBag;


/**
 * Class CrewController
 * @package App\Http\Controllers\Crew
 */
class CrewController extends Controller
{
    /**
     * Display a listing of all crews (requires a global_admin user)
     *
     * @param Request $request
     * @return \Illuminate\View\View
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
