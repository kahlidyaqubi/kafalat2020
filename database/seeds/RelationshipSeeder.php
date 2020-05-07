<?php

use Illuminate\Database\Seeder;

class RelationshipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('immovables')->insert([
            ['name' => 'أخرى', 'name_tr' => null, 'status' => 1],
            ['name' => 'أراضي', 'name_tr' => null, 'status' => 1],
            ['name' => 'محل تجاري', 'name_tr' => null, 'status' => 1],
        ]);
        DB::table('relationships')->insert([
            ['name' => 'أخرى', 'name_tr' => null, 'status' => 1],
            ['name' => 'ابن', 'name_tr' => 'OĞLU', 'status' => 1],
            ['name' => 'ابن الخال/ة', 'name_tr' => 'KUZEN', 'status' => 1],
            ['name' => 'ابن الزوج', 'name_tr' => 'VEY OĞUL', 'status' => 1],
            ['name' => 'ابن العم/ة', 'name_tr' => 'KUZEN', 'status' => 1],
            ['name' => 'ابن/ة الاخ/ت', 'name_tr' => 'YEĞEN', 'status' => 1],
            ['name' => 'ابنة', 'name_tr' => 'KIZI', 'status' => 1],
            ['name' => 'اخ', 'name_tr' => 'ERKEK KARDEŞİ', 'status' => 1],
            ['name' => 'اخ الزوج', 'name_tr' => 'KAYIN BİRADER', 'status' => 1],
            ['name' => 'اخ الزوجة', 'name_tr' => 'KAYIN BİRADER', 'status' => 1],
            ['name' => 'اخت', 'name_tr' => 'KIZ KARDEŞİ', 'status' => 1],
            ['name' => 'اخت الزوج ', 'name_tr' => 'GÖRÜMCE', 'status' => 1],
            ['name' => 'اخت الزوجة', 'name_tr' => 'BALDIZ', 'status' => 1],
            ['name' => 'الحالة', 'name_tr' => 'KENDİSİ', 'status' => 1],
            ['name' => 'ام', 'name_tr' => 'ANNESİ', 'status' => 1],
            ['name' => 'أب', 'name_tr' => 'BABASI', 'status' => 1],
            ['name' => 'بنت الزوج', 'name_tr' => 'VEY KIZ', 'status' => 1],
            ['name' => 'جدة', 'name_tr' => 'NİNE', 'status' => 1],
            ['name' => 'جدة', 'name_tr' => 'BABAANNE', 'status' => 1],
            ['name' => 'حفيد/ة', 'name_tr' => 'TORUNU', 'status' => 1],
            ['name' => 'حماية', 'name_tr' => 'KAYNANA', 'status' => 1],
            ['name' => 'خال', 'name_tr' => 'DAYI', 'status' => 1],
            ['name' => 'خالة', 'name_tr' => 'TEYZE', 'status' => 1],
            ['name' => 'رب الاسرة', 'name_tr' => 'AİLE REİSİ ', 'status' => 1],
            ['name' => 'زوج', 'name_tr' => 'KOCASI', 'status' => 1],
            ['name' => 'زوج الام', 'name_tr' => 'VEY BABA', 'status' => 1],
            ['name' => 'زوجة', 'name_tr' => '4\'Cİ HANIMI', 'status' => 1],
            ['name' => 'زوجة ابن', 'name_tr' => 'OĞLUNUN HANIMI', 'status' => 1],
            ['name' => 'زوجة اخ', 'name_tr' => 'KARDEŞİNİN HANIMI', 'status' => 1],
            ['name' => 'زوجة الاب', 'name_tr' => 'VEY ANNE', 'status' => 1],
            ['name' => 'زوجة الابن', 'name_tr' => 'OĞUL HANIMI', 'status' => 1],
            ['name' => 'زوجة اولى', 'name_tr' => '1\'Cİ HANIMI', 'status' => 1],
            ['name' => 'زوجة ثالثة', 'name_tr' => '3\'Cİ HANIMI', 'status' => 1],
            ['name' => 'زوجة ثانية', 'name_tr' => '2\'Cİ HANIMI', 'status' => 1],
            ['name' => 'شقيقة', 'name_tr' => 'VEY KARDEŞ', 'status' => 1],
            ['name' => 'صهر/زوج الابنة', 'name_tr' => 'KAYINBİRADER', 'status' => 1],
            ['name' => 'عديل', 'name_tr' => 'BACANAK', 'status' => 1],
            ['name' => 'عم', 'name_tr' => 'AMCA', 'status' => 1],
            ['name' => 'عمة', 'name_tr' => 'HALA', 'status' => 1],
            ['name' => 'والد الزوج', 'name_tr' => 'KAYINPEDER', 'status' => 1],
            ['name' => 'والده الزوجة', 'name_tr' => null, 'status' => 1],
            ['name' => 'الابن المتزوج', 'name_tr' => null, 'status' => 1],
            ['name' => 'والدة الزوج', 'name_tr' => null, 'status' => 1],
            ['name' => 'زوج 1', 'name_tr' => null, 'status' => 1],
            ['name' => 'زوج 2', 'name_tr' => null, 'status' => 1],
            ['name' => 'زوج الابنة', 'name_tr' => null, 'status' => 1],
            ['name' => 'زوجة العم', 'name_tr' => null, 'status' => 1],
            ['name' => 'ابنة العم', 'name_tr' => null, 'status' => 1],
            ['name' => 'اخ - متزوج', 'name_tr' => null, 'status' => 1],
            ['name' => 'جد', 'name_tr' => null, 'status' => 1],
            ['name' => 'زوجة الشهيدة الثانية', 'name_tr' => null, 'status' => 1],
            ['name' => 'ابنة الابنة', 'name_tr' => null, 'status' => 1],
            ['name' => 'ابن الابنة', 'name_tr' => null, 'status' => 1],
            ['name' => 'ام الزوج', 'name_tr' => null, 'status' => 1],
            ['name' => 'ابنة الابن ', 'name_tr' => null, 'status' => 1],
            ['name' => 'ام الزوجة', 'name_tr' => null, 'status' => 1],
        ]);
    }
}
