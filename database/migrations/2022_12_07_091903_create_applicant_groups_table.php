<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Applicant group management migration
 *
 * @author Andreas Georgopulos andreas.georgopulos@gmail.com
 * @since 2022-12-06
 */
class CreateApplicantGroupsTable extends Migration
{
	const TABLE_APPLICATION_GROUPS = 'applicant_groups';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(self::TABLE_APPLICATION_GROUPS, function (Blueprint $table) {
            $table->bigIncrements('id');
	        $table->string('name', 100);
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
        Schema::dropIfExists(self::TABLE_APPLICATION_GROUPS);
    }
}
