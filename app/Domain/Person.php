<?php

namespace App\Domain;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    //
    public function crews()
    {
    	return $this->belongsToMany(Crew::class, 'crew_person');
    }
}
