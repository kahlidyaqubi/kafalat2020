<?php

use Illuminate\Database\Seeder;

class UniversitySpecialtieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('university_specialties')->insert([
            ['name' => 'أخرى', 'status' => 1],
            ['name' => 'بكالوريوس هندسة', 'status' => 1],
            ['name' => 'ابتدائي', 'status' => 1],
            ['name' => 'بكالوريوس ادب انجليزي', 'status' => 1],
            ['name' => 'بكالوريوس خدمة اجتماعية', 'status' => 1],
            ['name' => 'دبلوم', 'status' => 1],
            ['name' => 'بكالوريوس', 'status' => 1],
            ['name' => 'جامعي', 'status' => 1],
            ['name' => 'بكالوريوس إدارة', 'status' => 1],
            ['name' => 'بكالوريوس خدمة اجتماعية', 'status' => 1],
            ['name' => 'دبلوم  إدارة واتمتة مكاتب', 'status' => 1],
            ['name' => 'دبلوم سكرتارية ودراسات قانونية', 'status' => 1],
        ]);
    }
}
