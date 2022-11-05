<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSpecsToCountingUnitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('counting_units', function (Blueprint $table) {
            $table->bigInteger('design_id')->default(1)->after('unit_name');
            $table->bigInteger('fabric_id')->default(1);
            $table->bigInteger('colour_id')->default(1);
            $table->bigInteger('size_id')->default(1);
            $table->bigInteger('gender_id')->default(1);
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
