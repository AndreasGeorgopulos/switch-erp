<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id')->comment('Egyedi azonosító')->unique();
			$table->string('key')->comment('Kulcs');
			$table->timestamps();
			$table->softDeletes();
        });
		Schema::create('role_translates', function (Blueprint $table) {
			$table->increments('id')->comment('Egyedi azonosító')->unique();
			$table->string('role_id')->comment('Role ID');
			$table->string('language_code')->comment('Nyelv');
			$table->string('name')->comment('Megnevezés');
			$table->string('description')->comment('Leírás');
			$table->timestamps();
			$table->softDeletes();
		});

        Schema::create('roles_acls', function (Blueprint $table) {
            $table->increments('id')->comment('Egyedi azonosító')->unique();
            $table->integer('role_id')->comment('Szabály');
            $table->string('path')->comment('Útvonal');
        });

        Schema::create('role_user', function (Blueprint $table) {
            $table->integer('user_id')->comment('Felhasználó');
            $table->integer('role_id')->comment('Szabály');
            
            $table->primary(['user_id', 'role_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('roles');
        Schema::drop('roles_acls');
        Schema::drop('role_user');
    }
}
