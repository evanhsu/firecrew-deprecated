<?php

namespace App\Domain\People;

use Illuminate\Database\Eloquent\Model;
use App\Domain\Items\Item;
use App\Domain\Items\CanHaveItemsInterface;

class Person extends Model implements CanHaveItemsInterface
{
    //
    public function crews() {
    	return $this->belongsToMany(Crew::class, 'crew_person');
    }

    public function crewYear($year) {
    	return $this->crews()->wherePivot('year', $year);
    }

    public function items()
    {
    	return $this->morphMany(Item::class, 'checked_out_to');
    }

    public function issueItem($item)
    {
        return $this->items()->save($item);
    }
}
