<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUrgentCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('urgent_coupons', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('family_id')->nullable();
            $table->unsignedInteger('institution_id')->nullable();
            $table->unsignedInteger('coupon_reason_id')->nullable();
            $table->unsignedInteger('coupon_type');
            $table->unsignedInteger('country_id')->nullable();
            $table->longText('note')->nullable();
            $table->boolean('funder_type');
            $table->unsignedInteger('sponsor_id')->nullable();
            $table->double('funder_value')->nullable();
            $table->date('his_date');
            $table->unsignedInteger('currency_id');
            $table->unsignedInteger('admin_status_id')->nullable();
            $table->boolean('delivery_status')->default(0);
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
        Schema::dropIfExists('urgent_coupons');
    }
}
