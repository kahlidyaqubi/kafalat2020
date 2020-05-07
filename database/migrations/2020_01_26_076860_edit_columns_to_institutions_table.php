<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditColumnsToInstitutionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('institutions', function (Blueprint $table) {
            $table->unsignedInteger('institution_type_id')->nullable()->change();
            $table->unsignedInteger('licensor_id')->nullable()->change();
            $table->integer('licensor_number')->nullable()->change();
            $table->string('email')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('neighborhoods', function (Blueprint $table) {
            //
        });
    }
}
