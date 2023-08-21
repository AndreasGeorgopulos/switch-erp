<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddContractDateToCompaniesTable extends Migration
{
    const TABLE_COMPANIES = 'companies';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(self::TABLE_COMPANIES, function (Blueprint $table) {
            $table->date('contract_date')->nullable()->after('contract_file_mime_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(self::TABLE_COMPANIES, function (Blueprint $table) {
            $table->dropColumn('contract_date');
        });
    }
}
