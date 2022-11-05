<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupplierCreditListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supplier_credit_lists', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('purchase_id');
            $table->integer('credit_amount');
            $table->date('repay_date');
            $table->integer('paid_status');
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
        Schema::dropIfExists('supplier_credit_lists');
    }
}
