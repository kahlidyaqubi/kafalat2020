<?php

use Illuminate\Database\Seeder;

class QualificationLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('qualification_levels')->insert([
            ['name' => 'الأول', 'name_tr' => null],
            ['name' => 'الثانى', 'name_tr' => null],
            ['name' => 'الثالث', 'name_tr' => null],
            ['name' => 'الرابع', 'name_tr' => null],
            ['name' => 'الخامس', 'name_tr' => null],
            ['name' => 'السادس', 'name_tr' => null],
            ['name' => 'ابتدائي', 'name_tr' => null],
            ['name' => 'السابع', 'name_tr' => null],
            ['name' => 'الثامن', 'name_tr' => null],
            ['name' => 'التاسع', 'name_tr' => null],
            ['name' => 'ثانوية عامة', 'name_tr' => null],
        ]);
    }
}
