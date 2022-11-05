<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiscountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discounts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('item_id');
            $table->unsignedInteger('counting_unit_id');
            $table->string('voucher_id');
            $table->string('voucher_code');
            $table->date('voucher_date');
            $table->integer('discount_flag');
            $table->integer('discount_item_amount');
            $table->integer('discount_voucher_amount');
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
        Schema::dropIfExists('discounts');
    }
}
