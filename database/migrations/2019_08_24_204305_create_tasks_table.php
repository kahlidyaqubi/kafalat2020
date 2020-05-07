<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('admin_id');//الآمر
            $table->unsignedInteger('user_id');//المطيع
            $table->string('title');
            $table->longText('nots');
            $table->boolean('done')->nullable();
            $table->dateTime('expense_date')->nullable();
            $table->unsignedInteger('family_id')->nullable();
            $table->unsignedInteger('project_id')->nullable();
            $table->unsignedInteger('institution_id')->nullable();
            $table->dateTime('from_date')->nullable();
            $table->dateTime('to_date')->nullable();
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            $table->unsignedInteger('deleted_by')->nullable();

            $table->foreign('admin_id')->references('id')->on('users');
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('tasks');
    }
}
