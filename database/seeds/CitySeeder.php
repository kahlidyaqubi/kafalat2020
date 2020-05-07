<?php

use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cities')->insert([
            ['name' => 'بيت حانون', 'name_tr' => 'BEYT HANUN', 'governorate_id' => 1],
            ['name' => 'جباليا', 'name_tr' => 'CABALYA', 'governorate_id' => 1],
            ['name' => 'بيت لاهيا', 'name_tr' => 'BEYT LAHYE', 'governorate_id' => 1],
            ['name' => 'ابراج الندى', 'name_tr' => 'NADA ABRAJ', 'governorate_id' => 1],
            ['name' => 'شيخ زايد', 'name_tr' => 'ŞİH ZAYİD', 'governorate_id' => 1],
            ['name' => 'ابراج العودة', 'name_tr' => 'AVDA ABRAJ', 'governorate_id' => 1],
            ['name' => 'قرية بدوية', 'name_tr' => 'GARYA BEDEVİ', 'governorate_id' => 1],
            ['name' => 'عزبة بيت حانون', 'name_tr' => 'BEYT HANUN İZBE', 'governorate_id' => 1],
            ['name' => 'مدينة غزة', 'name_tr' => 'GAZZE', 'governorate_id' => 2],
            ['name' => 'جحر الديك', 'name_tr' => 'CUHR ELDİK', 'governorate_id' => 3],
            ['name' => 'بريج', 'name_tr' => 'BÜRİC', 'governorate_id' => 3],
            ['name' => 'زهراء', 'name_tr' => 'ZAHRA', 'governorate_id' => 3],
            ['name' => 'نصيرات', 'name_tr' => 'NÜSEYRET', 'governorate_id' => 3],
            ['name' => 'زوايدة', 'name_tr' => 'ZAVEYİDE', 'governorate_id' => 3],
            ['name' => 'مغراقة', 'name_tr' => 'MUĞRAKA', 'governorate_id' => 3],
            ['name' => 'دير البلح', 'name_tr' => 'DYR ALBALAH', 'governorate_id' => 3],
            ['name' => 'مغازي', 'name_tr' => 'MAĞAZI', 'governorate_id' => 3],
            ['name' => 'مصدر', 'name_tr' => 'MUSADİR', 'governorate_id' => 3],
            ['name' => 'خانيونس الشرقية', 'name_tr' => 'HANYUNİS ŞERGİYE', 'governorate_id' => 4],
            ['name' => 'خانيونس الغربية', 'name_tr' => 'HANYUNİS ĞARBİYE', 'governorate_id' => 4],
            ['name' => 'خانيونس البلد', 'name_tr' => 'HANYUNİS ELBELAD', 'governorate_id' => 4],
            ['name' => 'رفح الشرقية', 'name_tr' => 'REFAH ŞERGİYE', 'governorate_id' => 5],
            ['name' => 'رفح الغربية', 'name_tr' => 'REFAH ĞARBİYE', 'governorate_id' => 5],
            ['name' => 'رفح البلد', 'name_tr' => 'REFAH ELBELAD', 'governorate_id' => 5],
            ['name' => 'خانيونس', 'name_tr' => 'HANYUNİS', 'governorate_id' => 4],
            ['name' => 'رفح', 'name_tr' => 'REFAH', 'governorate_id' => 5],
            ['name' => 'ايرز', 'name_tr' => null, 'governorate_id' => 1],
            ['name' => 'الشمال', 'name_tr' => null, 'governorate_id' => 1],
            ['name' => 'الدرج', 'name_tr' => null, 'governorate_id' =>null],
            ['name' => 'وادي غزة', 'name_tr' => null, 'governorate_id' =>null],
        ]);
    }
}
