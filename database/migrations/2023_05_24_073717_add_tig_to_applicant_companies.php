<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTigToApplicantCompanies extends Migration
{
	const TABLE_APPLICANT_COMPANIES = 'applicant_companies';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(self::TABLE_APPLICANT_COMPANIES, function (Blueprint $table) {
	        $table->string('tig_file')->nullable()->after('monogram');
	        $table->string('tig_file_mime_type')->nullable()->after('tig_file');
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
				'tig_file',
				'tig_file_mime_type',
	        ]);
        });
    }
}
