<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Domain\Crews\Crew;
use App\Services\ItemsService;
use App\Domain\Items\Item;
use App\Http\Transformers\ItemTransformer;

class ItemsController extends Controller
{
    protected $items;

    public function __construct(ItemsService $items)
    {
        $this->items = $items;
    }

    /**
     *  Returns a flat collection of ALL items belonging to the specified Crew
     *
     */
    public function indexForCrew(Request $request, $crewId) {

        $crew = Crew::find($crewId);
        if($request->input('category')) {
            $items = $this->items->ofCategory($crew, $request->input('category'));
        } else {
            $items = $this->items->byCrew($crew);
        }

        return $this->response->collection(
            $items,
            new ItemTransformer,
            ['key' => 'item']
        );
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

    public function incrementItemQuantity($itemId) {
        $item = Item::findOrFail($itemId);
        $this->items->incrementQuantity($item);

        return $this->response->accepted();
    }

    public function decrementItemQuantity($itemId) {
        $item = Item::findOrFail($itemId);
        $this->items->decrementQuantity($item);

        return $this->response->accepted();
    }
}
