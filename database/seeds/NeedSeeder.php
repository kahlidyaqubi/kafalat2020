<?php

use Illuminate\Database\Seeder;

class NeedSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('needs')->insert([
            ['name' => 'يحتاج'],
            ['name' => 'لا يحتاج'],
        ]);
    }
}
