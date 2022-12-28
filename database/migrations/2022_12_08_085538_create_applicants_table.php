<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Applicant management migration
 *
 * @author Andreas Georgopulos andreas.georgopulos@gmail.com
 * @since 2022-12-06
 */
class CreateApplicantsTable extends Migration
{
	const TABLE_APPLICANTS = 'applicants';
	const TABLE_APPLICATION_GROUPS = 'applicant_groups';
	const TABLE_APPLICATION_GROUPS_JOIN_APPLICANTS = 'applicant_applicant_group';
	const TABLE_USERS = 'users';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(self::TABLE_APPLICANTS, function (Blueprint $table) {
            $table->bigIncrements('id');
	        $table->integer('user_id')->nullable()->unsigned();
	        $table->string('name', 100);
	        $table->string('email', 255);
	        $table->string('phone', 30);
	        $table->string('linked_in', 255)->nullable();
	        $table->string('description', 255)->nullable();
	        $table->integer('experience_year')->nullable();
	        $table->date('last_contact_date')->nullable();
	        $table->date('last_callback_date')->nullable();
	        $table->string('in_english')->nullable();
	        $table->text('forwarded_to_companies')->nullable();
			$table->boolean('is_subcontractor')->nullable();
			$table->string('graduation')->nullable();
			$table->integer('salary')->nullable();
	        $table->integer('notice_period')->nullable();
			$table->boolean('home_office')->nullable();
	        $table->longText('note')->nullable();
	        $table->longText('report')->nullable();
	        $table->string('cv_file')->nullable();
	        $table->string('cv_file_mime_type')->nullable();
	        $table->boolean('is_active');
	        $table->timestamps();
	        $table->softDeletes();

			$table->foreign('user_id', 'foreign_key_Last_user_id_users')
				->references('id')
				->on(self::TABLE_USERS)
				->onDelete('cascade');
        });

	    Schema::create(self::TABLE_APPLICATION_GROUPS_JOIN_APPLICANTS, function (Blueprint $table) {
		    $table->bigInteger('applicant_id', false, true);
		    $table->bigInteger('applicant_group_id', false, true);

			$table->primary(['applicant_id', 'applicant_group_id'], 'primary_key_applicant_group_applicant');

		    $table->foreign('applicant_id', 'foreign_key_applicant_id_applicant')
			    ->references('id')
			    ->on(self::TABLE_APPLICANTS)
			    ->onDelete('cascade');

		    $table->foreign('applicant_group_id', 'foreign_key_applicant_group_id_applicant_group')
			    ->references('id')
			    ->on(self::TABLE_APPLICATION_GROUPS)
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
        Schema::dropIfExists(self::TABLE_APPLICATION_GROUPS_JOIN_APPLICANTS);
        Schema::dropIfExists(self::TABLE_APPLICANTS);
    }
}
