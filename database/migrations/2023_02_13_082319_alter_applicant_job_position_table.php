<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterApplicantJobPositionTable extends Migration
{
	const TABLE_APPLICANT_JOB_POSITION = 'applicant_job_position';
	const TABLE_JOB_POSITIONS = 'job_positions';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    Schema::table(self::TABLE_APPLICANT_JOB_POSITION, function (Blueprint $table) {
		    $table->string('monogram', 4)->after('send_date')->nullable();
	    });

	    DB::query('ALTER TABLE `applicant_job_position` CHANGE `job_position_id` `job_position_id` bigint(20) unsigned NULL AFTER `applicant_id`');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
	    Schema::table(self::TABLE_APPLICANT_JOB_POSITION, function (Blueprint $table) {
		    $table->dropColumn([
			    'monogram',
		    ]);
	    });
    }
}
