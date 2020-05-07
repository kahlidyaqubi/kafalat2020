<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('/divisin', 'Admin\HomeController@divisin');
Route::post('/divisin', 'Admin\HomeController@divisin_post');


Route::get('/action', 'Admin\HomeController@action');

//Route::get('/orderd10', 'Admin\FamilyController@orderd10');

//Route::get('/orderd6', 'Admin\FamilyController@orderd6');

//Route::get('/orderd5', 'Admin\FamilyController@orderd5');

//Route::get('/orderd4', 'Admin\FamilyController@orderd4');

//Route::get('/orderd3', 'Admin\FamilyController@orderd3');

//Route::get('/orderd2', 'Admin\FamilyController@orderd2');

//Route::get('/orderd', 'Admin\FamilyController@orderd');

Route::get('test', function () {
    $expense_details = \App\ExpenseDetail::where('delivery', 1)->take(2)->get();
    
    $pdf = \niklasravnsborg\LaravelPdf\Facades\Pdf::loadView('admin.expense_detail.print_card', compact('expense_details'));
  // return view('admin.expense_detail.print_card',compact('expense_details'));
    
    return $pdf->stream("expense_details.pdf");
});

//Route::get('/test', function () {
//    //Config::set('excel.import.heading','original');
//    dd(Config::get('excel.import.heading'));
//    //dd('test');
//    $expense_details = \App\ExpenseDetail::all();
//
//    $thetype = 'normal';
//    $theaction = 'print';
//    return view('admin.expense.print_all', compact('expense_details', 'theaction', 'thetype'));
//});

Route::get('/', 'Auth\LoginController@showLoginForm');
Route::get('/logout', 'Auth\LoginController@logout');

Route::get('/configClear', function () {
    \Illuminate\Support\Facades\Artisan::call('config:clear');
    \Illuminate\Support\Facades\Artisan::call('view:clear');
    return redirect('/');
});

Route::get('/cacheClear', function () {
    \Illuminate\Support\Facades\Artisan::call('cache:clear');
    return redirect('/');
});
 Route::get('/updatePassword', 'Admin\HomeController@editPassword');
  Route::post('/updatePassword', 'Admin\HomeController@updatePassword');

Route::get('/admin/families/families_ajax', 'Admin\FamilyController@families_ajax');
Route::get('/admin/families/families_ajax_id', 'Admin\FamilyController@families_ajax_id');
Route::get('/admin/families/person_ajax_id', 'Admin\FamilyController@person_ajax_id');

Route::get('/admin/expenses/families_in_expense_ajax/{id}', 'Admin\ExpenseController@families_in_expense_ajax');
Route::get('/admin/users/users_ajax', 'Admin\UserController@users_ajax');
Route::get('/admin/sponsors/sponsors_ajax', 'Admin\SponsorController@sponsors_ajax');
Route::get('/admin/sponsors/sponsors_ajax_id', 'Admin\SponsorController@sponsors_ajax_id');
// governorate
Route::get('/admin/governorates/cities/{id}', 'Admin\GovernorateController@cities');
Route::get('/admin/cities/neighborhoods/{id}', 'Admin\CityController@neighborhoods');
Route::get('/admin/item_categories/item_types_ajaxs/{id}', 'Admin\ItemCategoryController@item_types_ajaxs');
Route::get('/admin/projects/season_ajax/{id}', 'Admin\ProjectController@season_ajax');

