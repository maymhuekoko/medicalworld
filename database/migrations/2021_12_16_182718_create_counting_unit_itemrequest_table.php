<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCountingUnitItemrequestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('counting_unit_itemrequest', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('counting_unit_id');
            $table->foreign('counting_unit_id')->references('id')->on('counting_units')->onDelete('cascade');
            $table->unsignedInteger('itemrequest_id');
            $table->foreign('itemrequest_id')->references('id')->on('itemrequests')->onDelete('cascade');
            $table->integer('quantity');
            $table->integer('send_quantity')->nullable();
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
        Schema::dropIfExists('counting_unit_itemrequest');
    }
}
