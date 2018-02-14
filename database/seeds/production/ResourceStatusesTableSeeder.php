<?php
namespace App\Database\Seeds\Production;

use App\Domain\StatusableResources\RappelHelicopter;
use App\Domain\StatusableResources\ShortHaulHelicopter;
use App\Domain\StatusableResources\SmokeJumperAirplane;
use App\Domain\Crews\Crew;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ResourceStatusesTableSeeder extends Seeder
{

    public function run()
    {
        DB::table('resource_statuses')->delete();

        $this->createStatusForRappelHelicopter('N205RH', 'Tim Lyda', [42.5063, -123.3823]);
        $this->createStatusForRappelHelicopter('N223HT', 'Adam Kahler', [44.2792, -120.9022]);
        $this->createStatusForRappelHelicopter('N510WW', 'Nick Sailer', [44.404, -118.9635]);
        $this->createStatusForRappelHelicopter('N502HQ', 'Wallace', [47.40, -120.2045]);
        $this->createStatusForRappelHelicopter('N669H', 'Simon Driskell', [45.29, -118.0]);
        $this->createStatusForRappelHelicopter('N689H', 'Jake Mason', [45.295, -118.0]);
        $this->createStatusForRappelHelicopter('N16HX', 'Bohnstedt', [45.0207, -116.4369]);
        $this->createStatusForRappelHelicopter('N9122Z', 'Benfatti', [45.45, -111.2428]);
        $this->createStatusForRappelHelicopter('N932CH', 'Parkhouse', [45.1151, -113.881]);
        $this->createStatusForRappelHelicopter('N933CH', 'Todd Sexton', [45.115, -113.89]);
        $this->createStatusForRappelHelicopter('N205DY', 'Schwandt', [43.5757, -115.9853]);
        $this->createStatusForRappelHelicopter('N183HQ (H-502)', 'Torres', [41.557, -122.8533]);
        $this->createStatusForRappelHelicopter('N213KA (H-520)', 'Casey Jones', [36.905, -119.3155]);
        $this->createStatusForRappelHelicopter('N571SC', '', [48.3863367, -115.55058]);
    }//End run()

    private function createStatusForRappelHelicopter($tailnumber, $managerName, $coords)
    {
        $rightNow = Carbon::now();
//        $yesterday = Carbon::now()->subday(); // A timestamp from yesterday
//        $lastWeek = Carbon::now()->subweek(); // A timestamp from last week

        $heli = RappelHelicopter::where("identifier", $tailnumber)->first();
        $crew = $heli->crew;
        $user = $crew->users()->first();
        $statusArray = array(
            'statusable_resource_type' => $heli->resource_type,
            'statusable_resource_name' => $heli->identifier,
            'latitude' => $coords[0],
            'longitude' => $coords[1],
            'staffing_category1' => $heli->staffingCategory1(),
            'staffing_category2' => $heli->staffingCategory2(),
            'staffing_value1' => "3",
            'staffing_value2' => "4",
            'manager_name' => $managerName,
            'manager_phone' => '555-888-1925',
            'comments1' => "The 2017 contact has ended.",
            'comments2' => "The 2018 contract begins in June",
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
        $status = $heli->statuses()->create($statusArray);

        return $status;
    }

    private function createPopupinfo($status)
    {
        switch ($status['statusable_resource_type']) {
            case ShortHaulHelicopter::resourceType():
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

            case RappelHelicopter::resourceType():
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

            case SmokeJumperAirplane::resourceType():
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
