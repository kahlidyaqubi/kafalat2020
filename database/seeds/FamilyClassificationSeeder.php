<?php

use Illuminate\Database\Seeder;

class FamilyClassificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('family_classifications')->insert([
            ['name' => 'جديد'],
            ['name' => 'فعال'],
            ['name' => 'غير فعال'],
            ['name' => 'مبطل'],
            ['name' => 'مؤرشف'],
        ]);
    }
}
