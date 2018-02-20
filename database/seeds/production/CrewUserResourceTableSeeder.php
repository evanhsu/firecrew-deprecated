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

        User::create(array(
            'name' => 'Curt Parkhouse (Admin)',
            'email' => 'cparkhouse+admin@fs.fed.us',
            'password' => '$2y$10$qwgF2oUG4r4F7RQKXVCQVOWtsrjZwapWP0SJvoGFaeiKKqz/DR7eO',
            'global_admin' => true,
        ));
//

        $crew = Crew::create(array(
            'name' => 'Siskiyou Rappel Crew',
            'phone' => '541-471-6891',
            'address_street1' => "657 Flaming Rd",
            'address_city' => "Grants Pass",
            'address_state' => "OR",
            'address_zip' => "97526",
            'dispatch_center_name' => 'Rogue Dispatch',
            'dispatch_center_identifier' => 'RVICC',
            'dispatch_center_daytime_phone' => '222-999-9999',
            'dispatch_center_24_hour_phone' => '222-555-3344',
        ));
        $user = User::create(array(
            'name' => 'Dan Quinones',
            'email' => 'dquinones@fs.fed.us',
            'password' => '$2y$10$qwgF2oUG4r4F7RQKXVCQVOWtsrjZwapWP0SJvoGFaeiKKqz/DR7eO',
            'crew_id' => $crew->id,
        ));
        $crew->statuses()->create($this->createCrewStatusArray($user->name, $user->id, 'Quinones', '541-471-6847'));
        Rappelhelicopter::create(array(
            'identifier' => 'N205RH',
            'model' => 'Bell 205A1++',
            'crew_id' => $crew->id,
        ));

//

        $crew = Crew::create(array(
            'name' => 'Central Oregon Rappellers',
            'phone' => '541-416-6840',
            'dispatch_center_name' => 'Central Oregon Dispatch',
            'dispatch_center_identifier' => 'COIDC',
            'dispatch_center_daytime_phone' => '222-999-9999',
            'dispatch_center_24_hour_phone' => '222-555-3344',
        ));
        $user = User::create(array(
            'name' => 'Chad Schmidt',
            'email' => 'chadschmidt@fs.fed.us',
            'password' => '$2y$10$qwgF2oUG4r4F7RQKXVCQVOWtsrjZwapWP0SJvoGFaeiKKqz/DR7eO',
            'crew_id' => $crew->id,
        ));
        $crew->statuses()->create($this->createCrewStatusArray($user->name, $user->id, 'Schmidt', '541-416-6840'));
        Rappelhelicopter::create(array(
            'identifier' => 'N223HT',
            'model' => 'Bell 205A1++',
            'crew_id' => $crew->id,
        ));

//

        $crew = Crew::create(array(
            'name' => 'Malheur Rappellers',
            'phone' => '541-575-3384',
            'dispatch_center_name' => 'John Day Dispatch',
            'dispatch_center_identifier' => '',
            'dispatch_center_daytime_phone' => '222-999-9999',
            'dispatch_center_24_hour_phone' => '222-555-3344',

        ));
        $user = User::create(array(
            'name' => 'Anthony Hernandez',
            'email' => 'ahernandez@fs.fed.us',
            'password' => '$2y$10$qwgF2oUG4r4F7RQKXVCQVOWtsrjZwapWP0SJvoGFaeiKKqz/DR7eO',
            'crew_id' => $crew->id,
        ));
        $crew->statuses()->create($this->createCrewStatusArray($user->name, $user->id, 'Hernandez', '541-333-2233'));
        Rappelhelicopter::create(array(
            'identifier' => 'N510WW',
            'model' => 'Bell 210',
            'crew_id' => $crew->id,
        ));

//

        $crew = Crew::create(array(
            'name' => 'Wenatchee Valley Rappellers',
            'phone' => '509-884-2492',
        ));
        $user = User::create(array(
            'name' => 'Mike Davis',
            'email' => 'mjdavis02@fs.fed.us',
            'password' => '$2y$10$qwgF2oUG4r4F7RQKXVCQVOWtsrjZwapWP0SJvoGFaeiKKqz/DR7eO',
            'crew_id' => $crew->id,
        ));
        $crew->statuses()->create($this->createCrewStatusArray($user->name, $user->id, 'Smith', '444-999-8080'));
        Rappelhelicopter::create(array(
            'identifier' => 'N502HQ',
            'model' => 'Bell 205++',
            'crew_id' => $crew->id,
        ));

//

        $crew = Crew::create(array(
            'name' => 'Grande Ronde Rappellers',
            'phone' => '541-975-5440',
        ));
        $user = User::create(array(
            'name' => 'Kyle Johnson',
            'email' => 'kylejohnson@fs.fed.us',
            'password' => '$2y$10$qwgF2oUG4r4F7RQKXVCQVOWtsrjZwapWP0SJvoGFaeiKKqz/DR7eO',
            'crew_id' => $crew->id,
        ));
        $crew->statuses()->create($this->createCrewStatusArray($user->name, $user->id));
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

//

        $crew = Crew::create(array(
            'name' => 'Price Valley Helirappellers',
            'phone' => '208-347-0327 x3001',
        ));
        $user = User::create(array(
            'name' => 'Cory Dolberry',
            'email' => 'cdolberry@fs.fed.us',
            'password' => '$2y$10$qwgF2oUG4r4F7RQKXVCQVOWtsrjZwapWP0SJvoGFaeiKKqz/DR7eO',
            'crew_id' => $crew->id,
        ));
        $crew->statuses()->create($this->createCrewStatusArray($user->name, $user->id));
        Rappelhelicopter::create(array(
            'identifier' => 'N16HX',
            'model' => 'Bell 205A1++',
            'crew_id' => $crew->id,
        ));

