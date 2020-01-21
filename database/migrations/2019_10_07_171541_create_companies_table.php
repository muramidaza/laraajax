<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->increments('id');
			$table->string('name');
			$table->string('director')->nullable();
			$table->string('phone1')->nullable();
			$table->string('phone2')->nullable();
			$table->string('address')->nullable();
			$table->string('website')->nullable();
			$table->string('email')->nullable();

			$table->string('OGRN')->nullable();
			$table->string('INN')->nullable();
			$table->string('KPP')->nullable();
			$table->string('UridAddress')->nullable();
			$table->string('OKPO')->nullable();
			$table->string('OKVED')->nullable();
			
			$table->string('RSchet')->nullable();
			$table->string('KSchet')->nullable();
			$table->string('BIK')->nullable();
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
        Schema::dropIfExists('companies');
    }
}
