<?php

use Illuminate\Database\Seeder;

class GovernorateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('governorates')->insert([
            ['name' => 'محافظة الشمال', 'name_tr' => 'KUZEY', 'country_id' => 1],
            ['name' => 'محافظة غزة', 'name_tr' => 'GAZZE', 'country_id' => 1],
            ['name' => 'محافظة الوسطى', 'name_tr' => 'VESTA', 'country_id' => 1],
            ['name' => 'محافظة خانيونس', 'name_tr' => 'HANYUNİS', 'country_id' => 1],
            ['name' => 'محافظة رفح', 'name_tr' => 'RAFAH', 'country_id' => 1],
        ]);
    }
}
