<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFixedAssetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fixed_assets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->integer('type');
            $table->string('description');
            $table->integer('initial_purchase_price');
            $table->integer('salvage_value');
            $table->integer('use_life');
            $table->integer('yearly_depriciation');
            $table->integer('existing_flag');
            $table->integer('used_years');
            $table->integer('current_value');
            $table->date('start_date');
            $table->integer('sell_or_end_flag');
            $table->integer('sell_price');
            $table->integer('profit_loss_value');
            $table->date('sell_date');
            $table->string('end_remark');
            $table->date('end_date');
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
        Schema::dropIfExists('fixed_assets');
    }
}
