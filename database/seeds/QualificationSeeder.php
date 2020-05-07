<?php

use Illuminate\Database\Seeder;

class QualificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('qualifications')->insert([
            ['name' => 'طالب/ة مدرسة', 'name_tr' => 'OKUL ÖĞR.'],
            ['name' => 'منقطع عن الجامعة', 'name_tr' => 'ÜN. TERK ETMİŞ'],
            ['name' => 'منقطع عن المدرسة', 'name_tr' => 'OKUNMASINI TERK ETMİŞ'],
            ['name' => 'خريج/ة جامعة', 'name_tr' => 'ÜNİVERSİTE MEZUNU'],
            ['name' => 'طالب/ة روضة', 'name_tr' => 'ANA OKUL'],
            ['name' => 'طالب/ة مهنى', 'name_tr' => 'MESLEK LİSESİ'],
            ['name' => 'طالب/ة ثانوية عامة ', 'name_tr' => 'LİSE ÖĞRENCİSİ'],
            ['name' => 'خريج/ة ثانوية', 'name_tr' => 'LİSE MEZUNU'],
            ['name' => 'طالب/ة جامعة', 'name_tr' => 'ÜNİVERSİTE ÖĞR.'],
            ['name' => 'طفل/ة', 'name_tr' => 'ÇOCUK'],
            ['name' => 'ابتدائى', 'name_tr' => null],
            ['name' => 'إعدادي', 'name_tr' => null],
            ['name' => 'ثانوى', 'name_tr' => null],
        ]);
    }
}
