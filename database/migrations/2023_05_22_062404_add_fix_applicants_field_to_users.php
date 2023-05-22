<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFixApplicantsFieldToUsers extends Migration
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
            $table->boolean('fix_applicants')->nullable()->after('password');
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
	        $table->dropColumn('fix_applicants');
        });
    }
}
