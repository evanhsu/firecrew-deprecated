<?php

namespace App\Http\Controllers\Status;

use App\Domain\Crews\Crew;
use App\Domain\Statuses\Coordinate;
use App\Domain\Statuses\CrewStatus;
use App\Domain\Statuses\ResourceStatus;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class CrewStatusController extends Controller
{
    /**
     * Display the Crew Status update form
     * Note: this form POSTS its response to the StatusController
     *
     * @param Request $request
     * @param $crewId
     * @param null $tailnumber
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function newStatus(Request $request, $crewId, $tailnumber = null)
    {
        // Retrieve the requested Crew with the latest CrewStatus
        $crew = Crew::findOrFail($crewId);

        // Make sure this user is authorized...
        if (Gate::denies('act-as-admin-for-crew', $crewId)) {
            return redirect()->back()->withErrors("You're not authorized to update that crew's status!");
        }

        // Retrieve the most recent status update to prepopulate the form (returns a 'new Status' if none exist)
        $crew->load('status');
        $resources = $crew->resourcesWithLatestStatus;

        // Convert the lat and lon from decimal-degrees into decimal-minutes
        $modifiedResources = $resources->map(function ($resource, $index) {
            if(is_null($resource->latestStatus)) {
                $resource->latestStatus = new ResourceStatus();
            }
            $coords = (new Coordinate($resource->latestStatus->latitude, $resource->latestStatus->longitude))->asDecimalMinutes();
            $resource->latestStatus->latitude_deg = $coords['latitude']['degrees'];
            $resource->latestStatus->latitude_min = $coords['latitude']['minutes'];
            $resource->latestStatus->longitude_deg = $coords['longitude']['degrees'];
            $resource->latestStatus->longitude_min = $coords['longitude']['minutes'];
            return $resource;
        });

        // Authorization complete - continue...
        // Display the status update form
        if (Auth::user()->isGlobalAdmin()) {
            $request->session()->flash('active_menubutton', 'crews'); // Tell the menubar which button to highlight
        } else {
            $request->session()->flash('active_menubutton', 'status'); // Tell the menubar which button to highlight
        }

        return view('status_forms/status')->with('crew', $crew)->with('resources', $modifiedResources)->with('tailnumber', $tailnumber);
    }


    /**
     * Receive a post request from the Crew Status form (Intel) and create a new CrewStatus.
     *
     * @param Request $request
     * @param $crewId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, $crewId)
    {
        $crew = Crew::findOrFail($crewId);
        $status = new CrewStatus($request->all());

        $status->created_by_name = Auth::user()->name;
        $status->created_by_id = Auth::user()->id;

         // Attempt to save
        if($crew->statuses()->save($status)) {
            return redirect()->back()->with('alert', array('message' => 'Status update saved!', 'type' => 'success'));
        }
        return redirect()->back()->with('alert', array('message' => 'Status update failed!', 'type' => 'danger'));
    }
}