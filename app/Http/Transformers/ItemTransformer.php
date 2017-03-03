<?php
namespace App\Http\Transformers;

use League\Fractal\TransformerAbstract;
use App\Http\Transformers\PersonTransformer;
use App\Domain\Items\Item;

class ItemTransformer extends TransformerAbstract
{
	protected $availableIncludes = [];
	protected $defaultIncludes = [];

	public function transform(Item $item)
	{
		return $item->toArray();
	}

	public function includePerson(Item $item)
	{
		$person = $item->checked_out_to;
		return $this->item(
			$person,
			new PersonTransformer,
			['key' => 'person']
		);
	}
}
