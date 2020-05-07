<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditFunderTypeToUrgentCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('urgent_coupons', function (Blueprint $table) {
            $table->boolean('funder_type')->default(0)->change();
            $table->unsignedInteger('currency_id')->nullable()->change();
            $table->renameColumn('amount_curacy_id', 'amount_currency_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('urgent_coupons', function (Blueprint $table) {
            //
        });
    }
}
