<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSeasonCouponFamilyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('season_coupon_family', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('season_coupon_id');
            $table->unsignedInteger('family_id')->nullable();
            $table->boolean('delivery_status')->default(0);
            $table->date('delivery_date')->nullable();
            $table->string('delivery_place')->nullable();
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
        Schema::dropIfExists('season_coupon_family');
    }
}
