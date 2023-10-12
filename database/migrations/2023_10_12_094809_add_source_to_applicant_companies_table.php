<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSourceToApplicantCompaniesTable extends Migration
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
            $table->string('source')->nullable()->after('monogram');
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
            $table->dropColumn('source');
        });
    }
}
