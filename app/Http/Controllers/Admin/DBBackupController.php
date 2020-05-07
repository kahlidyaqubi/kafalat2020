<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;

class DBBackupController extends Controller
{
    public function index()
    {
        return view('admin.dbBackup.list');
    }
    public function back_up(){
        set_time_limit(0);
        //$backup = Artisan::call("backup:run");
        $backup = Artisan::call("backup:run --only-db");
        //dd($backup);
       // Artisan::call('backup:run  --disable-notifications');
	   //Artisan::call('backup:run');
	   //dd(Artisan::call('backup:run'));
        return back()->with('success','تم  إنشاء نسخة احتياطية بنجاح');
    }
}
