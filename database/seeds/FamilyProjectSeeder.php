<?php

use Illuminate\Database\Seeder;

class FamilyProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('family_projects')->insert([
            ['name' => 'عائلة الأخوة', 'name_tr' => 'Kardeşler ailesi', 'code' => 'KAP'],
            ['name' => 'تعليم الأيتام', 'name_tr' => 'Yetimlerin eğitimi', 'code' => 'YTM']
        ]);
    }
}
