<?php

use Illuminate\Database\Seeder;

class HealthSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('healths')->insert([
            ['name' => 'سليم'],
            ['name' => 'مريض'],
        ]);
    }
}
