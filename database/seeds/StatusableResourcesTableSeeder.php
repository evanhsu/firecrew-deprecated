<?php

use App\Domain\StatusableResources\RappelHelicopter;
use App\Domain\StatusableResources\ShortHaulHelicopter;
use App\Domain\StatusableResources\SmokeJumperAirplane;
use App\Domain\Crews\Crew;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusableResourcesTableSeeder extends Seeder
{

    public function run()
    {
        DB::table('statusable_resources')->delete();

        $crew = Crew::where("name", "=", "Grand Canyon Short Haul Crew")->first();
        ShortHaulHelicopter::create(array(
            'identifier'  => 'N1111',
            'model'       => 'Astar B350',
            'crew_id'     => $crew->id
        ));
        ShortHaulHelicopter::create(array(
            'identifier'  => 'N2222',
            'model'       => 'MD-900',
            'crew_id'     => $crew->id
        ));


        $crew = Crew::where("name", "Price Valley")->first();
        Rappelhelicopter::create(array(
            'identifier'  => 'N3333',
            'model'       => 'Bell 407',
            'crew_id'     => $crew->id
        ));


        $crew = Crew::where("name", "Redding Smokejumpers")->first();
        SmokeJumperAirplane::create(array(
            'identifier'  => 'J-89',
            'model'       => 'C-130',
            'crew_id'     => $crew->id
        ));
        SmokeJumperAirplane::create(array(
            'identifier'  => 'J-83',
            'model'       => 'DHC-6',
            'crew_id'     => $crew->id
        ));


        // This helicopter is not assigned to a Crew
        Rappelhelicopter::create(array(
            'identifier'  => 'N4444',
            'model'       => 'Bell 205',
            'crew_id'     => null
        ));

    }
}
