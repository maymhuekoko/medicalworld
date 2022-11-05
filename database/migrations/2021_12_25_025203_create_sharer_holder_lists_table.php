<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSharerHolderListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sharer_holder_lists', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('general_capital_id');
            $table->string('name');
            $table->string('nrc_passprot');
            $table->string('position');
            $table->integer('share_percent');
            $table->integer('divident_percent');
            $table->integer('capital_amount');
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
        Schema::dropIfExists('sharer_holder_lists');
    }
}
