<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFamiliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('families', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('family_project_id')->nullable();
//            $table->string('str_evaluate')->nullable();
            $table->string('mobile_one')->nullable();
            $table->string('mobile_two')->nullable();
            $table->integer('telephone')->nullable();
            $table->longText('previous_income_coupon')->nullable();
            $table->string('previous_income_value')->nullable();
            $table->integer('rent_value')->nullable();
            $table->unsignedInteger('country_id')->nullable(); // مكان الميلاد
            $table->unsignedInteger('city_id')->nullable(); // محافظه الاسره
            $table->unsignedInteger('governorate_id')->nullable(); // محافظه الاسره
            $table->unsignedInteger('neighborhood_id')->nullable();
            $table->string('address')->nullable();
            $table->string('address_tr')->nullable();
            $table->unsignedInteger('house_ownership_id')->nullable();
            $table->unsignedInteger('house_roof_id')->nullable();
            $table->unsignedInteger('house_status_id')->nullable();
            $table->integer('value_rent')->nullable();
            $table->boolean('furniture_status')->nullable();
            $table->integer('room_number')->nullable();
            $table->unsignedInteger('family_classification_id')->nullable();
            $table->unsignedInteger('family_status_id')->nullable();
            $table->string('id_university')->nullable();
            $table->unsignedInteger('study_type_id')->nullable();
            $table->unsignedInteger('study_part_id')->nullable();
            $table->unsignedInteger('educational_institution_id')->nullable();
            $table->unsignedInteger('university_specialty_id')->nullable();
            $table->unsignedInteger('study_level_id')->nullable();
            $table->string('graduated_date')->nullable();
            $table->integer('study_hour_price')->nullable();
            $table->unsignedInteger('representative_id')->nullable();
            $table->string('total_income_value')->nullable();
            $table->integer('wive_count')->nullable();
            $table->integer('member_count')->nullable();

            $table->unsignedInteger('representative_job_type_id')->nullable();
            $table->unsignedInteger('representative_relationship_id')->nullable();

            $table->longText('representative_reason')->nullable();
            $table->string('father_death_reason')->nullable();
            $table->date('father_death_date')->nullable();
            $table->string('father_death_date_old')->nullable();
            $table->string('mother_death_reason')->nullable();
            $table->date('mother_death_date')->nullable();
            $table->string('mother_death_date_old')->nullable();
            $table->text('step')->nullable();
            $table->longText('note')->nullable();// وضع الاسره في ملف الايتام
            $table->unsignedInteger('funded_institution_id')->nullable();
            $table->unsignedInteger('visit_reason_id');
            $table->date('visit_mission_date')->nullable();
            $table->boolean('need')->nullable();
            $table->unsignedInteger('data_entry_id')->nullable();
            $table->unsignedInteger('job_type_id')->nullable();
            $table->unsignedInteger('income_type_id')->nullable();
            $table->unsignedInteger('family_type_id')->nullable();
            $table->longText('note_turkey')->nullable();
            $table->string('code')->nullable();
            $table->date('ignore_date')->nullable();
            $table->date('receiving_date')->nullable();
            $table->longText('ignore_reason')->nullable();
            $table->unsignedInteger('expense_id')->nullable();
            $table->unsignedInteger('person_id')->nullable();
            $table->unsignedInteger('breadwinner_id')->nullable();
            $table->unsignedInteger('furniture_status_id')->nullable();
            $table->integer('income_value')->nullable();
            $table->integer('visit_count')->nullable();
            $table->longText('old_attachment')->nullable();
            $table->text('searcher_note')->nullable();
            $table->tinyInteger('hidden')->default(0);
            $table->tinyInteger('is_sent')->default(0);
            $table->tinyInteger('approve')->default(0);
            $table->tinyInteger('archive')->default(0);
            $table->unsignedInteger('parent_id')->nullable();

            // visit
            $table->integer('year')->nullable();
            $table->integer('year_number')->nullable();
            $table->string('visit_date')->nullable();

            $table->foreign('parent_id')->references('id')->on('families');
            $table->foreign('governorate_id')->references('id')->on('governorates');
            $table->foreign('family_type_id')->references('id')->on('family_types');
            $table->foreign('representative_id')->references('id')->on('persons');
            $table->foreign('representative_job_type_id')->references('id')->on('job_types');
            $table->foreign('person_id')->references('id')->on('persons');
            $table->foreign('breadwinner_id')->references('id')->on('relationships');
            $table->foreign('expense_id')->references('id')->on('expenses');
            $table->foreign('family_project_id')->references('id')->on('family_projects');
            $table->foreign('furniture_status_id')->references('id')->on('furniture_statuses');
            $table->foreign('country_id')->references('id')->on('countries');
            $table->foreign('city_id')->references('id')->on('cities');
            $table->foreign('neighborhood_id')->references('id')->on('neighborhoods');
            $table->foreign('house_ownership_id')->references('id')->on('house_ownerships');
            $table->foreign('house_roof_id')->references('id')->on('house_roofs');
            $table->foreign('house_status_id')->references('id')->on('house_statuses');
            $table->foreign('family_classification_id')->references('id')->on('family_classifications');
            $table->foreign('family_status_id')->references('id')->on('family_statuses');
            $table->foreign('study_type_id')->references('id')->on('study_types');
            $table->foreign('study_part_id')->references('id')->on('study_parts');
            $table->foreign('educational_institution_id')->references('id')->on('educational_institutions');
            $table->foreign('university_specialty_id')->references('id')->on('university_specialties');
            $table->foreign('study_level_id')->references('id')->on('study_levels');
            $table->foreign('representative_relationship_id')->references('id')->on('relationships');
            $table->foreign('funded_institution_id')->references('id')->on('funded_institutions');
            $table->foreign('data_entry_id')->references('id')->on('users');
            $table->foreign('visit_reason_id')->references('id')->on('visit_reasons');
            $table->foreign('job_type_id')->references('id')->on('job_types');
            $table->foreign('income_type_id')->references('id')->on('income_types');

            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            $table->unsignedInteger('deleted_by')->nullable();

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
        Schema::dropIfExists('families');
    }
}
