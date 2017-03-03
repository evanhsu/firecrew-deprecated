<?php
namespace App\Http\Transformers;

use League\Fractal\TransformerAbstract;
use App\Domain\People\Person;

class PersonTransformer extends TransformerAbstract
{
	protected availableIncludes = [];
	protected defaultIncludes = [];

	public function transform(Person $person)
	{
		return $person->toArray();
	}
}
