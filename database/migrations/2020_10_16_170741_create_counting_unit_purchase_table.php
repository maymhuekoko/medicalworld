<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCountingUnitPurchaseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('counting_unit_purchase', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('counting_unit_id');
            $table->unsignedInteger('purchase_id');
            $table->Integer('quantity');
            $table->Integer('price');
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
        Schema::dropIfExists('counting_unit_purchase');
    }
}
