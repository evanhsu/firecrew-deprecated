<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePeopleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('people', function (Blueprint $table) {
            $table->increments('id');
            $table->string('iqcs_number')->nullable();
            $table->string('firstname')->nullable();
            $table->string('lastname')->nullable();
            $table->boolean('male')->nullable();
            $table->datetime('birthdate')->nullable();
            $table->string('avatar_filename')->nullable();
            $table->text('bio')->nullable();
            $table->boolean('has_purchase_card')->default(false);
            $table->boolean('temporary')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('people');
    }
}
