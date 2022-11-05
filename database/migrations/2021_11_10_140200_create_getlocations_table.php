<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGetlocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('getlocations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('rider_id');
            $table->text('address');
            $table->decimal('lat',10,7);
            $table->decimal('long',10,7);
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
        Schema::dropIfExists('getlocations');
    }
}
