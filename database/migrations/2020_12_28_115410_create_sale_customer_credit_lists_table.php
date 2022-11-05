<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaleCustomerCreditlistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_customer_creditlists', function (Blueprint $table) {
            
            $table->bigIncrements('id');
            $table->integer('sales_customer_id');
            $table->integer('voucher_id');
            $table->string('voucher_code');
            $table->integer('credit_amount');
            $table->date('repaymentdate');
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
        Schema::dropIfExists('sale_customer_creditlists');
    }
}
