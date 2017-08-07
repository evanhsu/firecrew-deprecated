<?php

namespace App\Domain\Crews;

use App\Domain\Aircrafts\Aircraft;
use Illuminate\Database\Eloquent\Model;
use App\Domain\Items\Item;
use App\Domain\People\Person;
use App\Domain\Users\User;

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

	public function aircrafts() {
	    return $this->hasMany(Aircraft::class);
    }

	public function people() {
		return $this->belongsToMany(Person::class, 'crew_person');
	}

	public function roster($year) {
		return $this->people()->wherePivot('year',$year);
	}

	public function items() {
		return $this->hasMany(Item::class);
	}

	public function users() {
	    return $this->hasMany(User::class);
    }

    public function crew() {
	    return $this;
    }

    public function statusable_type_plain() {
        if ($pos = strrpos($this->statusable_type, '\\')) {
            $chunks = explode('\\', $this->statusable_type);
            return strtolower($chunks[count($chunks)-1]);
        } else {
            return strtolower($this->statusable_type);
        }
    }
}
