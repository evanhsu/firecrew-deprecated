<?php

use App\Domain\Aircrafts\Aircraft;
use App\Domain\Aircrafts\RappelHelicopter;
use App\Domain\Aircrafts\ShortHaulHelicopter;
use App\Domain\Aircrafts\SmokeJumperAirplane;
use App\Domain\Crews\Crew;
use App\Domain\Statuses\Status;
use App\Domain\Users\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StatusesTableSeeder extends Seeder
{

    public function run()
    {
        DB::table('statuses')->delete();

        $rightNow = Carbon::now();

        $heli = Aircraft::where("tailnumber", "N1111")->first();
        $user = User::where("crew_id", $heli->crew_id)->first();
        $crew = $heli->crew;
        $oldtime = Carbon::now()->subday(); // A timestamp from yesterday
        $statusArray = array(
            'statusable_type' => $crew->statusable_type,
            'statusable_id' => $heli->id,
            'statusable_name' => $heli->tailnumber,
            'latitude' => 42.454223,
            'longitude' => -123.310388,
            'staffing_value1' => "3",
            'staffing_value2' => "4",
            'manager_name' => "Bob Nielson",
            'manager_phone' => "789-566-4430",
            'comments1' => "This is update 1 of 2 from the db seeder",
            'comments2' => "This is upcoming",
            'assigned_fire_name' => "Gasquet Complex",
            'assigned_fire_number' => "WA-FRE-150038",
            'assigned_supervisor' => "John Thompson",
            'assigned_supervisor_phone' => "333-444-5555",
            'distance' => 100,
            'label_text' => ".",
            'created_by_name' => $user->name,
            'created_by_id' => $user->id,
            'created_at' => $oldtime,
            'updated_at' => $oldtime,
            'crew_name' => $crew->name,
            'popup_content' => ""
        );
        $statusArray['popup_content'] = $this->createPopupinfo($statusArray);
        $status = Status::create($statusArray);


        $statusArray = array(
            'statusable_type' => $crew->statusable_type,
            'statusable_id' => $heli->id,
            'statusable_name' => $heli->tailnumber,
            'latitude' => 42.464223,
            'longitude' => -121.210388,
            'staffing_value1' => "3",
            'staffing_value2' => "4",
            'manager_name' => "Bob Nielson",
            'manager_phone' => "789-566-4430",
            'comments1' => "This is update 2 of 2 from the db seeder",
            'comments2' => "This is upcoming",
            'assigned_fire_name' => "Gasquet Complex",
            'assigned_fire_number' => "WA-FRE-150038",
            'assigned_supervisor' => "John Thompson",
            'assigned_supervisor_phone' => "333-444-5555",
            'distance' => 100,
            'label_text' => ".",
            'created_by_name' => $user->name,
            'created_by_id' => $user->id,
            'created_at' => $rightNow,
            'updated_at' => $rightNow,
            'crew_name' => $crew->name,
            'popup_content' => ""
        );
        $statusArray['popup_content'] = $this->createPopupinfo($statusArray);
        $status = Status::create($statusArray);


        $heli = Aircraft::where("tailnumber", "N2222")->first();
        $user = User::where("crew_id", $heli->crew_id)->first();
        $crew = $heli->crew;
        $statusArray = array(
            'statusable_type' => $crew->statusable_type,
            'statusable_id' => $heli->id,
            'statusable_name' => $heli->tailnumber,
            'latitude' => 44.084223,
            'longitude' => -119.310388,
            'staffing_value1' => "3",
            'staffing_value2' => "4",
            'manager_name' => "Jim Lewis",
            'manager_phone' => "250-778-5443",
            'comments1' => "This is update 1 of 1 from the db seeder",
            'comments2' => "This is upcoming",
            'assigned_fire_name' => "Big Windy",
            'assigned_fire_number' => "OR-RSF-150208",
            'assigned_supervisor' => "Bill Newman",
            'assigned_supervisor_phone' => "333-444-5555",
            'distance' => 100,
            'label_text' => ".",
            'created_by_name' => $user->name,
            'created_by_id' => $user->id,
            'created_at' => $rightNow,
            'updated_at' => $rightNow,
            'crew_name' => $crew->name,
            'popup_content' => ""
        );
        $statusArray['popup_content'] = $this->createPopupinfo($statusArray);
        $status = Status::create($statusArray);


        $heli = Aircraft::where("tailnumber", "N3333")->first();
        $user = User::where("crew_id", $heli->crew_id)->first();
        $crew = $heli->crew;
        $statusArray = array(
            'statusable_type' => $crew->statusable_type,
            'statusable_id' => $heli->id,
            'statusable_name' => $heli->tailnumber,
            'latitude' => 46.384223,
            'longitude' => -115.310388,
            'staffing_value1' => "3",
            'staffing_value2' => "4",
            'manager_name' => "Steve Borland",
            'manager_phone' => "334-998-6756",
            'comments1' => "This is update 1 of 1 from the db seeder",
            'comments2' => "This is upcoming",
            'assigned_fire_name' => "",
            'assigned_fire_number' => "",
            'assigned_supervisor' => "",
            'assigned_supervisor_phone' => "",
            'Distance' => 100,
            'label_text' => ".",
            'created_by_name' => $user->name,
            'created_by_id' => $user->id,
            'created_at' => $rightNow,
            'updated_at' => $rightNow,
            'crew_name' => $crew->name,
            'popup_content' => ""
        );
        $statusArray['popup_content'] = $this->createPopupinfo($statusArray);
        $status = Status::create($statusArray);


        $heli = Aircraft::where("tailnumber", "J-83")->first();
        $user = User::where("crew_id", $heli->crew_id)->first();
        $crew = $heli->crew;
        $statusArray = array(
            'statusable_type' => $crew->statusable_type,
            'statusable_id' => $heli->id,
            'statusable_name' => $heli->tailnumber,
            'latitude' => 38.511060,
            'longitude' => -118.441425,
            'staffing_value1' => "3",
            'staffing_value2' => "4",
            'manager_name' => "Mark Kennedy",
            'manager_phone' => "789-432-2120",
            'comments1' => "This is update 1 of 1 from the db seeder",
            'comments2' => "This is upcoming",
            'assigned_fire_name' => "",
            'assigned_fire_number' => "",
            'assigned_supervisor' => "",
            'assigned_supervisor_phone' => "",
            'distance' => 100,
            'label_text' => ".",
            'created_by_name' => $user->name,
            'created_by_id' => $user->id,
            'created_at' => $rightNow,
            'updated_at' => $rightNow,
            'crew_name' => $crew->name,
            'popup_content' => ''
        );
        $statusArray['popup_content'] = $this->createPopupinfo($statusArray);
        $status = Status::create($statusArray);


        $heli = Aircraft::where("tailnumber", "J-89")->first();
        $user = User::where("crew_id", $heli->crew_id)->first();
        $crew = $heli->crew;
        $oldtime = Carbon::now()->subDays(3); // A stale timestamp
        $statusArray = array(
            'statusable_type' => $crew->statusable_type,
            'statusable_id' => $heli->id,
            'statusable_name' => $heli->tailnumber,
            'latitude' => 45.281331,
            'longitude' => -116.225388,
            'staffing_value1' => "3",
            'staffing_value2' => "4",
            'manager_name' => "Pat Stone",
            'manager_phone' => "530-448-8581",
            'comments1' => "This is update 1 of 1 from the db seeder",
            'comments2' => "This is upcoming",
            'assigned_fire_name' => "Morning Fire",
            'assigned_fire_number' => "MT-FFT-150038",
            'assigned_supervisor' => "Gary Pickett",
            'assigned_supervisor_phone' => "333-444-5555",
            'distance' => 100,
            'label_text' => ".",
            'created_by_name' => $user->name,
            'created_by_id' => $user->id,
            'created_at' => $oldtime,
            'updated_at' => $oldtime,
            'crew_name' => $crew->name,
            'popup_content' => ''
        );
        $statusArray['popup_content'] = $this->createPopupinfo($statusArray);
        $status = Status::create($statusArray);


        $crew = Crew::where("name", "Prineville Hotshots")->first();
        $user = User::where("crew_id", $crew->id)->first();
        $oldtime = Carbon::now()->subDays(3); // A stale timestamp
        $statusArray = array(
            'statusable_type' => $crew->statusable_type,
            'statusable_id' => $crew->id,
            'statusable_name' => $crew->name,
            'latitude' => 45.281331,
            'longitude' => -111.225388,
            'staffing_value1' => "3",
            'staffing_value2' => "4",
            'manager_name' => "Pat Stone",
            'manager_phone' => "530-448-8581",
            'comments1' => "This is update 1 of 1 from the db seeder",
            'comments2' => "This is upcoming",
            'assigned_fire_name' => "Morning Fire",
            'assigned_fire_number' => "MT-FFT-150038",
            'assigned_supervisor' => "Gary Pickett",
            'assigned_supervisor_phone' => "333-444-5555",
            'distance' => 100,
            'label_text' => ".",
            'created_by_name' => $user->name,
            'created_by_id' => $user->id,
            'created_at' => $oldtime,
            'updated_at' => $oldtime,
            'crew_name' => $crew->name,
            'popup_content' => ''
        );
        $statusArray['popup_content'] = $this->createPopupinfo($statusArray);
        $status = Status::create($statusArray);


    }//End run()

    private function createPopupinfo($status)
    {
        switch ($status['statusable_type']) {
            case ShortHaulHelicopter::class:
                return "<table class=\"popup-table\">
                        <tr>
                            <td class=\"logo-cell\" aria-label=\"Logo\" title=\"Crew Logo\">
                                <img src=\"\"/>
                            </td>

                            <td aria-label=\"Aircraft Info\" title=\"Current manager & aircraft info\">
                                <div class=\"popup-col-header\"><span class=\"glyphicon glyphicon-plane\"></span> HMGB</div>
                                " . $status['manager_name'] . "<br />
                                " . $status['manager_phone'] . "
                            </td>

                            <td aria-label=\"Current Staffing\" title=\"Current staffing levels\">
                                <div class=\"popup-col-header\"><span class=\"glyphicon glyphicon-user\"></span> Staffing</div>
                                <table class=\"staffing_table\">
                                    <tr><td>EMT:</td><td>" . $status['staffing_value1'] . "</td></tr>
                                    <tr><td>HAUL:</td><td>" . $status['staffing_value2'] . "</td></tr>
                                </table>
                            </td>

                            <td aria-label=\"Current Assignment\" title=\"Current assignment & supervisor\">
                                <div class=\"popup-col-header\"><span class=\"glyphicon glyphicon-map-marker\"></span> Assigned</div>
                                " . $status['assigned_fire_name'] . "<br />
                                " . $status['assigned_fire_number'] . "<br />
                                " . $status['assigned_supervisor'] . "<br />
                                " . $status['assigned_supervisor_phone'] . "</td>
                        </tr>
                        <tr>
                            <td class=\"timestamp-cell\" colspan=\"4\">Updated: " . $status['created_at'] . "</td>
                        </tr>
                    </table>";
                break;

            case RappelHelicopter::class:
                return "<table class=\"popup-table\">
                        <tr>
                            <td class=\"logo-cell\" aria-label=\"Logo\" title=\"Crew Logo\">
                                <img src=\"\"/>
                            </td>

                            <td aria-label=\"Aircraft Info\" title=\"Current manager & aircraft info\">
                                <div class=\"popup-col-header\"><span class=\"glyphicon glyphicon-plane\"></span> HMGB</div>
                                " . $status['manager_name'] . "<br />
                                " . $status['manager_phone'] . "
                            </td>

                            <td aria-label=\"Current Staffing\" title=\"Current staffing levels\">
                                <div class=\"popup-col-header\"><span class=\"glyphicon glyphicon-user\"></span> Staffing</div>
                                <table class=\"staffing_table\">
                                    <tr><td>HRAP:</td><td>" . $status['staffing_value1'] . "</td></tr>
                                    <tr><td>Surplus:</td><td>" . $status['staffing_value2'] . "</td></tr>
                                </table>
                            </td>

                            <td aria-label=\"Current Assignment\" title=\"Current assignment & supervisor\">
                                <div class=\"popup-col-header\"><span class=\"glyphicon glyphicon-map-marker\"></span> Assigned</div>
                                " . $status['assigned_fire_name'] . "<br />
                                " . $status['assigned_fire_number'] . "<br />
                                " . $status['assigned_supervisor'] . "<br />
                                " . $status['assigned_supervisor_phone'] . "</td>
                        </tr>
                        <tr>
                            <td class=\"timestamp-cell\" colspan=\"4\">Updated: " . $status['created_at'] . "</td>
                        </tr>
                    </table>";
                break;

            case SmokeJumperAirplane::class:
                return "<table class=\"popup-table\">
                        <tr>
                            <td class=\"logo-cell\" aria-label=\"Logo\" title=\"Crew Logo\">
                                <img src=\"\"/>
                            </td>

                            <td aria-label=\"Aircraft Info\" title=\"Current manager & aircraft info\">
                                <div class=\"popup-col-header\"><span class=\"glyphicon glyphicon-plane\"></span> Spotter</div>
                                " . $status['manager_name'] . "<br />
                                " . $status['manager_phone'] . "
                            </td>

                            <td aria-label=\"Current Staffing\" title=\"Current staffing levels\">
                                <div class=\"popup-col-header\"><span class=\"glyphicon glyphicon-user\"></span> Staffing</div>
                                <table class=\"staffing_table\">
                                    <tr><td>SMKJ:</td><td>" . $status['staffing_value1'] . "</td></tr>
                                </table>
                            </td>

                            <td aria-label=\"Current Assignment\" title=\"Current assignment & supervisor\">
                                <div class=\"popup-col-header\"><span class=\"glyphicon glyphicon-map-marker\"></span> Assigned</div>
                                " . $status['assigned_fire_name'] . "<br />
                                " . $status['assigned_fire_number'] . "<br />
                                " . $status['assigned_supervisor'] . "<br />
                                " . $status['assigned_supervisor_phone'] . "</td>
                        </tr>
                        <tr>
                            <td class=\"timestamp-cell\" colspan=\"4\">Updated: " . $status['created_at'] . "</td>
                        </tr>
                    </table>";
                break;

            case Crew::class:
                $output = "<table class=\"popup-table\">
                        <tr>
                            <td class=\"logo-cell\" aria-label=\"Logo\" title=\"Crew Logo\">
                                <img src=\"\"/>
                            </td>

                            <td aria-label=\"Crew Info\" title=\"Current crew boss & crew info\">
                                <div class=\"popup-col-header\"><span class=\"glyphicon glyphicon-user\"></span> CRWB</div>
                                " . $status['manager_name'] . "<br />
                                " . $status['manager_phone'] . "
                            </td>

                            <td aria-label=\"Current Staffing\" title=\"Current staffing levels\">
                                <div class=\"popup-col-header\"><span class=\"glyphicon glyphicon-user\"></span> Staffing</div>
                                <table class=\"staffing_table\">
                                    <tr><td>Crew size:</td><td>" . $status['staffing_value1'] . "</td></tr>";

                if ($status['comments2'] == "true") $output .= "<tr><td>Available: Yes</td></tr>";
                else $output .= "<tr><td>Available: No</td></tr>";

                $output .= "</table>
                            </td>

                            <td aria-label=\"Current Assignment\" title=\"Current assignment & supervisor\">
                                <div class=\"popup-col-header\"><span class=\"glyphicon glyphicon-map-marker\"></span> Assigned</div>
                                " . $status['assigned_fire_name'] . "<br />
                                " . $status['assigned_fire_number'] . "<br />
                                " . $status['assigned_supervisor'] . "<br />
                                " . $status['assigned_supervisor_phone'] . "
                                Day 1: " . $status['staffing_value2'] . "</td>

                        </tr>
                        <tr>
                            <td class=\"timestamp-cell\" colspan=\"4\">Updated: " . $status['created_at'] . "</td>
                        </tr>
                    </table>";
                return $output;
                break;
        } // End switch()
    } // createPopupinfo()

}
