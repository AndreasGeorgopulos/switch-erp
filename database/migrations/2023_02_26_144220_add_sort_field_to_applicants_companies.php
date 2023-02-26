<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSortFieldToApplicantsCompanies extends Migration
{
	const TABLE_APPLICANTS = 'applicants';
	const TABLE_COMPANIES = 'companies';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    Schema::table(self::TABLE_APPLICANTS, function (Blueprint $table) {
		    $table->integer('sort')->default(0)->after('user_id');
	    });

	    Schema::table(self::TABLE_COMPANIES, function (Blueprint $table) {
		    $table->integer('sort')->default(0)->after('id');
	    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
	    Schema::table(self::TABLE_APPLICANTS, function (Blueprint $table) {
		    $table->dropColumn([
			    'sort',
		    ]);
	    });

	    Schema::table(self::TABLE_COMPANIES, function (Blueprint $table) {
		    $table->dropColumn([
			    'sort',
		    ]);
	    });
    }
}
