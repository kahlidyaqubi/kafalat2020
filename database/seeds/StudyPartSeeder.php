<?php

use Illuminate\Database\Seeder;

class StudyPartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('study_parts')->insert([
            ['name' => 'حكومة'],
            ['name' => 'وكالة'],
            ['name' => 'خاص'],
        ]);
    }
}
