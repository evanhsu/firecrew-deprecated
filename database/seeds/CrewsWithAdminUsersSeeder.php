<?php

use App\Domain\Aircrafts\RappelHelicopter;
use App\Domain\Aircrafts\ShortHaulHelicopter;
use App\Domain\Aircrafts\SmokeJumperAirplane;
use App\Domain\Crews\Crew;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Domain\Users\User;

class CrewsWithAdminUsersSeeder extends Seeder
{
    public function run()
    {
        DB::table('crews')->delete();
        DB::table('users')->delete();

        // Create GLOBAL ADMIN users
        User::create(array(
            'name' => 'Evan',
            'email' => 'evanhsu@gmail.com',
            'password' => bcrypt('password'),
            'password'	=> bcrypt('password'),
            'global_admin' => true,
        ));
        User::create(array(
            'name' => 'Ed Ministrator',
            'email' => 'test@admin.com',
            'password' => bcrypt('password'),
            'global_admin' => true,
        ));


        $crew = Crew::create(array(
            'name' => 'Grand Canyon Short Haul Crew',
            'phone' => '330-404-5050',
            'address_street1' => "45220 Canyon St.",
            'address_city' => "Canyon City",
            'address_state' => "AZ",
            'statusable_type' => ShortHaulHelicopter::class,
        ));
        User::create(array(
            'name' => 'Grant Kenyon',
            'email' => 'test@shorthaul.com',
            'password' => bcrypt('password'),
            'crew_id' => $crew->id,
        ));

        $crew = Crew::create(array(
            'name' => 'Price Valley',
            'phone' => '280-324-2909',
            'address_street1' => "9999 Reservoir Way",
            'address_city' => "Sun Valley",
            'address_state' => "ID",
            'statusable_type' => RappelHelicopter::class,
        ));
        User::create(array(
            'name' => 'Pete Valles',
            'email' => 'test@rappel.com',
            'password' => bcrypt('password'),
            'crew_id' => $crew->id,
        ));

        $crew = Crew::create(array(
            'name' => 'Prineville Hotshots',
            'phone' => '541-887-5477',
            'statusable_type' => Crew::class,
        ));
        User::create(array(
            'name' => 'Prine Vill',
            'email' => 'test@hotshot.com',
            'password' => bcrypt('password'),
            'crew_id' => $crew->id,
        ));
        $crew = Crew::create(array(
            'name' => 'Redding Smokejumpers',
            'phone' => '541-555-6677',
            'statusable_type' => SmokeJumperAirplane::class,
        ));
        User::create(array(
            'name' => 'Red Ding',
            'email' => 'test@smokejumper.com',
            'password' => bcrypt('password'),
            'crew_id' => $crew->id,
        ));
    }

}
