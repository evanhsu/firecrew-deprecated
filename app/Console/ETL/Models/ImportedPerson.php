<?php

namespace App\Console\ETL\Models;

use Illuminate\Database\Eloquent\Model;
use App\Console\ETL\Models\ImportedItem;

class ImportedPerson extends Model
{
    protected $connection = 'etl_source';
	protected $table = 'crewmembers';
	
    public function items() {
    	return $this->hasMany(ImportedItem::class);
    }

}
