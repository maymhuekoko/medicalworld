<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliveryreceivesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deliveryreceives', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('customer_name');
            $table->text('customer_phone');
            $table->integer('pick_delivery')->comment('pickup-0,delivery-1');
            $table->text('pickup_address')->nullable();
            $table->integer('pickup_township_id');
            $table->integer('pickup_charges');
            $table->text('contactname_at_pickup');
            $table->text('contactphone_at_pickup');
            $table->text('destination_address');
            $table->integer('township_id');
            $table->integer('delivery_charges');
            $table->text('contactname_at_destination');
            $table->text('contactphone_at_destination');
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
        Schema::dropIfExists('deliveryreceives');
    }
}
