<?php

namespace App\Http\Controllers;

use App\Domain\Crews\Crew;
use App\Services\CrewsService;
use App\Services\ItemsService;
use App\Domain\Items\Item;
use App\Http\Transformers\ItemTransformer;
use Dingo\Api\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class ItemsController extends Controller
{
    /**
     * @var ItemsService
     */
    protected $items;
    /**
     * @var CrewsService
     */
    protected $crews;

    public function __construct(ItemsService $items)
    {
        $this->items = $items;
    }

    public function create(Request $request) 
    {
        $this->items->create(
            array_filter($request->only([
                'type',
                'category',
                'crew_id',
                'parent_id',
                'serial_number',
                'quantity',
                'color',
                'size',
                'description',
                'condition',
                'checked_out_to_id',
                'checked_out_to_type',
                'note',
                'usable',
                'restock_trigger',
                'restock_to_quantity',
                'source',
            ]))
        );

        return $this->response->created();
    }

    /**
     *  Returns a flat collection of ALL items belonging to the specified Crew
     * @param Request $request
     * @param $crewId
     * @return \Dingo\Api\Http\Response
     */
    public function indexForCrew(Request $request, $crewId) {

        $crew = $this->findCrewOrFail($crewId);
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
        $crew = $this->findCrewOrFail($crewId);
        $categories = $this->items->categories($crew);

        return $categories;
    }

    public function indexForPerson($personId) {

    }

    public function show($id) {
        $item = $this->items->findOrFail($id);

        return $this->response->item(
            $item,
            new ItemTransformer,
            ['key' => 'item']
        );
    }

    public function update(Request $request, $itemId) {
        $attributes = array_filter($request->only([
                'type',
                'category',
                'crew_id',
                'parent_id',
                'serial_number',
                'quantity',
                'color',
                'item_size',
                'description',
                'condition',
                'checked_out_to_id',
                'checked_out_to_type',
                'note',
                'usable',
                'restock_trigger',
                'restock_to_quantity',
                'source',
        ]));
        // Front-end form must use 'item_size' because 'size' is a reserved javascript object property
        $attributes['size'] = $attributes['item_size'];

        $item = $this->items->findOrFail($itemId);

//        $this->items->update($itemId, $attributes);
        $item->update($attributes);

        return $this->response->item(
            $item,
            new ItemTransformer,
            ['key' => 'item']
        );
    }

    public function incrementItemQuantity($itemId) {
        $item = Item::findOrFail($itemId);
        $item->incrementQuantity();

        return $this->response->accepted();
    }

    public function decrementItemQuantity($itemId) {
        $item = Item::findOrFail($itemId);
        $item->decrementQuantity();

        return $this->response->accepted();
    }

    private function findCrewOrFail($crewId) {
        $crew = Crew::find($crewId);
        if(!$crew) {
            throw new NotFoundHttpException("Crew $crewId doesn't exist");
        }
        return $crew;
    }
}
