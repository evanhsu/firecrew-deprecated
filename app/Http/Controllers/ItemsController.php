<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Domain\Crews\Crew;
use App\Services\ItemsService;

class ItemsController extends Controller
{
    protected $items;

    public function __construct(ItemsService $items)
    {
        $this->items = $items;
    }

    public function indexForCrew($crewId) {

    	$crew = Crew::find($crewId);
        $categories = $this->items->byCategory($crew);

    	return view('items.index', ['categories' => $categories]);
    }

    public function indexForPerson($personId) {

    }

    public function show($id) {

    }

    public function update($id, $request) {

    }
}
