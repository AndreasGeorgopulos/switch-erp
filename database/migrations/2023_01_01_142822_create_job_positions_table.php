<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobPositionsTable extends Migration
{
	const TABLE_JOB_POSITIONS = 'job_positions';
	const TABLE_SKILLS = 'skills';
	const TABLE_JOB_POSITION_SKILL = 'job_position_skill';
	const TABLE_APPLICANT_JOB_POSITION = 'applicant_job_position';
	const TABLE_APPLICANTS = 'applicants';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(self::TABLE_JOB_POSITIONS, function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->bigInteger('company_id');
	        $table->string('title');
	        $table->text('description');
			$table->string('contact_name');
			$table->string('contact_email');
			$table->string('contact_phone');
	        $table->boolean('is_active');
            $table->timestamps();
            $table->softDeletes();
        });

	    Schema::create(self::TABLE_JOB_POSITION_SKILL, function (Blueprint $table) {
		    $table->bigInteger('job_position_id', false, true);
		    $table->bigInteger('skill_id', false, true);

		    $table->primary(['job_position_id', 'skill_id'], 'primary_key_skill_job_position');

		    $table->foreign('job_position_id', 'foreign_key_job_position_id_job_position')
			    ->references('id')
			    ->on(self::TABLE_JOB_POSITIONS)
			    ->onDelete('cascade');

		    $table->foreign('skill_id', 'foreign_key_skill_id_job_position')
			    ->references('id')
			    ->on(self::TABLE_SKILLS)
			    ->onDelete('cascade');
	    });

	    Schema::create(self::TABLE_APPLICANT_JOB_POSITION, function (Blueprint $table) {
		    $table->bigInteger('applicant_id', false, true);
		    $table->bigInteger('job_position_id', false, true);
		    $table->text('description');

		    $table->primary(['applicant_id', 'job_position_id'], 'primary_key_applicant_job_position');

		    $table->foreign('applicant_id', 'foreign_key_applicant_id_applicants_02')
			    ->references('id')
			    ->on(self::TABLE_APPLICANTS)
			    ->onDelete('cascade');

		    $table->foreign('job_position_id', 'foreign_key_job_position_id_job_position_02')
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
        Schema::dropIfExists(self::TABLE_APPLICANT_JOB_POSITION);
        Schema::dropIfExists(self::TABLE_JOB_POSITION_SKILL);
        Schema::dropIfExists(self::TABLE_JOB_POSITIONS);
    }
}
