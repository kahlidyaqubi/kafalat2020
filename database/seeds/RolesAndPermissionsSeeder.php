<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        $permission1_id = DB::table('permissions')->insertGetId(['name' => 'users', 'guard_name' => 'web', 'title' => 'المستخدمين', 'icon' => 'group', 'link' => '', 'order_id' => 1, 'in_menu' => 1, 'in_setting' => 3, 'parent_id' => 0]);
        $permission2_id = DB::table('permissions')->insertGetId(['name' => 'list users', 'guard_name' => 'web', 'title' => 'إدارة المستخدمين', 'icon' => 'fas fa-address-book', 'link' => '/admin/users', 'order_id' => 1, 'in_menu' => 1, 'in_setting' => 0, 'parent_id' => $permission1_id]);
        $permission3_id = DB::table('permissions')->insertGetId(['name' => 'create users', 'guard_name' => 'web', 'title' => 'إضافة مستخدم', 'icon' => 'person_add', 'link' => '/admin/users/create', 'order_id' => 1, 'in_menu' => 1, 'in_setting' => 0, 'parent_id' => $permission1_id]);
        $permission4_id = DB::table('permissions')->insertGetId(['name' => 'edit users', 'guard_name' => 'web', 'title' => 'تعديل مستخدم', 'icon' => 'equalizer', 'link' => '/admin/users/edit', 'order_id' => 1, 'in_menu' => 0, 'in_setting' => 0, 'parent_id' => $permission1_id]);
        $permission5_id = DB::table('permissions')->insertGetId(['name' => 'delete users', 'guard_name' => 'web', 'title' => 'حذف مستخدم', 'icon' => 'equalizer', 'link' => '/admin/users/delete', 'order_id' => 1, 'in_menu' => 0, 'in_setting' => 0, 'parent_id' => $permission1_id]);
        $permission6_id = DB::table('permissions')->insertGetId(['name' => 'permission users', 'guard_name' => 'web', 'title' => 'تحديد صلاحيات', 'icon' => 'equalizer', 'link' => '/admin/users/permission', 'order_id' => 1, 'in_menu' => 0, 'in_setting' => 0, 'parent_id' => $permission1_id]);
        $permission2021_id = DB::table('permissions')->insertGetId(['name' => 'getLog users', 'guard_name' => 'web', 'title' => 'حركات المستخدم', 'icon' => 'equalizer', 'link' => '/admin/users/getLog', 'order_id' => 1, 'in_menu' => 0, 'in_setting' => 0, 'parent_id' => $permission1_id]);

        // Logs
        $permission7_id = DB::table('permissions')->insertGetId(['name' => 'Logs', 'guard_name' => 'web', 'title' => 'حركات النظام', 'icon' => 'equalizer', 'link' => '', 'order_id' => 13, 'in_menu' => 1, 'in_setting' => 3, 'parent_id' => 0]);
        $permission8_id = DB::table('permissions')->insertGetId(['name' => 'list Logs', 'guard_name' => 'web', 'title' => ' إدارة حركات النظام', 'icon' => 'low_priority', 'link' => '/admin/logs', 'order_id' => 1, 'in_menu' => 1, 'in_setting' => 0, 'parent_id' => $permission7_id]);

        // nameTranslations
        $permission9_id = DB::table('permissions')->insertGetId(['name' => 'nameTranslations', 'guard_name' => 'web', 'title' => 'الترجمة', 'icon' => 'g_translate', 'link' => '', 'order_id' => 13, 'in_menu' => 1, 'in_setting' => 3, 'parent_id' => 0]);
        $permission10_id = DB::table('permissions')->insertGetId(['name' => 'list nameTranslations', 'guard_name' => 'web', 'title' => 'إدارة الترجمة', 'icon' => 'assignment', 'link' => '/admin/nameTranslations', 'order_id' => 1, 'in_menu' => 1, 'in_setting' => 0, 'parent_id' => $permission9_id]);
        $permission11_id = DB::table('permissions')->insertGetId(['name' => 'create nameTranslations', 'guard_name' => 'web', 'title' => 'إضافة ترجمة', 'icon' => 'iso', 'link' => '/admin/nameTranslations/create', 'order_id' => 1, 'in_menu' => 1, 'in_setting' => 0, 'parent_id' => $permission9_id]);
        $permission12_id = DB::table('permissions')->insertGetId(['name' => 'edit nameTranslations', 'guard_name' => 'web', 'title' => 'تعديل ترجمة', 'icon' => 'offline_pin', 'link' => '/admin/nameTranslations/edit', 'order_id' => 1, 'in_menu' => 0, 'in_setting' => 0, 'parent_id' => $permission9_id]);
        $permission13_id = DB::table('permissions')->insertGetId(['name' => 'delete nameTranslations', 'guard_name' => 'web', 'title' => 'حذف ترجمة', 'icon' => 'equalizer', 'link' => '/admin/nameTranslations/delete', 'order_id' => 1, 'in_menu' => 0, 'in_setting' => 0, 'parent_id' => $permission9_id]);
        $permission14_id = DB::table('permissions')->insertGetId(['name' => 'import nameTranslations', 'guard_name' => 'web', 'title' => 'استيراد ملف الترجمة', 'icon' => 'offline_pin', 'link' => '/admin/nameTranslations/import/names', 'order_id' => 1, 'in_menu' => 1, 'in_setting' => 0, 'parent_id' => $permission9_id]);

        // settings
        $permission15_id = DB::table('permissions')->insertGetId(['name' => 'settings', 'guard_name' => 'web', 'title' => 'إعدادات البرنامج العامة', 'icon' => 'brightness_7', 'link' => '', 'order_id' => 13, 'in_menu' => 1, 'in_setting' => 3, 'parent_id' => 0]);
        $permission16_id = DB::table('permissions')->insertGetId(['name' => 'list settings', 'guard_name' => 'web', 'title' => ' إدارة إعدادات البرنامج العامة', 'icon' => 'brightness_auto', 'link' => '/admin/settings', 'order_id' => 1, 'in_menu' => 1, 'in_setting' => 0, 'parent_id' => $permission15_id]);
        $permission7716_id = DB::table('permissions')->insertGetId(['name' => 'list settings', 'guard_name' => 'web', 'title' => 'إعدادت عامة', 'icon' => 'brightness_auto', 'link' => '/admin/all_settings', 'order_id' => 1, 'in_menu' => 1, 'in_setting' => 0, 'parent_id' => $permission15_id]);

        // db
        $permission17_id = DB::table('permissions')->insertGetId(['name' => 'dbBackups', 'guard_name' => 'web', 'title' => 'النسخ الاحتياطية  للبيانات', 'icon' => 'library_books', 'link' => '', 'order_id' => 13, 'in_menu' => 1, 'in_setting' => 3, 'parent_id' => 0]);
        $permission18_id = DB::table('permissions')->insertGetId(['name' => 'list dbBackups', 'guard_name' => 'web', 'title' => 'إدارة النسخ الاحتياطية ', 'icon' => 'library_add', 'link' => '/admin/dbBackups', 'order_id' => 1, 'in_menu' => 1, 'in_setting' => 0, 'parent_id' => $permission17_id]);
        $permission19_id = DB::table('permissions')->insertGetId(['name' => 'delete dbBackups', 'guard_name' => 'web', 'title' => 'حذف النسخه الاحتياطيه', 'icon' => 'equalizer', 'link' => '/admin/dbBackups/delete', 'order_id' => 1, 'in_menu' => 0, 'in_setting' => 1, 'parent_id' => $permission17_id]);

        // call
        $permission20_id = DB::table('permissions')->insertGetId(['name' => 'calls', 'guard_name' => 'web', 'title' => 'الاتصالات', 'icon' => 'phone', 'link' => '', 'order_id' => 2, 'in_menu' => 1, 'in_setting' => 0, 'parent_id' => 0]);
        $permission21_id = DB::table('permissions')->insertGetId(['name' => 'list calls', 'guard_name' => 'web', 'title' => 'إدارة الاتصالات', 'icon' => 'perm_phone_msg', 'link' => '/admin/calls', 'order_id' => 1, 'in_menu' => 1, 'in_setting' => 0, 'parent_id' => $permission20_id]);
        $permission22_id = DB::table('permissions')->insertGetId(['name' => 'create calls', 'guard_name' => 'web', 'title' => 'إضافة اتصال', 'icon' => 'contact_phone', 'link' => '/admin/calls/create', 'order_id' => 1, 'in_menu' => 1, 'in_setting' => 0, 'parent_id' => $permission20_id]);
        $permission23_id = DB::table('permissions')->insertGetId(['name' => 'edit calls', 'guard_name' => 'web', 'title' => 'تعديل اتصال', 'icon' => 'equalizer', 'link' => '/admin/calls/edit', 'order_id' => 1, 'in_menu' => 0, 'in_setting' => 0, 'parent_id' => $permission20_id]);
        $permission24_id = DB::table('permissions')->insertGetId(['name' => 'delete calls', 'guard_name' => 'web', 'title' => 'حذف اتصال', 'icon' => 'equalizer', 'link' => '/admin/calls/delete', 'order_id' => 1, 'in_menu' => 0, 'in_setting' => 0, 'parent_id' => $permission20_id]);

        // families
        $permission25_id = DB::table('permissions')->insertGetId(['name' => 'families', 'guard_name' => 'web', 'title' => ' الاستمارات والزيارات', 'icon' => 'assignment_ind', 'link' => '', 'order_id' => 13, 'in_menu' => 1, 'in_setting' => 0, 'parent_id' => 0]);
        $permission26_id = DB::table('permissions')->insertGetId(['name' => 'list families', 'guard_name' => 'web', 'title' => 'إدارة الاستمارات والزيارات', 'icon' => 'assignment', 'link' => '/admin/families', 'order_id' => 1, 'in_menu' => 1, 'in_setting' => 0, 'parent_id' => $permission25_id]);
        $permission27_id = DB::table('permissions')->insertGetId(['name' => 'create families', 'guard_name' => 'web', 'title' => 'إضافة استمارة', 'icon' => 'library_add', 'link' => '/admin/families/create', 'order_id' => 1, 'in_menu' => 1, 'in_setting' => 0, 'parent_id' => $permission25_id]);
        $permission28_id = DB::table('permissions')->insertGetId(['name' => 'edit families', 'guard_name' => 'web', 'title' => 'تعديل استمارة', 'icon' => 'equalizer', 'link' => '/admin/families/edit', 'order_id' => 1, 'in_menu' => 0, 'in_setting' => 0, 'parent_id' => $permission25_id]);
        $permission29_id = DB::table('permissions')->insertGetId(['name' => 'delete families', 'guard_name' => 'web', 'title' => 'حذف استمارة', 'icon' => 'equalizer', 'link' => '/admin/families/delete', 'order_id' => 1, 'in_menu' => 0, 'in_setting' => 0, 'parent_id' => $permission25_id]);
        $permission30_id = DB::table('permissions')->insertGetId(['name' => 'log families', 'guard_name' => 'web', 'title' => 'سجل استمارة', 'icon' => 'equalizer', 'link' => '/admin/families/log', 'order_id' => 1, 'in_menu' => 0, 'in_setting' => 0, 'parent_id' => $permission25_id]);
        $permission31_id = DB::table('permissions')->insertGetId(['name' => 'visit families', 'guard_name' => 'web', 'title' => 'زيارات الاستمارة', 'icon' => 'equalizer', 'link' => '/admin/families/visit', 'order_id' => 1, 'in_menu' => 0, 'in_setting' => 0, 'parent_id' => $permission25_id]);
        $permission32_id = DB::table('permissions')->insertGetId(['name' => 'coupon families', 'guard_name' => 'web', 'title' => 'مساعدات الاستمارة', 'icon' => 'equalizer', 'link' => '/admin/families/coupon', 'order_id' => 1, 'in_menu' => 0, 'in_setting' => 0, 'parent_id' => $permission25_id]);
        $permission33_id = DB::table('permissions')->insertGetId(['name' => 'expense families', 'guard_name' => 'web', 'title' => 'صرفيات الاستمارة', 'icon' => 'equalizer', 'link' => '/admin/families/expense', 'order_id' => 1, 'in_menu' => 0, 'in_setting' => 0, 'parent_id' => $permission25_id]);
        $permission34_id = DB::table('permissions')->insertGetId(['name' => 'call families', 'guard_name' => 'web', 'title' => 'اتصالات الاستمارة', 'icon' => 'equalizer', 'link' => '/admin/families/call', 'order_id' => 1, 'in_menu' => 0, 'in_setting' => 0, 'parent_id' => $permission25_id]);
        $permission35_id = DB::table('permissions')->insertGetId(['name' => 'sponsor families', 'guard_name' => 'web', 'title' => 'كفلاء الاستمارة', 'icon' => 'equalizer', 'link' => '/admin/families/sponsor', 'order_id' => 1, 'in_menu' => 0, 'in_setting' => 0, 'parent_id' => $permission25_id]);
        $permission36_id = DB::table('permissions')->insertGetId(['name' => 'sponsor families', 'guard_name' => 'web', 'title' => 'كفلاء الاستمارة', 'icon' => 'equalizer', 'link' => '/admin/families/sponsor', 'order_id' => 1, 'in_menu' => 0, 'in_setting' => 0, 'parent_id' => $permission25_id]);
        $permission37_id = DB::table('permissions')->insertGetId(['name' => 'import visits', 'guard_name' => 'web', 'title' => 'استيراد ملف الزيارات', 'icon' => 'assignment_turned_in', 'link' => '/admin/families/import/visit', 'order_id' => 1, 'in_menu' => 1, 'in_setting' => 0, 'parent_id' => $permission25_id]);
        $permission38_id = DB::table('permissions')->insertGetId(['name' => 'import YTM', 'guard_name' => 'web', 'title' => 'استيراد ملف الايتام', 'icon' => 'assignment_returned', 'link' => '/admin/families/import/ytm', 'order_id' => 1, 'in_menu' => 1, 'in_setting' => 0, 'parent_id' => $permission25_id]);

        // expenses
        $permission39_id = DB::table('permissions')->insertGetId(['name' => 'expenses', 'guard_name' => 'web', 'title' => 'الصرفيات', 'icon' => 'swap_vert', 'link' => '', 'order_id' => 15, 'in_menu' => 1, 'in_setting' => 0, 'parent_id' => 0]);
        $permission40_id = DB::table('permissions')->insertGetId(['name' => 'list expenses', 'guard_name' => 'web', 'title' => 'إدارة الصرفيات', 'icon' => 'subtitles', 'link' => '/admin/expenses', 'order_id' => 1, 'in_menu' => 1, 'in_setting' => 0, 'parent_id' => $permission39_id]);
        $permission41_id = DB::table('permissions')->insertGetId(['name' => 'delete expenses', 'guard_name' => 'web', 'title' => 'حذف صرفية', 'icon' => 'equalizer', 'link' => '/admin/expenses/delete', 'order_id' => 1, 'in_menu' => 0, 'in_setting' => 0, 'parent_id' => $permission39_id]);
        $permission42_id = DB::table('permissions')->insertGetId(['name' => 'importExcel expenses', 'guard_name' => 'web', 'title' => 'استيراد ملف صرفية', 'icon' => 'developer_board', 'link' => '/admin/expenses/importExcel', 'order_id' => 1, 'in_menu' => 1, 'in_setting' => 0, 'parent_id' => $permission39_id]);
        $permission43_id = DB::table('permissions')->insertGetId(['name' => 'import ignore excel expenses', 'guard_name' => 'web', 'title' => 'استيراد ملف الابطال', 'icon' => 'import_export', 'link' => '/admin/expenses/importIgnoreFile', 'order_id' => 1, 'in_menu' => 1, 'in_setting' => 0, 'parent_id' => $permission39_id]);
        $permission45_id = DB::table('permissions')->insertGetId(['name' => 'details expenses', 'guard_name' => 'web', 'title' => 'تفاصيل صرفية', 'icon' => 'equalizer', 'link' => '/admin/expenses/details', 'order_id' => 1, 'in_menu' => 0, 'in_setting' => 0, 'parent_id' => $permission39_id]);
        $permission46_id = DB::table('permissions')->insertGetId(['name' => 'sendSMS expenses', 'guard_name' => 'web', 'title' => 'ابلاغ صرفية', 'icon' => 'equalizer', 'link' => '/admin/expenses/sendSMS', 'order_id' => 1, 'in_menu' => 0, 'in_setting' => 0, 'parent_id' => $permission39_id]);
        $permission47_id = DB::table('permissions')->insertGetId(['name' => 'delivery expenses', 'guard_name' => 'web', 'title' => 'تسليم صرفية', 'icon' => 'equalizer', 'link' => '/admin/delivery', 'order_id' => 1, 'in_menu' => 0, 'in_setting' => 0, 'parent_id' => $permission39_id]);
        $permission48_id = DB::table('permissions')->insertGetId(['name' => 'show expenses', 'guard_name' => 'web', 'title' => 'عرض صرفية', 'icon' => 'equalizer', 'link' => '/admin/expenses/show', 'order_id' => 1, 'in_menu' => 0, 'in_setting' => 0, 'parent_id' => $permission39_id]);
        $permission1148_id = DB::table('permissions')->insertGetId(['name' => 'show expenseDetails', 'guard_name' => 'web', 'title' => 'الكشوفات', 'icon' => 'equalizer', 'link' => '/admin/expenseDetails/', 'order_id' => 1, 'in_menu' => 1, 'in_setting' => 0, 'parent_id' => $permission39_id]);

        // expenseDetails
        $permission49_id = DB::table('permissions')->insertGetId(['name' => 'expenseDetails', 'guard_name' => 'web', 'title' => 'تفاصيل الصرفية', 'icon' => 'equalizer', 'link' => '', 'order_id' => 16, 'in_menu' => 0, 'in_setting' => 0, 'parent_id' => 0]);
        $permission50_id = DB::table('permissions')->insertGetId(['name' => 'delete expenseDetails', 'guard_name' => 'web', 'title' => 'حذف تفاصيل الصرفية', 'icon' => 'equalizer', 'link' => '/admin/expenseDetails/delete', 'order_id' => 1, 'in_menu' => 0, 'in_setting' => 0, 'parent_id' => $permission49_id]);
        $permission51_id = DB::table('permissions')->insertGetId(['name' => 'sendSMS expenseDetails', 'guard_name' => 'web', 'title' => 'ابلاغ حذف تفاصيل الصرفية', 'icon' => 'equalizer', 'link' => '/admin/expenseDetails/sendSMS', 'order_id' => 1, 'in_menu' => 0, 'in_setting' => 0, 'parent_id' => $permission49_id]);
        $permission52_id = DB::table('permissions')->insertGetId(['name' => 'delivery expenseDetails', 'guard_name' => 'web', 'title' => 'تسليم تفاصيل الصرفية', 'icon' => 'equalizer', 'link' => '/admin/expenseDetails/delivery', 'order_id' => 1, 'in_menu' => 0, 'in_setting' => 0, 'parent_id' => $permission49_id]);
        $permission53_id = DB::table('permissions')->insertGetId(['name' => 'sponsor expenseDetails', 'guard_name' => 'web', 'title' => 'عرض كفلاء تفاصيل الصرفية', 'icon' => 'equalizer', 'link' => '/admin/expenseDetails/sponsor', 'order_id' => 1, 'in_menu' => 0, 'in_setting' => 0, 'parent_id' => $permission49_id]);

        // expensePrices
        $permission54_id = DB::table('permissions')->insertGetId(['name' => 'sponsors', 'guard_name' => 'web', 'title' => 'الكفلاء', 'icon' => 'equalizer', 'link' => '', 'order_id' => 18, 'in_menu' => 1, 'in_setting' => 0, 'parent_id' => 0]);
        $permission55_id = DB::table('permissions')->insertGetId(['name' => 'list sponsors', 'guard_name' => 'web', 'title' => 'إدارة الكفلاء', 'icon' => 'equalizer', 'link' => '/admin/sponsors', 'order_id' => 1, 'in_menu' => 1, 'in_setting' => 0, 'parent_id' => $permission54_id]);
        $permission56_id = DB::table('permissions')->insertGetId(['name' => 'edit sponsors', 'guard_name' => 'web', 'title' => 'تعديل كفيل', 'icon' => 'equalizer', 'link' => '/admin/sponsors/edit', 'order_id' => 1, 'in_menu' => 0, 'in_setting' => 0, 'parent_id' => $permission54_id]);
        $permission57_id = DB::table('permissions')->insertGetId(['name' => 'delete sponsors', 'guard_name' => 'web', 'title' => 'حذف كفيل', 'icon' => 'equalizer', 'link' => '/admin/sponsors/delete', 'order_id' => 1, 'in_menu' => 0, 'in_setting' => 0, 'parent_id' => $permission54_id]);
        $permission58_id = DB::table('permissions')->insertGetId(['name' => 'expenseLog sponsors', 'guard_name' => 'web', 'title' => 'عرض صرفيات كفيل', 'icon' => 'equalizer', 'link' => '/admin/sponsors/expenseLog', 'order_id' => 1, 'in_menu' => 0, 'in_setting' => 0, 'parent_id' => $permission54_id]);
        $permission59_id = DB::table('permissions')->insertGetId(['name' => 'callLog sponsors', 'guard_name' => 'web', 'title' => 'عرض اتصالات كفيل', 'icon' => 'equalizer', 'link' => '/admin/sponsors/callLog', 'order_id' => 1, 'in_menu' => 0, 'in_setting' => 0, 'parent_id' => $permission54_id]);
        $permission60_id = DB::table('permissions')->insertGetId(['name' => 'delete familyLog', 'guard_name' => 'web', 'title' => 'عرض مفكولي الكفيل', 'icon' => 'equalizer', 'link' => '/admin/sponsors/familyLog', 'order_id' => 1, 'in_menu' => 0, 'in_setting' => 0, 'parent_id' => $permission54_id]);

        // projects
        $permission61_id = DB::table('permissions')->insertGetId(['name' => 'projects', 'guard_name' => 'web', 'title' => 'المشاريع', 'icon' => 'widgets', 'link' => '', 'order_id' => 2, 'in_menu' => 1, 'in_setting' => 2, 'parent_id' => 0]);
        $permission62_id = DB::table('permissions')->insertGetId(['name' => 'list projects', 'guard_name' => 'web', 'title' => 'إدارة المشاريع', 'icon' => 'view_quilt', 'link' => '/admin/projects', 'order_id' => 1, 'in_menu' => 1, 'in_setting' => 0, 'parent_id' => $permission61_id]);
        $permission63_id = DB::table('permissions')->insertGetId(['name' => 'create projects', 'guard_name' => 'web', 'title' => 'إضافة مشروع', 'icon' => 'unarchive', 'link' => '/admin/projects/create', 'order_id' => 1, 'in_menu' => 1, 'in_setting' => 0, 'parent_id' => $permission61_id]);
        $permission64_id = DB::table('permissions')->insertGetId(['name' => 'edit projects', 'guard_name' => 'web', 'title' => 'تعديل مشروع', 'icon' => 'equalizer', 'link' => '/admin/projects/edit', 'order_id' => 1, 'in_menu' => 0, 'in_setting' => 0, 'parent_id' => $permission61_id]);
        $permission65_id = DB::table('permissions')->insertGetId(['name' => 'delete projects', 'guard_name' => 'web', 'title' => 'حذف مشروع', 'icon' => 'equalizer', 'link' => '/admin/projects/delete', 'order_id' => 1, 'in_menu' => 0, 'in_setting' => 0, 'parent_id' => $permission61_id]);

        // season coupon
        $permission67_id = DB::table('permissions')->insertGetId(['name' => 'season_coupons', 'guard_name' => 'web', 'title' => 'المساعدات الموسمية', 'icon' => 'equalizer', 'link' => '', 'order_id' => 3, 'in_menu' => 1, 'in_setting' => 2, 'parent_id' => 0]);
        $permission68_id = DB::table('permissions')->insertGetId(['name' => 'list season_coupons', 'guard_name' => 'web', 'title' => 'إدارة المساعدات الموسمية', 'icon' => 'equalizer', 'link' => '/admin/season_coupons', 'order_id' => 1, 'in_menu' => 1, 'in_setting' => 0, 'parent_id' => $permission67_id]);
        $permission1169_id = DB::table('permissions')->insertGetId(['name' => 'create season_coupons', 'guard_name' => 'web', 'title' => 'إضافة مساعدة موسمية', 'icon' => 'iso', 'link' => '/admin/season_coupons/searctoaddcoupon', 'order_id' => 1, 'in_menu' => 1, 'in_setting' => 0, 'parent_id' => $permission67_id]);
        $permission69_id = DB::table('permissions')->insertGetId(['name' => 'create season_coupons', 'guard_name' => 'web', 'title' => 'إكمال مساعدة موسمية', 'icon' => 'iso', 'link' => '/admin/season_coupons/create', 'order_id' => 1, 'in_menu' => 0, 'in_setting' => 0, 'parent_id' => $permission67_id]);
        $permission70_id = DB::table('permissions')->insertGetId(['name' => 'edit season_coupons', 'guard_name' => 'web', 'title' => 'تعديل مساعدة موسمية', 'icon' => 'equalizer', 'link' => '/admin/season_coupons/edit', 'order_id' => 1, 'in_menu' => 0, 'in_setting' => 0, 'parent_id' => $permission67_id]);
        $permission71_id = DB::table('permissions')->insertGetId(['name' => 'delete season_coupons', 'guard_name' => 'web', 'title' => 'حذف مساعدة موسمية', 'icon' => 'equalizer', 'link' => '/admin/season_coupons/delete', 'order_id' => 1, 'in_menu' => 0, 'in_setting' => 0, 'parent_id' => $permission67_id]);

        // urgent coupons
        $permission72_id = DB::table('permissions')->insertGetId(['name' => 'urgent_coupons', 'guard_name' => 'web', 'title' => 'المساعدات الطارئة', 'icon' => 'equalizer', 'link' => '', 'order_id' => 3, 'in_menu' => 1, 'in_setting' => 2, 'parent_id' => 0]);
        $permission73_id = DB::table('permissions')->insertGetId(['name' => 'list urgent_coupons', 'guard_name' => 'web', 'title' => 'إدارة المساعدات الطارئة', 'icon' => 'equalizer', 'link' => '/admin/urgent_coupons', 'order_id' => 1, 'in_menu' => 1, 'in_setting' => 0, 'parent_id' => $permission72_id]);
        $permission1174_id = DB::table('permissions')->insertGetId(['name' => 'create urgent_coupons', 'guard_name' => 'web', 'title' => 'إضافة مساعدة طارئة', 'icon' => 'iso', 'link' => '/admin/urgent_coupons/searctoaddcoupon', 'order_id' => 1, 'in_menu' => 1, 'in_setting' => 0, 'parent_id' => $permission72_id]);
        $permission74_id = DB::table('permissions')->insertGetId(['name' => 'create urgent_coupons', 'guard_name' => 'web', 'title' => 'إكمال مساعدة طارئة', 'icon' => 'iso', 'link' => '/admin/urgent_coupons/create', 'order_id' => 1, 'in_menu' => 0, 'in_setting' => 0, 'parent_id' => $permission72_id]);
        $permission75_id = DB::table('permissions')->insertGetId(['name' => 'edit urgent_coupons', 'guard_name' => 'web', 'title' => 'تعديل مساعدة طارئة', 'icon' => 'equalizer', 'link' => '/admin/urgent_coupons/edit', 'order_id' => 1, 'in_menu' => 0, 'in_setting' => 0, 'parent_id' => $permission72_id]);
        $permission76_id = DB::table('permissions')->insertGetId(['name' => 'delete urgent_coupons', 'guard_name' => 'web', 'title' => 'حذف مساعدة طارئة', 'icon' => 'equalizer', 'link' => '/admin/urgent_coupons/delete', 'order_id' => 1, 'in_menu' => 0, 'in_setting' => 0, 'parent_id' => $permission72_id]);

        // profile
        $permission77_id = DB::table('permissions')->insertGetId(['name' => 'profile', 'guard_name' => 'web', 'title' => 'البروفايل', 'icon' => 'equalizer', 'link' => '', 'order_id' => 19, 'in_menu' => 0, 'in_setting' => 1, 'parent_id' => 0]);
        $permission78_id = DB::table('permissions')->insertGetId(['name' => 'edit profile', 'guard_name' => 'web', 'title' => 'تعديل المعلومات الشخصية', 'icon' => 'equalizer', 'link' => '/admin/profile/edit', 'order_id' => 1, 'in_menu' => 0, 'in_setting' => 0, 'parent_id' => $permission77_id]);

        // familyStatuses
        $permission79_id = DB::table('permissions')->insertGetId(['name' => 'familyStatuses', 'guard_name' => 'web', 'title' => 'أوضاع الحالات', 'icon' => 'equalizer', 'link' => '', 'order_id' => 2, 'in_menu' => 1, 'in_setting' => 1, 'parent_id' => 0]);
        $permission80_id = DB::table('permissions')->insertGetId(['name' => 'list familyStatuses', 'guard_name' => 'web', 'title' => 'إدارة  أوضاع الحالات', 'icon' => 'equalizer', 'link' => '/admin/familyStatuses', 'order_id' => 1, 'in_menu' => 1, 'in_setting' => 1, 'parent_id' => $permission79_id]);
        $permission81_id = DB::table('permissions')->insertGetId(['name' => 'create familyStatuses', 'guard_name' => 'web', 'title' => 'إضافة وضع الحالة', 'icon' => 'iso', 'link' => '/admin/familyStatuses/create', 'order_id' => 1, 'in_menu' => 1, 'in_setting' => 1, 'parent_id' => $permission79_id]);
        $permission82_id = DB::table('permissions')->insertGetId(['name' => 'edit familyStatuses', 'guard_name' => 'web', 'title' => 'تعديل وضع الحالة', 'icon' => 'equalizer', 'link' => '/admin/familyStatuses/edit', 'order_id' => 1, 'in_menu' => 0, 'in_setting' => 1, 'parent_id' => $permission79_id]);
        $permission83_id = DB::table('permissions')->insertGetId(['name' => 'delete familyStatuses', 'guard_name' => 'web', 'title' => 'حذف وضع الحالة', 'icon' => 'equalizer', 'link' => '/admin/familyStatuses/delete', 'order_id' => 1, 'in_menu' => 0, 'in_setting' => 1, 'parent_id' => $permission79_id]);

        // neighborhoods
        $permission84_id = DB::table('permissions')->insertGetId(['name' => 'neighborhoods', 'guard_name' => 'web', 'title' => 'الأحياء', 'icon' => 'location_on', 'link' => '', 'order_id' => 2, 'in_menu' => 1, 'in_setting' => 1, 'parent_id' => 0]);
        $permission85_id = DB::table('permissions')->insertGetId(['name' => 'list neighborhoods', 'guard_name' => 'web', 'title' => 'إدارة الأحياء', 'icon' => 'equalizer', 'link' => '/admin/neighborhoods', 'order_id' => 1, 'in_menu' => 1, 'in_setting' => 1, 'parent_id' => $permission84_id]);
        $permission86_id = DB::table('permissions')->insertGetId(['name' => 'create neighborhoods', 'guard_name' => 'web', 'title' => 'إضافة حي', 'icon' => 'iso', 'link' => '/admin/neighborhoods/create', 'order_id' => 1, 'in_menu' => 1, 'in_setting' => 1, 'parent_id' => $permission84_id]);
        $permission87_id = DB::table('permissions')->insertGetId(['name' => 'edit neighborhoods', 'guard_name' => 'web', 'title' => 'تعديل حي', 'icon' => 'equalizer', 'link' => '/admin/neighborhoods/edit', 'order_id' => 1, 'in_menu' => 0, 'in_setting' => 1, 'parent_id' => $permission84_id]);
        $permission88_id = DB::table('permissions')->insertGetId(['name' => 'delete neighborhoods', 'guard_name' => 'web', 'title' => 'حذف حي', 'icon' => 'equalizer', 'link' => '/admin/neighborhoods/delete', 'order_id' => 1, 'in_menu' => 0, 'in_setting' => 1, 'parent_id' => $permission84_id]);

        // institutions
        $permission89_id = DB::table('permissions')->insertGetId(['name' => 'institutions', 'guard_name' => 'web', 'title' => 'الجمعيات', 'icon' => 'equalizer', 'link' => '', 'order_id' => 2, 'in_menu' => 1, 'in_setting' => 2, 'parent_id' => 0]);
        $permission90_id = DB::table('permissions')->insertGetId(['name' => 'list institutions', 'guard_name' => 'web', 'title' => 'إدارة الجمعيات', 'icon' => 'icon-layers', 'link' => '/admin/institutions', 'order_id' => 1, 'in_menu' => 1, 'in_setting' => 0, 'parent_id' => $permission89_id]);
        $permission91_id = DB::table('permissions')->insertGetId(['name' => 'create institutions', 'guard_name' => 'web', 'title' => 'إضافة جمعية', 'icon' => 'icon-user-follow', 'link' => '/admin/institutions/create', 'order_id' => 1, 'in_menu' => 1, 'in_setting' => 0, 'parent_id' => $permission89_id]);
        $permission92_id = DB::table('permissions')->insertGetId(['name' => 'edit institutions', 'guard_name' => 'web', 'title' => 'تعديل جمعية', 'icon' => 'equalizer', 'link' => '/admin/institutions/edit', 'order_id' => 1, 'in_menu' => 0, 'in_setting' => 0, 'parent_id' => $permission89_id]);
        $permission93_id = DB::table('permissions')->insertGetId(['name' => 'delete institutions', 'guard_name' => 'web', 'title' => 'حذف جمعية', 'icon' => 'equalizer', 'link' => '/admin/institutions/delete', 'order_id' => 1, 'in_menu' => 0, 'in_setting' => 0, 'parent_id' => $permission89_id]);

        // city
        $permission94_id = DB::table('permissions')->insertGetId(['name' => 'cities', 'guard_name' => 'web', 'title' => 'المدن', 'icon' => 'location_city', 'link' => '', 'order_id' => 2, 'in_menu' => 1, 'in_setting' => 1, 'parent_id' => 0]);
        $permission95_id = DB::table('permissions')->insertGetId(['name' => 'list cities', 'guard_name' => 'web', 'title' => 'إدارة المدن', 'icon' => 'equalizer', 'link' => '/admin/cities', 'order_id' => 1, 'in_menu' => 1, 'in_setting' => 1, 'parent_id' => $permission94_id]);
        $permission96_id = DB::table('permissions')->insertGetId(['name' => 'create cities', 'guard_name' => 'web', 'title' => 'إضافة مدينة', 'icon' => 'iso', 'link' => '/admin/cities/create', 'order_id' => 1, 'in_menu' => 1, 'in_setting' => 1, 'parent_id' => $permission94_id]);
        $permission97_id = DB::table('permissions')->insertGetId(['name' => 'edit cities', 'guard_name' => 'web', 'title' => 'تعديل مدينة', 'icon' => 'equalizer', 'link' => '/admin/cities/edit', 'order_id' => 1, 'in_menu' => 0, 'in_setting' => 1, 'parent_id' => $permission94_id]);
        $permission98_id = DB::table('permissions')->insertGetId(['name' => 'delete cities', 'guard_name' => 'web', 'title' => 'حذف مدينة', 'icon' => 'equalizer', 'link' => '/admin/city/delete', 'order_id' => 1, 'in_menu' => 0, 'in_setting' => 1, 'parent_id' => $permission94_id]);

        // country
        $permission99_id = DB::table('permissions')->insertGetId(['name' => 'countries', 'guard_name' => 'web', 'title' => 'أماكن الميلاد', 'icon' => 'equalizer', 'link' => '', 'order_id' => 4, 'in_menu' => 1, 'in_setting' => 1, 'parent_id' => 0]);
        $permission100_id = DB::table('permissions')->insertGetId(['name' => 'list countries', 'guard_name' => 'web', 'title' => 'إدارة أماكن الميلاد', 'icon' => 'equalizer', 'link' => '/admin/countries', 'order_id' => 1, 'in_menu' => 1, 'in_setting' => 1, 'parent_id' => $permission99_id]);
        $permission101_id = DB::table('permissions')->insertGetId(['name' => 'create countries', 'guard_name' => 'web', 'title' => 'إضافة مكان الميلاد', 'icon' => 'iso', 'link' => '/admin/countries/create', 'order_id' => 1, 'in_menu' => 1, 'in_setting' => 1, 'parent_id' => $permission99_id]);
        $permission102_id = DB::table('permissions')->insertGetId(['name' => 'edit countries', 'guard_name' => 'web', 'title' => 'تعديل مكان الميلاد', 'icon' => 'equalizer', 'link' => '/admin/countries/edit', 'order_id' => 1, 'in_menu' => 0, 'in_setting' => 1, 'parent_id' => $permission99_id]);
        $permission103_id = DB::table('permissions')->insertGetId(['name' => 'delete countries', 'guard_name' => 'web', 'title' => 'حذف مكان الميلاد', 'icon' => 'equalizer', 'link' => '/admin/countries/delete', 'order_id' => 1, 'in_menu' => 0, 'in_setting' => 1, 'parent_id' => $permission99_id]);

        // disease
        $permission104_id = DB::table('permissions')->insertGetId(['name' => 'diseases', 'guard_name' => 'web', 'title' => 'الأمراض', 'icon' => 'equalizer', 'link' => '', 'order_id' => 5, 'in_menu' => 1, 'in_setting' => 1, 'parent_id' => 0]);
        $permission105_id = DB::table('permissions')->insertGetId(['name' => 'list diseases', 'guard_name' => 'web', 'title' => 'إدارة الأمراض', 'icon' => 'equalizer', 'link' => '/admin/diseases', 'order_id' => 1, 'in_menu' => 1, 'in_setting' => 1, 'parent_id' => $permission104_id]);
        $permission106_id = DB::table('permissions')->insertGetId(['name' => 'create diseases', 'guard_name' => 'web', 'title' => 'إضافة مرض', 'icon' => 'equalizer', 'link' => '/admin/diseases/create', 'order_id' => 1, 'in_menu' => 1, 'in_setting' => 1, 'parent_id' => $permission104_id]);
        $permission107_id = DB::table('permissions')->insertGetId(['name' => 'edit diseases', 'guard_name' => 'web', 'title' => 'تعديل مرض', 'icon' => 'equalizer', 'link' => '/admin/diseases/edit', 'order_id' => 1, 'in_menu' => 0, 'in_setting' => 1, 'parent_id' => $permission104_id]);
        $permission108_id = DB::table('permissions')->insertGetId(['name' => 'delete diseases', 'guard_name' => 'web', 'title' => 'حذف مرض', 'icon' => 'equalizer', 'link' => '/admin/diseases/delete', 'order_id' => 1, 'in_menu' => 0, 'in_setting' => 1, 'parent_id' => $permission104_id]);

        // educational institution
        $permission109_id = DB::table('permissions')->insertGetId(['name' => 'educationalInstitutions', 'guard_name' => 'web', 'title' => 'المؤسسات التعليمية', 'icon' => 'local_library', 'link' => '', 'order_id' => 6, 'in_menu' => 1, 'in_setting' => 1, 'parent_id' => 0]);
        $permission110_id = DB::table('permissions')->insertGetId(['name' => 'list educationalInstitutions', 'guard_name' => 'web', 'title' => 'إدارة المؤسسات التعليمية', 'icon' => 'equalizer', 'link' => '/admin/educationalInstitutions', 'order_id' => 1, 'in_menu' => 1, 'in_setting' => 1, 'parent_id' => $permission109_id]);
        $permission111_id = DB::table('permissions')->insertGetId(['name' => 'create educationalInstitutions', 'guard_name' => 'web', 'title' => 'إضافة المؤسسة التعليمية', 'icon' => 'iso', 'link' => '/admin/educationalInstitutions/create', 'order_id' => 1, 'in_menu' => 1, 'in_setting' => 1, 'parent_id' => $permission109_id]);
        $permission112_id = DB::table('permissions')->insertGetId(['name' => 'edit educationalInstitutions', 'guard_name' => 'web', 'title' => 'تعديل المؤسسة التعليمية', 'icon' => 'equalizer', 'link' => '/admin/educationalInstitutions/edit', 'order_id' => 1, 'in_menu' => 0, 'in_setting' => 1, 'parent_id' => $permission109_id]);
        $permission113_id = DB::table('permissions')->insertGetId(['name' => 'delete educationalInstitutions', 'guard_name' => 'web', 'title' => 'حذف المؤسسة التعليمية', 'icon' => 'equalizer', 'link' => '/admin/educationalInstitutions/delete', 'order_id' => 1, 'in_menu' => 0, 'in_setting' => 1, 'parent_id' => $permission109_id]);
        $permission114_id = DB::table('permissions')->insertGetId(['name' => 'approval educationalInstitutions', 'guard_name' => 'web', 'title' => 'قبول المؤسسة التعليمية', 'icon' => 'equalizer', 'link' => '/admin/educationalInstitutions/approval', 'order_id' => 1, 'in_menu' => 0, 'in_setting' => 1, 'parent_id' => $permission109_id]);

        // file type
        $permission115_id = DB::table('permissions')->insertGetId(['name' => 'fileTypes', 'guard_name' => 'web', 'title' => ' أسماء المرفقات ', 'icon' => 'contacts', 'link' => '', 'order_id' => 7, 'in_menu' => 1, 'in_setting' => 1, 'parent_id' => 0]);
        $permission116_id = DB::table('permissions')->insertGetId(['name' => 'list fileTypes', 'guard_name' => 'web', 'title' => 'إدارة  أسماء المرفقات ', 'icon' => 'equalizer', 'link' => '/admin/fileTypes', 'order_id' => 1, 'in_menu' => 1, 'in_setting' => 1, 'parent_id' => $permission115_id]);
        $permission117_id = DB::table('permissions')->insertGetId(['name' => 'create fileTypes', 'guard_name' => 'web', 'title' => 'إضافة اسم المرفق', 'icon' => 'iso', 'link' => '/admin/fileTypes/create', 'order_id' => 1, 'in_menu' => 1, 'in_setting' => 1, 'parent_id' => $permission115_id]);
        $permission118_id = DB::table('permissions')->insertGetId(['name' => 'edit fileTypes', 'guard_name' => 'web', 'title' => 'تعديل  اسم المرفق', 'icon' => 'equalizer', 'link' => '/admin/fileTypes/edit', 'order_id' => 1, 'in_menu' => 0, 'in_setting' => 1, 'parent_id' => $permission115_id]);
        $permission119_id = DB::table('permissions')->insertGetId(['name' => 'delete fileTypes', 'guard_name' => 'web', 'title' => 'حذف  اسم المرفق', 'icon' => 'equalizer', 'link' => '/admin/fileTypes/delete', 'order_id' => 1, 'in_menu' => 0, 'in_setting' => 1, 'parent_id' => $permission115_id]);

        // funded institution
        $permission120_id = DB::table('permissions')->insertGetId(['name' => 'fundedInstitutions', 'guard_name' => 'web', 'title' => 'الجهات المرشحة', 'icon' => 'equalizer', 'link' => '', 'order_id' => 8, 'in_menu' => 1, 'in_setting' => 1, 'parent_id' => 0]);
        $permission121_id = DB::table('permissions')->insertGetId(['name' => 'list fundedInstitutions', 'guard_name' => 'web', 'title' => 'إدارة الجهات المرشحة', 'icon' => 'folder_shared', 'link' => '/admin/fundedInstitutions', 'order_id' => 1, 'in_menu' => 1, 'in_setting' => 1, 'parent_id' => $permission120_id]);
        $permission122_id = DB::table('permissions')->insertGetId(['name' => 'create fundedInstitutions', 'guard_name' => 'web', 'title' => 'إضافة جهة مرشحة', 'icon' => 'iso', 'link' => '/admin/fundedInstitutions/create', 'order_id' => 1, 'in_menu' => 1, 'in_setting' => 1, 'parent_id' => $permission120_id]);
        $permission123_id = DB::table('permissions')->insertGetId(['name' => 'edit fundedInstitutions', 'guard_name' => 'web', 'title' => 'تعديل جهة مرشحة', 'icon' => 'equalizer', 'link' => '/admin/fundedInstitutions/edit', 'order_id' => 1, 'in_menu' => 0, 'in_setting' => 1, 'parent_id' => $permission120_id]);
        $permission124_id = DB::table('permissions')->insertGetId(['name' => 'delete fundedInstitutions', 'guard_name' => 'web', 'title' => 'حذف جهة مرشحة', 'icon' => 'equalizer', 'link' => '/admin/fundedInstitutions/delete', 'order_id' => 1, 'in_menu' => 0, 'in_setting' => 1, 'parent_id' => $permission120_id]);
        $permission125_id = DB::table('permissions')->insertGetId(['name' => 'family fundedInstitutions', 'guard_name' => 'web', 'title' => 'افراد جهة مرشحة', 'icon' => 'equalizer', 'link' => '/admin/fundedInstitutions/family', 'order_id' => 1, 'in_menu' => 0, 'in_setting' => 1, 'parent_id' => $permission120_id]);

        // house ownership
        $permission126_id = DB::table('permissions')->insertGetId(['name' => 'houseOwnerships', 'guard_name' => 'web', 'title' => 'ملكيات السكن', 'icon' => 'description', 'link' => '', 'order_id' => 9, 'in_menu' => 1, 'in_setting' => 1, 'parent_id' => 0]);
        $permission127_id = DB::table('permissions')->insertGetId(['name' => 'list houseOwnerships', 'guard_name' => 'web', 'title' => 'إدارة ملكيات السكن', 'icon' => 'equalizer', 'link' => '/admin/houseOwnerships', 'order_id' => 1, 'in_menu' => 1, 'in_setting' => 1, 'parent_id' => $permission126_id]);
        $permission128_id = DB::table('permissions')->insertGetId(['name' => 'create houseOwnerships', 'guard_name' => 'web', 'title' => 'إضافة ملكية السكن', 'icon' => 'iso', 'link' => '/admin/houseOwnerships/create', 'order_id' => 1, 'in_menu' => 1, 'in_setting' => 1, 'parent_id' => $permission126_id]);
        $permission129_id = DB::table('permissions')->insertGetId(['name' => 'edit houseOwnerships', 'guard_name' => 'web', 'title' => 'تعديل ملكية السكن', 'icon' => 'equalizer', 'link' => '/admin/houseOwnerships/edit', 'order_id' => 1, 'in_menu' => 0, 'in_setting' => 1, 'parent_id' => $permission126_id]);
        $permission130_id = DB::table('permissions')->insertGetId(['name' => 'delete houseOwnerships', 'guard_name' => 'web', 'title' => 'حذف ملكية السكن', 'icon' => 'equalizer', 'link' => '/admin/houseOwnerships/delete', 'order_id' => 1, 'in_menu' => 0, 'in_setting' => 1, 'parent_id' => $permission126_id]);

        // houseRoofs
        $permission131_id = DB::table('permissions')->insertGetId(['name' => 'houseRoofs', 'guard_name' => 'web', 'title' => 'أنواع السكن', 'icon' => 'business', 'link' => '', 'order_id' => 10, 'in_menu' => 1, 'in_setting' => 1, 'parent_id' => 0]);
        $permission132_id = DB::table('permissions')->insertGetId(['name' => 'list houseRoofs', 'guard_name' => 'web', 'title' => 'إدارة أنواع السكن', 'icon' => 'equalizer', 'link' => '/admin/houseRoofs', 'order_id' => 1, 'in_menu' => 1, 'in_setting' => 1, 'parent_id' => $permission131_id]);
        $permission133_id = DB::table('permissions')->insertGetId(['name' => 'create houseRoofs', 'guard_name' => 'web', 'title' => 'إضافة نوع السكن', 'icon' => 'iso', 'link' => '/admin/houseRoofs/create', 'order_id' => 1, 'in_menu' => 1, 'in_setting' => 1, 'parent_id' => $permission131_id]);
        $permission134_id = DB::table('permissions')->insertGetId(['name' => 'edit houseRoofs', 'guard_name' => 'web', 'title' => 'تعديل نوع السكن', 'icon' => 'equalizer', 'link' => '/admin/houseRoofs/edit', 'order_id' => 1, 'in_menu' => 0, 'in_setting' => 1, 'parent_id' => $permission131_id]);
        $permission135_id = DB::table('permissions')->insertGetId(['name' => 'delete houseRoofs', 'guard_name' => 'web', 'title' => 'حذف نوع السكن', 'icon' => 'equalizer', 'link' => '/admin/houseRoofs/delete', 'order_id' => 1, 'in_menu' => 0, 'in_setting' => 1, 'parent_id' => $permission131_id]);

        // houseStatuses
        $permission136_id = DB::table('permissions')->insertGetId(['name' => 'houseStatuses', 'guard_name' => 'web', 'title' => 'أوضاع السكن', 'icon' => 'equalizer', 'link' => '', 'order_id' => 11, 'in_menu' => 1, 'in_setting' => 1, 'parent_id' => 0]);
        $permission137_id = DB::table('permissions')->insertGetId(['name' => 'list houseStatuses', 'guard_name' => 'web', 'title' => 'إدارة أوضاع السكن', 'icon' => 'equalizer', 'link' => '/admin/houseStatuses', 'order_id' => 1, 'in_menu' => 1, 'in_setting' => 1, 'parent_id' => $permission136_id]);
        $permission138_id = DB::table('permissions')->insertGetId(['name' => 'create houseStatuses', 'guard_name' => 'web', 'title' => 'إضافة وضع السكن', 'icon' => 'iso', 'link' => '/admin/houseStatuses/create', 'order_id' => 1, 'in_menu' => 1, 'in_setting' => 1, 'parent_id' => $permission136_id]);
        $permission139_id = DB::table('permissions')->insertGetId(['name' => 'edit houseStatuses', 'guard_name' => 'web', 'title' => 'تعديل وضع السكن', 'icon' => 'equalizer', 'link' => '/admin/houseStatuses/edit', 'order_id' => 1, 'in_menu' => 0, 'in_setting' => 1, 'parent_id' => $permission136_id]);
        $permission140_id = DB::table('permissions')->insertGetId(['name' => 'delete houseStatuses', 'guard_name' => 'web', 'title' => 'حذف وضع السكن', 'icon' => 'equalizer', 'link' => '/admin/houseStatuses/delete', 'order_id' => 1, 'in_menu' => 0, 'in_setting' => 1, 'parent_id' => $permission136_id]);

        // incomeTypes
        $permission141_id = DB::table('permissions')->insertGetId(['name' => 'incomeTypes', 'guard_name' => 'web', 'title' => 'جهات الدخل ', 'icon' => 'attach_money', 'link' => '', 'order_id' => 13, 'in_menu' => 1, 'in_setting' => 1, 'parent_id' => 0]);
        $permission142_id = DB::table('permissions')->insertGetId(['name' => 'list incomeTypes', 'guard_name' => 'web', 'title' => 'إدارة جهات الدخل ', 'icon' => 'equalizer', 'link' => '/admin/incomeTypes', 'order_id' => 1, 'in_menu' => 1, 'in_setting' => 1, 'parent_id' => $permission141_id]);
        $permission143_id = DB::table('permissions')->insertGetId(['name' => 'create incomeTypes', 'guard_name' => 'web', 'title' => 'إضافة جهة الدخل ', 'icon' => 'iso', 'link' => '/admin/incomeTypes/create', 'order_id' => 1, 'in_menu' => 1, 'in_setting' => 1, 'parent_id' => $permission141_id]);
        $permission144_id = DB::table('permissions')->insertGetId(['name' => 'edit incomeTypes', 'guard_name' => 'web', 'title' => 'تعديل جهة الدخل', 'icon' => 'equalizer', 'link' => '/admin/incomeTypes/edit', 'order_id' => 1, 'in_menu' => 0, 'in_setting' => 1, 'parent_id' => $permission141_id]);
        $permission145_id = DB::table('permissions')->insertGetId(['name' => 'delete incomeTypes', 'guard_name' => 'web', 'title' => 'حذف جهة الدخل', 'icon' => 'equalizer', 'link' => '/admin/incomeTypes/delete', 'order_id' => 1, 'in_menu' => 0, 'in_setting' => 1, 'parent_id' => $permission141_id]);
        $permission146_id = DB::table('permissions')->insertGetId(['name' => 'approval incomeTypes', 'guard_name' => 'web', 'title' => 'قبول جهة الدخل', 'icon' => 'equalizer', 'link' => '/admin/incomeTypes/approval', 'order_id' => 1, 'in_menu' => 0, 'in_setting' => 1, 'parent_id' => $permission141_id]);

        // jobTypes
        $permission147_id = DB::table('permissions')->insertGetId(['name' => 'jobTypes', 'guard_name' => 'web', 'title' => 'أنواع العمل', 'icon' => 'equalizer', 'link' => '', 'order_id' => 13, 'in_menu' => 1, 'in_setting' => 1, 'parent_id' => 0]);
        $permission148_id = DB::table('permissions')->insertGetId(['name' => 'list jobTypes', 'guard_name' => 'web', 'title' => 'إدارة أنواع العمل', 'icon' => 'equalizer', 'link' => '/admin/jobTypes', 'order_id' => 1, 'in_menu' => 1, 'in_setting' => 1, 'parent_id' => $permission147_id]);
        $permission149_id = DB::table('permissions')->insertGetId(['name' => 'create jobTypes', 'guard_name' => 'web', 'title' => 'إضافة نوع العمل', 'icon' => 'iso', 'link' => '/admin/jobTypes/create', 'order_id' => 1, 'in_menu' => 1, 'in_setting' => 1, 'parent_id' => $permission147_id]);
        $permission150_id = DB::table('permissions')->insertGetId(['name' => 'edit jobTypes', 'guard_name' => 'web', 'title' => 'تعديل نوع العمل', 'icon' => 'equalizer', 'link' => '/admin/jobTypes/edit', 'order_id' => 1, 'in_menu' => 0, 'in_setting' => 1, 'parent_id' => $permission147_id]);
        $permission151_id = DB::table('permissions')->insertGetId(['name' => 'delete jobTypes', 'guard_name' => 'web', 'title' => 'حذف نوع العمل', 'icon' => 'equalizer', 'link' => '/admin/jobTypes/delete', 'order_id' => 1, 'in_menu' => 0, 'in_setting' => 1, 'parent_id' => $permission147_id]);
        $permission152_id = DB::table('permissions')->insertGetId(['name' => 'approval jobTypes', 'guard_name' => 'web', 'title' => 'قبول نوع العمل', 'icon' => 'equalizer', 'link' => '/admin/jobTypes/approval', 'order_id' => 1, 'in_menu' => 0, 'in_setting' => 1, 'parent_id' => $permission147_id]);

        // qualifications
        $permission153_id = DB::table('permissions')->insertGetId(['name' => 'qualifications', 'guard_name' => 'web', 'title' => 'المؤهلات العلمية', 'icon' => 'book', 'link' => '', 'order_id' => 13, 'in_menu' => 1, 'in_setting' => 1, 'parent_id' => 0]);
        $permission154_id = DB::table('permissions')->insertGetId(['name' => 'list qualifications', 'guard_name' => 'web', 'title' => 'إدارة المؤهلات العلمية', 'icon' => 'equalizer', 'link' => '/admin/qualifications', 'order_id' => 1, 'in_menu' => 1, 'in_setting' => 1, 'parent_id' => $permission153_id]);
        $permission155_id = DB::table('permissions')->insertGetId(['name' => 'create qualifications', 'guard_name' => 'web', 'title' => 'إضافة مؤهل علمي', 'icon' => 'iso', 'link' => '/admin/qualifications/create', 'order_id' => 1, 'in_menu' => 1, 'in_setting' => 1, 'parent_id' => $permission153_id]);
        $permission156_id = DB::table('permissions')->insertGetId(['name' => 'edit qualifications', 'guard_name' => 'web', 'title' => 'تعديل مؤهل علمي', 'icon' => 'equalizer', 'link' => '/admin/qualifications/edit', 'order_id' => 1, 'in_menu' => 0, 'in_setting' => 1, 'parent_id' => $permission153_id]);
        $permission157_id = DB::table('permissions')->insertGetId(['name' => 'delete qualifications', 'guard_name' => 'web', 'title' => 'حذف مؤهل علمي', 'icon' => 'equalizer', 'link' => '/admin/qualifications/delete', 'order_id' => 1, 'in_menu' => 0, 'in_setting' => 1, 'parent_id' => $permission153_id]);

        // relationships
        $permission158_id = DB::table('permissions')->insertGetId(['name' => 'relationships', 'guard_name' => 'web', 'title' => 'صلات القرابة', 'icon' => 'supervisor_account', 'link' => '', 'order_id' => 13, 'in_menu' => 1, 'in_setting' => 1, 'parent_id' => 0]);
        $permission159_id = DB::table('permissions')->insertGetId(['name' => 'list relationships', 'guard_name' => 'web', 'title' => 'إدارة صلات القرابة', 'icon' => 'equalizer', 'link' => '/admin/relationships', 'order_id' => 1, 'in_menu' => 1, 'in_setting' => 1, 'parent_id' => $permission158_id]);
        $permission160_id = DB::table('permissions')->insertGetId(['name' => 'create relationships', 'guard_name' => 'web', 'title' => 'إضافة صلة القرابة', 'icon' => 'iso', 'link' => '/admin/relationships/create', 'order_id' => 1, 'in_menu' => 1, 'in_setting' => 1, 'parent_id' => $permission158_id]);
        $permission161_id = DB::table('permissions')->insertGetId(['name' => 'edit relationships', 'guard_name' => 'web', 'title' => 'تعديل صلة القرابة', 'icon' => 'equalizer', 'link' => '/admin/relationships/edit', 'order_id' => 1, 'in_menu' => 0, 'in_setting' => 1, 'parent_id' => $permission158_id]);
        $permission162_id = DB::table('permissions')->insertGetId(['name' => 'delete relationships', 'guard_name' => 'web', 'title' => 'حذف صلة القرابة', 'icon' => 'equalizer', 'link' => '/admin/relationships/delete', 'order_id' => 1, 'in_menu' => 0, 'in_setting' => 1, 'parent_id' => $permission158_id]);

        // universitySpecialties
        $permission163_id = DB::table('permissions')->insertGetId(['name' => 'universitySpecialties', 'guard_name' => 'web', 'title' => 'التخصصات الجامعية', 'icon' => 'equalizer', 'link' => '', 'order_id' => 13, 'in_menu' => 1, 'in_setting' => 1, 'parent_id' => 0]);
        $permission164_id = DB::table('permissions')->insertGetId(['name' => 'list universitySpecialties', 'guard_name' => 'web', 'title' => 'إدارة التخصصات الجامعي', 'icon' => 'equalizer', 'link' => '/admin/universitySpecialties', 'order_id' => 1, 'in_menu' => 1, 'in_setting' => 1, 'parent_id' => $permission163_id]);
        $permission165_id = DB::table('permissions')->insertGetId(['name' => 'create universitySpecialties', 'guard_name' => 'web', 'title' => 'إضافة التخصص الجامعي', 'icon' => 'iso', 'link' => '/admin/universitySpecialties/create', 'order_id' => 1, 'in_menu' => 1, 'in_setting' => 1, 'parent_id' => $permission163_id]);
        $permission166_id = DB::table('permissions')->insertGetId(['name' => 'edit universitySpecialties', 'guard_name' => 'web', 'title' => 'تعديل التخصص الجامعي', 'icon' => 'equalizer', 'link' => '/admin/universitySpecialties/edit', 'order_id' => 1, 'in_menu' => 0, 'in_setting' => 1, 'parent_id' => $permission163_id]);
        $permission167_id = DB::table('permissions')->insertGetId(['name' => 'delete universitySpecialties', 'guard_name' => 'web', 'title' => 'حذف التخصص الجامعي', 'icon' => 'equalizer', 'link' => '/admin/universitySpecialties/delete', 'order_id' => 1, 'in_menu' => 0, 'in_setting' => 1, 'parent_id' => $permission163_id]);
        $permission168_id = DB::table('permissions')->insertGetId(['name' => 'approval universitySpecialties', 'guard_name' => 'web', 'title' => 'قبول التخصص الجامعي', 'icon' => 'equalizer', 'link' => '/admin/universitySpecialties/approval', 'order_id' => 1, 'in_menu' => 0, 'in_setting' => 1, 'parent_id' => $permission163_id]);

        // visitReasons
        $permission169_id = DB::table('permissions')->insertGetId(['name' => 'visitReasons', 'guard_name' => 'web', 'title' => 'أسباب الزيارة', 'icon' => 'equalizer', 'link' => '', 'order_id' => 13, 'in_menu' => 1, 'in_setting' => 1, 'parent_id' => 0]);
        $permission170_id = DB::table('permissions')->insertGetId(['name' => 'list visitReasons', 'guard_name' => 'web', 'title' => 'إدارة أسباب الزيارة', 'icon' => 'equalizer', 'link' => '/admin/visitReasons', 'order_id' => 1, 'in_menu' => 1, 'in_setting' => 1, 'parent_id' => $permission169_id]);
        $permission171_id = DB::table('permissions')->insertGetId(['name' => 'create visitReasons', 'guard_name' => 'web', 'title' => 'إضافة سبب  الزيارة', 'icon' => 'iso', 'link' => '/admin/visitReasons/create', 'order_id' => 1, 'in_menu' => 1, 'in_setting' => 1, 'parent_id' => $permission169_id]);
        $permission172_id = DB::table('permissions')->insertGetId(['name' => 'edit visitReasons', 'guard_name' => 'web', 'title' => 'تعديل سبب  الزيارة', 'icon' => 'equalizer', 'link' => '/admin/visitReasons/edit', 'order_id' => 1, 'in_menu' => 0, 'in_setting' => 1, 'parent_id' => $permission169_id]);
        $permission173_id = DB::table('permissions')->insertGetId(['name' => 'delete visitReasons', 'guard_name' => 'web', 'title' => 'حذف سبب  الزيارة', 'icon' => 'equalizer', 'link' => '/admin/visitReasons/delete', 'order_id' => 1, 'in_menu' => 0, 'in_setting' => 1, 'parent_id' => $permission169_id]);

        // socialStatuses
        $permission174_id = DB::table('permissions')->insertGetId(['name' => 'socialStatuses', 'guard_name' => 'web', 'title' => 'الحالة الاجتماعية', 'icon' => 'accessible', 'link' => '', 'order_id' => 13, 'in_menu' => 1, 'in_setting' => 1, 'parent_id' => 0]);
        $permission175_id = DB::table('permissions')->insertGetId(['name' => 'list socialStatuses', 'guard_name' => 'web', 'title' => 'إدارة الحالة الاجتماعية', 'icon' => 'equalizer', 'link' => '/admin/socialStatuses', 'order_id' => 1, 'in_menu' => 1, 'in_setting' => 1, 'parent_id' => $permission174_id]);
        $permission176_id = DB::table('permissions')->insertGetId(['name' => 'create socialStatuses', 'guard_name' => 'web', 'title' => 'إضافة حالة اجتماعية', 'icon' => 'iso', 'link' => '/admin/socialStatuses/create', 'order_id' => 1, 'in_menu' => 1, 'in_setting' => 1, 'parent_id' => $permission174_id]);
        $permission177_id = DB::table('permissions')->insertGetId(['name' => 'edit socialStatuses', 'guard_name' => 'web', 'title' => 'تعديل حالة اجتماعية', 'icon' => 'equalizer', 'link' => '/admin/socialStatuses/edit', 'order_id' => 1, 'in_menu' => 0, 'in_setting' => 1, 'parent_id' => $permission174_id]);
        $permission178_id = DB::table('permissions')->insertGetId(['name' => 'delete socialStatuses', 'guard_name' => 'web', 'title' => 'حذف حالة اجتماعية', 'icon' => 'equalizer', 'link' => '/admin/socialStatuses/delete', 'order_id' => 1, 'in_menu' => 0, 'in_setting' => 1, 'parent_id' => $permission174_id]);

        // qualificationLevels
        $permission179_id = DB::table('permissions')->insertGetId(['name' => 'qualificationLevels', 'guard_name' => 'web', 'title' => 'المستوى التعليمي', 'icon' => 'collections_bookmark', 'link' => '', 'order_id' => 13, 'in_menu' => 1, 'in_setting' => 1, 'parent_id' => 0]);
        $permission180_id = DB::table('permissions')->insertGetId(['name' => 'list qualificationLevels', 'guard_name' => 'web', 'title' => 'إدارة المستوى التعليمي', 'icon' => 'equalizer', 'link' => '/admin/qualificationLevels', 'order_id' => 1, 'in_menu' => 1, 'in_setting' => 1, 'parent_id' => $permission179_id]);
        $permission181_id = DB::table('permissions')->insertGetId(['name' => 'create qualificationLevels', 'guard_name' => 'web', 'title' => 'إضافة مستوى تعليمي', 'icon' => 'iso', 'link' => '/admin/qualificationLevels/create', 'order_id' => 1, 'in_menu' => 1, 'in_setting' => 1, 'parent_id' => $permission179_id]);
        $permission182_id = DB::table('permissions')->insertGetId(['name' => 'edit qualificationLevels', 'guard_name' => 'web', 'title' => 'تعديل مستوى تعليمي', 'icon' => 'equalizer', 'link' => '/admin/qualificationLevels/edit', 'order_id' => 1, 'in_menu' => 0, 'in_setting' => 1, 'parent_id' => $permission179_id]);
        $permission183_id = DB::table('permissions')->insertGetId(['name' => 'delete qualificationLevels', 'guard_name' => 'web', 'title' => 'حذف مستوى تعليمي', 'icon' => 'equalizer', 'link' => '/admin/qualificationLevels/delete', 'order_id' => 1, 'in_menu' => 0, 'in_setting' => 1, 'parent_id' => $permission179_id]);

        // studyLevels
        $permission184_id = DB::table('permissions')->insertGetId(['name' => 'studyLevels', 'guard_name' => 'web', 'title' => 'المستوى الجامعي', 'icon' => 'school', 'link' => '', 'order_id' => 13, 'in_menu' => 1, 'in_setting' => 1, 'parent_id' => 0]);
        $permission185_id = DB::table('permissions')->insertGetId(['name' => 'list studyLevels', 'guard_name' => 'web', 'title' => 'إدارة المستوى الجامعي', 'icon' => 'equalizer', 'link' => '/admin/studyLevels', 'order_id' => 1, 'in_menu' => 1, 'in_setting' => 1, 'parent_id' => $permission184_id]);
        $permission186_id = DB::table('permissions')->insertGetId(['name' => 'create studyLevels', 'guard_name' => 'web', 'title' => 'إضافة مستوى جامعي', 'icon' => 'iso', 'link' => '/admin/studyLevels/create', 'order_id' => 1, 'in_menu' => 1, 'in_setting' => 1, 'parent_id' => $permission184_id]);
        $permission187_id = DB::table('permissions')->insertGetId(['name' => 'edit studyLevels', 'guard_name' => 'web', 'title' => 'تعديل مستوى جامعي', 'icon' => 'equalizer', 'link' => '/admin/studyLevels/edit', 'order_id' => 1, 'in_menu' => 0, 'in_setting' => 1, 'parent_id' => $permission184_id]);
        $permission188_id = DB::table('permissions')->insertGetId(['name' => 'delete studyLevels', 'guard_name' => 'web', 'title' => 'حذف مستوى جامعي', 'icon' => 'equalizer', 'link' => '/admin/studyLevels/delete', 'order_id' => 1, 'in_menu' => 0, 'in_setting' => 1, 'parent_id' => $permission184_id]);

        // studyParts
        $permission189_id = DB::table('permissions')->insertGetId(['name' => 'studyParts', 'guard_name' => 'web', 'title' => 'جهات الدراسة', 'icon' => 'chrome_reader_mode', 'link' => '', 'order_id' => 13, 'in_menu' => 1, 'in_setting' => 1, 'parent_id' => 0]);
        $permission190_id = DB::table('permissions')->insertGetId(['name' => 'list studyParts', 'guard_name' => 'web', 'title' => 'إدارة جهات الدراسة', 'icon' => 'equalizer', 'link' => '/admin/studyParts', 'order_id' => 1, 'in_menu' => 1, 'in_setting' => 1, 'parent_id' => $permission189_id]);
        $permission191_id = DB::table('permissions')->insertGetId(['name' => 'create studyParts', 'guard_name' => 'web', 'title' => 'إضافة جهة الدراسة', 'icon' => 'iso', 'link' => '/admin/studyParts/create', 'order_id' => 1, 'in_menu' => 1, 'in_setting' => 1, 'parent_id' => $permission189_id]);
        $permission192_id = DB::table('permissions')->insertGetId(['name' => 'edit studyParts', 'guard_name' => 'web', 'title' => 'تعديل جهة الدراسة', 'icon' => 'equalizer', 'link' => '/admin/studyParts/edit', 'order_id' => 1, 'in_menu' => 0, 'in_setting' => 1, 'parent_id' => $permission189_id]);
        $permission193_id = DB::table('permissions')->insertGetId(['name' => 'delete studyParts', 'guard_name' => 'web', 'title' => 'حذف جهة دراسة', 'icon' => 'equalizer', 'link' => '/admin/studyParts/delete', 'order_id' => 1, 'in_menu' => 0, 'in_setting' => 1, 'parent_id' => $permission189_id]);

        // studyParts
        $permission55189_id = DB::table('permissions')->insertGetId(['name' => 'departments', 'guard_name' => 'web', 'title' => 'الأقسام', 'icon' => 'chrome_reader_mode', 'link' => '', 'order_id' => 13, 'in_menu' => 1, 'in_setting' => 1, 'parent_id' => 0]);
        $permission55190_id = DB::table('permissions')->insertGetId(['name' => 'list departments', 'guard_name' => 'web', 'title' => 'إدارة الأقسام', 'icon' => 'equalizer', 'link' => '/admin/departments', 'order_id' => 1, 'in_menu' => 1, 'in_setting' => 1, 'parent_id' => $permission55189_id]);
        $permission55191_id = DB::table('permissions')->insertGetId(['name' => 'create departments', 'guard_name' => 'web', 'title' => 'إضافة قسم', 'icon' => 'iso', 'link' => '/admin/departments/create', 'order_id' => 1, 'in_menu' => 1, 'in_setting' => 1, 'parent_id' => $permission55189_id]);
        $permission55192_id = DB::table('permissions')->insertGetId(['name' => 'edit departments', 'guard_name' => 'web', 'title' => 'تعديل قسم', 'icon' => 'equalizer', 'link' => '/admin/departments/edit', 'order_id' => 1, 'in_menu' => 0, 'in_setting' => 1, 'parent_id' => $permission55189_id]);
        $permission55193_id = DB::table('permissions')->insertGetId(['name' => 'delete departments', 'guard_name' => 'web', 'title' => 'حذف قسم', 'icon' => 'equalizer', 'link' => '/admin/departments/delete', 'order_id' => 1, 'in_menu' => 0, 'in_setting' => 1, 'parent_id' => $permission55189_id]);


        // studyTypes
        $permission194_id = DB::table('permissions')->insertGetId(['name' => 'studyTypes', 'guard_name' => 'web', 'title' => 'أنواع الدراسة', 'icon' => 'equalizer', 'link' => '', 'order_id' => 13, 'in_menu' => 1, 'in_setting' => 1, 'parent_id' => 0]);
        $permission195_id = DB::table('permissions')->insertGetId(['name' => 'list studyTypes', 'guard_name' => 'web', 'title' => 'إدارة أنواع الدراسة', 'icon' => 'equalizer', 'link' => '/admin/studyTypes', 'order_id' => 1, 'in_menu' => 1, 'in_setting' => 1, 'parent_id' => $permission194_id]);
        $permission196_id = DB::table('permissions')->insertGetId(['name' => 'create studyTypes', 'guard_name' => 'web', 'title' => 'إضافة نوع الدراسة', 'icon' => 'iso', 'link' => '/admin/studyTypes/create', 'order_id' => 1, 'in_menu' => 1, 'in_setting' => 1, 'parent_id' => $permission194_id]);
        $permission197_id = DB::table('permissions')->insertGetId(['name' => 'edit studyTypes', 'guard_name' => 'web', 'title' => 'تعديل نوع الدراسة', 'icon' => 'equalizer', 'link' => '/admin/studyTypes/edit', 'order_id' => 1, 'in_menu' => 0, 'in_setting' => 1, 'parent_id' => $permission194_id]);
        $permission198_id = DB::table('permissions')->insertGetId(['name' => 'delete studyTypes', 'guard_name' => 'web', 'title' => 'حذف نوع الدراسة', 'icon' => 'equalizer', 'link' => '/admin/studyTypes/delete', 'order_id' => 1, 'in_menu' => 0, 'in_setting' => 1, 'parent_id' => $permission194_id]);


        // familyTypes
        $permission199_id = DB::table('permissions')->insertGetId(['name' => 'familyTypes', 'guard_name' => 'web', 'title' => 'تصنيفات الحالات', 'icon' => 'equalizer', 'link' => '', 'order_id' => 2, 'in_menu' => 1, 'in_setting' => 1, 'parent_id' => 0]);
        $permission200_id = DB::table('permissions')->insertGetId(['name' => 'list familyTypes', 'guard_name' => 'web', 'title' => 'إدارة تصنيفات الحالات', 'icon' => 'equalizer', 'link' => '/admin/familyTypes', 'order_id' => 1, 'in_menu' => 1, 'in_setting' => 1, 'parent_id' => $permission199_id]);
        $permission201_id = DB::table('permissions')->insertGetId(['name' => 'create familyTypes', 'guard_name' => 'web', 'title' => 'إضافة تصنيف الحالة', 'icon' => 'iso', 'link' => '/admin/familyTypes/create', 'order_id' => 1, 'in_menu' => 1, 'in_setting' => 1, 'parent_id' => $permission199_id]);
        $permission202_id = DB::table('permissions')->insertGetId(['name' => 'edit familyTypes', 'guard_name' => 'web', 'title' => 'تعديل تصنيف الحالة', 'icon' => 'equalizer', 'link' => '/admin/familyTypes/edit', 'order_id' => 1, 'in_menu' => 0, 'in_setting' => 1, 'parent_id' => $permission199_id]);
        $permission203_id = DB::table('permissions')->insertGetId(['name' => 'delete familyTypes', 'guard_name' => 'web', 'title' => 'حذف تصنيف الحالة', 'icon' => 'equalizer', 'link' => '/admin/familyTypes/delete', 'order_id' => 1, 'in_menu' => 0, 'in_setting' => 1, 'parent_id' => $permission199_id]);

        // idTypes
        $permission204_id = DB::table('permissions')->insertGetId(['name' => 'idTypes', 'guard_name' => 'web', 'title' => 'أنواع الوثائق', 'icon' => 'equalizer', 'link' => '', 'order_id' => 2, 'in_menu' => 1, 'in_setting' => 1, 'parent_id' => 0]);
        $permission205_id = DB::table('permissions')->insertGetId(['name' => 'list idTypes', 'guard_name' => 'web', 'title' => 'إدارة أنواع الوثائق', 'icon' => 'equalizer', 'link' => '/admin/idTypes', 'order_id' => 1, 'in_menu' => 1, 'in_setting' => 1, 'parent_id' => $permission204_id]);
        $permission206_id = DB::table('permissions')->insertGetId(['name' => 'create idTypes', 'guard_name' => 'web', 'title' => 'إضافة نوع الوثيقة', 'icon' => 'iso', 'link' => '/admin/idTypes/create', 'order_id' => 1, 'in_menu' => 1, 'in_setting' => 1, 'parent_id' => $permission204_id]);
        $permission207_id = DB::table('permissions')->insertGetId(['name' => 'edit familyTypes', 'guard_name' => 'web', 'title' => 'تعديل نوع الوثيقة', 'icon' => 'equalizer', 'link' => '/admin/idTypes/edit', 'order_id' => 1, 'in_menu' => 0, 'in_setting' => 1, 'parent_id' => $permission204_id]);
        $permission208_id = DB::table('permissions')->insertGetId(['name' => 'delete idTypes', 'guard_name' => 'web', 'title' => 'حذف نوع الوثيقة', 'icon' => 'equalizer', 'link' => '/admin/idTypes/delete', 'order_id' => 1, 'in_menu' => 0, 'in_setting' => 1, 'parent_id' => $permission204_id]);


        // furnitureStatuses
        $permission209_id = DB::table('permissions')->insertGetId(['name' => 'furnitureStatuses', 'guard_name' => 'web', 'title' => 'أوضاع الأثاث', 'icon' => 'equalizer', 'link' => '', 'order_id' => 2, 'in_menu' => 1, 'in_setting' => 1, 'parent_id' => 0]);
        $permission210_id = DB::table('permissions')->insertGetId(['name' => 'list furnitureStatuses', 'guard_name' => 'web', 'title' => 'إدارة أوضاع الأثاث', 'icon' => 'equalizer', 'link' => '/admin/furnitureStatuses', 'order_id' => 1, 'in_menu' => 1, 'in_setting' => 1, 'parent_id' => $permission209_id]);
        $permission211_id = DB::table('permissions')->insertGetId(['name' => 'create furnitureStatuses', 'guard_name' => 'web', 'title' => 'إضافة وضع الأثاث', 'icon' => 'iso', 'link' => '/admin/furnitureStatuses/create', 'order_id' => 1, 'in_menu' => 1, 'in_setting' => 1, 'parent_id' => $permission209_id]);
        $permission212_id = DB::table('permissions')->insertGetId(['name' => 'edit furnitureStatuses', 'guard_name' => 'web', 'title' => 'تعديل وضع الأثاث', 'icon' => 'equalizer', 'link' => '/admin/furnitureStatuses/edit', 'order_id' => 1, 'in_menu' => 0, 'in_setting' => 1, 'parent_id' => $permission209_id]);
        $permission213_id = DB::table('permissions')->insertGetId(['name' => 'delete furnitureStatuses', 'guard_name' => 'web', 'title' => 'حذف وضع الأثاث', 'icon' => 'equalizer', 'link' => '/admin/furnitureStatuses/delete', 'order_id' => 1, 'in_menu' => 0, 'in_setting' => 1, 'parent_id' => $permission209_id]);

        // beneficiary
        /* $permission214_id = DB::table('permissions')->insertGetId(['name' => 'beneficiaryInstitutions', 'guard_name' => 'web', 'title' => 'الجهات المستفيدة', 'icon' => 'equalizer', 'link' => '', 'order_id' => 8, 'in_menu' => 1, 'in_setting' => 1, 'parent_id' => 0]);
         $permission215_id = DB::table('permissions')->insertGetId(['name' => 'list beneficiaryInstitutions', 'guard_name' => 'web', 'title' => 'إدارة الجهات المستفيدة', 'icon' => 'equalizer', 'link' => '/admin/beneficiaryInstitutions', 'order_id' => 1, 'in_menu' => 1, 'in_setting' => 1, 'parent_id' => $permission214_id]);
         $permission216_id = DB::table('permissions')->insertGetId(['name' => 'create beneficiaryInstitutions', 'guard_name' => 'web', 'title' => 'إضافة جهة مستفيدة', 'icon' => 'iso', 'link' => '/admin/beneficiaryInstitutions/create', 'order_id' => 1, 'in_menu' => 1, 'in_setting' => 1, 'parent_id' => $permission214_id]);
         $permission217_id = DB::table('permissions')->insertGetId(['name' => 'edit beneficiaryInstitutions', 'guard_name' => 'web', 'title' => 'تعديل جهة مستفيدة', 'icon' => 'equalizer', 'link' => '/admin/beneficiaryInstitutions/edit', 'order_id' => 1, 'in_menu' => 0, 'in_setting' => 1, 'parent_id' => $permission214_id]);
         $permission218_id = DB::table('permissions')->insertGetId(['name' => 'delete beneficiaryInstitutions', 'guard_name' => 'web', 'title' => 'حذف جهة مستفيدة', 'icon' => 'equalizer', 'link' => '/admin/beneficiaryInstitutions/delete', 'order_id' => 1, 'in_menu' => 0, 'in_setting' => 1, 'parent_id' => $permission214_id]);
 */
        //expensePrices
        $permission369_id = DB::table('permissions')->insertGetId(['name' => 'expensePrices', 'guard_name' => 'web', 'title' => 'أسعار الصرف', 'icon' => 'equalizer', 'link' => '', 'order_id' => 17, 'in_menu' => 1, 'in_setting' => 1, 'parent_id' => 0]);
        $permission370_id = DB::table('permissions')->insertGetId(['name' => 'list expensePrices', 'guard_name' => 'web', 'title' => 'إدارة اسعار الصرف', 'icon' => 'equalizer', 'link' => '/admin/expense_prices', 'order_id' => 1, 'in_menu' => 1, 'in_setting' => 0, 'parent_id' => $permission369_id]);
        $permission371_id = DB::table('permissions')->insertGetId(['name' => 'create expensePrices', 'guard_name' => 'web', 'title' => 'إضافة سعر صرف', 'icon' => 'equalizer', 'link' => '/admin/expense_prices/create', 'order_id' => 1, 'in_menu' => 1, 'in_setting' => 0, 'parent_id' => $permission369_id]);
        $permission372_id = DB::table('permissions')->insertGetId(['name' => 'edit expensePrices', 'guard_name' => 'web', 'title' => 'تعديل سعر صرف', 'icon' => 'equalizer', 'link' => '/admin/expense_prices/edit', 'order_id' => 1, 'in_menu' => 0, 'in_setting' => 0, 'parent_id' => $permission369_id]);
        $permission373_id = DB::table('permissions')->insertGetId(['name' => 'delete expensePrices', 'guard_name' => 'web', 'title' => 'حذف سعر صرف', 'icon' => 'equalizer', 'link' => '/admin/expense_prices/delete', 'order_id' => 1, 'in_menu' => 0, 'in_setting' => 0, 'parent_id' => $permission369_id]);

        //expenseAmount
        $permission269_id = DB::table('permissions')->insertGetId(['name' => 'expenseAmounts', 'guard_name' => 'web', 'title' => 'مبالغ الصرفيات', 'icon' => 'equalizer', 'link' => '', 'order_id' => 17, 'in_menu' => 1, 'in_setting' => 1, 'parent_id' => 0]);
        $permission270_id = DB::table('permissions')->insertGetId(['name' => 'list expenseAmounts', 'guard_name' => 'web', 'title' => 'إدارة مبالغ الصرفيات', 'icon' => 'equalizer', 'link' => '/admin/expense_amounts', 'order_id' => 1, 'in_menu' => 1, 'in_setting' => 0, 'parent_id' => $permission269_id]);
        $permission271_id = DB::table('permissions')->insertGetId(['name' => 'create expenseAmounts', 'guard_name' => 'web', 'title' => 'إضافة مبلغ صرفية', 'icon' => 'equalizer', 'link' => '/admin/expense_amounts/create', 'order_id' => 1, 'in_menu' => 1, 'in_setting' => 0, 'parent_id' => $permission269_id]);
        $permission272_id = DB::table('permissions')->insertGetId(['name' => 'edit expenseAmounts', 'guard_name' => 'web', 'title' => 'تعديل مبلغ صرفية', 'icon' => 'equalizer', 'link' => '/admin/expense_amounts/edit', 'order_id' => 1, 'in_menu' => 0, 'in_setting' => 0, 'parent_id' => $permission269_id]);
        $permission273_id = DB::table('permissions')->insertGetId(['name' => 'delete expenseAmounts', 'guard_name' => 'web', 'title' => 'حذف مبلغ صرفية', 'icon' => 'equalizer', 'link' => '/admin/expense_amounts/delete', 'order_id' => 1, 'in_menu' => 0, 'in_setting' => 0, 'parent_id' => $permission269_id]);

        //tasks
        $permission5569_id = DB::table('permissions')->insertGetId(['name' => 'tasks', 'guard_name' => 'web', 'title' => 'المهام', 'icon' => 'equalizer', 'link' => '', 'order_id' => 17, 'in_menu' => 1, 'in_setting' => 3, 'parent_id' => 0]);
        $permission55270_id = DB::table('permissions')->insertGetId(['name' => 'list tasks', 'guard_name' => 'web', 'title' => 'إدارة المهام', 'icon' => 'equalizer', 'link' => '/admin/tasks', 'order_id' => 1, 'in_menu' => 1, 'in_setting' => 0, 'parent_id' => $permission5569_id]);
        $permission55271_id = DB::table('permissions')->insertGetId(['name' => 'create tasks', 'guard_name' => 'web', 'title' => 'إضافة مهمة', 'icon' => 'equalizer', 'link' => '/admin/tasks/create', 'order_id' => 1, 'in_menu' => 1, 'in_setting' => 0, 'parent_id' => $permission5569_id]);
        $permission55272_id = DB::table('permissions')->insertGetId(['name' => 'edit tasks', 'guard_name' => 'web', 'title' => 'تعديل مهمة', 'icon' => 'equalizer', 'link' => '/admin/tasks/edit', 'order_id' => 1, 'in_menu' => 0, 'in_setting' => 0, 'parent_id' => $permission5569_id]);
        $permission55273_id = DB::table('permissions')->insertGetId(['name' => 'delete tasks', 'guard_name' => 'web', 'title' => 'حذف مهمة', 'icon' => 'equalizer', 'link' => '/admin/tasks/delete', 'order_id' => 1, 'in_menu' => 0, 'in_setting' => 0, 'parent_id' => $permission5569_id]);

