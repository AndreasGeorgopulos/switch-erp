<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompaniesTable extends Migration
{
	const TABLE_COMPANIES = 'companies';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(self::TABLE_COMPANIES, function (Blueprint $table) {
            $table->bigIncrements('id');
	        $table->string('name', 100);
	        $table->string('contract_file')->nullable();
	        $table->string('contract_file_mime_type')->nullable();
	        $table->boolean('is_active');
            $table->timestamps();
	        $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(self::TABLE_COMPANIES);
    }
}
