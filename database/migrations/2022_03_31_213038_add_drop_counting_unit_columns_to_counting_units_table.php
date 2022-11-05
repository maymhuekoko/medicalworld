<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDropCountingUnitColumnsToCountingUnitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('counting_units', function (Blueprint $table) {
            $table->dropColumn(['normal_fixed_flash','normal_fixed_percent','whole_fixed_flash','whole_fixed_percent']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('counting_units', function (Blueprint $table) {
            //
        });
    }
}
