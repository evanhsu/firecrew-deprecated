<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStaffingcategory3ColumnToResourceStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('resource_statuses', function (Blueprint $table) {
            $table->string('staffing_category3',100)->nullable();
            $table->string('staffing_value3',100)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('resource_statuses', function (Blueprint $table) {
            // No safe way to remove these columns without losing data.
        });
    }
}
