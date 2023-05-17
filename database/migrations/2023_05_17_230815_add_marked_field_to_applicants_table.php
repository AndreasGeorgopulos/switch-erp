<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMarkedFieldToApplicantsTable extends Migration
{
	const TABLE_APPLICANTS = 'applicants';

	public function up()
	{
		Schema::table(self::TABLE_APPLICANTS, function (Blueprint $table) {
			$table->boolean('is_marked')->default(false)->after('cv_file_mime_type');
		});
	}

	public function down()
	{
		Schema::table(self::TABLE_APPLICANTS, function (Blueprint $table) {
			$table->dropColumn('is_marked');
		});
	}
}
