<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiscountMainsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discount_mains', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('voucher_id');
            $table->date('voucher_date');
            $table->string('voucher_code');
            $table->string('sale_customer_name');
            $table->string('items');
            $table->integer('discount_flag');
            $table->string('discount_type');
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
        Schema::dropIfExists('discount_mains');
    }
}
