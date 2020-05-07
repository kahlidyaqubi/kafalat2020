<?php

use Illuminate\Database\Seeder;

class FundedInstitutionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('funded_institutions')->insert([
            ['name_tr' => "",'name' => 'أخرى','code' => null, 'logo' => null, 'type' => null, 'status' => 1],
            ['name_tr' => "AHMET ELKÜRD",'name' => 'الكرد', 'code' => 'AEK', 'logo' => '', 'type' => 0, 'status' => 1],
            ['name_tr' => "BEYT HANUN",'name' => 'بيت حانون', 'code' => 'BH', 'logo' => '', 'type' => 0, 'status' => 1],
            ['name_tr' => "BENİ SÜHEYLA",'name' => 'بني سهيلا', 'code' => 'BS', 'logo' => '', 'type' => 0, 'status' => 1],
            ['name_tr' => "ELHAYRİYE",'name' => 'الهيئة الخيرية', 'code' => 'HYR', 'logo' => '', 'type' => 0, 'status' => 1],
            ['name_tr' => "WİSAM TAHA",'name' => 'وسام طه', 'code' => 'WS', 'logo' => '', 'type' => 0, 'status' => 1],
            ['name_tr' => "SOSYAL İŞLER BAK.",'name' => 'الشؤون الاجتماعية', 'code' => 'SIB', 'logo' => '', 'type' => 0, 'status' => 1],
            ['name_tr' => "FİLİSTİN ÜNİ",'name' => 'جامعة فلسطين', 'code' => 'FU', 'logo' => '', 'type' => 1, 'status' => 1],
            ['name_tr' => "GAZZE ÜNİ",'name' => 'جامعة إسلامية', 'code' => 'GU', 'logo' => '', 'type' => 1, 'status' => 1],
            ['name_tr' => "GAZZE TEKNİK ÜNİ",'name' => 'الكلية الجامعية للعلوم التطبيقة', 'code' => 'GTU', 'logo' => '', 'type' => 1, 'status' => 1],
            ['name_tr' => "EL AKSA ÜNİ",'name' => 'جامعة الأقصى', 'code' => 'AKS', 'logo' => '', 'type' => 1, 'status' => 1],
            ['name_tr' => "GAZZE ÜNİ",'name' => 'الجامعة الإسلامية-هولندا', 'code' => 'GUH', 'logo' => '', 'type' => 1, 'status' => 1],
            ['name_tr' => "",'name' => 'الأيتام', 'code' => 'YTM', 'logo' => '', 'type' => 1, 'status' => 1],
            ['name_tr' => "",'name' => 'جامعة الأزهر', 'code' => '', 'logo' => '', 'type' => 1, 'status' => 1],
            ['name_tr' => "",'name' => 'تحديث / تركيا', 'code' => '', 'logo' => '', 'type' => 1, 'status' => 1],
            ['name_tr' => "",'name' => 'جديد', 'code' => '', 'logo' => '', 'type' => 1, 'status' => 1],
            ['name_tr' => "",'name' => 'جديد - الحوراني', 'code' => '', 'logo' => '', 'type' => 1, 'status' => 1],
            ['name_tr' => "",'name' => 'تركيا', 'code' => '', 'logo' => '', 'type' => 1, 'status' => 1],
            ['name_tr' => "",'name' => 'مكتب تركيا', 'code' => '', 'logo' => '', 'type' => 1, 'status' => 1],
            ['name_tr' => "",'name' => 'تركيا لم يتم الارسال', 'code' => '', 'logo' => '', 'type' => 1, 'status' => 1],
            ['name_tr' => "",'name' => 'أبو يحيى', 'code' => '', 'logo' => '', 'type' => 1, 'status' => 1],
            ['name_tr' => "",'name' => 'أبو إسماعيل الداعور', 'code' => '', 'logo' => '', 'type' => 1, 'status' => 1],
            ['name_tr' => "",'name' => 'الإغاثة الإسلامية', 'code' => '', 'logo' => '', 'type' => 1, 'status' => 1],
            ['name_tr' => "",'name' => 'شادي العيسوي', 'code' => '', 'logo' => '', 'type' => 1, 'status' => 1],
            ['name_tr' => "",'name' => 'مراجع', 'code' => '', 'logo' => '', 'type' => 1, 'status' => 1],
        ]);
    }
}
