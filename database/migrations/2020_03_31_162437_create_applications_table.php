<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->integer('status'); // статус заявки - только принята, сделана диагностика, нужны запчасти, закрыта, закрыта нужно отдать оборудование
			$table->integer('type'); //тип заявки - консультация (только осмотр), ремонт, монтаж
			$table->integer('distantsiya'); // где находится оборудование - в офисе (заказчик привез), в нашем городе, за городом - не далее 100 км, далеко - более 100 км
			$table->integer('equipment'); // ID оборудования (адрес есть в связанной с Оборудованием таблицей)
			$table->integer('person'); // ID кто вызвал
			$table->integer('user'); // ID кто приянл заявку
			$table->text('problem'); // описание проблемы со слов заказчика
			$table->text('diagnosis')->nullable(); // результат осмотра, диагностика
			$table->text('decision')->nullable(); // принятое решение - починить сразу на месте, нужны запчасти, нужно забрать в офис, необходимо списать
			$table->text('repair')->nullable(); // описание проведенного ремонта (диагностика, замена, ремонт электрики, очистка)
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
        Schema::dropIfExists('applications');
    }
}
