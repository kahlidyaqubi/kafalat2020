<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePersonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('persons', function (Blueprint $table) {
            $table->increments('id');

            $table->string('first_name')->nullable();
            $table->string('second_name')->nullable();
            $table->string('third_name')->nullable();
            $table->string('family_name')->nullable();
            $table->string('full_name')->nullable();

            $table->string('first_name_tr')->nullable();
            $table->string('second_name_tr')->nullable();
            $table->string('third_name_tr')->nullable();
            $table->string('family_name_tr')->nullable();

            $table->char('gender', 1)->nullable();
            $table->string('full_name_tr')->nullable();
            $table->string('slug')->nullable();
            $table->boolean('work')->nullable();
            $table->boolean('health_status')->nullable();
            $table->string('old_status')->nullable();// الحاله ف أرشيف الزيارات

            $table->unsignedInteger('id_type_id')->nullable();
            $table->string('id_number')->nullable();
            $table->integer('date_of_birth')->nullable();
            $table->unsignedInteger('date_of_birth_place')->nullable();
            $table->unsignedInteger('qualification_id')->nullable();
            $table->unsignedInteger('qualification_level_id')->nullable();
            $table->unsignedInteger('social_status_id')->nullable();

            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            $table->unsignedInteger('deleted_by')->nullable();

            $table->foreign('date_of_birth_place')->references('id')->on('countries');
            $table->foreign('id_type_id')->references('id')->on('id_types');
            $table->foreign('qualification_id')->references('id')->on('qualifications');
            $table->foreign('qualification_level_id')->references('id')->on('qualification_levels');
            $table->foreign('social_status_id')->references('id')->on('social_statuses');
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
        Schema::dropIfExists('persons');
    }
}
