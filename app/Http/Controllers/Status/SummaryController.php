<?php

namespace App\Http\Controllers\Status;

use App\Http\Controllers\Controller;
use App\Domain\Crews\Crew;
use Illuminate\Http\Request;

class SummaryController extends Controller
{
    /**
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $crews = Crew::with(['status', 'statusableResources.latestStatus'])->get();

        $request->session()->flash('active_menubutton', 'summary'); // Tell the menubar which button to highlight

        return view('summary')->with('crews', $crews);
    }
}
