<?php
namespace App\Services;

use App\Domain\Crews\Crew;
use App\Domain\Items\Item;

class ItemsService
{
	public function byCategory(Crew $crew)
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

		$itemsQuery
			->orderBy('category', 'asc')
			->orderBy('serial_number', 'asc')
			->orderBy('description', 'asc')
			->orderBy('size', 'asc')
			->orderBy('color', 'asc');

		$items = $itemsQuery->get();


		return $items;

	}

	public function categories(Crew $crew)
	{
		$categories = $crew->items()->groupBy('category')->pluck('category');
		return $categories;
	}
}