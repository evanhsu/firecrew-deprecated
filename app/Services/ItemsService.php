<?php
namespace App\Services;

use App\Domain\Crews\Crew;
use App\Domain\Items\Item;
use App\Exceptions\ItemTypeException;
use Illuminate\Support\Facades\DB;

class ItemsService
{
	public function byCrew(Crew $crew)
	{
		return $crew->items()->with('checked_out_to')->get();
	}

	public function forCrewByCategory(Crew $crew)
	{
		$itemsQuery = $crew->items()->with('checked_out_to')
			->orderBy('category', 'asc')
			->orderBy('serial_number', 'asc')
			->orderBy('description', 'asc')
			->orderBy('size', 'asc')
			->orderBy('color', 'asc');

		$items = $itemsQuery->get();

		$items = $items->count() > 0 ? $items->groupBy('category') : collect();

		$items->transform(function($values, $key) {
			return [ 'name' => $key, 'items' => $values ];
		});

		return $items;
	}

	public function ofCategory(Crew $crew, $category = null)
	{
		$itemsQuery = $crew->items()->with('checked_out_to');

		if($category) {
			$itemsQuery->where('items.category', 'like', $category);
		}

		return $itemsQuery->get();
	}

	public function categories(Crew $crew)
	{
		$categories = $crew->items()
			->select('category')
			->distinct()
			->orderBy('category', 'asc')
			->pluck('category');
		return $categories;
	}

	public function incrementQuantity(Item $item)
	{
		if(($item->type != 'bulk') && ($item->type != 'bulk_issued')) {
			throw new ItemTypeException('Only bulk items can have their quantity incremented');
		}

		$item->quantity++;
		$item->save();

		return $item->quantity;
	}

	public function decrementQuantity(Item $item)
	{
		if(($item->type != 'bulk') && ($item->type != 'bulk_issued')) {
			throw new ItemTypeException('Only bulk items can have their quantity decremented');
		} 

		if($item->quantity == 0) {
			return 0;
		}

		$item->quantity--;
		$item->save();

		return $item->quantity;
	}
	
	public function checkIn(Item $item)
    {
        try {
            switch($item->type) {
                case 'accountable':
                    $this->checkInAccountableItem($item);
                    break;

                case 'bulk_issued':
                    $this->checkInBulkIssuedItem($item);
                    break;
            }
        } catch(\Exception $e) {
            return false;
        }

        return true;
    }

    private function checkInAccountableItem(Item $item)
    {
        $item->checked_out_to()->dissociate();
        $item->save();
    }

    private function checkInBulkIssuedItem(Item $item)
    {
        try {
            $item->parent->quantity += 1;
            $item->parent->save();

            $item->quantity -= 1;
            if($item->quantity == 0) {
                $item->delete();
            } else {
                $item->save();
            }

        } catch(\Exception $e) {
            return false;
        }

        return true;
    }	
}