<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Domain\Items\Item;
use App\Domain\People\Person;
use App\Domain\Vips\Vip;

class ItemTest extends TestCase
{
	use DatabaseTransactions;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testItemCanBeCheckedOutToPerson()
    {
    	$item = new Item();
    	$item->category = 'Sleeping bag';
    	$item->serial_number = 'abc123';
    	$item->crew_id = 1;
    	$item->color = 'Green';
    	$item->size = 'Regular';
    	$item->save();

    	$person = new Person();
    	$person->firstname = "John";
    	$person->lastname = "Doe";
    	$person->save();

    	$item->checkOutTo($person);
        $this->assertTrue($item->checked_out_to->id == $person->id);
        $this->assertTrue($person->items()->count() == 1);
    }

    public function testPersonCanBeIssuedAnItem()
    {
    	$item = new Item();
    	$item->category = 'Sleeping bag';
    	$item->serial_number = 'abc123';
    	$item->crew_id = 1;
    	$item->color = 'Green';
    	$item->size = 'Regular';
    	$item->save();

    	$person = new Person();
    	$person->firstname = "John";
    	$person->lastname = "Doe";
    	$person->save();

    	$person->issueItem($item);
        $this->assertTrue($item->checked_out_to->id == $person->id);
        $this->assertTrue($person->items()->count() == 1);
        $this->assertTrue($item::all()->count() == 1);
    }

    public function testItemCanBeCheckedOutToVip()
    {
    	$item = new Item();
    	$item->category = 'Sleeping bag';
    	$item->serial_number = 'abc123';
    	$item->crew_id = 1;
    	$item->color = 'Green';
    	$item->size = 'Regular';
    	$item->save();

    	$vip = new Vip();
    	$vip->name = "John Doe";
    	$vip->contact = "849-223-0982";
    	$vip->save();

    	$item->checkOutTo($vip);
        $this->assertTrue($item->checked_out_to->id == $vip->id);
        $this->assertTrue($vip->items()->count() == 1);
    }

    public function testVipCanBeIssuedAnItem()
    {
    	$item = new Item();
    	$item->category = 'Sleeping bag';
    	$item->serial_number = 'abc123';
    	$item->crew_id = 1;
    	$item->color = 'Green';
    	$item->size = 'Regular';
    	$item->save();

    	$vip = new Vip();
    	$vip->name = "John Doe";
    	$vip->contact = "849-223-0982";
    	$vip->save();

    	$vip->issueItem($item);
        $this->assertTrue($item->checked_out_to->id == $vip->id);
        $this->assertTrue($vip->items()->count() == 1);
        $this->assertTrue($item::all()->count() == 1);
    }
}
