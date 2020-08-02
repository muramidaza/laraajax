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
			$table->foreign('equipment_id')->references('id')->on('equipments');
			
			$table->integer('caller_id')->unsigned()->index()->nullable(); //id того кто вызвал сервисную службу
			$table->foreign('caller_id')->references('id')->on('persons');
			
			$table->string('caller_fio')->nullable(); //если "левый" человек вызвал
			
            $table->integer('user_act_accept')->unsigned()->index()->nullable(); //id того кто принял заявку
			$table->foreign('user_act_accept')->references('id')->on('users');
			
			$table->tinyInteger('act_status')->default(0); //статус: 0 - открыта, 1 - закрыта
			$table->tinyInteger('make_diagnos')->default(0); //диагностика
			$table->tinyInteger('need_spares')->default(0); //нужны ли запчасти
			$table->tinyInteger('mistake')->default(0); //ложная заявка
			$table->tinyInteger('distance')->default(0); //0 - сами привезли, 1 - в своем же городе, 2 - в городе рядом, 3 - очень далеко
			$table->tinyInteger('delivery')->default(0); //0 - сделали на месте, 1 - доставка в сервис-центр
			
			$table->text('problem')->nullable(); //описание проблемы со слов заказчика
			$table->text('diagnos')->nullable(); //результат диагностики
			$table->text('plan')->nullable(); //что нужно сделать
			$table->text('work')->nullable(); //что сделали
			$table->text('note')->nullable(); //замечания
			
			$table->string('city')->nullable(); //город 
			$table->string('address')->nullable(); //адрес
			$table->string('phone1')->nullable(); //телефон 1
			$table->string('phone2')->nullable(); //телефон 2
			$table->string('company')->nullable(); // организация
			$table->string('department')->nullable(); // отдел организации - так как оборудование потом может быть перепродано или перевезено
			$table->string('owner_fio')->nullable(); // ФИО частного владельца
			
			$table->integer('owner_id')->unsigned()->index()->nullable();
			$table->string('owner_type')->nullable();
			
			$table->timestamp('when_diagnos')->nullable(); //когда сделали диагностику или был выезд
			$table->timestamp('when_closed')->nullable(); //когда закрыли заявку
			
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
