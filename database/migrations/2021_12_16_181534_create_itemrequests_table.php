<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemrequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('itemrequests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('total_quantity');
            $table->date('date');
            $table->integer('request_by');
            $table->unsignedBigInteger('from_id');
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
        Schema::dropIfExists('itemrequests');
    }
}
