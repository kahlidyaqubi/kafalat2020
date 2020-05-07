<?php

use Illuminate\Database\Seeder;

class VisitReasonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('visit_reasons')->insert([
            ['name' => 'أخرى', 'status' => 1],
            ['name' => 'زياره اولي', 'status' => 1],
            ['name' => 'تكليف', 'status' => 1],
            ['name' => 'تحديث بيانات ', 'status' => 1],
            ['name' => 'مساعدات موسمية', 'status' => 1],
            ['name' => 'زياره', 'status' => 1],
            ['name' => 'صرفية', 'status' => 0],
            ['name' => 'حذف صرفية', 'status' => 0],
            ['name' => 'عملية ابطال', 'status' => 0],
            ['name' => 'مساعدات طارئة', 'status' => 1],

        ]);
    }
}