//Seasons
        $permission15569_id = DB::table('permissions')->insertGetId(['name' => 'seasons', 'guard_name' => 'web', 'title' => 'المواسم', 'icon' => 'equalizer', 'link' => '', 'order_id' => 17, 'in_menu' => 1, 'in_setting' => 2, 'parent_id' => 0]);
        $permission155270_id = DB::table('permissions')->insertGetId(['name' => 'list seasons', 'guard_name' => 'web', 'title' => 'إدارة موسم', 'icon' => 'equalizer', 'link' => '/admin/seasons', 'order_id' => 1, 'in_menu' => 1, 'in_setting' => 0, 'parent_id' => $permission15569_id]);
        $permission155271_id = DB::table('permissions')->insertGetId(['name' => 'create seasons', 'guard_name' => 'web', 'title' => 'إضافة موسم', 'icon' => 'equalizer', 'link' => '/admin/seasons/create', 'order_id' => 1, 'in_menu' => 1, 'in_setting' => 0, 'parent_id' => $permission15569_id]);
        $permission155272_id = DB::table('permissions')->insertGetId(['name' => 'edit seasons', 'guard_name' => 'web', 'title' => 'تعديل موسم', 'icon' => 'equalizer', 'link' => '/admin/seasons/edit', 'order_id' => 1, 'in_menu' => 0, 'in_setting' => 0, 'parent_id' => $permission15569_id]);
        $permission155273_id = DB::table('permissions')->insertGetId(['name' => 'delete seasons', 'guard_name' => 'web', 'title' => 'حذف موسم', 'icon' => 'equalizer', 'link' => '/admin/seasons/delete', 'order_id' => 1, 'in_menu' => 0, 'in_setting' => 0, 'parent_id' => $permission15569_id]);

        //coupon_reasons
        $permission25569_id = DB::table('permissions')->insertGetId(['name' => 'coupon_reasons', 'guard_name' => 'web', 'title' => 'أسباب المساعدة', 'icon' => 'equalizer', 'link' => '', 'order_id' => 17, 'in_menu' => 1, 'in_setting' => 1, 'parent_id' => 0]);
        $permission255270_id = DB::table('permissions')->insertGetId(['name' => 'list coupon_reasons', 'guard_name' => 'web', 'title' => 'إدارة أسباب المساعدة', 'icon' => 'equalizer', 'link' => '/admin/coupon_reasons', 'order_id' => 1, 'in_menu' => 1, 'in_setting' => 0, 'parent_id' => $permission25569_id]);
        $permission255271_id = DB::table('permissions')->insertGetId(['name' => 'create coupon_reasons', 'guard_name' => 'web', 'title' => 'إضافة سبب مساعدة', 'icon' => 'equalizer', 'link' => '/admin/coupon_reasons/create', 'order_id' => 1, 'in_menu' => 1, 'in_setting' => 0, 'parent_id' => $permission25569_id]);
        $permission255272_id = DB::table('permissions')->insertGetId(['name' => 'edit coupon_reasons', 'guard_name' => 'web', 'title' => 'تعديل سبب مساعدة', 'icon' => 'equalizer', 'link' => '/admin/coupon_reasons/edit', 'order_id' => 1, 'in_menu' => 0, 'in_setting' => 0, 'parent_id' => $permission25569_id]);
        $permission255273_id = DB::table('permissions')->insertGetId(['name' => 'delete coupon_reasons', 'guard_name' => 'web', 'title' => 'حذف سبب مساعدة', 'icon' => 'equalizer', 'link' => '/admin/coupon_reasons/delete', 'order_id' => 1, 'in_menu' => 0, 'in_setting' => 0, 'parent_id' => $permission25569_id]);
