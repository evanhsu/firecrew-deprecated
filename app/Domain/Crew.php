<?php

namespace App\Domain;

use Illuminate\Database\Eloquent\Model;

class Crew extends Model
{
	public static $types = [
		'handcrew'	=> (object)[
			'description' 	=> 'Type 2 Handcrew',
		],
		'hotshot'	=> (object)[
			'description'	=> 'Interagency Hotshot Crew',
		],
		'engine'	=> (object)[
			'description'	=> 'Engine Crew',
		],
		'helitack'	=> (object)[
			'description'	=> 'Helitack Crew (not Short Haul or Rappel)',
		],
		'shorthaul'	=> (object)[
			'description'	=> 'Short Haul',
		],
		'rappel'	=> (object)[
			'description'	=> 'Rappel Crew',
		],
		'smokejumper'=>(object)[
			'description'	=> 'Smokejumper Base',
		],
		'district'	=> (object)[
			'description'	=> 'A Ranger District or fire compound',
		],
	];

	function people() {
		return $this->belongsToMany(Person::class, 'crew_person');
	}
}
