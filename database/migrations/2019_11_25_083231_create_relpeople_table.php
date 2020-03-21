<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRelpeopleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
		Schema::create('relpeople', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('relperson_id')->unsigned()->index();
			$table->string('relperson_type');
			$table->integer('person_id')->unsigned()->index();
			$table->foreign('person_id')->references('id')->on('persons')->onDelete('cascade');        
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
