<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAktsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('akts', function (Blueprint $table) {
            $table->increments('id');
			
			$table->integer('equipment_id')->unsigned()->index(); //id оборудования на которое был сделан вызов
			$table->integer('person_id')->unsigned()->index()->nullable(); //id того кто вызвал сервисную службу
            $table->integer('user_id')->unsigned()->index(); //id того кто принял заявку
			
			$table->tinyInteger('status')->default(0); //статус 0 - только что открыта, 1 - проведена диагностика, нужны детали, 2 - проведена диагностика, не успели закончить, 3 - было закрыто, 4 - сделали, заявка закрыта, 5 - ложный вызов, заявка закрыта
			$table->tinyInteger('distance')->default(0); //0 - сами привезли, 1 - в своем же городе, 2 - в городе рядом, 3 - очень далеко
			$table->tinyInteger('delivery')->default(0); //0 - сами привезли, 1 - выезжали
			
			$table->text('problem')->nullable(); //описание проблемы со слов заказчика
			$table->text('diagnos')->nullable(); //результат диагностики
			$table->text('work')->nullable(); //что сделали
			
			$table->string('city'); //город 
			$table->string('address'); //адрес
			$table->string('company'); // организация
			$table->string('department'); // отдел организации - так как оборудование потом может быть перепродано или перевезено
			
			$table->string('fio'); //если "левыйЭ человек вызвал
			
			$table->timestamp('closed');
			
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
        Schema::dropIfExists('akts');
    }
}
