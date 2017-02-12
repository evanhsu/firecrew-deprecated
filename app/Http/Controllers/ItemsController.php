<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Domain\Crews\Crew;

class ItemsController extends Controller
{
    //
    public function indexForCrew($crewId) {

    	$crew = Crew::find($crewId);
    	$items = $crew->items;

    	return view('inventory', $items);
    }

    public function indexForPerson($personId) {

    }

    public function show($id) {

    }

    public function update($id, $request) {

    }
}
