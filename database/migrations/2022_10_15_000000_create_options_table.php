<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lq_options', function (Blueprint $table) {
            $table->increments('id')->comment('Egyedi azonosító')->unique();
            $table->string('lq_key')->comment('Kulcs');
            $table->string('lq_value')->comment('Érték');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('lq_options');
    }
}
