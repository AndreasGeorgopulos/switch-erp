<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMonogramToSales extends Migration
{
	const TABLE_SALES = 'sales';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    Schema::table(self::TABLE_SALES, function (Blueprint $table) {
		    $table->string('monogram', 4)->nullable()->after('web');
	    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
	    Schema::table(self::TABLE_SALES, function (Blueprint $table) {
		    $table->dropColumn([
			    'monogram',
		    ]);
	    });
    }
}
