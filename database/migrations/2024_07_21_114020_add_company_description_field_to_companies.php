<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCompanyDescriptionFieldToCompanies extends Migration
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
            $table->text('description')->nullable()->after('name');
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
            $table->dropColumn('description');
        });
    }
}
