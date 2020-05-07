<?php

use Illuminate\Database\Seeder;

class FileTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('file_types')->insert([
            ['name' => 'وثائق أخرى ', 'name_tr' => 'diğer belgeler', 'status' => 1],
            ['name' => 'صورة العائلة', 'name_tr' => 'AİLE FOTOSU', 'status' => 1],
            ['name' => 'تقرير طبي', 'name_tr' => 'SAĞLIK RAPORU', 'status' => 1],
            ['name' => 'صورة البيت', 'name_tr' => 'EV FOTOSU', 'status' => 1],
            ['name' => 'شهادة وفاة', 'name_tr' => 'VEFAT BELGESİ', 'status' => 1],
            ['name' => 'تقارير اخرى', 'name_tr' => 'ÇEŞİTLİ RAPORLAR', 'status' => 1],
            ['name' => 'عقد ايجار', 'name_tr' => 'KİRA SÖZLEŞMESİ', 'status' => 1],
            ['name' => 'شهادة قيد', 'name_tr' => 'ÖĞRENCİ BELGESİ', 'status' => 1],
            ['name' => 'الهوية', 'name_tr' => 'KİMLİK', 'status' => 1],
            ['name' => 'افادة هدم', 'name_tr' => 'YIKIMA BELGEİ', 'status' => 1],
            ['name' => 'افادة اضرار', 'name_tr' => 'HASAR BELGESİ', 'status' => 1],
            ['name' => 'شهادة طلاق', 'name_tr' => 'BOŞANMA BELGESİ', 'status' => 1],
            ['name' => 'الشكر', 'name_tr' => 'teşekkür mektubu', 'status' => 1],
        ]);
    }
}