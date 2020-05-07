<?php

use Illuminate\Database\Seeder;

class StudyTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('study_types')->insert([
            ['name' => 'أكاديمي'],
            ['name' => 'مهني'],
        ]);
    }
}
