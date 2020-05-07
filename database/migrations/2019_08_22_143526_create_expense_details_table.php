<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExpenseDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expense_details', function (Blueprint $table) {
            $table->increments('id');
            $table->double('amount');
            $table->double('amount_befor');
            $table->unsignedInteger('expense_id');//year and curruncy;
            $table->unsignedInteger('family_id');
            $table->unsignedInteger('funded_institution_id');
            $table->double('discount')->default(0)->nullable();
            $table->boolean('delivery')->default(0)->nullable();

           // $table->unsignedInteger('month_id');
           // $table->unsignedInteger('funded_institution_id');
            //            $table->integer('price');
//            $table->boolean('is_sent');
//            $table->boolean('is_delivery');

            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            $table->unsignedInteger('deleted_by')->nullable();

           // $table->foreign('funded_institution_id')->references('id')->on('funded_institutions');
            $table->foreign('funded_institution_id')->references('id')->on('funded_institutions');
            $table->foreign('expense_id')->references('id')->on('expenses');
            $table->foreign('family_id')->references('id')->on('families');
           // $table->foreign('month_id')->references('id')->on('months');
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
        Schema::dropIfExists('expense_details');
    }
}
