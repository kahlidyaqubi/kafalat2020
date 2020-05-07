<?php

use Illuminate\Database\Seeder;

class HouseRoofSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('house_roofs')->insert([
            ['name' => 'اسمنت'],
            ['name' => 'حجر'],
        ]);
    }
}
