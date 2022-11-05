<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliveryreceivePackagetypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deliveryreceive_packagetype', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('deliveryreceive_id');
            $table->unsignedBigInteger('packagetype_id');
            $table->text('dimension');
            $table->integer('pickup_delivery');
            $table->integer('qty');
            $table->integer('price');
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
        Schema::dropIfExists('deliveryreceive_packagetype');
    }
}
