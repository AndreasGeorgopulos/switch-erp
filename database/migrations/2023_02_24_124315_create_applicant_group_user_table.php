<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApplicantGroupUserTable extends Migration
{
	const TABLE_APPLICANT_GROUP_USER = 'applicant_group_user';
	const TABLE_APPLICANT_GROUPS = 'applicant_groups';
	const TABLE_USERS = 'users';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    Schema::create(self::TABLE_APPLICANT_GROUP_USER, function (Blueprint $table) {
		    $table->bigInteger('applicant_group_id', false, true);
		    $table->integer('user_id', false, true);

		    $table->foreign('applicant_group_id', 'foreign_key_applicant_group_id_applicant_group_01')
			    ->references('id')
			    ->on(self::TABLE_APPLICANT_GROUPS)
			    ->onDelete('cascade');

		    $table->foreign('user_id', 'foreign_key_user_id_user_02')
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
	    Schema::dropIfExists(self::TABLE_APPLICANT_GROUP_USER);
    }
}
