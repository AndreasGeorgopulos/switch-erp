<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSkillsTable extends Migration
{
	const TABLE_SKILLS = 'skills';
	const TABLE_APPLICANTS = 'applicants';
	const TABLE_APPLICANT_SKILL = 'applicant_skill';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(self::TABLE_SKILLS, function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->string('name');
			$table->boolean('is_active');
            $table->timestamps();
			$table->softDeletes();
        });

	    Schema::create(self::TABLE_APPLICANT_SKILL, function (Blueprint $table) {
		    $table->bigInteger('applicant_id', false, true);
		    $table->bigInteger('skill_id', false, true);

		    $table->primary(['applicant_id', 'skill_id'], 'primary_key_skill_applicant');

		    $table->foreign('applicant_id', 'foreign_key_skill_applicant_id_applicant')
			    ->references('id')
			    ->on(self::TABLE_APPLICANTS)
			    ->onDelete('cascade');

		    $table->foreign('skill_id', 'foreign_key_skill_id_skill')
			    ->references('id')
			    ->on(self::TABLE_SKILLS)
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
        Schema::dropIfExists(self::TABLE_APPLICANT_SKILL);
        Schema::dropIfExists(self::TABLE_SKILLS);
    }
}
