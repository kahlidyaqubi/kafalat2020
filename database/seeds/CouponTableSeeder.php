<?php

use Illuminate\Database\Seeder;

class CouponTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        /*********************/
        \Illuminate\Support\Facades\DB::table('admin_statuses')->insert([
            'name' => 'معتمد'
        ]);
        \Illuminate\Support\Facades\DB::table('admin_statuses')->insert([
            'name' => 'احتياط'
        ]);
        \Illuminate\Support\Facades\DB::table('admin_statuses')->insert([
            'name' => 'غير معتمد'
        ]);
        /*********************/

        \Illuminate\Support\Facades\DB::table('coupon_reasons')->insert([
            'name' => 'أخرى',
            'status' => 1
        ]);
        \Illuminate\Support\Facades\DB::table('coupon_reasons')->insert([
            'name' => 'أسرة فقيرة',
            'status' => 1
        ]);
        \Illuminate\Support\Facades\DB::table('coupon_reasons')->insert([
            'name' => 'مريض',
            'status' => 1
        ]);
        \Illuminate\Support\Facades\DB::table('coupon_reasons')->insert([
            'name' => 'طالب جامعي',
            'status' => 1
        ]);
        /*********************/

        \Illuminate\Support\Facades\DB::table('target_types')->insert([
            'name' => 'أخرى',
            'status' => 1
        ]);
        \Illuminate\Support\Facades\DB::table('target_types')->insert([
            'name' => 'الطفل',
            'status' => 1
        ]);
        \Illuminate\Support\Facades\DB::table('target_types')->insert([
            'name' => 'المرأة',
            'status' => 1
        ]);
        \Illuminate\Support\Facades\DB::table('target_types')->insert([
            'name' => 'الأسرة',
            'status' => 1
        ]);
        \Illuminate\Support\Facades\DB::table('target_types')->insert([
            'name' => 'المعاقين',
            'status' => 1
        ]);
        \Illuminate\Support\Facades\DB::table('target_types')->insert([
            'name' => 'الطلاب',
            'status' => 1
        ]);
        \Illuminate\Support\Facades\DB::table('target_types')->insert([
            'name' => 'المرضى',
            'status' => 1
        ]);
        \Illuminate\Support\Facades\DB::table('target_types')->insert([
            'name' => 'كبار السن',
            'status' => 1
        ]);
        \Illuminate\Support\Facades\DB::table('target_types')->insert([
            'name' => 'الشباب',
            'status' => 1
        ]);
        /**************************/

        \Illuminate\Support\Facades\DB::table('institution_types')->insert([
            'name' => 'أخرى'
            ,'status'=> 1
        ]);
        \Illuminate\Support\Facades\DB::table('institution_types')->insert([
            'name' => 'إغاثي'
            ,'status'=> 1
        ]);
        \Illuminate\Support\Facades\DB::table('institution_types')->insert([
            'name' => 'تنموي'
            ,'status'=> 1
        ]);
        \Illuminate\Support\Facades\DB::table('institution_types')->insert([
            'name' => 'زراعي'
            ,'status'=> 1
        ]);
        \Illuminate\Support\Facades\DB::table('institution_types')->insert([
            'name' => 'خدماتي'
            ,'status'=> 1
        ]);
        \Illuminate\Support\Facades\DB::table('institution_types')->insert([
            'name' => 'تعليم'
            ,'status'=> 1
        ]);
        /**************************/

        \Illuminate\Support\Facades\DB::table('licensors')->insert([
            'name' => 'أخرى',
            'status' => 1
        ]);
        \Illuminate\Support\Facades\DB::table('licensors')->insert([
            'name' => 'الداخلية',
            'status' => 1
        ]);
        \Illuminate\Support\Facades\DB::table('licensors')->insert([
            'name' => 'الشؤون الاجتماعية',
            'status' => 1
        ]);
        \Illuminate\Support\Facades\DB::table('licensors')->insert([
            'name' => 'بلدية',
            'status' => 1

        ]);
    }
}
