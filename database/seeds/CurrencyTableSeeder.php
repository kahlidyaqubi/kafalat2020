<?php

use Illuminate\Database\Seeder;

class CurrencyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('currencies')->insert([
            ['name' => 'اليورو', 'name_en' => 'euro', 'icon' => '€'],
            ['name' => 'الدولار', 'name_en' => 'usd', 'icon' => '$'],
            ['name' => 'الشيكل', 'name_en' => 'nis', 'icon' => '₪'],
        ]);
    }
}
