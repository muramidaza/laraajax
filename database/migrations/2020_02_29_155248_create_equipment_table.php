<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEquipmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('equipment', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type');
			$table->string('manufacturer');
			$table->string('model');
			$table->string('modification')->nullable();
			$table->string('sernumber')->nullable();
			$table->date('datemanuf')->nullable();
			$table->string('invnumber')->nullable();
			$table->string('voltage')->nullable();
			$table->string('current')->nullable();
			$table->string('power')->nullable();
			$table->string('weight')->nullable();
			$table->string('sizes')->nullable();
			$table->string('manufсountry')->nullable();
			$table->text('note')->nullable();
			$table->boolean('incontract')->nullable();
			$table->integer('owner_id')->unsigned()->index()->nullable();
			$table->string('owner_type')->nullable();			
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
        Schema::dropIfExists('equipment');
    }
}
