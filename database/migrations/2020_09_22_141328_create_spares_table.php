<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSparesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spares', function (Blueprint $table) {
            $table->increments('id');
			$table->string('type')->nullable(); //тип
			$table->string('name')->nullable(); //название
			$table->string('model')->nullable(); //модель 
			$table->string('parameter')->nullable(); //номинал размер
			$table->float('qty')->nullable(); //количество
			$table->enum('unit', ['шт', 'кг', 'г', 'л', 'мл', 'м', 'см', 'мм'])->nullable(); //единица измерения
			$table->string('note')->nullable(); //примечание
			$table->tinyInteger('ordered')->default(0); //деталь заказана
			$table->date('datedeliv')->nullable(); //дата доставки
			$table->string('servicedeliv')->default(0); //транспортная компания служба
			$table->tinyInteger('instock')->default(0); //деталь доставлена на склад
			$table->tinyInteger('installed')->default(0); //деталь установлена
			$table->integer('act_id')->unsigned()->index()->nullable(); //id акта
			$table->foreign('act_id')->references('id')->on('acts');			
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
        Schema::dropIfExists('spares');
    }
}
