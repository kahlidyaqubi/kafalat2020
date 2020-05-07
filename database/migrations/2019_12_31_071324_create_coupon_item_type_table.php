<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCouponItemTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //  $table->string('mobile')->nullable();
        //  $table->unsignedInteger('coupon_reason_id')->nullable();
        //  $table->boolean('funder_type');
        Schema::create('coupon_item_type', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('urgent_coupon_id');
            $table->unsignedInteger('season_coupon_id');
            $table->unsignedInteger('item_type_id');
            $table->integer('number')->nullable();
            $table->double('value')->nullable();
            $table->unsignedInteger('currency_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coupon_item_type');
    }
}
