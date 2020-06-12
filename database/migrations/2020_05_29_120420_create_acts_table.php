<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('acts', function (Blueprint $table) {
            $table->increments('id');
			
			$table->integer('equipment_id')->unsigned()->index()->nullable(); //id оборудования на которое был сделан вызов
			$table->integer('caller_id')->unsigned()->index()->nullable(); //id того кто вызвал сервисную службу
            $table->integer('dispatcher_id')->unsigned()->index()->nullable(); //id того кто принял заявку
			
			$table->foreign('equipment_id')->references('id')->on('equipments');
			$table->foreign('caller_id')->references('id')->on('persons');
			$table->foreign('dispatcher_id')->references('id')->on('users');
			
			$table->tinyInteger('status')->default(0); //статус 0 - только что открыта, 1 - проведена диагностика, нужны детали, 2 - проведена диагностика, не успели закончить, 3 - было закрыто, 4 - сделали, заявка закрыта, 5 - ложный вызов, заявка закрыта
			$table->tinyInteger('distance')->default(0); //0 - сами привезли, 1 - в своем же городе, 2 - в городе рядом, 3 - очень далеко
			$table->tinyInteger('delivery')->default(0); //0 - сделали на месте, 1 - доставка в сервис-центр
			
			$table->text('problem')->nullable(); //описание проблемы со слов заказчика
			$table->text('diagnos')->nullable(); //результат диагностики
			$table->text('plan')->nullable(); //что нужно сделать
			$table->text('work')->nullable(); //что сделали
			
			$table->string('city'); //город 
			$table->string('address'); //адрес
			$table->string('phone1'); //телефон 1
			$table->string('phone2'); //телефон 2
			$table->string('company'); // организация
			$table->string('department'); // отдел организации - так как оборудование потом может быть перепродано или перевезено
			$table->string('owner_fio'); // ФИО частного владельца
			
			$table->string('fio'); //если "левый" человек вызвал
			
			$table->timestamp('when_diagnos'); //когда сделали диагностику или был выезд
			$table->timestamp('when_closed'); //когда закрыли заявку
			
			$table->timestamps(); //когда была создана заявка
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
