<?php

namespace App\Domain\Items;

use Illuminate\Database\Eloquent\Model;
use App\Domain\Items\CanHaveItemsInterface;
use App\Domain\Crews\Crew;
use App\Domain\LogEntries\LogEntry;
use Illuminate\Support\Facades\DB;

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

    /**
     *  For Bulk-Issued items only.
     *  The parent item is the 'bulk' item collection that this 'bulk_issued'
     *  item was issued from.
     *
     */
    public function parent()
    {
        return $this->belongsTo(Item::class, 'parent_id');
    }

    /**
     *  For Bulk items only.
     *  Returns the collection of bulk_issued items for whom this Item is the parent.
     *
     */
    public function issued_items()
    {
        return $this->hasMany(Item::class, 'parent_id', 'id');
    }

    public function checked_out_to()
    {
        return $this->morphTo();
    }

    public function checkOutTo(CanHaveItemsInterface $owner)
    {
        try {
            switch($this->type) {
                case 'accountable':
                    $this->checkOutAccountableItem($owner);
                    break;

                case 'bulk':
                    $this->checkOutBulkItem($owner);
                    break;

                case 'bulk_issued':
                    $this->checkOutBulkIssuedItem($owner);
                    break;

                default:
                    return false;
            }
        } catch(\Exception $e) {
            return false;
        }

        return true;
    }



    private function checkOutAccountableItem(CanHaveItemsInterface $owner)
    {
        $this->checked_out_to()->associate($owner);
        $this->save();

        return true;
    }

    private function checkOutBulkItem(CanHaveItemsInterface $owner)
    {
        if($this->quantity <= 0) {
            throw new \Exception('No items remain to be checked out.');
        }

        DB::transaction(function() use($owner) {
            $newChild = $this->replicate();
            $newChild->type = 'bulk_issued';
            $newChild->parent_id = $this->id;
            $newChild->checked_out_to()->associate($owner);
            $newChild->quantity = 1;
            $newChild->save();

            $this->quantity -= 1;
            $this->save();
        });

        return true;
    }

    private function checkOutBulkIssuedItem(CanHaveItemsInterface $owner)
    {
        if($this->parent->quantity <= 0) {
            throw new \Exception('No items remain to be checked out.');
        }

        try {
            DB::transaction(function() {
                $this->quantity += 1;
                $this->save();
                $this->parent->quantity -= 1;
                $this->parent->save();
            });
        } catch(\Exception $e) {
            return false;
        }

        return true;
    }


}
