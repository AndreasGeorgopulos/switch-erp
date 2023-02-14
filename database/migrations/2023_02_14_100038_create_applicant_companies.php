<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApplicantCompanies extends Migration
{
	CONST TABLE_APPLICANT_COMPANIES = 'applicant_companies';
	const TABLE_JOB_POSITIONS = 'job_positions';
	CONST TABLE_APPLICANTS = 'applicants';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    Schema::create(self::TABLE_APPLICANT_COMPANIES, function (Blueprint $table) {
		    $table->bigInteger('applicant_id', false, true);
		    $table->bigInteger('job_position_id', false, true);

		    $table->foreign('applicant_id', 'foreign_key_applicant_id_applicants_03')
			    ->references('id')
			    ->on(self::TABLE_APPLICANTS)
			    ->onDelete('cascade');

		    $table->foreign('job_position_id', 'foreign_key_job_position_id_job_position_03')
			    ->references('id')
			    ->on(self::TABLE_JOB_POSITIONS)
			    ->onDelete('cascade');
	    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
	    Schema::dropIfExists(self::TABLE_APPLICANT_COMPANIES);
    }
}
