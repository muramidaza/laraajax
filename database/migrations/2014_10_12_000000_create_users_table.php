<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
			$table->string('realname')->nullable();
			$table->string('surname')->nullable();
			$table->string('patronymic')->nullable();
			$table->date('datebirth')->nullable();
			$table->enum('sex', ['man', 'woman'])->nullable();
			$table->string('phone1')->nullable();
			$table->string('phone2')->nullable();
			$table->string('address')->nullable();
			$table->string('web')->nullable();
			$table->string('post')->nullable();
			$table->boolean('executive')->nullable();
			$table->string('rules')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
