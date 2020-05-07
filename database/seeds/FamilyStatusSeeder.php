<?php

use Illuminate\Database\Seeder;

class FamilyStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('family_statuses')->insert([
            ['name' => 'سيء', 'name_tr' => 'KÖTÜ'],
            ['name' => 'سيء جدا', 'name_tr' => 'ÇOK KÖTÜ'],
            ['name' => 'مقبول', 'name_tr' => 'MAKBUL'],
            ['name' => 'جيد', 'name_tr' => 'İYİ'],
            ['name' => 'متوسط', 'name_tr' => 'ORTA'],
            ['name' => 'الأمر للكافل', 'name_tr' => 'KARAR SAHİBİ VEREN EL'],
            ['name' => 'جيد جدا', 'name_tr' => null],
        ]);
    }
}
