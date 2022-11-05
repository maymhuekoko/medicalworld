<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCountingUnitVoucherTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('counting_unit_voucher', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('voucher_id');
            $table->unsignedInteger('counting_unit_id');
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
        Schema::dropIfExists('counting_unit_voucher');
    }
}
