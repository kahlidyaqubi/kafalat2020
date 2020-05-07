<?php

use Illuminate\Database\Seeder;

class EducationaInstitutionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('educational_institutions')->insert([
            ['name' => 'أخرى', 'status' => 1],
            ['name' => 'الجامعه الاسلاميه', 'status' => 1],
            ['name' => 'جامعه الاقصي', 'status' => 1],
            ['name' => 'جامعه القدس المفتوحه', 'status' => 1],
        ]);
    }
}
