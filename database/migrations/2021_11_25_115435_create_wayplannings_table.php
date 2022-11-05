<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWayplanningsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wayplannings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('wayno');
            $table->integer('delivery_id');
            $table->date('date');
            $table->integer('pick_delivery');
            $table->integer('township_id');
            $table->time('start_time');
            $table->time('end_time');
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
        Schema::dropIfExists('wayplannings');
    }
}