//target_types
        $permission35569_id = DB::table('permissions')->insertGetId(['name' => 'target_types', 'guard_name' => 'web', 'title' => 'فئات الاستهداف', 'icon' => 'equalizer', 'link' => '', 'order_id' => 17, 'in_menu' => 1, 'in_setting' => 1, 'parent_id' => 0]);
        $permission355270_id = DB::table('permissions')->insertGetId(['name' => 'list target_types', 'guard_name' => 'web', 'title' => 'إدارة فئة استهداف', 'icon' => 'equalizer', 'link' => '/admin/target_types', 'order_id' => 1, 'in_menu' => 1, 'in_setting' => 0, 'parent_id' => $permission35569_id]);
        $permission355271_id = DB::table('permissions')->insertGetId(['name' => 'create target_types', 'guard_name' => 'web', 'title' => 'إضافة فئة استهداف', 'icon' => 'equalizer', 'link' => '/admin/target_types/create', 'order_id' => 1, 'in_menu' => 1, 'in_setting' => 0, 'parent_id' => $permission35569_id]);
        $permission355272_id = DB::table('permissions')->insertGetId(['name' => 'edit target_types', 'guard_name' => 'web', 'title' => 'تعديل فئة استهداف', 'icon' => 'equalizer', 'link' => '/admin/target_types/edit', 'order_id' => 1, 'in_menu' => 0, 'in_setting' => 0, 'parent_id' => $permission35569_id]);
        $permission355273_id = DB::table('permissions')->insertGetId(['name' => 'delete target_types', 'guard_name' => 'web', 'title' => 'حذف فئةاستهداف', 'icon' => 'equalizer', 'link' => '/admin/target_types/delete', 'order_id' => 1, 'in_menu' => 0, 'in_setting' => 0, 'parent_id' => $permission35569_id]);

