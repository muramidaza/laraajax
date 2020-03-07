<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoreFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('storefiles', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->string('nameFile');
			$table->string('pathFile');
			$table->string('typeFile');
			$table->string('sizeFile');
			$table->string('owner_type')->nullable();
			$table->integer('owner_id')->unsigned()->index()->nullable();
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
        Schema::dropIfExists('store_files');
    }
}
