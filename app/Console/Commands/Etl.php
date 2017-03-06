<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Domain\Items\Item;
use App\Domain\People\Person;
use App\Domain\Vips\Vip;
use App\Console\ETL\Models\ImportedItem;
use App\Console\ETL\Models\ImportedPerson;
use App\Console\ETL\Models\ImportedVip;
use App\Console\ETL\Models\ImportedRosterEntry;


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
     *  Map old ImportedItem->id to new Item->id
     *  [
     *      OldItemID => NewItemID
     *  ]
    **/
    private $newIdForImportedItem;

    /**
     *  Create a map of Items to their Parent Item.
     *  The keys are ID's of NEW items.
     *  The values are ID's of OLD items.
     *
     *  So to find the ID of the new parent for an Item:
     *      $newItem->parent_id = $this->newIdForImportedItem[$this->oldParentIdForNewItem[$newItem->id]]
     *
     *  [
     *      NewItemID => OldParentItemID
     *  ]
    **/
    private $oldParentIdForNewItem;

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
        $this->newIdForImportedItem = array();
        $this->oldParentIdForNewItem = array();
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

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // People
        DB::table('people')->delete();
        ImportedPerson::all()->each(function($importedPerson) {
            $person = new Person();
            $person->iqcs_number = $importedPerson->iqcs_number;
            $person->first_name = $importedPerson->firstname;
            $person->last_name = $importedPerson->lastname;
            $person->gender = null;
            $person->birthdate = null;
            $person->avatar_filename = $importedPerson->headshot_filename;
            $person->bio = $importedPerson->bio;
            $person->has_purchase_card = $importedPerson->has_purchase_card == 1;
            $person->save();

            // Build a lookup table that maps the old ID to the new ID
            $this->userIdMap[$importedPerson->id] = $person->id;
        });

        // VIP
        DB::table('vips')->delete();
        ImportedVip::all()->each(function($importedVip) {
            $vip = new Vip();
            $vip->name = $importedVip->name;
            $vip->contact = $importedVip->contact;
            $vip->save();

            $this->vipItemMap[$importedVip->item_id] = $vip->id;
        });


        // Items
        DB::table('items')->delete();
        ImportedItem::all()->each(function($importedItem) {
            $item = new Item();
            $item->crew_id = 1;
            $item->serial_number = $importedItem->serial_no;
            $item->quantity = $importedItem->quantity;
            $item->category = $importedItem->item_type;
            $item->type = empty($importedItem->serial_no) ? 'bulk' : 'accountable';
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

            $this->newIdForImportedItem[$importedItem->id] = $item->id;

            // Keep track of this item if it needs a parent_id (it's a bulk_issued item)
            // bulk_issued items in the old db had their parent_id stored in the 'item_source' column
            if(
                is_null($importedItem->serial_no) 
                && ($importedItem->checked_out_to_id != -1)
                && (ImportedItem::find($importedItem->item_source))
            ) {
                $this->oldParentIdForNewItem[$item->id] = $importedItem->item_source;
            }

            if($importedItem->person()->count() > 0) {
                $personId = $this->userIdMap[$importedItem->person->id];
                $item->checkOutTo(Person::find($personId));

            } elseif($importedItem->vip()->count() > 0) {
                $vipId = $this->vipItemMap[$importedItem->id];
                $item->checkOutTo(Vip::find($vipId));
            }
        });

        // Update the parent_id for bulk_issued items
        foreach($this->oldParentIdForNewItem as $newId => $oldParentId) {
            $item = Item::find($newId);
            $item->parent_id = $this->newIdForImportedItem[$oldParentId];
            $item->save();
        };


        // Rosters
        DB::table('crew_person')->delete();
        ImportedRosterEntry::all()->each(function($importedRosterEntry) {
            try {
                $importedPersonId = $importedRosterEntry->id;   // The ID of the person in the OLD database (note: the person_id column was never used in the old DB. The person_id was stored in the id column!)
                $personId = $this->userIdMap[$importedPersonId];// The ID of the person in the NEW database
                $person = Person::find($personId);

                $crewId = 1;    // Siskiyou Rappel Crew - manually inserted
                $person->crews()->attach($crewId, [
                    'year'  => $importedRosterEntry->year,
                    'bio'   => $importedRosterEntry->bio
                ]);
            } catch (\Exception $e) {
                $this->info($e->getMessage());
            }
        });


        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
