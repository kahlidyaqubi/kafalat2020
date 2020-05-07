<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExpensePricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expense_prices', function (Blueprint $table) {
            $table->increments('id');
            $table->double('euro_usd')->nullable();
            $table->double('usd_nis')->nullable();
            $table->double('euro_nis')->nullable();
            $table->integer('year');
            $table->unsignedInteger('month_id');
            $table->unsignedInteger('funded_institution_id');

            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            $table->unsignedInteger('deleted_by')->nullable();

            $table->foreign('month_id')->references('id')->on('months');
            $table->foreign('funded_institution_id')->references('id')->on('funded_institutions');
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
            $table->foreign('deleted_by')->references('id')->on('users');

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
        Schema::dropIfExists('expense_prices');
    }
}
