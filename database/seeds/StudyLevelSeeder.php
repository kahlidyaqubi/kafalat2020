<?php

use Illuminate\Database\Seeder;

class StudyLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('study_levels')->insert([
            ['name' => 'سنة أولى'],
            ['name' => 'سنة ثانية'],
            ['name' => 'سنة ثالثة'],
            ['name' => 'سنة رابعة'],
            ['name' => 'سنة خامسة'],
            ['name' => 'سنة سادسة'],
            ['name' => 'خريج'],
        ]);
    }
}
