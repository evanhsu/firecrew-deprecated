<?php
namespace App\Services;

use App\Domain\Crews\Crew;
use App\Domain\Items\Item;

class ItemsService
{
	public function byCategory(Crew $crew, $category = null)
	{
		$categoriesQuery = $crew->items();

		if($category) {
			$categoriesQuery->where('category', $category);
		}

		$categoriesQuery->orderBy('category');

		$categories = $categoriesQuery->get();

		$categories = $categories->count() > 0 ? $categories->groupBy('category') : collect();

		return $categories;
	}
}