Route::namespace('Admin')->prefix('admin')
    ->middleware(['auth', 'checkPermission', 'eastern-to-arabic'])
    ->group(function () {

        Route::get('/download/{file}', function ($file = '') {
            return response()->download(public_path('back_up/Laravel/') . $file);
        });
        Route::get('/delete/{file}', function ($file = '') {
            unlink(public_path('back_up/Laravel/') . $file);
            return back()->with('success', 'تم حذف نسخة احتياطية بنجاح');
        });

        Route::get('noAccess', 'HomeController@noAccess');

        Route::get('home', 'HomeController@index')->name('home');
        Route::get('search', 'HomeController@search')->name('search');

        // backup
        Route::resource('dbBackups', 'DBBackupController')->only(['index']);

        Route::get('back_up', 'DBBackupController@back_up')->name('back_up');

        // country
        Route::resource('countries', 'CountryController')->except(['destroy', 'show']);
        Route::get('countries/delete/{id}', 'CountryController@delete');

        // familyStatuses
        Route::resource('familyStatuses', 'FamilyStatusController')->except(['destroy', 'show']);
        Route::get('familyStatuses/delete/{id}', 'FamilyStatusController@delete');

        // furnitureTypes
        Route::resource('furnitureStatuses', 'FurnitureStatusController')->except(['destroy', 'show']);
        Route::get('furnitureStatuses/delete/{id}', 'FurnitureStatusController@delete');

        // familyTypes
        Route::resource('familyTypes', 'FamilyTypeController')->except(['destroy', 'show']);
        Route::get('familyTypes/delete/{id}', 'FamilyTypeController@delete');

        // idTypes
        Route::resource('idTypes', 'IDTypeController')->except(['destroy', 'show']);
        Route::get('idTypes/delete/{id}', 'IDTypeController@delete');

        // city
        Route::resource('cities', 'CityController')->except(['destroy', 'show']);
        Route::get('cities/delete/{id}', 'CityController@delete');


        // neighborhood
        Route::resource('neighborhoods', 'NeighborhoodController')->except(['destroy', 'show']);
        Route::get('neighborhoods/delete/{id}', 'NeighborhoodController@delete');
        Route::get('neighborhoods/approve/{id}', 'NeighborhoodController@approve');

        // diseases
        Route::resource('diseases', 'DiseaseController')->except(['destroy', 'show']);
        Route::get('diseases/delete/{id}', 'DiseaseController@delete');

        // house
        Route::resource('houseOwnerships', 'HouseOwnershipController')->except(['destroy', 'show']);
        Route::get('houseOwnerships/delete/{id}', 'HouseOwnershipController@delete');

        Route::resource('houseRoofs', 'HouseRoofController')->except(['destroy', 'show']);
        Route::get('houseRoofs/delete/{id}', 'HouseRoofController@delete');

        Route::resource('houseStatuses', 'HouseStatusController')->except(['destroy', 'show']);
        Route::get('houseStatuses/delete/{id}', 'HouseStatusController@delete');

        // income type
        Route::resource('incomeTypes', 'IncomeTypeController')->except(['destroy', 'show']);
        Route::get('incomeTypes/delete/{id}', 'IncomeTypeController@delete');

        // job type
        Route::resource('jobTypes', 'JobTypeController')->except(['destroy', 'show']);
        Route::get('jobTypes/delete/{id}', 'JobTypeController@delete');

        // file type
        Route::resource('fileTypes', 'FileTypeController')->except(['destroy', 'show']);
        Route::get('fileTypes/approve/{id}', 'FileTypeController@approve');
        Route::get('fileTypes/delete/{id}', 'FileTypeController@delete');

        // funded institution
        Route::resource('fundedInstitutions', 'FundedInstitutionController')->except(['destroy', 'show']);
        Route::get('fundedInstitutions/approve/{id}', 'FundedInstitutionController@approve');
        Route::get('fundedInstitutions/delete/{id}', 'FundedInstitutionController@delete');

        // beneficiary institution
        /* Route::resource('beneficiaryInstitutions', 'BeneficiaryInstitutionController')->except(['destroy', 'show']);
         Route::get('beneficiaryInstitutions/delete/{id}', 'BeneficiaryInstitutionController@delete');
 */
        // university specialty
        Route::resource('universitySpecialties', 'UniversitySpecialtyController')->except(['destroy', 'show']);
        Route::get('universitySpecialties/approve/{id}', 'UniversitySpecialtyController@approve');
        Route::get('universitySpecialties/delete/{id}', 'UniversitySpecialtyController@delete');

        // visit reason
        Route::resource('visitReasons', 'VisitReasonController')->except(['destroy', 'show']);
        Route::get('visitReasons/approve/{id}', 'VisitReasonController@approve');
        Route::get('visitReasons/delete/{id}', 'VisitReasonController@delete');

        // relation
        Route::resource('relationships', 'RelationshipController')->except(['destroy', 'show']);
        Route::get('relationships/approve/{id}', 'RelationshipController@approve');
        Route::get('relationships/delete/{id}', 'RelationshipController@delete');

        // immovables
        Route::resource('immovables', 'ImmovableController')->except(['destroy', 'show']);
        Route::get('immovables/approve/{id}', 'ImmovableController@approve');
        Route::get('immovables/delete/{id}', 'ImmovableController@delete');


        // educational institution
        Route::resource('educationalInstitutions', 'EducationalInstitutionController')->except(['destroy', 'show']);
        Route::get('educationalInstitutions/approve/{id}', 'EducationalInstitutionController@approve');
        Route::get('educationalInstitutions/delete/{id}', 'EducationalInstitutionController@delete');

        // qualifications
        Route::resource('qualifications', 'QualificationController')->except(['destroy', 'show']);
        Route::get('qualifications/delete/{id}', 'QualificationController@delete');

        // socialStatuses
        Route::resource('socialStatuses', 'SocialStatusController')->except(['destroy', 'show']);
        Route::get('socialStatuses/delete/{id}', 'SocialStatusController@delete');

        // qualificationLevels
        Route::resource('qualificationLevels', 'QualificationLevelController')->except(['destroy', 'show']);
        Route::get('qualificationLevels/delete/{id}', 'QualificationLevelController@delete');

        // studyType
        Route::resource('studyTypes', 'StudyTypeController')->except(['destroy', 'show']);
        Route::get('studyTypes/delete/{id}', 'StudyTypeController@delete');

        // studyPart
        Route::resource('studyParts', 'StudyPartController')->except(['destroy', 'show']);
        Route::get('studyParts/delete/{id}', 'StudyPartController@delete');

        // studyLevel
        Route::resource('studyLevels', 'StudyLevelController')->except(['destroy', 'show']);
        Route::get('studyLevels/delete/{id}', 'StudyLevelController@delete');

        // translation
        Route::resource('nameTranslations', 'NameTranslationController')->except(['destroy', 'show']);
        Route::get('nameTranslations/import/names', 'NameTranslationController@getImportNames');
        Route::post('nameTranslations/import/names', 'NameTranslationController@importNames');
        Route::get('nameTranslations/delete/{id}', 'NameTranslationController@delete');
        Route::get('nameTranslations/export/translationsFile', 'NameTranslationController@exportTranslationsFile');


        // user routes

        Route::get('users/print_group', 'UserController@print_group');
        Route::get('users/delete_group', 'UserController@delete_group');
        Route::get('users/index_data', 'UserController@index_data')->name('datatables.users');;
        Route::resource('users', 'UserController');
        Route::get('users/delete/{id}', 'UserController@delete');
        Route::get('users/permission/{id}', 'UserController@permission');
        Route::get('users/getLog/{id}', 'UserController@getLog');
        Route::get('users/getLogs/{id}', 'UserController@getLogs');
        Route::post('users/permission/{id}', 'UserController@updatePermission');
        Route::get('users/suspend/{id}', 'UserController@suspend');
        Route::get('users/family_log/{id}', 'UserController@familyLog');
        Route::get('users/family_log_data/{id}', 'UserController@familyLogData');
        Route::get('users/tasks/{id}', 'UserController@tasks');
        Route::get('users/his_tasks/{id}', 'UserController@his_tasks');

        //
        Route::get('/notifications/get', 'NotificationController@get');
        Route::get('/notifications', 'NotificationController@index');
        Route::get('/notifications/delete/{id}', 'NotificationController@delete');
        Route::get('/getnotfiy/{id}', 'NotificationController@read');

        // departments routes
        Route::resource('departments', 'DepartmentController')->except(['destroy']);
        Route::get('departments/delete/{id}', 'DepartmentController@delete');
        Route::get('departments/approve/{id}', 'DepartmentController@approve');

        // tasks routes
        Route::resource('tasks', 'TaskController')->except(['destroy']);
        Route::get('tasks/delete/{id}', 'TaskController@delete');
        Route::get('tasks/done/{id}', 'TaskController@done');
        Route::get('tasks/full_done/{id}', 'TaskController@full_done');


        // expenses routes
        Route::get('expenses', 'ExpenseController@index');
        Route::get('expenses/getExpenses', 'ExpenseController@getExpenses');
        Route::get('expenses/delete/{id}', 'ExpenseController@delete');
        Route::get('expenses/importExcel', 'ExpenseController@importExcel');
        Route::get('expenses/importIgnoreFile', 'ExpenseController@importIgnoreFile');
        Route::post('expenses/importIgnoreFile', 'ExpenseController@store_importIgnoreFile');
        Route::post('expenses/importExcel', 'ExpenseController@storeImportExcel');
        Route::get('expenses/ImportExcel_2/{recive_date}/{family_project_id}/{year}/{excel_file_name}/{mounth_count}/{old_name}/{the_months?}', 'ExpenseController@continue');
        Route::get('expenses/continue', 'ExpenseController@continueByGet');
        Route::get('expenses/ImportExcel_month', 'ExpenseController@ImportExcel_month');
        Route::post('expenses/ImportExcel_2', 'ExpenseController@storeImportExcel_2');
        Route::get('expenses/invalidators', 'ExpenseController@invalidators');
        Route::post('expenses/invalidators', 'ExpenseController@store_invalidators');
        Route::post('expenses/exportIgnoreFile', 'ExpenseController@exportIgnoreFile');
        Route::get('expenses/details/{id}', 'ExpenseController@details');
        Route::get('expenses/all_details', 'ExpenseController@all_details');
        Route::get('expenses/sendSMS', 'ExpenseController@sendSMS');
        Route::get('expenses/delivery/{id}', 'ExpenseController@delivery');
        Route::get('expenses/show/{id}', 'ExpenseController@show');
        Route::get('expenses/showF', 'ExpenseController@showF');


        // expenseDetails routes
        Route::get('expenseDetails/sendSMS', 'ExpenseDetailController@sendSMS');
        Route::get('expenseDetails/delivery', 'ExpenseDetailController@delivery');
        Route::get('expenseDetails', 'ExpenseDetailController@index');
        Route::get('expenseDetails/delete/{id}', 'ExpenseDetailController@delete');
        Route::get('expenseDetails/sponsor/{id}', 'ExpenseDetailController@sponsor');

        // expensePrices routes
        Route::get('expense_prices/delete_group', 'ExpensePriceController@delete_group');
        Route::get('expense_prices/data', 'ExpensePriceController@index_data')->name('datatables.expense_prices');
        Route::resource('expense_prices', 'ExpensePriceController')->except(['destroy']);
        Route::get('expense_prices/delete/{id}', 'ExpensePriceController@delete');

        // expenseAmounts routes
        Route::get('expense_amounts/delete_group', 'ExpenseAmountController@delete_group');
        Route::resource('expense_amounts', 'ExpenseAmountController')->except(['destroy']);
        Route::get('expense_amounts/delete/{id}', 'ExpenseAmountController@delete');

        // sponsor
        //ajax

        Route::get('sponsors/delete_group', 'SponsorController@delete_group');
        Route::resource('sponsors', 'SponsorController')->except(['destroy']);
        Route::get('sponsors/front/update', 'SponsorController@updateF');
        Route::get('sponsors/delete/{id}', 'SponsorController@delete');
        Route::get('sponsors/expenseLog/{id}', 'SponsorController@expenseLog');
        Route::get('sponsors/callLog/{id}', 'SponsorController@callLog');
        Route::get('sponsors/family_log/{id}', 'SponsorController@familyLog');
        Route::post('sponsors/family_log_data/{id}', 'SponsorController@familyLogData');
        Route::get('sponsors/checkStatus/{id}', 'SponsorController@checkStatus');

        // profile routes
        Route::get('profile/show', 'ProfileController@show');
        Route::get('profile/edit', 'ProfileController@edit');
        Route::post('profile/update', 'ProfileController@update');
        Route::post('profile/addMedia', 'ProfileController@addMedia');
        Route::get('profile/removeMedia/{id}', 'ProfileController@removeMedia');
        Route::get('profile/editPassword', 'ProfileController@editPassword');
        Route::post('profile/updatePassword', 'ProfileController@updatePassword');
        Route::get('profile/log', 'ProfileController@log');
        Route::get('profile/getLogs', 'ProfileController@getLog');
        Route::get('profile/tasks', 'ProfileController@tasks');

        // setting
        Route::resource('settings', 'SettingController')->only(['index']);
        Route::get('settings/logo_backgrounds/{color}', 'SettingController@logo_backgrounds');
        Route::get('settings/navbar_backgrounds/{color}', 'SettingController@navbar_backgrounds');
        Route::get('settings/sidebar_backgrounds/{color}', 'SettingController@sidebar_backgrounds');
        Route::PATCH('settings/update', 'SettingController@update');
        Route::PATCH('settings/updateWelcome', 'SettingController@updateWelcome');

        Route::get('all_settings/', 'SettingController@all_settings');
        // log
        Route::resource('logs', 'LogController')->only('index');
        Route::get('logs/getLogs', 'LogController@getLogs');


        // Family
        //ajax
        Route::get('families/sendSMS', 'FamilyController@sendSMS');
        Route::post('families/exportFamilies', 'FamilyController@exportFamilies');
        Route::resource('families', 'FamilyController')->except(['destroy']);
        // log
        Route::get('families/{id}/showArchive', 'FamilyController@showArchive');
        Route::get('families/archive/{id}', 'FamilyController@archive');
//marge
Route::get('families/{id}/marge', 'FamilyController@marge');
        Route::post('families/{id}/marge', 'FamilyController@marge_post');


        // media
        Route::get('families/removeMedia/{id}', 'FamilyController@removeMedia');
        Route::get('families/{id}/addMedia', 'FamilyController@addMedia');
        Route::post('families/addNewMedia/{id}', 'FamilyController@addNewMedia');
        //Route::get('families/media/visitMedia/import', 'FamilyController@visitMedia2');
        //Route::get('families/media/visitMedia2/import', 'FamilyController@visitMedia2');
        //member
        Route::get('families/addMember/{id}', 'FamilyController@addMember');
        Route::post('families/addWives/{id}', 'FamilyController@addWives');
        Route::post('families/addNewMember/{id}', 'FamilyController@addNewMember');
        Route::post('families/editNewMember/{id}/{family_id}', 'FamilyController@editNewMember');
        Route::get('families/search/idNumber', 'FamilyController@searchIdNumber');
        Route::post('families/addSingleMember/{personId}/{familyId}', 'FamilyController@addSingleMember');
        Route::post('families/removeMember/{id}', 'FamilyController@removeMember');

        Route::get('families/add/getTranslation', 'FamilyController@getTranslation');
        Route::post('families/approve/{id}', 'FamilyController@approve');
        Route::post('families/addNewIncomeType/{personId}/{familyId}', 'FamilyController@addSingleMember');
        Route::post('families/details/getFamilies', 'FamilyController@getFamilies');
        Route::get('families/delete/{id}', 'FamilyController@delete');
        Route::get('families/delete_visit/{id}', 'FamilyController@delete_visit');
        
        //Route::get('families/visit/{id}', 'FamilyController@visit');
        Route::get('families/coupon/{id}', 'FamilyController@coupon');
        Route::get('families/expense/{id}', 'FamilyController@expense');
        Route::get('families/call/{id}', 'FamilyController@call');
        Route::get('families/sponsor/{id}', 'FamilyController@sponsor');
        Route::get('families/ignoreReason/{id}', 'FamilyController@ignoreReason');
        Route::get('families/is_complete/{id}', 'FamilyController@is_complete');
        Route::get('families/is_translate/{id}', 'FamilyController@is_translate');
        Route::post('families/removeIncome/{id}', 'FamilyController@removeIncome');

        // import
        Route::post('families/import/searcherNoteTurkey', 'FamilyController@searcherNoteTurkey');
        Route::post('families/import/representative', 'FamilyController@representative');
        Route::post('families/import/hiddenVisit', 'FamilyController@importHiddenVisit');
        Route::post('families/import/visit', 'FamilyController@importVisit');
        Route::post('families/import/oldVisit', 'FamilyController@importOldVisit');
        Route::get('families/import/visit', 'FamilyController@getImportVisit');
        Route::post('families/import/ytmFile', 'FamilyController@importYTMFile');
        Route::post('families/import/ytmOld', 'FamilyController@importOldYTM');
        Route::get('families/import/ytm', 'FamilyController@getImportYTM');

        // download template
        Route::get('families/visit/template/download', 'FamilyController@visitTemplateDownload');
        Route::get('families/ytm/template/download', 'FamilyController@YTMTemplateDownload');

        // export pdf
        Route::get('families/export/pdf/visit', 'FamilyController@exportAllTurkeyVisit');
        Route::get('families/export/pdf/ytm', 'FamilyController@exportAllTurkeyYTM');
        Route::get('families/export/pdf/visit/{id}', 'FamilyController@exportItemTurkeyVisit');
        Route::get('families/export/pdf/ytm/{id}', 'FamilyController@exportItemTurkeyYTM');

        // export word
        Route::get('families/export/word/visit/{id}', 'FamilyController@exportItemWordTurkeyVisit');
        Route::get('families/export/word/ytm/{id}', 'FamilyController@exportItemWordTurkeyYTM');

        // export excel
        Route::post('families/exportFamilies', 'FamilyController@exportFamilies');
        Route::get('families/export/excel/ytm/{id}', 'FamilyController@exportItemExcelYTM');
        Route::get('families/export/excel/visit/{id}', 'FamilyController@exportItemExcelVisit');
        Route::get('families/export/excel/visit', 'FamilyController@exportAllExcelVisit');
        Route::get('families/export/excel/ytm', 'FamilyController@exportAllExcelYTM');

        // call
        Route::resource('calls', 'CallController')->except(['destroy']);
        Route::get('calls/front/update', 'CallController@updateF');
        Route::get('calls/delete/{id}', 'CallController@delete');


        // LicenseController
        Route::resource('licensors', 'LicensorController')->except(['destroy']);
        Route::get('licensors/delete/{id}', 'LicensorController@delete');
        Route::get('licensors/institutions/{id}', 'LicensorController@institutions');
        Route::get('licensors/approve/{id}', 'LicensorController@approve');

        // projects
        Route::resource('projects', 'ProjectController')->except(['destroy']);
        Route::get('projects/delete/{id}', 'ProjectController@delete');
        Route::get('projects/seasons/{id}', 'ProjectController@seasons');
        Route::get('projects/season_coupons/{id}', 'ProjectController@season_coupons');

        // institutions
        Route::resource('institutions', 'InstitutionController')->except(['destroy']);
        Route::get('institutions/delete/{id}', 'InstitutionController@delete');
        Route::get('institutions/urgent_coupons/{id}', 'InstitutionController@urgent_coupons');
        Route::get('institutions/season_coupons/{id}', 'InstitutionController@season_coupons');
        Route::get('institutions/removeMedia/{id}', 'InstitutionController@removeMedia');

        // urgent coupon

        Route::get('urgent_coupons/sendSMS', 'UrgentCouponController@sendSMS');
        Route::get('urgent_coupons/approve', 'UrgentCouponController@approve');
        Route::get('urgent_coupons/delivery', 'UrgentCouponController@delivery');
        Route::get('urgent_coupons/removeMedia/{id}', 'UrgentCouponController@removeMedia');
        Route::get('urgent_coupons/import_urgent_coupon', 'UrgentCouponController@import_urgent_coupon');
        Route::post('urgent_coupons/import_urgent_coupon', 'UrgentCouponController@store_import_urgent_coupon');
        Route::get('urgent_coupons/import_urgent_coupon_extra', 'UrgentCouponController@import_urgent_coupon_extra');
        Route::post('urgent_coupons/import_urgent_coupon_extra', 'UrgentCouponController@store_import_urgent_coupon_extra');
        Route::get('urgent_coupons/searctoaddcoupon', 'UrgentCouponController@searctoaddcoupon');
        Route::get('urgent_coupons/editorcreat', 'UrgentCouponController@editorcreat');
        Route::resource('urgent_coupons', 'UrgentCouponController')->except(['destroy']);
        Route::get('urgent_coupons/delete/{id}', 'UrgentCouponController@delete');

        // Season Coupon
        Route::get('season_coupons/sendSMS', 'SeasonCouponController@sendSMS');

        Route::get('season_coupons/removeMedia/{id}', 'SeasonCouponController@removeMedia');
        Route::get('season_coupons/approve', 'SeasonCouponController@approve');
        Route::get('season_coupons/delivery', 'SeasonCouponController@delivery');
        // Route::get('season_coupons/import_season_coupon', 'SeasonCouponController@import_season_coupon');
        // Route::post('season_coupons/import_season_coupon', 'SeasonCouponController@store_import_season_coupon');
        Route::get('season_coupons/searctoaddcoupon', 'SeasonCouponController@searctoaddcoupon');
        Route::get('season_coupons/editorcreat', 'SeasonCouponController@editorcreate');
        Route::resource('season_coupons', 'SeasonCouponController')->except(['destroy']);
        Route::get('season_coupons/delete/{id}', 'SeasonCouponController@delete');
        Route::get('season_coupons/add_pesrons/{id}', 'SeasonCouponController@add_pesrons');
        Route::post('season_coupons/add_pesrons/{id}', 'SeasonCouponController@add_pesrons_post');
        Route::get('season_coupons/show_pesrons/{id}', 'SeasonCouponController@show_pesrons');

// season_coupon_families
        Route::get('season_coupon_families/searctoaddcoupon/{type}', 'SeasonCouponFamilyController@searctoaddcoupon');
        Route::get('season_coupon_families/editorcreat', 'SeasonCouponFamilyController@editorcreate');
        Route::resource('season_coupon_families', 'SeasonCouponFamilyController')->except(['destroy']);
        Route::get('season_coupon_families/delete/{id}', 'SeasonCouponFamilyController@delete');
        Route::get('season_coupon_families/delivery/{id}', 'SeasonCouponFamilyController@delivery');

        // Seasons
        Route::resource('seasons', 'SeasonController')->except(['destroy']);
        Route::get('seasons/delete/{id}', 'SeasonController@delete');
        Route::get('seasons/season_coupons/{id}', 'SeasonController@season_coupons');


        // coupon_reasons
        Route::resource('coupon_reasons', 'CouponReasonController')->except(['destroy']);
        Route::get('coupon_reasons/delete/{id}', 'CouponReasonController@delete');
        Route::get('coupon_reasons/approve/{id}', 'CouponReasonController@approve');

        //institution_type
        Route::resource('institution_types', 'InstitutionTypeController')->except(['destroy']);
        Route::get('institution_types/delete/{id}', 'InstitutionTypeController@delete');
        Route::get('institution_types/approve/{id}', 'InstitutionTypeController@approve');

        // TargetType
        Route::resource('target_types', 'TargetTypeController')->except(['destroy']);
        Route::get('target_types/delete/{id}', 'TargetTypeController@delete');
        Route::get('target_types/approve/{id}', 'TargetTypeController@approve');
        Route::get('target_types/institutions/{id}', 'TargetTypeController@institutions');

        // ItemType
        Route::resource('item_types', 'ItemTypeController')->except(['destroy']);
        Route::get('item_types/delete/{id}', 'ItemTypeController@delete');
        Route::get('item_types/approve/{id}', 'ItemTypeController@approve');

        // ItemCategories
        Route::resource('item_categories', 'ItemCategoryController')->except(['destroy']);
        Route::get('item_categories/delete/{id}', 'ItemCategoryController@delete');
        Route::get('item_categories/approve/{id}', 'ItemCategoryController@approve');
        Route::get('item_categories/item_types/{id}', 'ItemCategoryController@item_types');

    });
