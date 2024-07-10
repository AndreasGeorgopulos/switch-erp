<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddContactEmail2FieldToJobPositions extends Migration
{
    const TABLE_JOB_POSITIONS = 'job_positions';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(self::TABLE_JOB_POSITIONS, function (Blueprint $table) {
            $table->string('contact_email_2', 255)->nullable()->after('contact_email');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(self::TABLE_JOB_POSITIONS, function (Blueprint $table) {
            $table->dropColumn('contact_email_2');
        });
    }
}
