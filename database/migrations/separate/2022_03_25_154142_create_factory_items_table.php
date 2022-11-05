<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFactoryItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('factory_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('item_name')->unique();
            $table->unsignedInteger('category_id');
            $table->unsignedInteger('subcategory_id');
            $table->integer('purchase_price')->default(0);
            $table->integer('instock_qty')->default(0);
            $table->integer('reserved_qty')->default(0);
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
        Schema::dropIfExists('factory_items');
    }
}
