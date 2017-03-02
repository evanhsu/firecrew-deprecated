<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Domain\Crews\Crew;
use App\Services\ItemsService;
use App\Domain\Items\Item;

class ItemsController extends Controller
{
    protected $items;

    public function __construct(ItemsService $items)
    {
        $this->items = $items;
    }

    /**
     * Convert snake_case Model Attributes to camelCase for API response
     *
     */
    public function itemTransformer($item)
    {
        $transformedItem = [
            'id'                => $item->id,
            'crewId'            => $item->crew_id,
            'parentId'          => $item->parent_id,
            'serialNumber'      => $item->serial_number,
            'quantity'          => $item->quantity,
            'type'              => $item->type,
            'category'          => $item->category,
            'color'             => $item->color,
            'itemSize'          => $item->size,
            'description'       => $item->description,
            'condition'         => $item->condition,
            'checkedOutTo'      => $item->checked_out_to,
            'note'              => $item->note,
            'usable'            => $item->usable,
            'restockTrigger'    => $item->restock_trigger,
            'restockToQuantity' => $item->restock_to_quantity,
            'source'            => $item->source,
            'createdAt'         => $item->created_at,
            'updatedAt'         => $item->updated_at,
        ];

        // foreach($item->toArray() as $key => $value) {
            // $transformedItem[camel_case($key)] = $value;
        // } 

        return $transformedItem;
    }

    /**
     *  
     *
     */
    public function indexForCrewByCategory(Request $request, $crewId) 
    {

    	$crew = Crew::find($crewId);
        if($request->input('category')) {
            $items = $this->items->ofCategory($crew, $request->input('category'));
            $itemsTransformed = [];
            $items->each($itemsTransformed->push(itemTransformer($item)));

            $response = [
                "category" => [
                    "name"  => $request->input('category'), 
                    "items"     => $itemsTransformed,
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

    /**
     *  Returns a flat collection of ALL items belonging to the specified Crew
     *
     */
    public function indexForCrew(Request $request, $crewId) {

        $crew = Crew::find($crewId);
        if($request->input('category')) {
            $items = $this->items->forCrewByCategory($crew, $request->input('category'));
        } else {
            $items = $this->items->byCrew($crew);
        }

        $itemsTransformed = $items->map(function($item) {
            return $this->itemTransformer($item);
        });

        $response = [
            "items" => $itemsTransformed
        ];

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

    public function incrementItemQuantity($itemId) {
        $item = Item::findOrFail($itemId);
        $item->quantity++;
        $item->save();

        return ['quantity' => $item->quantity];
    }

    public function decrementItemQuantity($itemId) {
        $item = Item::findOrFail($itemId);
        $item->quantity--;
        $item->save();

        return ['quantity' => $item->quantity];
    }
}
