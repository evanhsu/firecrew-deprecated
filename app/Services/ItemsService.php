<?php
namespace App\Services;

use App\Domain\Crews\Crew;
use App\Domain\Items\Item;

class ItemsService
{
	public function byCategory(Crew $crew)
	{
		$itemsQuery = $crew->items();

		$itemsQuery->orderBy('category', 'serial_number', 'description', 'size', 'color');

		$items = $itemsQuery->get();

		$items = $items->count() > 0 ? $items->groupBy('category') : collect();

		return $items;
	}

	public function ofCategory(Crew $crew, $category = null)
	{
		$itemsQuery = $crew->items();

		if($category) {
			$itemsQuery->where('category', 'like', $category);
		}

		$itemsQuery->orderBy('category', 'serial_number', 'description', 'size', 'color');

		$items = $itemsQuery->get();

		return $items;

	}

	public function categories(Crew $crew)
	{
		$categories = $crew->items()->groupBy('category')->pluck('category');
		return $categories;
	}
}