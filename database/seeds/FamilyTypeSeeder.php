<?php

use Illuminate\Database\Seeder;

class FamilyTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('family_types')->insert([
            ['name' => 'مريض'],
            ['name' => 'جريح'],
            ['name' => 'شهيد'],
            ['name' => 'اسير'],
            ['name' => 'يتيم'],
            ['name' => 'صعب'],
            ['name' => 'طالب جامعي'],
            ['name' => 'الأمر للكافل'],
            ['name' => 'يترك الأمر لولي الأمر'],
            ['name' => 'خريجة كلية'],
        ]);
    }
}
