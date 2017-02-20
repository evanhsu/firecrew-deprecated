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

    public function indexForCrew(Request $request, $crewId) {

    	$crew = Crew::find($crewId);
        $items = $this->items->ofCategory($crew, $request->input('category'));
        $categoryItems = [
            "category" => [
                "name"  => $request->input('category'), 
                "items"     => $items,
            ],
        ];
        $categories = $this->items->categories($crew);

        switch($request->input('format')) {
            case 'json':
                return $categoryItems;
                break;

            case 'html':
            default:
                return view('items.index', [
                    'items'=> $categoryItems
                ]);
                break;
        }
    }

    public function indexForPerson($personId) {

    }

    public function show($id) {

    }

    public function update($id, $request) {

    }
}
