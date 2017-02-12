<?php

namespace App\Domain\Items;

use Illuminate\Database\Eloquent\Model;
use App\Domain\Items\CanHaveItemsInterface;

class Item extends Model
{
    //
    public function logEntries()
    {
    	return $this->morphMany(LogEntry::class, 'loggable');
    }

    public function crew()
    {
    	return $this->belongsTo(Crew::class);
    }

    public function checked_out_to()
    {
        return $this->morphTo();
    }

    public function checkOutTo(CanHaveItemsInterface $owner)
    {
        $this->checked_out_to()->associate($owner);
        $this->save();
    }

}
