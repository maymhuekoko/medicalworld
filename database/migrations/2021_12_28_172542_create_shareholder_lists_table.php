<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShareholderListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shareholder_lists', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('general_information_id');
            $table->string('name');
            $table->string('nrc_passport');
            $table->string('position');
            $table->integer('share_percent');
            $table->integer('devident_percent');
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
        Schema::dropIfExists('shareholder_lists');
    }
}