//item_types
        $permission45569_id = DB::table('permissions')->insertGetId(['name' => 'item_types', 'guard_name' => 'web', 'title' => 'أنواع الوحدات', 'icon' => 'equalizer', 'link' => '', 'order_id' => 17, 'in_menu' => 1, 'in_setting' => 1, 'parent_id' => 0]);
        $permission455270_id = DB::table('permissions')->insertGetId(['name' => 'list item_types', 'guard_name' => 'web', 'title' => 'إدارة نوع الوحدة', 'icon' => 'equalizer', 'link' => '/admin/item_types', 'order_id' => 1, 'in_menu' => 1, 'in_setting' => 0, 'parent_id' => $permission45569_id]);
        $permission455271_id = DB::table('permissions')->insertGetId(['name' => 'create item_types', 'guard_name' => 'web', 'title' => 'إضافة نوع وحدة', 'icon' => 'equalizer', 'link' => '/admin/item_types/create', 'order_id' => 1, 'in_menu' => 1, 'in_setting' => 0, 'parent_id' => $permission45569_id]);
        $permission455272_id = DB::table('permissions')->insertGetId(['name' => 'edit item_types', 'guard_name' => 'web', 'title' => 'تعديل نوع وحدة', 'icon' => 'equalizer', 'link' => '/admin/item_types/edit', 'order_id' => 1, 'in_menu' => 0, 'in_setting' => 0, 'parent_id' => $permission45569_id]);
        $permission455273_id = DB::table('permissions')->insertGetId(['name' => 'delete item_types', 'guard_name' => 'web', 'title' => 'حذف نوع وحدة', 'icon' => 'equalizer', 'link' => '/admin/item_types/delete', 'order_id' => 1, 'in_menu' => 0, 'in_setting' => 0, 'parent_id' => $permission45569_id]);

