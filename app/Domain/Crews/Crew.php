<?php

namespace App\Domain\Crews;

use Illuminate\Database\Eloquent\Model;
use App\Domain\Items\Item;
use App\Domain\People\Person;

class Crew extends Model
{
	public static $types = [
		'handcrew'	=> 'Type 2 Handcrew',
		'hotshot'	=> 'Interagency Hotshot Crew',
		'engine'	=> 'Engine Crew',
		'helitack'	=> 'Helitack Crew (not Short Haul or Rappel)',
		'shorthaul'	=> 'Short Haul',
		'rappel'	=> 'Rappel Crew',
		'smokejumper'=>'Smokejumper Base',
		'district'	=> 'A Ranger District or fire compound',
	];

	function people() {
		return $this->belongsToMany(Person::class, 'crew_person');
	}

	function roster($year) {
		return $this->people()->wherePivot('year',$year);
	}

	function items() {
		return $this->hasMany(Item::class);
	}

}
