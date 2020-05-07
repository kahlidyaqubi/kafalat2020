<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFamilyIncomesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('family_incomes', function (Blueprint $table) {
            $table->increments('id');

            $table->string('value');
            $table->string('note')->nullable();
            $table->unsignedInteger('family_id');
            $table->unsignedInteger('income_type_id');

            $table->foreign('family_id')->references('id')->on('families');
            $table->foreign('income_type_id')->references('id')->on('income_types');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('family_incomes');
    }
}
