<?php

use Illuminate\Database\Seeder;

class IncomeTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('income_types')->insert([
            ['name' => 'متقاعد', 'name_tr' => 'EMEKLİ', 'status' => 1],
            ['name' => 'حارس', 'name_tr' => 'KABICI', 'status' => 1],
            ['name' => 'دهان', 'name_tr' => 'BOYACI', 'status' => 1],
            ['name' => 'موظف', 'name_tr' => 'MEMUR', 'status' => 1],
            ['name' => 'موظف حكومى', 'name_tr' => 'DEVLET MEMURU', 'status' => 1],
            ['name' => 'موظف خاص', 'name_tr' => 'MEMUR', 'status' => 1],
            ['name' => 'موظف سلطة', 'name_tr' => 'GÖREVLİ', 'status' => 1],
            ['name' => 'ربة بيت', 'name_tr' => 'EV HANIMI', 'status' => 1],
            ['name' => 'سائق', 'name_tr' => 'ŞÖFÖR', 'status' => 1],
            ['name' => 'عامل', 'name_tr' => 'İŞCİ', 'status' => 1],
            ['name' => 'عامل متقطع', 'name_tr' => 'GEÇİCİ İŞÇİ', 'status' => 1],
            ['name' => 'لا يعمل', 'name_tr' => 'İŞSİZ', 'status' => 1],
        ]);
    }
}
