<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFamilyMemberDiseasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('family_member_diseases', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedInteger('disease_id');
            $table->unsignedInteger('family_id');
            $table->unsignedInteger('person_id');
            $table->foreign('family_id')->references('id')->on('families');
            $table->foreign('person_id')->references('id')->on('persons');
            $table->foreign('disease_id')->references('id')->on('diseases');

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
        Schema::dropIfExists('family_member_diseases');
    }
}
