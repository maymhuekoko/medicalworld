<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('address');
            $table->dateTime('order_date');
            $table->dateTime('delivered_date')->nullable();
            $table->integer('total_quantity');
            $table->tinyInteger('status')->comment('1 Will order Status, 2 will confirm status, 3 will change-order status,4 will deliverd status and 5 will be delete status');
            $table->unsignedInteger('customer_id');
            $table->unsignedInteger('employee_id');
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
        Schema::dropIfExists('orders');
    }
}
