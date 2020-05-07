<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name')->nullable();
            $table->string('second_name')->nullable();
            $table->string('third_name')->nullable();
            $table->string('family_name')->nullable();
            $table->text('full_name')->nullable();
            $table->string('user_name')->nullable();
            $table->string('email')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->date('work_start_date')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->integer('id_number')->nullable();
            $table->string('mobile')->nullable();
            $table->string('mobile_one')->nullable();
            $table->string('mobile_two')->nullable();
            $table->string('address')->nullable();
            $table->string('contract_type')->nullable();
            $table->text('image')->nullable();

            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
