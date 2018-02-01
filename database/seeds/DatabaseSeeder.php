<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        $this->call(UsersTableSeeder::class);
//        $this->call(CrewsTableSeeder::class);
        $this->call(CrewsWithAdminUsersSeeder::class);

        $this->call(StatusableResourcesTableSeeder::class);
        $this->call(ResourceStatusesTableSeeder::class);
        $this->call(EtlDbSeeder::class);
    }
}
