<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Domain\Items\Item;
use App\Domain\People\Person;
use App\Domain\Vips\Vip;
use App\Console\ETL\Models\ImportedItem;
use App\Console\ETL\Models\ImportedPerson;
use App\Console\ETL\Models\ImportedVip;


class Etl extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'etl:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Load data from a siskiyou_general mysqldump into the new database';

    /**
     * Map user id's from the old database to user id's in the new database
     * [ 
     *  3  => 'c8hjc982ui3f0m',
     *  72 => 'y4yubnugjo3974',
     * ]
     * 
     * @var array
    **/
    private $userIdMap;


    /**
     *  Map item_id to vip ID
     *  [
     *      item3 => vip384
     *  ]
    **/
    private $vipItemMap;
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->userIdMap = array();
        $this->vipItemMap = array();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
        shell_exec('mysql -u firecrew --database siskiyou_general < app/Console/ETL/siskiyou_general.sql');


        // People
        ImportedPerson::all()->each(function($importedPerson) {
            $person = new Person();
            $person->iqcs_number = $importedPerson->iqcs_number;
            $person->firstname = $importedPerson->firstname;
            $person->lastname = $importedPerson->lastname;
            $person->male = null;
            $person->birthdate = null;
            $person->avatar_filename = $importedPerson->headshot_filename;
            $person->bio = $importedPerson->bio;
            $person->has_purchase_card = $importedPerson->has_purchase_card;
            $person->save();

            // Build a lookup table that maps the old ID to the new ID
            $this->userIdMap[$importedPerson->id] = $person->id;
        });

        // VIP
        ImportedVip::all()->each(function($importedVip) {
            $vip = new Vip();
            $vip->name = $importedVip->name;
            $vip->contact = $importedVip->contact;
            $vip->save();

            $this->vipItemMap[$importedVip->item_id] = $vip->id;
        });


        // Items
        ImportedItem::all()->each(function($importedItem) {
            $item = new Item();
            $item->crew_id = 1;
            $item->serial_number = $importedItem->serial_no;
            $item->quantity = $importedItem->quantity;
            $item->category = $importedItem->item_type;
            $item->type = is_null($importedItem->serial_no) ? 'bulk' : 'accountable';
            $item->color = $importedItem->color;
            $item->size = $importedItem->size;
            $item->description = $importedItem->description;
            $item->condition = $importedItem->item_condition;
            $item->note = $importedItem->note;
            $item->usable = $importedItem->usable;
            $item->restock_trigger = $importedItem->restock_trigger;
            $item->restock_to_quantity = $importedItem->restock_to_level;
            $item->source = $importedItem->item_source;
            $item->save();

            if($importedItem->person()->count() > 0) {
                $personId = $this->userIdMap[$importedItem->person->id];
                $item->checkOutTo(Person::find($personId));

            } elseif($importedItem->vip()->count() > 0) {
                $vipId = $this->vipItemMap[$importedItem->id];
                $item->checkOutTo(Vip::find($vipId));
            }
        });
    }
}
