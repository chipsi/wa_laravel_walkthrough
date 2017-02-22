<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Locations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::create('locations', function(Blueprint $table) {
			$table->increments('id');
            $table->string('city', 200)->nullable();
            $table->string('street_name', 200)->nullable();
            $table->integer('street_number')->unsigned()->nullable();
			$table->string('zip', 50)->nullable();
			$table->string('country', 200)->nullable();
			$table->string('name', 200)->nullable();
			$table->float('latitude')->nullable();
			$table->float('longitude')->nullable();
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
        Schema::drop('locations');
    }
}
