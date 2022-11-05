<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFactoryOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('factory_orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("factory_order_number");
            $table->string("department_name");
            $table->date("delivery_date");
            $table->longText("remark")->nullable();
            $table->string("showroom");
            $table->bigInteger("total_quantity");
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
        Schema::dropIfExists('factory_orders');
    }
}
