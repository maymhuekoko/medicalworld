<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmailFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('email_fields', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('subject');
            $table->string('title');
            $table->string('subtitle');
            $table->text('description');
            $table->string('link');
            $table->string('photo');
            $table->string('attach');
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
        Schema::dropIfExists('email_fields');
    }
}
