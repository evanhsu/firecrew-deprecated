<?php
namespace App\Database\Seeds\Production;

use Illuminate\Database\Seeder;
use App\Domain\Crews\Crew;
use App\Domain\StatusableResources\RappelHelicopter;
use Illuminate\Support\Facades\DB;
use App\Domain\Users\User;

class CrewUserResourceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('crews')->delete();
        DB::table('users')->delete();
        DB::table('statusable_resources')->delete();


// Create GLOBAL ADMIN users
        User::create(array(
            'name' => 'Evan Hsu',
            'email' => 'evanhsu@gmail.com',
            'password' => '$2y$10$Vxu14gHq7q6no.kGjJNQm.1xHklpnhev/p4CEHW1/HsXl02bmwwV.',
            'global_admin' => true,
        ));

        $crew = Crew::create(array(
            'name' => 'Siskiyou Rappel Crew',
            'phone' => '541-471-6891',
            'address_street1' => "657 Flaming Rd",
            'address_city' => "Grants Pass",
            'address_state' => "OR",
            'address_zip' => "97526",
        ));
        User::create(array(
            'name' => 'Dan Quinones',
            'email' => 'dquinones@fs.fed.us',
            'password' => '$2y$10$qwgF2oUG4r4F7RQKXVCQVOWtsrjZwapWP0SJvoGFaeiKKqz/DR7eO',
            'crew_id' => $crew->id,
        ));
        Rappelhelicopter::create(array(
            'identifier' => 'N205RH',
            'model' => 'Bell 205A1++',
            'crew_id' => $crew->id,
        ));

        $crew = Crew::create(array(
            'name' => 'Central Oregon Rappellers',
            'phone' => '541-416-6840',
        ));
        User::create(array(
            'name' => 'Chad Schmidt',
            'email' => 'chadschmidt@fs.fed.us',
            'password' => '$2y$10$qwgF2oUG4r4F7RQKXVCQVOWtsrjZwapWP0SJvoGFaeiKKqz/DR7eO',
            'crew_id' => $crew->id,
        ));
        Rappelhelicopter::create(array(
            'identifier' => 'N223HT',
            'model' => 'Bell 205A1++',
            'crew_id' => $crew->id,
        ));

        $crew = Crew::create(array(
            'name' => 'Malheur Rappellers',
            'phone' => '541-575-3384',
        ));
        User::create(array(
            'name' => 'Anthony Hernandez',
            'email' => 'ahernandez@fs.fed.us',
            'password' => '$2y$10$qwgF2oUG4r4F7RQKXVCQVOWtsrjZwapWP0SJvoGFaeiKKqz/DR7eO',
            'crew_id' => $crew->id,
        ));
        Rappelhelicopter::create(array(
            'identifier' => 'N510WW',
            'model' => 'Bell 210',
            'crew_id' => $crew->id,
        ));

        $crew = Crew::create(array(
            'name' => 'Wenatchee Valley Rappellers',
            'phone' => '509-884-2492',
        ));
        User::create(array(
            'name' => 'Mike Davis',
            'email' => 'mjdavis02@fs.fed.us',
            'password' => '$2y$10$qwgF2oUG4r4F7RQKXVCQVOWtsrjZwapWP0SJvoGFaeiKKqz/DR7eO',
            'crew_id' => $crew->id,
        ));
        Rappelhelicopter::create(array(
            'identifier' => 'N502HQ',
            'model' => 'Bell 205++',
            'crew_id' => $crew->id,
        ));

        $crew = Crew::create(array(
            'name' => 'Grande Ronde Rappellers',
            'phone' => '541-975-5440',
        ));
        User::create(array(
            'name' => 'Kyle Johnson',
            'email' => 'kylejohnson@fs.fed.us',
            'password' => '$2y$10$qwgF2oUG4r4F7RQKXVCQVOWtsrjZwapWP0SJvoGFaeiKKqz/DR7eO',
            'crew_id' => $crew->id,
        ));
        Rappelhelicopter::create(array(
            'identifier' => 'N669H',
            'model' => 'Bell 205A1++',
            'crew_id' => $crew->id
        ));
        Rappelhelicopter::create(array(
            'identifier' => 'N689H',
            'model' => 'Bell 205A1++',
            'crew_id' => $crew->id,
        ));

        $crew = Crew::create(array(
            'name' => 'Price Valley Helirappellers',
            'phone' => '208-347-0327 x3001',
        ));
        User::create(array(
            'name' => 'Cory Dolberry',
            'email' => 'cdolberry@fs.fed.us',
            'password' => '$2y$10$qwgF2oUG4r4F7RQKXVCQVOWtsrjZwapWP0SJvoGFaeiKKqz/DR7eO',
            'crew_id' => $crew->id,
        ));
        Rappelhelicopter::create(array(
            'identifier' => 'N16HX',
            'model' => 'Bell 205A1++',
            'crew_id' => $crew->id,
        ));

        $crew = Crew::create(array(
            'name' => 'Gallatin Rappel Crew',
            'phone' => '406-763-4874',
        ));
        User::create(array(
            'name' => 'Ward Hiesterman',
            'email' => 'whiesterman@fs.fed.us',
            'password' => '$2y$10$qwgF2oUG4r4F7RQKXVCQVOWtsrjZwapWP0SJvoGFaeiKKqz/DR7eO',
            'crew_id' => $crew->id,
        ));
        Rappelhelicopter::create(array(
            'identifier' => 'N9122Z',
            'model' => 'Bell 212HP',
            'crew_id' => $crew->id,
        ));

        $crew = Crew::create(array(
            'name' => 'Salmon Heli-Rappellers',
            'phone' => '208-756-8122',
        ));
        User::create(array(
            'name' => 'Curtis Parkhouse',
            'email' => 'cparkhouse@fs.fed.us',
            'password' => '$2y$10$qwgF2oUG4r4F7RQKXVCQVOWtsrjZwapWP0SJvoGFaeiKKqz/DR7eO',
            'crew_id' => $crew->id,
        ));
        Rappelhelicopter::create(array(
            'identifier' => 'N932CH',
            'model' => 'Bell 205A1++',
            'crew_id' => $crew->id
        ));
        Rappelhelicopter::create(array(
            'identifier' => 'N933CH',
            'model' => 'Bell 205A1++',
            'crew_id' => $crew->id,
        ));

        $crew = Crew::create(array(
            'name' => 'Lucky Peak Rappel Crew',
            'phone' => '208-373-4277',
        ));
        User::create(array(
            'name' => 'Jeremy Schwandt',
            'email' => 'jsschwandt@fs.fed.us',
            'password' => '$2y$10$qwgF2oUG4r4F7RQKXVCQVOWtsrjZwapWP0SJvoGFaeiKKqz/DR7eO',
            'crew_id' => $crew->id,
        ));
        Rappelhelicopter::create(array(
            'identifier' => 'N205DY',
            'model' => 'Bell 205A1++',
            'crew_id' => $crew->id,
        ));

        $crew = Crew::create(array(
            'name' => 'Scott Valley Rappel Crew',
            'phone' => '530-468-1294',
        ));
        User::create(array(
            'name' => 'Scott Valley',
            'email' => 'scottvalley@fs.fed.us',
            'password' => '$2y$10$qwgF2oUG4r4F7RQKXVCQVOWtsrjZwapWP0SJvoGFaeiKKqz/DR7eO',
            'crew_id' => $crew->id,
        ));
        Rappelhelicopter::create(array(
            'identifier' => 'N183HQ (H-502)',
            'model' => 'Bell 205A1++',
            'crew_id' => $crew->id,
        ));

        $crew = Crew::create(array(
            'name' => 'Sierra Helitack ',
            'phone' => '559-855-8325',
        ));
        User::create(array(
            'name' => 'Casey Jones',
            'email' => 'cjones06@fs.fed.us',
            'password' => '$2y$10$qwgF2oUG4r4F7RQKXVCQVOWtsrjZwapWP0SJvoGFaeiKKqz/DR7eO',
            'crew_id' => $crew->id,
        ));
        Rappelhelicopter::create(array(
            'identifier' => 'N213KA (H-520)',
            'model' => 'Bell 212',
            'crew_id' => $crew->id,
        ));

        $crew = Crew::create(array(
            'name' => 'Kootenai Rappel Crew',
            'phone' => '406-283-7865',
        ));
        User::create(array(
            'name' => 'Kootenai',
            'email' => 'kootenai@fs.fed.us',
            'password' => '$2y$10$qwgF2oUG4r4F7RQKXVCQVOWtsrjZwapWP0SJvoGFaeiKKqz/DR7eO',
            'crew_id' => $crew->id,
        ));
        Rappelhelicopter::create(array(
            'identifier' => 'N571SC',
            'model' => 'Bell 212HP',
            'crew_id' => $crew->id,
        ));
    }
}
