<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobPositionUserTable extends Migration
{
	const TABLE_JOB_POSITION_USER = 'job_position_user';
	const TABLE_JOB_POSITIONS = 'job_positions';
	const TABLE_USERS = 'users';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    Schema::create(self::TABLE_JOB_POSITION_USER, function (Blueprint $table) {
		    $table->bigInteger('job_position_id', false, true);
		    $table->integer('user_id', false, true);

		    $table->foreign('job_position_id', 'foreign_key_job_position_id_job_position_04')
			    ->references('id')
			    ->on(self::TABLE_JOB_POSITIONS)
			    ->onDelete('cascade');

		    $table->foreign('user_id', 'foreign_key_user_id_user_01')
			    ->references('id')
			    ->on(self::TABLE_USERS)
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
	    Schema::dropIfExists(self::TABLE_JOB_POSITION_USER);
    }
}
