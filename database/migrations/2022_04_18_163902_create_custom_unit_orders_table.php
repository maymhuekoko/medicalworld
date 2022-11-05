<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomUnitOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('custom_unit_orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('item_name');
            $table->bigInteger('design_id');
            $table->bigInteger('fabric_id');
            $table->bigInteger('colour_id');
            $table->bigInteger('size_id');
            $table->bigInteger('gender_id');
            $table->integer('selling_price');
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
        Schema::dropIfExists('custom_unit_orders');
    }
}
