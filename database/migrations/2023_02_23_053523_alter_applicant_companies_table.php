<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterApplicantCompaniesTable extends Migration
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
		    $table->text('information')->nullable()->after('send_date');
		    $table->dateTime('interview_time')->nullable()->after('information');
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
			    'information',
			    'interview_time',
		    ]);
	    });
    }
}
