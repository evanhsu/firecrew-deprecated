<?php

namespace App\Http\Controllers\Status;

use App\Http\Controllers\Controller;
use App\Domain\Crews\Crew;

class SummaryController extends Controller
{
    /**
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $crews = Crew::with(['status', 'statusableResources.latestStatus'])->get();
        return view('summary')->with('crews', $crews);
    }
}
