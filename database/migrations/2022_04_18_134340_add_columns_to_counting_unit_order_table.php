<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToCountingUnitOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('counting_unit_order', function (Blueprint $table) {
//            $table->bigInteger('design_id');
//            $table->bigInteger('fabric_id');
//            $table->bigInteger('colour_id');
//            $table->bigInteger('size_id');
//            $table->bigInteger('gender_id');
//            $table->string('item_name');
//            $table->integer('selling_price');
            $table->dropColumn('counting_unit_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('counting_unit_order', function (Blueprint $table) {
            //
        });
    }
}
