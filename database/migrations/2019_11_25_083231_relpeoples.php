<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Relpeoples extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
		Schema::create('relpeoples', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('relpeople_id')->unsigned()->index();
			$table->string('relpeople_type');
			$table->integer('people_id')->unsigned()->index();
			$table->foreign('people_id')->references('id')->on('people')->onDelete('cascade');        
		});
	
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
