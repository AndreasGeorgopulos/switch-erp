<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMoreThanFieldsToApplicantCompaniesTable extends Migration
{
	CONST TABLE_APPLICANT_COMPANIES = 'applicant_companies';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    Schema::table(self::TABLE_APPLICANT_COMPANIES, function (Blueprint $table) {
		    $table->integer('salary')->nullable()->after('interview_time');
		    $table->date('work_begin_date')->nullable()->after('salary');
		    $table->text('follow_up')->nullable()->after('work_begin_date');
		    $table->string('monogram', 4)->nullable()->after('follow_up');
	    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
	    Schema::table(self::TABLE_APPLICANT_COMPANIES, function (Blueprint $table) {
		    $table->dropColumn([
			    'salary',
			    'work_begin_date',
			    'follow_up',
			    'monogram',
		    ]);
	    });
    }
}
