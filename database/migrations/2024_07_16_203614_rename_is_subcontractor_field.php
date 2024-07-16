<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameIsSubcontractorField extends Migration
{
    const TABLE_APPLICANTS = 'applicants';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 1. Új oszlop hozzáadása a kívánt helyre
        Schema::table(self::TABLE_APPLICANTS, function (Blueprint $table) {
            $table->tinyInteger('employment_relationship')->after('is_subcontractor');
        });

        // 2. Adatok másolása a régi oszlopból az új oszlopba
        DB::table(self::TABLE_APPLICANTS)->update([
            'employment_relationship' => DB::raw('is_subcontractor')
        ]);

        // 3. Régi oszlop törlése
        Schema::table(self::TABLE_APPLICANTS, function (Blueprint $table) {
            $table->dropColumn('is_subcontractor');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // 1. Régi oszlop visszaállítása
        Schema::table(self::TABLE_APPLICANTS, function (Blueprint $table) {
            $table->boolean('is_subcontractor')->after('employment_relationship');
        });

        // 2. Adatok másolása az új oszlopból a régi oszlopba
        DB::table(self::TABLE_APPLICANTS)->update([
            'is_subcontractor' => DB::raw('employment_relationship')
        ]);

        // 3. Új oszlop törlése
        Schema::table(self::TABLE_APPLICANTS, function (Blueprint $table) {
            $table->dropColumn('employment_relationship');
        });
    }
}