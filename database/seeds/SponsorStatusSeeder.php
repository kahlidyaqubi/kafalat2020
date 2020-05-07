<?php

use Illuminate\Database\Seeder;

class SponsorStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sponsor_statuses')->insert([
            ['name' => 'مستمر'],
            ['name' => 'متقطع'],
            ['name' => 'متوقف'],
        ]);
    }
}
