<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCrewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crews', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('abbreviation')->nullable();
            $table->string('type')->nullable();
            $table->string("statusable_type")->nullable();
            $table->integer('region')->nullable();
            $table->string('phone', 25)->nullable();
            $table->string('fax', 25)->nullable();
            $table->string('logo_filename')->nullable();
            $table->string('address_street1')->nullable();
            $table->string('address_street2')->nullable();
            $table->string('address_city')->nullable();
            $table->string('address_state')->nullable();
            $table->string('address_zip')->nullable();

            $table->string('dispatch_center_name')->nullable();
            $table->string('dispatch_center_identifier')->nullable();
            $table->string('dispatch_center_daytime_phone')->nullable();
            $table->string('dispatch_center_24_hour_phone')->nullable();

            $table->timestampsTz();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('crews');
        Schema::enableForeignKeyConstraints();
    }
}
