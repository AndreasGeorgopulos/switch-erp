<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVacationsTable extends Migration
{
	const TABLE_VACATIONS = 'vacations';
	const TABLE_USERS = 'users';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(self::TABLE_VACATIONS, function (Blueprint $table) {
            $table->bigIncrements('id');
	        $table->integer('user_id')->unsigned();
			$table->date('begin_date');
			$table->date('end_date');
			$table->text('notice');
			$table->tinyInteger('status')->default(1)->comment('1 - Requested, 2 - Approved, 3 - Rejected');
            $table->timestamps();
			$table->softDeletes();

	        $table->foreign('user_id')->references('id')->on(self::TABLE_USERS);
        });

	    Schema::table(self::TABLE_USERS, function (Blueprint $table) {
		    $table->integer('vacation_days_per_year')->nullable()->after('theme_id');
	    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
	    Schema::table(self::TABLE_VACATIONS, function (Blueprint $table) {
		    $table->dropForeign(['user_id']);
	    });
	    Schema::table(self::TABLE_USERS, function (Blueprint $table) {
		    $table->dropColumn(['vacation_days_per_year']);
	    });
	    Schema::dropIfExists(self::TABLE_VACATIONS);
    }
}
