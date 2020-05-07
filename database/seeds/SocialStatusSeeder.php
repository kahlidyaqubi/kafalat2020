<?php

use Illuminate\Database\Seeder;

class SocialStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('social_statuses')->insert([
            ['name' => 'سجين', 'name_tr' => 'MAHKUM'],
            ['name' => 'محبوس', 'name_tr' => 'TUTUKLU'],
            ['name' => 'أرملة', 'name_tr' => 'DUL'],
            ['name' => 'أسير', 'name_tr' => 'ESİR'],
            ['name' => 'آنسة/أعزب', 'name_tr' => 'İŞSİZ'],
            ['name' => 'تارك الأسرة', 'name_tr' => 'AİLESİNİ TERK ETMİŞ'],
            ['name' => 'شهيد/ة', 'name_tr' => 'ŞEHİT'],
            ['name' => 'متزوج/ة', 'name_tr' => 'EVLİ'],
            ['name' => 'متوفى/ة', 'name_tr' => 'RAHMETLİ'],
            ['name' => 'مسن/ة', 'name_tr' => 'YAŞLI'],
            ['name' => 'ربة بيت', 'name_tr' => 'EV HANIMI '],
            ['name' => 'جريح', 'name_tr' => 'YARALI'],
            ['name' => 'مسافر', 'name_tr' => 'YOLCU'],
            ['name' => 'مطلقة', 'name_tr' => 'BOŞANMIŞ'],
            ['name' => 'مفقود', 'name_tr' => 'KAYIP'],
        ]);
    }
}
