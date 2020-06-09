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
			
			$table->integer('equipment_id')->unsigned()->index()->nullable(); //id оборудования на которое был сделан вызов
			$table->integer('person_id')->unsigned()->index()->nullable(); //id того кто вызвал сервисную службу
            $table->integer('user_id')->unsigned()->index()->nullable(); //id того кто принял заявку
			
			$table->foreign('equipment_id')->references('id')->on('equipments');
			$table->foreign('person_id')->references('id')->on('persons');
			$table->foreign('user_id')->references('id')->on('users');
			
			$table->tinyInteger('status')->default(0); //статус 0 - только что открыта, 1 - проведена диагностика, нужны детали, 2 - проведена диагностика, не успели закончить, 3 - было закрыто, 4 - сделали, заявка закрыта, 5 - ложный вызов, заявка закрыта
			$table->tinyInteger('distance')->default(0); //0 - сами привезли, 1 - в своем же городе, 2 - в городе рядом, 3 - очень далеко
			$table->tinyInteger('delivery')->default(0); //0 - делели на местеб 1 - доставка в сервис-центр
			
			$table->text('problem')->nullable(); //описание проблемы со слов заказчика
			$table->text('diagnos')->nullable(); //результат диагностики
			$table->text('plan')->nullable(); //что нужно сделать
			$table->text('work')->nullable(); //что сделали
			
			$table->string('city'); //город 
			$table->string('address'); //адрес
			$table->string('company'); // организация
			$table->string('department'); // отдел организации - так как оборудование потом может быть перепродано или перевезено
			
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
