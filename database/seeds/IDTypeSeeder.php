<?php

use Illuminate\Database\Seeder;

class IDTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('id_types')->insert([
            ['name' => 'هوية', 'type' => 0, 'number' => 9],
            ['name' => 'جواز سفر', 'type' => 0, 'number' => 7],
            ['name' => 'بطاقة تعريف', 'type' => 0, 'number' => 9],
        ]);
    }
}
