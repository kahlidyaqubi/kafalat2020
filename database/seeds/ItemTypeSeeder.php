<?php

use Illuminate\Database\Seeder;

class ItemTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('item_categories')->insert([
            ['name' => 'وجبة', 'status' => 1],
            ['name' => 'لحمة', 'status' => 1],
        ]);

        DB::table('item_types')->insert([
            ['name' => 'غداء', 'status' => 1 , 'item_category_id'=> 1],
            ['name' => 'كيلو', 'status' => 1, 'item_category_id'=> 2],
        ]);
    }
}
