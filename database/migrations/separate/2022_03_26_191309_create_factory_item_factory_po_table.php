<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFactoryItemFactoryPoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('factory_item_factory_po', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('factory_item_id');
            $table->unsignedInteger('factory_po_id');
            $table->integer('purchase_price')->default(0);
            $table->integer('quantity')->default(0);
            $table->text('remark')->nullable();
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
        Schema::dropIfExists('factory_item_factory_po');
    }
}
