<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInstitutionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('institutions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->unsignedInteger('institution_type_id');
            $table->unsignedInteger('licensor_id');
            $table->integer('licensor_number');
            $table->unsignedInteger('neighborhood_id')->nullable();
            $table->string('mobile')->nullable();
            $table->string('mobile_one')->nullable();
            $table->string('mobile_two')->nullable();
            $table->string('address')->nullable();
            $table->string('responsible_person')->nullable();

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
        Schema::dropIfExists('institutions');
    }
}
