<?php

use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('departments')->insert([
            ['name' => 'أخرى', 'status' => 1],
            ['name' => 'مدير الجمعية', 'status' => 1],
            ['name' => 'مراسل', 'status' => 1],
            ['name' => 'محاسبة', 'status' => 1],
            ['name' => 'باحث اجتماعي', 'status' => 1],
            ['name' => 'تصوير ومونتاج', 'status' => 1],
            ['name' => 'سكرتاريا', 'status' => 1],
            ['name' => 'علاقات عامة', 'status' => 1],
            ['name' => 'منسق مشروع', 'status' => 1],
            ['name' => 'مساعد اداري', 'status' => 1],
            ['name' => 'مساعد مصور', 'status' => 1],
            ['name' => 'مبرمجة', 'status' => 1],
            ['name' => 'متطوعة', 'status' => 1],
            ['name' => 'مدخل بيانات', 'status' => 1],
        ]);
    }
}
