<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFamilyMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('family_media', function (Blueprint $table) {

            $table->increments('id');
            $table->string('path');
            $table->unsignedInteger('family_id');
            $table->unsignedInteger('file_type_id')->nullable();
            $table->tinyInteger('type')->default(0);//0 file ( image or files ) //1 link

            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('deleted_by')->nullable();

            $table->foreign('family_id')->references('id')->on('families');
            $table->foreign('file_type_id')->references('id')->on('file_types');
            $table->foreign('created_by')->references('id')->on('users');
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
        Schema::dropIfExists('family_media');
    }
}
