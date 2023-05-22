<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateThemesTable extends Migration
{
	const TABLE_THEMES = 'themes';
	const TABLE_USERS = 'users';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(self::TABLE_THEMES, function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->string('name');
			$table->longText('data')->nullable();
			$table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });

	    Schema::table(self::TABLE_USERS, function (Blueprint $table) {
		    $table->unsignedBigInteger('theme_id')->nullable()->after('id');
		    $table->foreign('theme_id')->references('id')->on(self::TABLE_THEMES);
	    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
	    Schema::table(self::TABLE_USERS, function (Blueprint $table) {
		    $table->dropForeign(['theme_id']);
		    $table->dropColumn('theme_id');
	    });

        Schema::dropIfExists(self::TABLE_THEMES);
    }
}
