<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLocationNameToCrewStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('crew_statuses', function (Blueprint $table) {
            //
            Schema::table('crew_statuses', function (Blueprint $table) {
                //
                $table->string('location_name')->nullable();
            });        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('crew_statuses', function (Blueprint $table) {
            //
            $table->dropColumn('location_name');
        });
    }
}
