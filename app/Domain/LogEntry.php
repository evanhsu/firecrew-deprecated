<?php

namespace App\Domain;

use Illuminate\Database\Eloquent\Model;

class LogEntry extends Model
{
    public function loggable()
    {
    	return $this->morphTo();
    }
}
