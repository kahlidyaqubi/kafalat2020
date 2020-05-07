<?php

use Illuminate\Database\Seeder;

class BeneficiaryInstitutionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('beneficiary_institutions')->insert([
            ['name' => 'أخرى ','code' => null, 'logo' => null, 'type' => null, 'status' => 1],
            ['name' => 'الكرد', 'code' => 'AEK', 'logo' => '', 'type' => 0, 'status' => 1],
            ['name' => 'جديد / جامعة فلسطين', 'code' => 'FU', 'logo' => '', 'type' => 1, 'status' => 1],
            ['name' => 'تحديث/تركيا', 'code' => '', 'logo' => '', 'type' => 1, 'status' => 1],
            ['name' => 'جديد/جامعة الأقصى', 'code' => '', 'logo' => '', 'type' => 1, 'status' => 1],
            ['name' => 'جديد/جامعة الأزهر', 'code' => '', 'logo' => '', 'type' => 1, 'status' => 1],
            ['name' => 'جديد / جامعة إسلامية', 'code' => '', 'logo' => '', 'type' => 1, 'status' => 1],
            ['name' => 'جديد / الكلية الجامعية', 'code' => '', 'logo' => '', 'type' => 1, 'status' => 1],
            ['name' => 'جديد', 'code' => '', 'logo' => '', 'type' => 1, 'status' => 1],
            ['name' => 'جديد - الحوراني', 'code' => '', 'logo' => '', 'type' => 1, 'status' => 1],
            ['name' => 'جديد / تركيا ', 'code' => '', 'logo' => '', 'type' => 1, 'status' => 1],
            ['name' => 'جديد / مكتب تركيا ', 'code' => '', 'logo' => '', 'type' => 1, 'status' => 1],
            ['name' => 'جديد /تركيا لم يتم الارسال ', 'code' => '', 'logo' => '', 'type' => 1, 'status' => 1],
            ['name' => 'جديد/أبو يحيى', 'code' => '', 'logo' => '', 'type' => 1, 'status' => 1],
            ['name' => 'جديد/أبو إسماعيل الداعور', 'code' => '', 'logo' => '', 'type' => 1, 'status' => 1],
            ['name' => 'جديد/الإغاثة الإسلامية', 'code' => '', 'logo' => '', 'type' => 1, 'status' => 1],
            ['name' => 'جديد/شادي العيسوي', 'code' => '', 'logo' => '', 'type' => 1, 'status' => 1],
            ['name' => 'جديد/مراجع', 'code' => '', 'logo' => '', 'type' => 1, 'status' => 1],
        ]);
    }
}
