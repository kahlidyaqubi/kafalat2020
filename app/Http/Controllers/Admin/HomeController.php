<?php

namespace App\Http\Controllers\Admin;

use App\Call;
use App\ExpenseDetail;
use App\Family;
use App\FamilyProject;
use App\FundedInstitution;
use App\Http\Controllers\Controller;
use App\SeasonCoupon;
use App\Sponsor;
use App\UrgentCoupon;
use App\User;
use Browser;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests\ResetPassRequest;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Permission\Models\Permission;
use App\Events\NewLogCreated;
use Illuminate\Support\Facades\Hash;
use App\Events\SmsEvent;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['divisin', 'divisin_post','updatePassword','editPassword']);
    }
    
     function cron_all()
    {
        set_time_limit(0);
        Session()->put('myreq', 5);
         Session()->put('id', 6);
     \Illuminate\Support\Facades\Artisan::call('schedule:run');
   // \Illuminate\Support\Facades\Artisan::call('queue:work --tries=3');
    dd('done');
    }
    
     function editPassword()
    {
        return view('auth.passwords.editPassword');
    }
    
    function updatePassword(ResetPassRequest $request)
    {
       $users = User::where('mobile_one','like','%'.$request['mobile'].'%')
        ->orWhere('mobile_two','like','%'.$request['mobile'].'%');

        if ($users->count() > 1 || !($users->first())) {
            return back()->with('error', 'لم يتم العثور على المستخدم')->withInput();  }
        $user = $users->first();

        $newPassword_1=rand();
        $massage = "كلمة المرور الجديدة $newPassword_1";
        
        $newPassword = Hash::make($newPassword_1);

if (!($user->mobile_one) && !($user->mobile_two)) {
                   
            return back()->with('error', 'لم يتم العثور على المستخدم')->withInput();
                } else {
                    $mobile = ($user->mobile_one) && $user->mobile_one>0 ?$user->mobile_one: $user->mobile_two;
                    ltrim($mobile, "0");
                    if (!(strpos($mobile, '+970') !== false)) {
                        $mobile = '+970' . $mobile;
                    }

                    if (strlen($mobile) != 13) {
            return back()->with('error', 'رقم التواصل غير صحيح')->withInput();
                    } else {
                        event(new SmsEvent($massage, $mobile));

                    }
                }

        if ($user->update(['password' => $newPassword])) {
           
            return back()->with('success', 'تم تغيير كلمة المرور بنجاح');
        } else {
            return back()->with('error', 'لم يتم تغيير كلمة المرور بنجاح');
        }
    }

    public function index()
    {

        if (auth()->user()->getAllPermissions()->count() == 0) {
            return redirect('/admin/noAccess');
        }

        $ytem_count = Family::whereNull('parent_id')->whereNotNull('person_id')->where('family_project_id', 2)->count();
        $families_count = Family::whereNull('parent_id')->whereNotNull('person_id')->where('family_project_id', 1)->count();
        $season_coupons_count = SeasonCoupon::all()->count();
        $urgent_coupons_count = UrgentCoupon::all()->count();
        $users_count = User::all()->count();
        $calls_count = Call::all()->count();
        $expense_details_count = ExpenseDetail::all()->count();
        $sponsors_count = Sponsor::all()->count();

        $expense_details = FundedInstitution::select('name')->withcount('expense_details')->get();
        $expense_details_chart = json_encode($expense_details);


        $recipients = FamilyProject::select('name')->
                withCount(['recipients'=> function ($query) {
                     $query->whereNull('parent_id');
                }])->get();
        $recipients_chart = json_encode($recipients);

        return view('admin.home.home', compact('sponsors_count', 'recipients_chart', 'expense_details_chart', 'expense_details_count', 'calls_count', 'users_count', 'urgent_coupons_count', 'season_coupons_count', 'families_count', 'ytem_count'));
    }

    public function noAccess()
    {
        return view('admin.home.noAccess');
    }

    public function search(Request $request)
    {
        $q = $request['q'] ?? "";

        $results = Permission::whereNotNull('link')->where('link', '!=', '')->when($q, function ($query) use ($q) {
            return $query->where('title', 'like', '%' . $q . '%');
        })->orderBy("title")->paginate(20)
            ->appends(["q" => $q,]);


        return view('admin.home.search', compact('results', 'q'));
    }

    public function divisin()
    {
        return view('divisin');
    }

    public function divisin_post(Request $request)
    {
        
        
        
        $testeroor = $this->validate($request, [
            'excel_file' => 'required|mimes:csv,xlsx,xls',
            'part' => 'required',
        ]);
        $excel_file = $request["excel_file"];
        $part = $request["part"];
        $file_name = $filename = pathinfo($excel_file->getClientOriginalName(), PATHINFO_FILENAME);
        $collection = Excel::load($excel_file, 'UTF-8')->get();
        if (gettype($collection->first()->first()) == "double" || gettype($collection->first()->first()) == "string" || gettype($collection->first()->first()) == "integer") {
            $collection = $collection;

        } else {
            $collection = $collection->first();

        }
        if ($collection->count() < ($part * 100 - 100)) {
			request()['part']=1;
            return back()->with('error', "هذا الملف أصغر من أن يقسم إلى $part أقسام ")->withInput(request()->all);;
        }

        $to = ($part * 100);
        $from = ($to - 100);
        //dd($headerRow);
        $to = $collection->count() < $to ? $collection->count() : $to;
        //dd($to);

        $last_collection = Excel::load($excel_file, 'UTF-8')->get();
        if (gettype($last_collection->first()->first()) == "double" || gettype($last_collection->first()->first()) == "string" || gettype($last_collection->first()->first()) == "integer") {
            $last_collection = $last_collection;

        } else {
            $last_collection = $last_collection->first();

        }


        $headerRow = $collection->first()->keys()->toArray();


        $headerRow = array_filter($headerRow, "is_string");

        if (!empty($headerRow[0])) {
            for ($i = 0; $i < count($headerRow); $i++) {

                if (!(trim($headerRow[$i])) && trim($headerRow[$i]) != 0) {
                    break;
                }

                $x = 'index' . $i;

                $$x = "" . trim($headerRow[$i]) . "";
            }
        }else{
            return back()->with('error', 'يجب تنسيق الملف بشكل صحيح')->withInput(request()->all);
        }

        if (!($headerRow)) {
            return back()->with('error', 'يجب تنسيق الملف بشكل صحيح')->withInput(request()->all);
        }
        if ($headerRow[count($headerRow) - 1] == count($headerRow) - 1) {
            unset($headerRow[count($headerRow) - 1]);
        }
        if (count($headerRow) < 4) {
            //error عدد الأعمدة أقل من المتعارف عليه
            return back()->with('error', 'عدد الأعمدة أقل من التنسيق اللازم')->withInput(request()->all);
        }

        if (($index0 == "عائلة الأخوة" || $index0 == "تعليم الأيتام") &&
            ($index1 == "كود المكفول") &&
            ($index2 == "اسم المكفول") &&
            ($index3 == "الكافل")) {

            Excel::create(" $file_name" . "part_" . $part, function ($excel) use ($last_collection, $headerRow, $from, $to) {

                $excel->sheet('file', function ($sheet) use ($last_collection, $headerRow, $from, $to) {
                    $sheet->fromArray($headerRow, NULL, 'A1');
                    //$collection->shift();
                    $myArray = $last_collection->toArray();
                    $j = 2;
                    for ($i = $from; $i < $to; $i++) {
                        $sheet->row($j, $myArray[$i]);
                        $j++;
                    }
                });

            })->download('xlsx');

        } else {
            return back()->with('error', 'تنسيق ملف الإكسل غير صحيح (لا يحتوي اسم المشروع او كود المكفول أو اسم المكفول أو الكافل')->withInput(request()->all);
        }

    }
}
