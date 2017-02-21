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
        if($request->input('category')) {
            $items = $this->items->ofCategory($crew, $request->input('category'));
            $response = [
                "category" => [
                    "name"  => $request->input('category'), 
                    "items"     => $items,
                ]
            ];
        } else {
            $categories = $this->items->byCategory($crew);
            $response = [
                "categories" => $categories,
            ];
        }

        switch($request->input('format')) {
            case 'json':
                return $response;
                break;

            case 'html':
            default:
                return view('items.index', [
                    'items'=> []
                ]);
                break;
        }
    }

    public function categoriesForCrew($crewId) {
        $crew = Crew::find($crewId);
        $categories = $this->items->categories($crew);

        return $categories;
    }

    public function indexForPerson($personId) {

    }

    public function show($id) {

    }

    public function update($id, $request) {

    }
}
