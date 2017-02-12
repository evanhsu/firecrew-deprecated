<?php

use Illuminate\Database\Seeder;

class EtlDbSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::unprepared(file_get_contents('app/Console/ETL/siskiyou_general.sql'));
    }
}
