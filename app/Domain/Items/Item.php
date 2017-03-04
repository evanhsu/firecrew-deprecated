<?php

namespace App\Domain\Items;

use Illuminate\Database\Eloquent\Model;
use App\Domain\Items\CanHaveItemsInterface;
use App\Domain\Crews\Crew;
use App\Domain\LogEntries\LogEntry;

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
        return $this->belongsTo(Item::class);
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
            }
        } catch(Exception $e) {
            return false;
        }

        return true;
    }

    public function checkIn()
    {
        try {
            switch($this->type) {
                case 'accountable':
                    $this->checkInAccountableItem();
                    break;

                case 'bulk_issued':
                    $this->checkInBulkIssuedItem();
                    break;
            }
        } catch(Exception $e) {
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
        $newChild = $this->replicate();
        $newChild->type = 'bulk_issued';
        $newChild->checked_out_to()->associate($owner);
        $newChild->save();

        return true;
    }

    private function checkOutBulkIssuedItem(CanHaveItemsInterface $owner)
    {
        if($this->parent->quantity <= 0) {
            throw new Exception('No items remain to be checked out.')
        }

        $thisOriginalQuantity = $this->quantity;
        $parentOriginalQuantity = $this->parent->quantity;

        try {
            $this->quantity += 1;
            $this->save();
            $this->parent->quantity -= 1;
            $this->parent->save();
        } catch(Exception $e) {
            $this->quantity = $thisOriginalQuantity;
            $this->save();
            $this->parent->quantity = $parentOriginalQuantity;
            $this->parent->save();

            return false;
        }

        return true;
    }

    private function checkInAccountableItem()
    {
        $this->checked_out_to()->dissociate();
        $this->save();
    }

    private function checkInBulkIssuedItem()
    {
        $thisOriginalQuantity = $this->quantity;
        $parentOriginalQuantity = $this->parent->quantity;

        try {
            $this->parent->quantity += 1;
            $this->parent->save();

            $this->quantity -= 1;
            if($this->quantity == 0) {
                $this->destroy();
            } else {
                $this->save();
            }

        } catch(Exception $e) {
            $this->quantity = $thisOriginalQuantity;
            $this->save();
            $this->parent->quantity = $parentOriginalQuantity;
            $this->parent->save();

            return false;
        }

        return true;
    }
}
