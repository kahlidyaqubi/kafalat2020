<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSeasonCouponMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('season_coupon_media', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('path');

            $table->unsignedInteger('season_coupon_id');
            $table->unsignedInteger('file_type_id')->nullable();
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('deleted_by')->nullable();
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
        Schema::dropIfExists('season_coupon_media');
    }
}
