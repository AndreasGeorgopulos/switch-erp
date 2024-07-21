<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToUsers extends Migration
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
            $table->boolean('deletable_from_job_position')->default(true)->after('password');
            $table->boolean('add_for_new_job_position')->default(false)->after('password');
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
            $table->dropColumn('deletable_from_job_position');
            $table->dropColumn('add_for_new_job_position');
        });
    }
}
