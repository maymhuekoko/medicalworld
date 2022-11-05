<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGeneralCapitalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('general_capitals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('bussiness_name');
            $table->integer('bussiness_type');
            $table->integer('total_starting_capital');
            $table->integer('number_shareholder');
            $table->integer('current_capital');
            $table->integer('current_fixed_asset');
            $table->integer('current_cash');
            $table->integer('current_equity');
            $table->integer('reinvest_percent');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('general_capitals');
    }
}
