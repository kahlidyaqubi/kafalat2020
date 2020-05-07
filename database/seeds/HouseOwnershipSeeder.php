<?php

use Illuminate\Database\Seeder;

class HouseOwnershipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('house_ownerships')->insert([
            ['name' => 'ملك'],
            ['name' => 'اجار'],
            ['name' => 'للعائلة'],
            ['name' => 'أرض حكومية'],
        ]);
    }
}
