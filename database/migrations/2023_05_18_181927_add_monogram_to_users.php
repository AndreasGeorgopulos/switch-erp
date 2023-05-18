<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMonogramToUsers extends Migration
{
	const TABLE_USERS = 'users';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    Schema::table(self::TABLE_USERS, function (Blueprint $table) {
		    $table->string('monogram', 4)->nullable()->after('password');
	    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
	    Schema::table(self::TABLE_USERS, function (Blueprint $table) {
		    $table->dropColumn('monogram');
	    });
    }
}
