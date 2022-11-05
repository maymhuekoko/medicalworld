<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusToCountingUnitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('counting_units', function (Blueprint $table) {
            $table->integer('normal_fixed_flash')->default(0);
            $table->integer('normal_fixed_percent')->default(0);
            $table->integer('whole_fixed_flash')->default(0);
            $table->integer('whole_fixed_percent')->default(0);
            $table->integer('order_fixed_flash')->default(0);
            $table->integer('order_fixed_percent')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('counting_units', function (Blueprint $table) {
            //
        });
    }
}
