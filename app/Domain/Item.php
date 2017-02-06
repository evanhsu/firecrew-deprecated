<?php

namespace App\Domain;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    //
    public function LogEntries()
    {
    	return $this->morphMany(LogEntry::class, 'loggable');
    }
}
