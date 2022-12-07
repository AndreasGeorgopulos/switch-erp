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
			$table->increments('id')->comment('Egyedi azonosító')->unique();
			$table->string('name')->comment('Név');
			$table->string('email')->comment('Email cím');
			$table->string('password')->comment('Jelszó');
			$table->string('hash')->comment('Regisztráció megerősítése link')->nullable();
			$table->string('hash_2')->comment('Új jelszó generálása link')->nullable();
			$table->dateTime('hash_2_date')->comment('Új jelszó generálás érvényesség')->nullable();
			$table->string('remember_token')->comment('Token')->nullable();
			$table->tinyInteger('active')->comment('Aktív')->default(1);
			$table->softDeletes();
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
        Schema::dropIfExists('users');
    }
}
