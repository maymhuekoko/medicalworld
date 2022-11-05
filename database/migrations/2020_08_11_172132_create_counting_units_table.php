<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCountingUnitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('counting_units', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('unit_name');
            $table->integer('current_quantity');
            $table->integer('reorder_quantity');
            $table->integer('purchase_price');
            $table->unsignedInteger('item_id');
            $table->softDeletes();
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
        Schema::dropIfExists('counting_units');
    }
}
