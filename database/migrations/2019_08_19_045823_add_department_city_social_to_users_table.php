<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDepartmentCitySocialToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {

            $table->unsignedInteger('neighborhood_id')->nullable();
            $table->unsignedInteger('department_id')->nullable();
            $table->unsignedInteger('social_status_id')->nullable();
            $table->unsignedInteger('university_specialty_id')->nullable();
            $table->unsignedInteger('governorate_id')->nullable();

            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            $table->unsignedInteger('deleted_by')->nullable();

            $table->foreign('university_specialty_id')->references('id')->on('university_specialties');
            $table->foreign('governorate_id')->references('id')->on('governorates');
            $table->foreign('neighborhood_id')->references('id')->on('neighborhoods');
            $table->foreign('department_id')->references('id')->on('departments');
            $table->foreign('social_status_id')->references('id')->on('social_statuses');

            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
            $table->foreign('deleted_by')->references('id')->on('users');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
