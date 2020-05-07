<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToFamiliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('families', function (Blueprint $table) {
            $table->unsignedInteger('immovable_id')->nullable();
            $table->integer('home_space')->nullable();
            $table->integer('number_school_students')->nullable();
            $table->integer('number_university_students')->nullable();
            $table->integer('supplies_card')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('families', function (Blueprint $table) {
            //
        });
    }
}