//Item_categories
        $permission55569_id = DB::table('permissions')->insertGetId(['name' => 'item_categories', 'guard_name' => 'web', 'title' => 'أصناف الوحدات', 'icon' => 'equalizer', 'link' => '', 'order_id' => 17, 'in_menu' => 1, 'in_setting' => 1, 'parent_id' => 0]);
        $permission555270_id = DB::table('permissions')->insertGetId(['name' => 'list item_categories', 'guard_name' => 'web', 'title' => 'إدارة أصناف الوحدات', 'icon' => 'equalizer', 'link' => '/admin/item_categories', 'order_id' => 1, 'in_menu' => 1, 'in_setting' => 0, 'parent_id' => $permission55569_id]);
        $permission555271_id = DB::table('permissions')->insertGetId(['name' => 'create item_categories', 'guard_name' => 'web', 'title' => 'إضافة صنف وحدة', 'icon' => 'equalizer', 'link' => '/admin/item_categories/create', 'order_id' => 1, 'in_menu' => 1, 'in_setting' => 0, 'parent_id' => $permission55569_id]);
        $permission555272_id = DB::table('permissions')->insertGetId(['name' => 'edit item_categories', 'guard_name' => 'web', 'title' => 'تعديل صنف وحدة', 'icon' => 'equalizer', 'link' => '/admin/item_categories/edit', 'order_id' => 1, 'in_menu' => 0, 'in_setting' => 0, 'parent_id' => $permission55569_id]);
        $permission555273_id = DB::table('permissions')->insertGetId(['name' => 'delete item_categories', 'guard_name' => 'web', 'title' => 'حذف صنف وحدة', 'icon' => 'equalizer', 'link' => '/admin/item_categories/delete', 'order_id' => 1, 'in_menu' => 0, 'in_setting' => 0, 'parent_id' => $permission55569_id]);
