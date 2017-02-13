<?php

namespace App\Domain\Vips;

use Illuminate\Database\Eloquent\Model;
use App\Domain\Crews\Crew;
use App\Domain\Items\Item;
use App\Domain\Items\CanHaveItemsInterface;

/**
 *  A Vip is a temporary person who is created solely to check out an item.
 *
**/
class Vip extends Model implements CanHaveItemsInterface
{
    //
    public function crew() {
    	return $this->belongsTo(Crew::class);
    }

    public function getFullNameAttribute() {
        return $this->name;
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
