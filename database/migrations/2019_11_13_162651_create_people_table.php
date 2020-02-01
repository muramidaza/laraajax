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
			$table->string('name');
			$table->string('surname')->nullable();
			$table->string('patronymic')->nullable();
			$table->date('datebirth')->nullable();
			$table->enum('sex', ['man', 'woman'])->nullable();
			$table->string('phone1')->nullable();
			$table->string('phone2')->nullable();
			$table->string('address')->nullable();
			$table->string('email')->nullable();
			$table->string('web')->nullable();
			$table->string('post')->nullable();
			$table->boolean('executive')->nullable();
            $table->timestamps();
			$table->softDeletes();
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
