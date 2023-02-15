<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToApplicantCompaniesTable extends Migration
{
	CONST TABLE_APPLICANT_COMPANIES = 'applicant_companies';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    Schema::table(self::TABLE_APPLICANT_COMPANIES, function (Blueprint $table) {
		    $table->tinyInteger('status')->default(1)->comment('1: Átküldve, 2: Elutasítva(sokat kér), 3: Elutasítva(kevés tapasztalat), 4: Időközben elhelyezkedett, 5: Ajánlatot kapott, nem fogadta el, 6: Interjú, 7: 2. Interjú, 8: Ajánlattétel, 9: Elhelyezve');
		    $table->date('send_date');
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
	    Schema::table(self::TABLE_APPLICANT_COMPANIES, function (Blueprint $table) {
		    $table->dropColumn([
			    'status',
			    'send_date',
			    'created_at',
			    'updated_at',
			    'deleted_at',
		    ]);
	    });
    }
}
