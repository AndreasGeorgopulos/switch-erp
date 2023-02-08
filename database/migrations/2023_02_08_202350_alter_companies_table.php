<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterCompaniesTable extends Migration
{
	const TABLE_COMPANY = 'companies';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    Schema::table(self::TABLE_COMPANY, function (Blueprint $table) {
			$table->double('success_award')->after('name')->nullable();
			$table->date('payment_deadline')->after('success_award')->nullable();
			$table->string('contact_name', 100)->after('payment_deadline')->nullable();
			$table->string('contact_email', 255)->after('contact_name')->nullable();
			$table->string('contact_phone', 30)->after('contact_email')->nullable();
	    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
	    Schema::table(self::TABLE_COMPANY, function (Blueprint $table) {
			$table->dropColumn([
				'success_award',
				'payment_deadline',
				'contact_name',
				'contact_email',
				'contact_phone',
			]);
	    });
    }
}
