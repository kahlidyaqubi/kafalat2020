<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditColumnsToSeasonCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('season_coupons', function (Blueprint $table) {
            $table->date('application_date')->nullable()->change();;
            $table->date('execution_date')->nullable()->change();;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('season_coupons', function (Blueprint $table) {
            //
        });
    }
}
