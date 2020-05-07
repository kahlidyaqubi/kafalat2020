<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSeasonCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('season_coupons', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('season_id');
            $table->unsignedInteger('institution_id')->nullable();
            $table->unsignedInteger('family_id')->nullable();
            $table->unsignedInteger('coupon_reason_id')->nullable();
            $table->date('application_date');
            $table->date('execution_date');
            $table->unsignedInteger('coupon_type');
            $table->unsignedInteger('admin_status_id')->nullable();
            $table->boolean('delivery_status')->default(0);
            $table->timestamp('delivery_date')->nullable();
            $table->string('delivery_place')->nullable();
			$table->double('amount')->nullable();
			 $table->unsignedInteger('amount_curacy_id')->nullable();
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
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
        Schema::dropIfExists('season_coupons');
    }
}
