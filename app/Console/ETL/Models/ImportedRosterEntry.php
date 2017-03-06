<?php

namespace App\Console\ETL\Models;

use Illuminate\Database\Eloquent\Model;

class ImportedRosterEntry extends Model
{
    protected $connection = 'etl_source';
    protected $table = 'roster';
    
    public function person()
    {
    	return $this->belongsTo(ImportedPerson::class, 'person_id');
    }
}
