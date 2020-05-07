<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditColumnsToCouponItemTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('coupon_item_type', function (Blueprint $table) {
            $table->unsignedInteger('urgent_coupon_id')->nullable()->change();
            $table->unsignedInteger('season_coupon_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('neighborhoods', function (Blueprint $table) {
            //
        });
    }
}
