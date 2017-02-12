<?php

namespace App\Console\ETL\Models;

use Illuminate\Database\Eloquent\Model;

class ImportedItem extends Model
{
    protected $connection = 'etl_source';
    protected $table = 'inventory';
    
    public function person()
    {
    	return $this->belongsTo(ImportedPerson::class, 'checked_out_to_id');
    }

    public function vip()
    {
    	return $this->hasOne(ImportedVip::class, 'item_id');
    }

}
