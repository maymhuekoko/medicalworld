<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomUnitFactoryOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('custom_unit_factory_orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('factory_order_id');
            $table->string("person_name");
            $table->bigInteger("person_id")->nullable();
            $table->bigInteger("design_id");
            $table->string("design_name");
            $table->bigInteger("fabric_id");
            $table->string("fabric_name");
            $table->bigInteger("colour_id");
            $table->string("colour_name");
            $table->bigInteger("size_id");
            $table->string("size_name");
            $table->bigInteger("gender_id")->nullable();
            $table->string("gender_name")->nullable();
            $table->bigInteger("pp_id")->nullable();
            $table->string("pp_name")->nullable();
            $table->bigInteger("quantity");
            $table->bigInteger("price");
            $table->bigInteger("total_price");
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
        Schema::dropIfExists('custom_unit_factory_orders');
    }
}
