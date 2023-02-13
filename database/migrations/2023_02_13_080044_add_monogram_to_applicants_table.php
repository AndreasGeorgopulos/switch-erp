<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMonogramToApplicantsTable extends Migration
{
	const TABLE_APPLICANTS = 'applicants';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    Schema::table(self::TABLE_APPLICANTS, function (Blueprint $table) {
		    $table->string('monogram', 4)->after('name')->nullable();
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
			    'monogram',
		    ]);
	    });
    }
}
