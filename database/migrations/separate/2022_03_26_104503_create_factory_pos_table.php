<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFactoryPosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('factory_pos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('po_number')->unique();
            $table->timestamp('po_date')->nullable();
            $table->timestamp('receive_date')->nullable();
            $table->integer('total_qty')->default(0);
            $table->integer('total_price')->default(0);
            $table->tinyinteger('status')->default(0);
            $table->string('requested_by')->nullable();
            $table->string('approved_by')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('factory_pos');
    }
}
