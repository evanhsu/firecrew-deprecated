<?php

namespace App\Domain\Items;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    //
    public function LogEntries()
    {
    	return $this->morphMany(LogEntry::class, 'loggable');
    }

    public function crew()
    {
    	return $this->belongsTo(Crew::class);
    }

    public function person()
    {
    	return $this->belongsTo(Person::class);
    }

}
