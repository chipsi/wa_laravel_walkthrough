<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Persons extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::create('persons', function(Blueprint $table) {
			$table->increments('id');
            $table->string('nickname', 100);
            $table->string('first_name', 100);
            $table->string('last_name', 100);
            $table->integer('id_location')->unsigned()->nullable();
            $table->date('birth_day')->nullable();
            $table->integer('height')->unsigned()->nullable();
            $table->timestamps();

			$table->unique(['nickname', 'first_name', 'last_name']);
			$table->foreign('id_location')->references('id')->on('locations')->onDelete('cascade');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('persons');
    }
}
