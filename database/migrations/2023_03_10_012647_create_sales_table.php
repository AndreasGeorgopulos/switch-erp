<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesTable extends Migration
{
	const TABLE_SALES = 'sales';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(self::TABLE_SALES, function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->bigInteger('sort')->nullable();
			$table->string('company_name')->nullable();
	        $table->tinyInteger('status')->nullable()->comment('1: Szerződve, 2: Folyamatban, 3: Visszahívni, 4: Újra kereshető, 5: Nem keressük');
	        $table->date('callback_date')->nullable();
	        $table->string('contact')->nullable();
	        $table->string('position')->nullable();
	        $table->string('phone')->nullable();
	        $table->string('email')->nullable();
	        $table->string('information')->nullable();
	        $table->date('last_contact_date')->nullable();
	        $table->string('web')->nullable();
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
        Schema::dropIfExists(self::TABLE_SALES);
    }
}
