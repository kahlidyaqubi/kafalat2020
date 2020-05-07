<?php

use Illuminate\Database\Seeder;

class MonthTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('months')->insert([
            ['name_ar' => 'يناير', 'name_tr' => 'Ocak', 'name_en' => 'ocak'],
            ['name_ar' => 'فبراير', 'name_tr' => 'Şubat', 'name_en' => 'subat'],
            ['name_ar' => 'مارس', 'name_tr' => 'Mart', 'name_en' => 'mart'],
            ['name_ar' => 'ابريل', 'name_tr' => 'Nisan', 'name_en' => 'nisan'],
            ['name_ar' => 'مايو', 'name_tr' => 'Mayıs', 'name_en' => 'mayis'],
            ['name_ar' => 'يونيو', 'name_tr' => 'Haziran', 'name_en' => 'haziran'],
            ['name_ar' => 'يوليو', 'name_tr' => 'Temmuz', 'name_en' => 'temmuz'],
            ['name_ar' => 'أغسطس', 'name_tr' => 'Ağustos', 'name_en' => 'agustos'],
            ['name_ar' => 'سبتمبر', 'name_tr' => 'Eylül', 'name_en' => 'eylul'],
            ['name_ar' => 'أكتوبر', 'name_tr' => 'Ekim', 'name_en' => 'ekim'],
            ['name_ar' => 'نوفمبر', 'name_tr' => 'Kasım', 'name_en' => 'kasım'],
            ['name_ar' => 'ديسمبر', 'name_tr' => 'Aralık', 'name_en' => 'aralık'],
        ]);
    }
}
