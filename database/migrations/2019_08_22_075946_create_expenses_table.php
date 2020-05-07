<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->increments('id');
           // $table->unsignedInteger('currency_id');
            $table->unsignedInteger('family_project_id');
            $table->integer('year');
            $table->dateTime('recive_date');
            $table->string('excel_file');
            /*$table->tinyInteger('euroToDollarCheck');
            $table->tinyInteger('dollarToNisCheck');
            $table->tinyInteger('euroToNisCheck');
            $table->string('euroToDollarPrice');
            $table->string('dollarToNisPrice');
            $table->string('euroToNisPrice');
            $table->string('sub');
            $table->unsignedInteger('funded_institution_id');
            $table->tinyInteger('type');*/

//            $table->unsignedInteger('currency_id');

//            $table->unsignedInteger('funded_institution_id');
//            $table->dateTime('the_date');
//            //$table->unsignedInteger('expense_price_id');

            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            $table->unsignedInteger('deleted_by')->nullable();

          //  $table->foreign('currency_id')->references('id')->on('currencies');
           $table->foreign('family_project_id')->references('id')->on('family_projects');
            //$table->foreign('funded_institution_id')->references('id')->on('funded_institutions');
            //$table->foreign('expense_price_id')->references('id')->on('expense_prices');

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
        Schema::dropIfExists('expenses');
    }
}