//

        $crew = Crew::create(array(
            'name' => 'Gallatin Rappel Crew',
            'phone' => '406-763-4874',
        ));
        $user = User::create(array(
            'name' => 'Ward Hiesterman',
            'email' => 'whiesterman@fs.fed.us',
            'password' => '$2y$10$qwgF2oUG4r4F7RQKXVCQVOWtsrjZwapWP0SJvoGFaeiKKqz/DR7eO',
            'crew_id' => $crew->id,
        ));
        $crew->statuses()->create($this->createCrewStatusArray($user->name, $user->id));
        Rappelhelicopter::create(array(
            'identifier' => 'N9122Z',
            'model' => 'Bell 212HP',
            'crew_id' => $crew->id,
        ));

//

        $crew = Crew::create(array(
            'name' => 'Salmon Heli-Rappellers',
            'phone' => '208-756-8122',
        ));
        $user = User::create(array(
            'name' => 'Curtis Parkhouse',
            'email' => 'cparkhouse@fs.fed.us',
            'password' => '$2y$10$qwgF2oUG4r4F7RQKXVCQVOWtsrjZwapWP0SJvoGFaeiKKqz/DR7eO',
            'crew_id' => $crew->id,
        ));
        $crew->statuses()->create($this->createCrewStatusArray($user->name, $user->id));
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

//

        $crew = Crew::create(array(
            'name' => 'Lucky Peak Rappel Crew',
            'phone' => '208-373-4277',
        ));
        $user = User::create(array(
            'name' => 'Jeremy Schwandt',
            'email' => 'jsschwandt@fs.fed.us',
            'password' => '$2y$10$qwgF2oUG4r4F7RQKXVCQVOWtsrjZwapWP0SJvoGFaeiKKqz/DR7eO',
            'crew_id' => $crew->id,
        ));
        $crew->statuses()->create($this->createCrewStatusArray($user->name, $user->id));
        Rappelhelicopter::create(array(
            'identifier' => 'N205DY',
            'model' => 'Bell 205A1++',
            'crew_id' => $crew->id,
        ));

//

        $crew = Crew::create(array(
            'name' => 'Scott Valley Rappel Crew',
            'phone' => '530-468-1294',
        ));
        $user = User::create(array(
            'name' => 'Scott Valley',
            'email' => 'scottvalley@fs.fed.us',
            'password' => '$2y$10$qwgF2oUG4r4F7RQKXVCQVOWtsrjZwapWP0SJvoGFaeiKKqz/DR7eO',
            'crew_id' => $crew->id,
        ));
        $crew->statuses()->create($this->createCrewStatusArray($user->name, $user->id));
        Rappelhelicopter::create(array(
            'identifier' => 'N183HQ (H-502)',
            'model' => 'Bell 205A1++',
            'crew_id' => $crew->id,
        ));

//

        $crew = Crew::create(array(
            'name' => 'Sierra Helitack ',
            'phone' => '559-855-8325',
            'dispatch_center_name' => 'Cali Dispatch',
            'dispatch_center_identifier' => 'CD',
            'dispatch_center_daytime_phone' => '222-999-9999',
            'dispatch_center_24_hour_phone' => '222-555-3344',
        ));
        $user = User::create(array(
            'name' => 'Casey Jones',
            'email' => 'cjones06@fs.fed.us',
            'password' => '$2y$10$qwgF2oUG4r4F7RQKXVCQVOWtsrjZwapWP0SJvoGFaeiKKqz/DR7eO',
            'crew_id' => $crew->id,
        ));
        $crew->statuses()->create($this->createCrewStatusArray($user->name, $user->id));
        Rappelhelicopter::create(array(
            'identifier' => 'N213KA (H-520)',
            'model' => 'Bell 212',
            'crew_id' => $crew->id,
        ));

//

        $crew = Crew::create(array(
            'name' => 'Kootenai Rappel Crew',
            'phone' => '406-283-7865',
        ));
        $user = User::create(array(
            'name' => 'Kootenai',
            'email' => 'kootenai@fs.fed.us',
            'password' => '$2y$10$qwgF2oUG4r4F7RQKXVCQVOWtsrjZwapWP0SJvoGFaeiKKqz/DR7eO',
            'crew_id' => $crew->id,
        ));
        $crew->statuses()->create($this->createCrewStatusArray($user->name, $user->id));
        Rappelhelicopter::create(array(
            'identifier' => 'N571SC',
            'model' => 'Bell 212HP',
            'crew_id' => $crew->id,
        ));

//

        $crew = Crew::create(array(
            'name' => 'Rappel Specialist',
            'phone' => '888-888-8888',
        ));
        $user = User::create(array(
            'name' => 'Eric Bush',
            'email' => 'ejbush@fs.fed.us',
            'password' => '$2y$10$qwgF2oUG4r4F7RQKXVCQVOWtsrjZwapWP0SJvoGFaeiKKqz/DR7eO',
            'crew_id' => $crew->id,
        ));
        $crew->statuses()->create($this->createCrewStatusArray($user->name, $user->id));
    }

    private function createCrewStatusArray($updatedByName, $updatedById, $dutyOfficerName='', $dutyOfficerPhone='')
    {
        return [
            'intel'                 => "",
            'personnel_1_name'      => "",
            'personnel_1_role'      => "",
            'personnel_1_location'  => "",
            'personnel_1_note'      => "",
            'created_by_name'       => $updatedByName,
            'created_by_id'         => $updatedById,
            'duty_officer_name'     => $dutyOfficerName,
            'duty_officer_phone'    => $dutyOfficerPhone,
        ];
    }
}
