<?php

namespace App\Console\ETL\Models;

use Illuminate\Database\Eloquent\Model;

class ImportedVip extends Model
{
    protected $connection = 'etl_source';
	protected $table = 'vip';
	
    public function item() {
    	return $this->belongsTo(ImportedItem::class, 'item_id');
    }
}
