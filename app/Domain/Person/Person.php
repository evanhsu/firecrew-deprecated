<?php

namespace App\Domain\Person;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    //
    public function crews() {
    	return $this->belongsToMany(Crew::class, 'crew_person');
    }

    public function crewYear($year) {
    	return $this->crews()->wherePivot('year', $year);
    }
}
