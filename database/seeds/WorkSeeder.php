<?php

use Illuminate\Database\Seeder;

class WorkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('works')->insert([
            ['name' => 'لا يعمل',],
            ['name' => 'يعمل',],
        ]);
    }
}