//licensors
        $permission655569_id = DB::table('permissions')->insertGetId(['name' => 'licensors', 'guard_name' => 'web', 'title' => 'جهات الترخيص', 'icon' => 'equalizer', 'link' => '', 'order_id' => 17, 'in_menu' => 1, 'in_setting' => 1, 'parent_id' => 0]);
        $permission6555270_id = DB::table('permissions')->insertGetId(['name' => 'list licensors', 'guard_name' => 'web', 'title' => 'إدارة جهات الترخيص', 'icon' => 'equalizer', 'link' => '/admin/licensors', 'order_id' => 1, 'in_menu' => 1, 'in_setting' => 0, 'parent_id' => $permission655569_id]);
        $permission6555271_id = DB::table('permissions')->insertGetId(['name' => 'create licensors', 'guard_name' => 'web', 'title' => 'إضافة جهة ترخيص', 'icon' => 'equalizer', 'link' => '/admin/licensors/create', 'order_id' => 1, 'in_menu' => 1, 'in_setting' => 0, 'parent_id' => $permission655569_id]);
        $permission6555272_id = DB::table('permissions')->insertGetId(['name' => 'edit licensors', 'guard_name' => 'web', 'title' => 'تعديل جهة ترخيص', 'icon' => 'equalizer', 'link' => '/admin/licensors/edit', 'order_id' => 1, 'in_menu' => 0, 'in_setting' => 0, 'parent_id' => $permission655569_id]);
        $permission6555273_id = DB::table('permissions')->insertGetId(['name' => 'delete licensors', 'guard_name' => 'web', 'title' => 'حذف جهة ترخيص', 'icon' => 'equalizer', 'link' => '/admin/licensors/delete', 'order_id' => 1, 'in_menu' => 0, 'in_setting' => 0, 'parent_id' => $permission655569_id]);
        //coupon_reasons
        $permission255695_id = DB::table('permissions')->insertGetId(['name' => 'institution_types', 'guard_name' => 'web', 'title' => 'أنواع الجمعيات', 'icon' => 'equalizer', 'link' => '', 'order_id' => 17, 'in_menu' => 1, 'in_setting' => 1, 'parent_id' => 0]);
        $permission2552705_id = DB::table('permissions')->insertGetId(['name' => 'list institution_types', 'guard_name' => 'web', 'title' => 'إدارة أنواع الجمعيات', 'icon' => 'equalizer', 'link' => '/admin/institution_types', 'order_id' => 1, 'in_menu' => 1, 'in_setting' => 0, 'parent_id' => $permission255695_id]);
        $permission2552715_id = DB::table('permissions')->insertGetId(['name' => 'create institution_types', 'guard_name' => 'web', 'title' => 'إضافة أنواع الجمعيات', 'icon' => 'equalizer', 'link' => '/admin/institution_types/create', 'order_id' => 1, 'in_menu' => 1, 'in_setting' => 0, 'parent_id' => $permission255695_id]);
        $permission2552725_id = DB::table('permissions')->insertGetId(['name' => 'edit institution_types', 'guard_name' => 'web', 'title' => 'تعديل أنواع الجمعيات', 'icon' => 'equalizer', 'link' => '/admin/institution_types/edit', 'order_id' => 1, 'in_menu' => 0, 'in_setting' => 0, 'parent_id' => $permission255695_id]);
        $permission2552735_id = DB::table('permissions')->insertGetId(['name' => 'delete institution_types', 'guard_name' => 'web', 'title' => 'حذف أنواع الجمعيات', 'icon' => 'equalizer', 'link' => '/admin/institution_types/delete', 'order_id' => 1, 'in_menu' => 0, 'in_setting' => 0, 'parent_id' => $permission255695_id]);

        // immovables
        $permission15811_id = DB::table('permissions')->insertGetId(['name' => 'immovables', 'guard_name' => 'web', 'title' => 'العقارات', 'icon' => 'supervisor_account', 'link' => '', 'order_id' => 13, 'in_menu' => 1, 'in_setting' => 1, 'parent_id' => 0]);
        $permission15911_id = DB::table('permissions')->insertGetId(['name' => 'list immovables', 'guard_name' => 'web', 'title' => 'إدارة العقارات', 'icon' => 'equalizer', 'link' => '/admin/immovables', 'order_id' => 1, 'in_menu' => 1, 'in_setting' => 1, 'parent_id' => $permission15811_id]);
        $permission16011_id = DB::table('permissions')->insertGetId(['name' => 'create immovables', 'guard_name' => 'web', 'title' => 'إضافة عقار', 'icon' => 'iso', 'link' => '/admin/immovables/create', 'order_id' => 1, 'in_menu' => 1, 'in_setting' => 1, 'parent_id' => $permission15811_id]);
        $permission16111_id = DB::table('permissions')->insertGetId(['name' => 'edit immovables', 'guard_name' => 'web', 'title' => 'تعديل عقار', 'icon' => 'equalizer', 'link' => '/admin/immovables/edit', 'order_id' => 1, 'in_menu' => 0, 'in_setting' => 1, 'parent_id' => $permission15811_id]);
        $permission16211_id = DB::table('permissions')->insertGetId(['name' => 'delete immovables', 'guard_name' => 'web', 'title' => 'حذف عقار', 'icon' => 'equalizer', 'link' => '/admin/immovables/delete', 'order_id' => 1, 'in_menu' => 0, 'in_setting' => 1, 'parent_id' => $permission15811_id]);


        $user = \App\User::where('email', 'admin@gmail.com')->first();
        if ($user)
            $user_id = $user->id;
        else
            //create users
            $user_id = DB::table('users')->insertGetId([
                'full_name' => 'الادمن',
                'first_name' => 'admin',
                'user_name' => 'admin',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('12345678'),
            ]);

        for ($i = 1; $i <= 217; $i++) {
            $x = 'permission' . $i . '_id';
            \App\User::find($user_id)->syncPermissions($permission1_id);
        }

        \App\User::find($user_id)->syncPermissions([
            $permission1_id,
            $permission2_id,
            $permission3_id,
            $permission4_id,
            $permission5_id,
            $permission6_id,
            $permission7_id,
            $permission8_id,
            $permission9_id,
            $permission10_id,
            $permission11_id,
            $permission12_id,
            $permission13_id,
            $permission14_id,
            $permission15_id,
            $permission16_id,
            $permission7716_id,
            $permission17_id,
            $permission18_id,
            $permission19_id,
            $permission20_id,
            $permission21_id,
            $permission22_id,
            $permission23_id,
            $permission24_id,
            $permission25_id,
            $permission26_id,
            $permission27_id,
            $permission28_id,
            $permission29_id,
            $permission30_id,
            $permission31_id,
            $permission32_id,
            $permission33_id,
            $permission34_id,
            $permission35_id,
            $permission36_id,
            $permission37_id,
            $permission38_id,
            $permission39_id,
            $permission40_id,
            $permission41_id,
            $permission42_id,
            $permission43_id,
            $permission45_id,
            $permission46_id,
            $permission47_id,
            $permission48_id,
            $permission49_id,
            $permission50_id,
            $permission51_id,
            $permission52_id,
            $permission53_id,
            $permission54_id,
            $permission55_id,
            $permission56_id,
            $permission57_id,
            $permission58_id,
            $permission59_id,
            $permission60_id,
            $permission61_id,
            $permission62_id,
            $permission63_id,
            $permission64_id,
            $permission65_id,
//            $permission66_id,
            $permission67_id,
            $permission68_id,
            $permission69_id,
            $permission70_id,
            $permission71_id,
            $permission72_id,
            $permission73_id,
            $permission74_id,
            $permission75_id,
            $permission76_id,
            $permission77_id,
            $permission78_id,
            $permission79_id,
            $permission80_id,
            $permission81_id,
            $permission82_id,
            $permission83_id,
            $permission84_id,
            $permission85_id,
            $permission86_id,
            $permission87_id,
            $permission88_id,
            $permission89_id,
            $permission90_id,
            $permission91_id,
            $permission92_id,
            $permission93_id,
            $permission94_id,
            $permission95_id,
            $permission96_id,
            $permission97_id,
            $permission98_id,
            $permission99_id,
            $permission100_id,
            $permission101_id,
            $permission102_id,
            $permission103_id,
            $permission104_id,
            $permission105_id,
            $permission106_id,
            $permission107_id,
            $permission108_id,
            $permission109_id,
            $permission110_id,
            $permission111_id,
            $permission112_id,
            $permission113_id,
            $permission114_id,
            $permission115_id,
            $permission116_id,
            $permission117_id,
            $permission118_id,
            $permission119_id,
            $permission120_id,
            $permission121_id,
            $permission122_id,
            $permission123_id,
            $permission124_id,
            $permission125_id,
            $permission126_id,
            $permission127_id,
            $permission128_id,
            $permission129_id,
            $permission130_id,
            $permission131_id,
            $permission132_id,
            $permission133_id,
            $permission134_id,
            $permission135_id,
            $permission136_id,
            $permission137_id,
            $permission138_id,
            $permission139_id,
            $permission140_id,
            $permission141_id,
            $permission142_id,
            $permission143_id,
            $permission144_id,
            $permission145_id,
            $permission146_id,
            $permission147_id,
            $permission148_id,
            $permission149_id,
            $permission150_id,
            $permission151_id,
            $permission152_id,
            $permission153_id,
            $permission154_id,
            $permission155_id,
            $permission156_id,
            $permission157_id,
            $permission158_id,
            $permission159_id,
            $permission160_id,
            $permission161_id,
            $permission162_id,
            $permission163_id,
            $permission164_id,
            $permission165_id,
            $permission166_id,
            $permission167_id,
            $permission168_id,
            $permission169_id,
            $permission170_id,
            $permission171_id,
            $permission172_id,
            $permission173_id,
            $permission174_id,
            $permission175_id,
            $permission176_id,
            $permission177_id,
            $permission178_id,
            $permission179_id,
            $permission180_id,
            $permission181_id,
            $permission182_id,
            $permission183_id,
            $permission184_id,
            $permission185_id,
            $permission186_id,
            $permission187_id,
            $permission188_id,
            $permission189_id,
            $permission190_id,
            $permission191_id,
            $permission192_id,
            $permission193_id,
            $permission194_id,
            $permission195_id,
            $permission196_id,
            $permission197_id,
            $permission198_id,
            $permission199_id,
            $permission200_id,
            $permission201_id,
            $permission202_id,
            $permission203_id,
            $permission204_id,
            $permission205_id,
            $permission206_id,
            $permission207_id,
            $permission208_id,
            $permission209_id,
            $permission210_id,
            $permission211_id,
            $permission212_id,
            $permission213_id,
            /*$permission214_id,
            $permission215_id,
            $permission216_id,
            $permission217_id,
            $permission218_id,*/
            $permission269_id,
            $permission270_id,
            $permission271_id,
            $permission272_id,
            $permission273_id,
            $permission369_id,
            $permission370_id,
            $permission371_id,
            $permission372_id,
            $permission373_id,
            $permission5569_id,
            $permission55270_id,
            $permission55271_id,
            $permission55272_id,
            $permission55273_id,
            $permission15569_id,
            $permission155270_id,
            $permission155271_id,
            $permission155272_id,
            $permission155273_id,
            $permission25569_id,
            $permission255270_id,
            $permission255271_id,
            $permission255272_id,
            $permission255273_id,
            $permission35569_id,
            $permission355270_id,
            $permission355271_id,
            $permission355272_id,
            $permission355273_id,
            $permission45569_id,
            $permission455270_id,
            $permission455271_id,
            $permission455272_id,
            $permission455273_id,
            $permission55569_id,
            $permission555270_id,
            $permission555271_id,
            $permission555272_id,
            $permission555273_id,
            $permission2021_id,
            $permission55189_id,
            $permission55190_id,
            $permission55191_id,
            $permission55192_id,
            $permission55193_id,
            $permission655569_id,
            $permission6555270_id,
            $permission6555271_id,
            $permission6555272_id,
            $permission6555273_id,
            $permission1169_id,
            $permission1174_id,
            $permission1148_id,
            $permission255695_id,
            $permission2552705_id,
            $permission2552715_id,
            $permission2552725_id,
            $permission2552735_id,
            $permission15811_id,
            $permission15911_id,
            $permission16011_id,
            $permission16111_id,
            $permission16211_id,
        ]);

    }
}