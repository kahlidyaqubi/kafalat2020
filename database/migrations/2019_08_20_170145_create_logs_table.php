<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('message')->nullable();
            $table->text('ip_address')->nullable();
            $table->text('device')->nullable();
            $table->text('device_platform')->nullable();
            $table->text('agent')->nullable();
            $table->text('path')->nullable();
            $table->text('path_status')->nullable();
            $table->text('name')->nullable();

            $table->unsignedInteger('user_id');
            $table->unsignedInteger('log_category_id');

            $table->foreign('log_category_id')->references('id')->on('log_categories');
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('logs');
    }
}
