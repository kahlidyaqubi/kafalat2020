<?php

use Illuminate\Database\Seeder;

class HouseStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('house_statuses')->insert([
            ['name' => 'سيء'],
            ['name' => 'سيء جدا'],
            ['name' => 'مقبول'],
            ['name' => 'جيد'],
            ['name' => 'مهدوم'],
            ['name' => 'متوسط'],
        ]);
    }
}
