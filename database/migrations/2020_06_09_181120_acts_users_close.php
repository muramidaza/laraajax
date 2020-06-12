<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ActsUsersClose extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
		Schema::create('users_acts_close', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('act_id')->unsigned()->index();
			$table->foreign('act_id')->references('id')->on('users')->onDelete('cascade');
			$table->integer('user_id')->unsigned()->index();
			$table->foreign('user_id')->references('id')->on('acts')->onDelete('cascade');
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
