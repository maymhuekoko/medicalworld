<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemadjustsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('itemadjusts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('counting_unit_id');
            $table->foreign('counting_unit_id')->references('id')->on('counting_units')->onDelete('cascade');
            $table->integer('oldstock_qty');
            $table->integer('adjust_qty');
            $table->integer('extra_qty')->default(0);
            $table->integer('newstock_qty');
            $table->unsignedBigInteger('from_id');
            $table->foreign('from_id')->references('id')->on('froms')->onDelete('cascade');
            $table->unsignedBigInteger('user_id')->comment('created by');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('itemadjusts');
    }
}
