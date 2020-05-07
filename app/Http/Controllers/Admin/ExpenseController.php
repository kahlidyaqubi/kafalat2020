<?php

namespace App\Http\Controllers\Admin;

use App\Action;
use App\Currency;
use App\Events\NewLogCreated;
use App\Expense;
use App\ExpenseAmount;
use App\ExpenseDetail;
use App\ExpenseDetailMonth;
use App\ExpenseDetailSponsor;
use App\ExpensePrice;
use App\Family;
use App\FamilyProject;
use App\FundedInstitution;
use App\Http\Requests\Expense_2Request;
use App\Http\Requests\Expense_invalidatorRequest;
use App\Http\Requests\Expense_monthRequest;
use App\Http\Requests\ExpenseRequest;
use App\Jobs\MyJob;
use App\Month;
use App\Person;
use Illuminate\Support\Facades\Config;
use Notification;
use App\Notifications\NotifyUsers;
use App\Sponsor;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DataTables;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Session;
use DB;
use Psy\Exception\ErrorException;
use Spatie\Permission\Models\Permission;
use niklasravnsborg\LaravelPdf\Facades\Pdf;


class ExpenseController extends Controller
{

    public function __construct()
    {
        Config::set('excel.import.heading', 'original');
    }

    public function index(Request $request)
    {
        $q = $request["q"] ?? "";
        $family_project_id = $request["family_project_id"] ?? "";
        $min_id = Expense::first()->id ?? 1;
        $max_id = Expense::orderByDesc('id')->first()->id ?? 1;
        $from_id = $request["from_id"] ?? $min_id;
        $to_id = $request["to_id"] ?? $max_id;
        $from_recive_date = $request["from_recive_date"] ?? "";
        $to_recive_date = $request["to_recive_date"] ?? "";


        $expense = Expense::when($q, function ($query) use ($q) {
            return $query->where('old_name', 'like', '%' . $q . '%');
        })->when($family_project_id, function ($query) use ($family_project_id) {
            return $query->where('family_project_id', $family_project_id);
        })->when($from_id && $to_id, function ($query) use ($from_id, $to_id) {
            return $query->whereBetween('id', [$from_id, $to_id]);
        })->when($from_recive_date && $to_recive_date, function ($query) use ($from_recive_date, $to_recive_date) {
            return $query->whereBetween('recive_date', [$from_recive_date, $to_recive_date]);
        })->orderBy("expenses.id", 'desc')->paginate(20)
            ->appends([
                "q" => $q, "family_project_id" => $family_project_id, "from_id" => $from_id
                , "to_id" => $to_id, "from_recive_date" => $from_recive_date, "to_recive_date" => $to_recive_date]);

        $family_projects = FamilyProject::orderBy('name')->get();


        $faild_collection = Session::get('faildCollection') ?? "";
        return view('admin.expense.index', compact('expense', 'faild_collection', 'family_projects', 'family_project_id',
            'from_id', 'to_id', 'q',
            'from_recive_date', 'to_recive_date', 'min_id', 'max_id'));

    }


 public function edit($id)
    {
        $expense = Expense::find($id);


        if ($expense) {

         return view('admin.expense.edit',compact('expense'));

        } else {

            event(new NewLogCreated('المحاوله للوصول لصرفية غير موجودة برقم : ', $id, 80, 0, null));
            return redirect("/admin/expenses")->with('error', 'المحاوله للوصول لصرفية غير موجودة برقم : ' . $id);
        }
    }
    
    public function update($id,Request $request)
    {
        $expense = Expense::find($id);


        if ($expense) {

         $expense->update($request->all());


            event(new NewLogCreated('تم تعديل صرفية بنجاح : ', $id, 80, 0, null));
            return redirect("/admin/expenses/".$id."/edit")->with('success','تم تعديل صرفية بنجاح ' . $id);

        } else {

            event(new NewLogCreated('المحاوله للوصول لصرفية غير موجودة برقم : ', $id, 80, 0, null));
            return redirect("/admin/expenses")->with('error', 'المحاوله للوصول لصرفية غير موجودة برقم : ' . $id);
        }
    }

    public function delete($id)
    {
        $expense = Expense::find($id);


        if ($expense) {

            $excel_file = $expense->excel_file ?? "";
            $families = Family::where('expense_id', $id)->whereNotNull('parent_id')
                ->whereHas('person')->whereHas('parent')->get();
            $b = 0;
            foreach ($families->chunk(20) as $family) {
                set_time_limit(0);
                foreach ($family as $son_family) {
                    set_time_limit(0);
                    $b++;
                    /*if ($b > 17)
                        break;*/


                    $family = $son_family->parent;

                    $family_update = [];
                    $person_update = [];
                    if ($son_family->visit_count == 1) {
                        $family_update['visit_reason_id'] = 8;
                        $family_update['visit_date'] = Carbon::now();
                        if ($son_family->need) {
                            $family_update['family_classification_id'] = 1;
                        } else {
                            $family_update['family_classification_id'] = 5;
                        }

                    } elseif ($son_family->visit_count > 1) {

                        $past_brother = Family::where('parent_id', $son_family->parent_id)
                            ->where('visit_count', '<', $son_family->visit_count)
                            // ->whereNotNull('family_classification_id')
                            ->orderBy('visit_count', 'desc')->first();
                        // dd($family);
                        if ($past_brother) {

                            $family_update['visit_reason_id'] = 8;
                            $family_update['visit_date'] = Carbon::now();
                            $family_update['family_classification_id'] = $past_brother->family_classification_id;
                            $his_brother = Family::where('parent_id', $son_family->parent_id)
                                ->where('visit_count', '>', $son_family->visit_count)
                                ->orderBy('visit_count', 'desc')->first();


                            if ($his_brother) {
                                //جائت صرفية بعدهت
                                $family_update['code'] = $his_brother->code;
                                $person_update['full_name_tr'] = $his_brother->person->full_name_tr;

                            } else {
                                $family_update['code'] = $past_brother->code;
                                $person_update['full_name_tr'] = $past_brother->person->full_name_tr;
                            }
                        } else {

                            //dd('1مستحيل');
                            continue;
                        }
                    } else {
                        // dd('2مستحيل');
                        continue;
                    }


                    // year + year number visit
                    $currentDate = Carbon::now();
                    $currentYear = $currentDate->year;
                    $familiesYearNumber = Family::whereNotNull('parent_id')->where(['year' => $currentYear])
                        ->get()->sortBy('visit_date');

                    $numberCount = 1;
                    foreach ($familiesYearNumber as $number) {
                        $number->update(['year_number' => $numberCount]);
                        $numberCount++;
                    }

                    $person = $family->person;
                    if (count($family_update) > 0)
                        $family->update($family_update);
                    if (count($person_update) > 0)
                        $person->update($person_update);
                    // clone person
                    $newPerson = $person->replicate();
                    $newPerson->save();
                    // clone family
                    $newFamily = $family->replicate();
                    $newFamily->save();
                    // update family clone data
                    $newFamily->update(
                        [
                            'visit_count' => $family->visit_count,
                            'approve' => 1,
                            'archive' => 1,
                            'parent_id' => $family->id,
                            'person_id' => $newPerson->id,
                        ]);
                    $updateData = [
                        'archive' => 0,
                        'approve' => 0,
                        'visit_count' => $newFamily->visit_count + 1,
                        'expense_id' => null,
                    ];
                    // update family
                    $family->update($updateData);

                    // clone income
                    if ((isset($family->incomes)) && (!is_null($family->incomes))) {
                        foreach ($family->incomes as $item) {
                            $newIncome = $item->replicate();
                            $newIncome->family_id = $newFamily->id;
                            $newIncome->save();
                        }
                    }

                    // clone members
                    if ((isset($family->members)) && (!is_null($family->members))) {
                        foreach ($family->members as $item) {
                            $itemPerson = $item->person;
                            $newMember = $item->replicate();
                            $newPerson = $itemPerson->replicate();
                            $newPerson->save();
                            $newMember->family_id = $newFamily->id;
                            $newMember->person_id = $newPerson->id;
                            $newMember->save();
                        }
                    }

                    // clone searcher
                    if ((isset($family->searcher)) && (!is_null($family->searcher))) {
                        foreach ($family->searcher as $item) {
                            $newSearcher = $item->replicate();
                            $newSearcher->family_id = $newFamily->id;
                            $newSearcher->save();
                        }
                    }

                    // clone member diseases
                    if ((isset($family->familyMemberDiseases)) && (!is_null($family->familyMemberDiseases))) {
                        foreach ($family->familyMemberDiseases as $item) {
                            $newIncome = $item->replicate();
                            $newIncome->family_id = $newFamily->id;
                            $newIncome->save();
                        }
                    }
                    //تم تحديث تصنيف الكفيل


                }
                ////sleep(5);
            }
            $expense_details_ids = ExpenseDetail::where('expense_id', $id)->pluck('id')->toArray();
            $expense_detail_sponsors_ids = ExpenseDetailSponsor::whereIn('expense_detail_id', $expense_details_ids)->pluck('id')->toArray();
            $expense_detail_months_ids = ExpenseDetailMonth::whereIn('expense_detail_id', $expense_details_ids)->pluck('id')->toArray();


            if (count($expense_detail_months_ids) > 0)
                ExpenseDetailMonth::destroy($expense_detail_months_ids);
            if (count($expense_detail_sponsors_ids) > 0)
                ExpenseDetailSponsor::destroy($expense_detail_sponsors_ids);
            if (count($expense_details_ids) > 0)
                ExpenseDetail::destroy($expense_details_ids);


            $expense->delete();

            event(new NewLogCreated('تم حذف  الصرفية وآثارها بنجاح ', $excel_file, 80, 0, null));
            $action = Action::create(['title' => 'تم حذف صرفية', 'type' => Permission::findByName('list expenses')->title, 'link' => Permission::findByName('list expenses')->link]);
            $users = User::permission('expenses')->whereNotIn('id', [auth()->user()->id])->get();
            if ($users->first())
                Notification::send($users, new NotifyUsers($action));
            return redirect('admin/expenses')->with('success', 'تم حذف  الصرفية وآثارها بنجاح');

        } else {

            event(new NewLogCreated('المحاوله للوصول لصرفية غير موجودة برقم : ', $id, 80, 0, null));
            return redirect("/admin/expenses")->with('error', 'المحاوله للوصول لصرفية غير موجودة برقم : ' . $id);
        }
    }

    public function importExcel()
    {

        $family_projects = FamilyProject::orderBy('name')->get();
        return view('admin.expense.import', compact('family_projects'));
    }

    public function storeImportExcel(ExpenseRequest $request)
    {
        $recive_date = $request['recive_date'];
        $family_project_id = $request['family_project_id'];
        $year = $request['year'];
        $mounth_count = $request['mounth_count'];
        if ($request->hasFile('excel_file')) {
            if ($request->file('excel_file')->isValid()) {
                try {
                    $file = $request->file('excel_file');
                    $old_name = $file->getClientOriginalName();
                    $excel_file_name = rand(11111, 99999) . '.' . $file->getClientOriginalExtension();
                    $request->file('excel_file')->move(storage_path() . '/app/', $excel_file_name);

                    try {
                        
                        
                        
                        $collection = Excel::load(storage_path("/app/" . $excel_file_name), 'UTF-8')->get();
                        
                        
                        
        if (gettype($collection->first()->first()) == "double" || gettype($collection->first()->first()) == "string" || gettype($collection->first()->first()) == "integer") {
            $collection = $collection;

        } else {
            $collection = $collection->first();

        }
                        
                    } catch
                    (\ErrorException $e1) {
                        //error FileNotFoundException)
                        return redirect('/admin/expenses/importExcel')->with('error', 'لا يمكن رفع ملف أوفيس 2003 ، يرجى تحديث الملف ')->withInput($request->except(['excel_file']));
                    }

                   /* if ($collection->count() > 100) {
                        unlink(storage_path("/app/" . $excel_file_name));
                        return back()->with('error', 'لا يمكن رفع ملف أكثر من 100 صف دفعة واحدة')->withInput($request->except(['excel_file']));
                    }*/


                    return redirect('/admin/expenses/ImportExcel_2/' . $recive_date . '/' . $family_project_id . '/' . $year . '/' . $excel_file_name . '/' . $mounth_count . '/' . $old_name)->withInput($request->all);
                } catch (FileNotFoundException $e) {
                    //error FileNotFoundException)
                    return back()->with('error', 'خطأ في رفع الملف' . $e)->withInput($request->except(['excel_file']));
                }
            }
        } else {
            //error لم يتم رفع أي ملف)
            return back()->with('error', 'لم يتم رفع أي ملف')->withInput(request()->all);

        }
    }

    public
    function continue($recive_date, $family_project_id, $year, $excel_file_name, $mounth_count, $old_name, $the_months = null)
    {

        $all_months = Month::all();
        $all_currencies = Currency::all();
        $first_project_name = FamilyProject::find(1)->name;
        $second_project_name = FamilyProject::find(2)->name;
        $the_amount_in_index = 0;
        $has_months = 0;

        if ($the_months) {
            $the_months = explode(',', $the_months);
        }

        if (!Storage::exists($excel_file_name)) {
            return back()->with('error', 'الملف محذوف ، تم إرفاق هذه الصرفية من قبل')->withInput(session()->getOldInput());
        }
        // $collection = Excel::toCollection(new ExpenseImport, $excel_file_name);


        $collection = Excel::load(storage_path("/app/" . $excel_file_name), 'UTF-8')->get();

        $monthes_ids = [];
        $expense_prices_ids = [];
        $expense_amounts_ids = [];


        if (gettype($collection->first()->first()) == "double" || gettype($collection->first()->first()) == "string" || gettype($collection->first()->first()) == "integer") {
            $collection = $collection;

        } else {
            $collection = $collection->first();

        }

        if($collection->first()){

            $headerRow = $collection->first()->keys()->toArray();
        }else{
            return back()->with('error', 'الصفوف تحمل قيم غير صحيحة البنية')->withInput(session()->getOldInput());
        }

        $headerRow = array_filter($headerRow, "is_string");


        for ($i = 0; $i < count($headerRow); $i++) {

            if (!(trim($headerRow[$i])) && trim($headerRow[$i]) != 0) {
                break;
            }

            $x = 'index' . $i;

            $$x = "" . trim($headerRow[$i]) . "";
        }


        if (!($headerRow)) {
            return back()->with('error', 'يجب تنسيق الملف بشكل صحيح')->withInput(session()->getOldInput());
        }
        if ($headerRow[count($headerRow) - 1] == count($headerRow) - 1) {
            unset($headerRow[count($headerRow) - 1]);
        }
        if (count($headerRow) < 4) {
            //error عدد الأعمدة أقل من المتعارف عليه
            return back()->with('error', 'عدد الأعمدة أقل من التنسيق اللازم')->withInput(session()->getOldInput());
        }

        /// dd(1, $index0, $index1, $index2, $index3);

        if (($index0 == $first_project_name || $index0 == $second_project_name) &&
            ($index1 == "كود المكفول") &&
            ($index2 == "اسم المكفول") &&
            ($index3 == "الكافل")) {

            if ($index0 == $first_project_name && $family_project_id != 1) {
                //error تنسيق الملف لا ينتملي للمشروع الذي اخترته
                return back()->with('error', 'تنسيق الملف لا يوافق المشروع الذي اخترته')->withInput(session()->getOldInput());
            }
            if ($index0 == $second_project_name && $family_project_id != 2) {
                //error تنسيق الملف لا ينتملي للمشروع الذي اخترته
                return back()->with('error', 'تنسيق الملف لا يوافق المشروع الذي اخترته')->withInput(session()->getOldInput());
            }
            if ($index0 != $second_project_name && $index0 != $first_project_name) {
                //error تنسيق الملف لا يحتوي إسم المشروع
                return back()->with('error', 'تنسيق الملف لا يحتوي إسم المشروع')->withInput(session()->getOldInput());

            }

            if (count($headerRow) > 4) {// يحتوى المبلغ على الأقل

                for ($i = 4; $i < count($headerRow); $i++) {
                    if (!(trim($headerRow[$i])))
                        break;
                    $month = Month::where('name_en', trim($headerRow[$i]))->orWhere('name_tr', trim($headerRow[$i]))->first();

                    if ($month) {
                        array_push($monthes_ids, $month->id);
                    } else {
                        $the_amount_in_index = $i;
                    }

                }

            }

            if (count($monthes_ids) > 0) // يوجد أشهر
                $has_months = 1;

            if (count($monthes_ids) == 0 && ($the_months)) {
                $monthes_ids = $the_months;
            }

            $monthes_ids = array_values(array_filter($monthes_ids));
            if (count($monthes_ids) != $mounth_count) {
                //لا يوجد أشهر
                if (count($monthes_ids) == 0) {

                    $months = 0;
                } else {
                    //error عدد الأشهر المدخل لا يطابق عدد الأشهر بالملف
                    return back()->with('error', 'عدد الأشهر المدخل لا يطابق عدد الأشهر بالملف')->withInput(session()->getOldInput());
                }
            }
            $currency = Currency::where('name_en', trim($headerRow[$the_amount_in_index]))->first();


            //dd($headerRow, $headerRow[$the_amount_in_index]);

            if ($currency || $the_amount_in_index == 0) {
                $familes_codes = $collection->pluck('كود المكفول')->toArray();

                $familes_codes = array_filter($familes_codes);
                //array_shift($familes_codes);
                //dd($familes_codes);


                if (strpos($familes_codes[0], 'YTM') !== false) {
                    $familes_codes = array_unique(array_map(function ($item) {
                        if ($item) {

                            $array = explode('.', $item);
                            return $array[0];
                        }
                    }, $familes_codes));
                } else {
                    $familes_codes = array_unique(array_map(function ($item) {
                        if ($item) {

                            $array = explode('.', $item);
                            if (count($array) < 5) {
                                return null;
                            }
                            return $array[3];
                        }
                    }, $familes_codes));
                }

                $funded_institutions_ids = FundedInstitution::whereIn('code', $familes_codes)->pluck('id');
                ////dd('يلف على الأشهر ، ويثبت السنة ، وداخل كل شهر يلف على الجهات ويبحث عن سعر الصرف، والي بلاقيه بضيفه بحفظه، والي ما بلاقيه، بنشئه بصفار');
                for ($i = 0; $i < count($monthes_ids); $i++) {
                    foreach ($funded_institutions_ids as $funded_institution_id) {
                        $expense_price = ExpensePrice::where('year', $year)
                            ->where('month_id', $monthes_ids[$i])
                            ->where('funded_institution_id', $funded_institution_id)
                            ->first();//;
                        $expense_amount = ExpenseAmount::where('year', $year)
                            ->where('month_id', $monthes_ids[$i])
                            ->where('funded_institution_id', $funded_institution_id)
                            ->first();//;
                        if ($expense_price) {
                            array_push($expense_prices_ids, $expense_price->id);
                        } else {

                            $expense_price_id = ExpensePrice::create(['month_id' => $monthes_ids[$i],
                                'funded_institution_id' => $funded_institution_id,
                                'year' => $year
                            ])->id;
                            array_push($expense_prices_ids, $expense_price_id);
                        }
                        if ($expense_amount) {
                            array_push($expense_amounts_ids, $expense_amount->id);
                        } else {
                            $expense_amount_id = ExpenseAmount::create(['month_id' => $monthes_ids[$i],
                                'funded_institution_id' => $funded_institution_id,
                                'year' => $year
                            ])->id;
                            array_push($expense_amounts_ids, $expense_amount_id);
                        }
                    }

                }

                $expense_prices = ExpensePrice::whereIn('id', $expense_prices_ids)->orderBy('year')->orderBy('month_id')->orderBy('funded_institution_id')->get();
                $expense_amounts = ExpenseAmount::whereIn('id', $expense_amounts_ids)->orderBy('year')->orderBy('month_id')->orderBy('funded_institution_id')->get();
                if (count($expense_amounts) != count($expense_prices)) {
                    return back()->with('error', 'خطأ غير متوقع يجب مراجعة المبرمج')->withInput(session()->getOldInput());
                }
                if (($the_months)) {
                    $months = Month::find($the_months);
                } else {
                    $months = Month::find($monthes_ids);

                }

                $funded_institutions = FundedInstitution::find($funded_institutions_ids);

                if (count($monthes_ids) == 0 && $months->count() == 0) {
                    return view('admin.expense.import_getmonth', compact('excel_file_name', 'old_name',
                        'all_months', 'recive_date',
                        'year', 'family_project_id', 'mounth_count'));
                }

                //$amount = 0; لا ادري لماذا

                return view('admin.expense.import_continue', compact('excel_file_name', 'old_name', 'expense_prices', 'expense_amounts',
                    'months', 'all_currencies', 'all_months', 'funded_institutions', 'the_amount_in_index', 'recive_date',
                    'year', 'currency', 'family_project_id', 'has_months'));
            } else {
                //error حقل العملة والمبلغ غير متوفر

                return back()->with('error', 'عمود العملة والمبلغ غير صحيح البنية')->withInput(session()->getOldInput());
            }


        } else {

            //error تنسيق ملف الإكسل غير صحيح (لا يحتوي اسم المشروع او كود المكفول أو اسم المكفول أو الكافل)
            return back()->with('error', 'تنسيق ملف الإكسل غير صحيح (لا يحتوي اسم المشروع او كود المكفول أو اسم المكفول أو الكافل')->withInput(session()->getOldInput());
        }


    }

    public function continueByGet(Expense_monthRequest $request)
    {
        $recive_date = $request['recive_date'];
        $family_project_id = $request['family_project_id'];
        $year = $request['year'];
        $excel_file_name = $request['excel_file'];
        $mounth_count = $request['mounth_count'];
        $the_months = implode(",", $request['the_months']);
        $old_name = $request['old_name'];

        return redirect('/admin/expenses/ImportExcel_2/' . $recive_date . '/' . $family_project_id . '/' . $year . '/' . $excel_file_name . '/' . $mounth_count . '/' . $old_name . '/' . $the_months);

    }

     public function storeImportExcel_2(Expense_2Request $request){

        $myreq=$request->all();
        $id=auth()->user()->id;


        $excel_file = $request["excel_file"];
        $old_name = $request["old_name"];
        $has_months = $request["has_months"];
        $family_project_id = $request["family_project_id"];
        $recive_date = $request["recive_date"];
        $the_amount_in_index = $request["the_amount_in_index"];
        $year = $request["year"];
        $months = array_filter($request["months"]);
        $funded_institutions = array_filter($request["funded_institutions"]);
        $funded_institution_id_prices =array_filter( $request["funded_institution_id_prices"]);
        $funded_institution_id_amounts = array_filter($request["funded_institution_id_amounts"]);
        $month_amounts =array_filter($request["month_amounts"]);
        $month_prices = array_filter($request["month_prices"]);
        $currency_id = array_filter($request["currency_id"]);
        $change_type = array_filter($request["change_type"]);
        $euro_nis = $request["euro_nis"];
        $euro_usd = $request["euro_usd"];
        $usd_nis_ind = $request["usd_nis_ind"];
        $usd_nis = $request["usd_nis"];
        $amount = $request["amount_befor"];
        $discount = $request["discount"];
        $in_valid = $request['in_valid']??"";


        if (!Storage::exists($excel_file)) {
            return redirect('/admin/expenses/importExcel')->with('error', 'الملف محذوف ، تم إرفاق هذه الصرفية من قبل')->withInput(request()->all);
        }

        $count_all_arr =  count($months) * count($funded_institutions);



        if ($count_all_arr    == count($funded_institution_id_prices)
            && $count_all_arr == count($funded_institution_id_amounts)
            && $count_all_arr == count($month_amounts)
            && $count_all_arr == count($month_prices)
            && $count_all_arr == count($currency_id)
            && $count_all_arr == count($change_type)
            && $count_all_arr == count($euro_nis)
            && $count_all_arr == count($euro_usd)
            && $count_all_arr == count($usd_nis_ind)
            && $count_all_arr == count($usd_nis)
            && $count_all_arr == count($currency_id)) {

            DB::beginTransaction();

            foreach ($month_amounts as $key => $month_amount) {
                $i = $key;
                $expense_prices = ExpensePrice::where('year', $year)
                    ->where('month_id', $month_amounts[$i])
                    ->where('funded_institution_id', $funded_institution_id_amounts[$i]);


                if ($expense_prices->get()->count() != 1) {
                    return back()->with('error',
                        '
                1   يرجى التأكد من إدخال جميع البيانات المطلوبة
                    ')->withInput(request()->all);
                }

                $j = $expense_prices->first()->id;
                //استثناء تعارض المبلغ مع النسبة
                if ($currency_id[$i] == '1' && ($euro_nis[$j] == 0 && $euro_usd[$j] == 0)
                    || $currency_id[$i] == '2 ' && $usd_nis[$j] == 0
                    || $change_type [$j] == '1' && $euro_nis[$j] == 0
                    || $change_type [$j] == '2' && ($euro_usd[$j] == 0 || $usd_nis_ind[$j] == 0)
                    || $change_type [$j] == '3' && $usd_nis[$j] == 0
                    || $currency_id[$i] == '0') {
                    DB::rollback();
                    return back()->with('error', 'أسعار الصرف المدخلة، تتعارض مع نوع التحويل')->withInput(request()->all);

                } else {
                    $expense_amounts = DB::table('expense_amounts')
                        ->where('year', $year)
                        ->where('month_id', $month_amounts[$i])
                        ->where('funded_institution_id', $funded_institution_id_amounts[$i]);

                    if ($expense_amounts->get()->count() < 1) {
                        return back()->with('error', '
              2    يرجى التأكد من إدخال جميع البيانات المطلوبة
                    ')->withInput(request()->all);
                    }



                    if (($amount[$i] &&!is_numeric($amount[$i])) ||
                        ($discount[$i] &&!is_numeric($discount[$i])) ||
                        ($currency_id[$i] &&!is_numeric($currency_id[$i])) ||
                        ($usd_nis_ind[$j] &&!is_numeric($usd_nis_ind[$j])) ||
                        ($euro_nis[$j] &&!is_numeric($euro_nis[$j])) ||
                        ($euro_usd[$j] &&!is_numeric($euro_usd[$j]))) {
                        return back()->with('error', 'يرجى التأكد من ادخال أسعار صرف أرقام وليست أحرف')->withInput(request()->all);
                    }

                    $expense_amounts->update([
                            'amount' => $amount[$i],
                            'discount' => $discount[$i],
                            'currency_id' => $currency_id[$i]]
                    );

                    if ($usd_nis[$j] <= 0)
                        $usd_nis[$j] = $usd_nis_ind[$j];

                    $expense_prices->update([
                            'euro_usd' => $euro_usd[$j],
                            'usd_nis' => $usd_nis[$j],
                            'euro_nis' => $euro_nis[$j]]
                    );
                }

            }
            DB::commit();


            //$collection = Excel::toCollection(new ExpenseImport, $excel_file);
            $collection = Excel::load(storage_path("/app/" . $excel_file), 'UTF-8')->get();


            if (gettype($collection->first()->first()) == "double" || gettype($collection->first()->first()) == "string" || gettype($collection->first()->first()) == "integer") {
                $collection = $collection;

            } else {
                $collection = $collection->first();

            }

            unlink(storage_path("/app/" . $excel_file));

            $expense = Expense::create([
                'excel_file' => $excel_file,
                'family_project_id' => $family_project_id,
                'year' => $year,
                'recive_date' => $recive_date,
                'old_name' => $old_name
            ]);

            $error_string = "";
            $note_string = "";
            $invalidators_ids = [];
            $families_ids = [];
            $all_sponsors_ids = [];
            $headerRow = $collection->first()->keys()->toArray();
            $faildCollection = collect();
            //$faildCollection->shift();
            $faildCollection->push($headerRow);


            $project_name = FamilyProject::find($family_project_id)->name;
            $j = 1;


            //حوال 722 مرهم كلهم
            foreach ($collection->chunk(30) as $collections) {
                set_time_limit(0);
                
                    
                foreach ($collections as $keys => $vals) {
                    set_time_limit(0);
                    $output = json_decode('' . $vals, true);
                    $valus = array_values($output);

                    if (isset($vals[$project_name]))
                        $his_id = (int)trim($vals[$project_name]);
                    else
                        continue;
                    // dd($his_id);
                    /**يجب التعليق**/
                    /*if ($j >= 17)
                        break;
    */
                    $j++;

                    /*********/


                    foreach($vals as $prop => $val)
                    {
                        unset($vals->{$prop});
                        $vals[trim($prop)] = trim($val);
                    }


                    if (($vals[$project_name])&&(int)trim($vals[$project_name]) != 0
                        && (substr(trim($vals['كود المكفول']), 0, 9) === "633.KAP.F" || substr(trim($vals['كود المكفول']), 0, 8) === "YTM.FLS.")
                        && (trim($vals['اسم المكفول'])) && strlen(trim($vals['اسم المكفول'])) >= 1
                        && substr(trim($vals['اسم المكفول']), 0, 3) !== "604"
                        && (!(trim($vals['الكافل'])) || strlen(trim($vals['الكافل'])) >= 1)
                    ) {

                        $array = explode('.', trim($vals['كود المكفول']));
                        if ($family_project_id == 1) {
                            if (count($array) >= 5)
                                $family_code = $array[3];
                            elseif (count($array) == 3)
                                $family_code = $array[0];
                            else {
                                $error_string = $error_string . "<br> الصف رقم $his_id  الكود به غير سليم البنية ";
                                continue;
                            }
                        } else {
                            if (count($array) == 3)
                                $family_code = $array[0];
                            else {
                                $error_string = $error_string . "<br> الصف رقم $his_id  الكود به غير سليم البنية ";
                                continue;
                            }
                        }

                        $funded_institution = FundedInstitution::where('code', $family_code)->first();
                        if ($funded_institution) {

                            $month_loop = 4 + count($months); //اي ان مبالغ الليرا للأشهر تبدأ من الخاةة 4 إلى 6 اي لعند ما ينتهي عدد الأشهر في الملف.
                            $his_months_ids = [];
                            $last_month_id = 0;
                            if ($has_months) {//منطقة يحمل الأشهر
                                for ($z = 4; $z < $month_loop; $z++) {


                                    if ((int)trim($valus[$z]) > 0) {
                                        array_push($his_months_ids, Month::where('name_en', trim($headerRow[$z]))->orWhere('name_tr', trim($headerRow[$z]))->first()->id);

                                    }
                                }
                                $last_month_id = $his_months_ids[count($his_months_ids) - 1];
                            } else {//منطقة لا يحمل اشهر
                                $his_months_ids = $months;
                                $last_month_id = $his_months_ids[count($his_months_ids) - 1];
                            }

                            $his_expense_amount = ExpenseAmount::where('month_id', $last_month_id)->where('year', $year)->where('funded_institution_id', $funded_institution->id)->first();
                            $his_expense_price = ExpensePrice::where('month_id', $last_month_id)->where('year', $year)->where('funded_institution_id', $funded_institution->id)->first();
                            $his_currency = $his_expense_amount->currency;
                            if ($the_amount_in_index > 0) {
                                $his_befor_amount = round((float)trim((double) filter_var($valus[$the_amount_in_index],  FILTER_SANITIZE_NUMBER_FLOAT,
                                    FILTER_FLAG_ALLOW_FRACTION)));//تتغير في حال  لا يحمل مبلغ
                            } else { // منطقة لا يحمل مبلغ
                                //الفالديشن صحيح 100%
                                //قد يحمل اشهر وقد لا يحمل
                                //المنطقة3و4
                                $his_befor_amount = $his_expense_amount->amount;
                            }

                            $real_amount = 0;
                            if ($his_currency->id == 3) {
                                $real_amount = (1 - ($his_expense_amount->discount / 100)) * $his_befor_amount;
                            } elseif ($his_currency->id == 2) {
                                if ($his_expense_price->usd_nis) {
                                    $real_amount = $his_expense_price->usd_nis * (1 - ($his_expense_amount->discount / 100)) * $his_befor_amount;
                                } else {
                                    $faildCollection->push($valus);
                                    $error_string = $error_string . "<br> الصف رقم $his_id  لا يحتوي سعر الصرف ";


                                    continue;

                                }
                            } elseif ($his_currency->id == 1) {
                                if ($his_expense_price->euro_nis) {
                                    $real_amount = $his_expense_price->euro_nis * (1 - ($his_expense_amount->discount / 100)) * $his_befor_amount;
                                } elseif ($his_expense_price->euro_usd && $his_expense_price->usd_nis) {
                                    $real_amount = $his_expense_price->usd_nis * $his_expense_price->euro_usd * (1 - ($his_expense_amount->discount / 100)) * $his_befor_amount;
                                } else {
                                    $faildCollection->push($valus);
                                    $error_string = $error_string . "<br> الصف رقم $his_id  لا يحتوي سعر الصرف ";

                                    continue;
                                }
                            }


                            if ($his_befor_amount > 0) {

                                $full_name = trim($vals['اسم المكفول']);
                                $code = trim($vals['كود المكفول']);

                                if (strpos($vals['كود المكفول'], '-1') !== false) {
                                    $code = str_replace("-1", "", $code);
                                }
                                $search_code = $code;
                                $code_GUH = FundedInstitution::find(12)->code;
                                $code_GU = FundedInstitution::find(9)->code;
                                if (strpos($code, $code_GUH) !== false) {
                                    $code = str_replace($code_GUH, $code_GU, $code); // لارجاع كود هولندا عادي
                                }
                                $array_code = explode('.', $code);
                                $found_code = count($array_code) > 4 ? $array_code[3] : 0;
                                $his_founded = FundedInstitution::where('code', $found_code)->first();
                                if (strpos($vals['كود المكفول'], '.M') !== false) {
                                    $search_code = str_replace(".M", "", $code);
                                }

                                $falmils_by_name = Family::whereNull('parent_id')->whereHas('person'
                                    , function ($query) use ($vals, $j, $full_name) {
                                        $query->where('full_name_tr','like', $full_name);
                                    })->with('person');
                                $falmils_by_code = Family::with('person')
                                    ->where(function ($query) use ($code, $search_code) {
                                        $query->where('code', $code)
                                            ->orWhere('code', $search_code);
                                    })->whereNull('parent_id');
                                $vists_by_name = array_unique(array_filter(Family::whereNotNull('parent_id')->whereHas('person'
                                    , function ($query) use ($vals, $j, $full_name) {
                                        $query->where('full_name_tr','like', $full_name);
                                    })->pluck('parent_id')->toArray()));
                                $vists_by_code = array_unique(array_filter(Family::with('person')
                                    ->where(function ($query) use ($code, $search_code) {
                                        $query->where('code', $code)
                                            ->orWhere('code', $search_code);
                                    })->whereNotNull('parent_id')->pluck('parent_id')->toArray()));


                                if (/*(count($vists_by_code) > 1 || count($vists_by_name) > 1) ||
                                    (count($vists_by_code) > 1 && count($vists_by_name) == 0) ||
                                    (count($vists_by_code) == 0 && count($vists_by_name) > 1) ||*/
                                    ($falmils_by_name->count() > 1 || $falmils_by_code->count() > 1) ||
                                    ($falmils_by_name->count() > 1 && !($falmils_by_code->first())) ||
                                    (!($falmils_by_name->first()) && $falmils_by_code->count() > 1)) {// التكرار اذا كان الاسم غير يونيك اوالكود غير يونيك، أو بالاسم غير موجود والكود غير يونيك، أو بالكود غير موجود والاسم غير يوميك

                                    $faildCollection->push($valus);

                                    $error_string = $error_string . "<br> لم يتم إضافة الصف رقم $his_id  لتكرر اسمه في العائلات، يرجى مراجعة الاستمارة وتعديلها ";

                                    continue;
                                }
                                if (strpos(trim($vals['كود المكفول']), 'Ü') !== false) {
                                    $code = str_replace("Ü", "U", trim($vals['كود المكفول']));
                                }


                                if ($falmils_by_name->count() == 1) {

                                    $family_id = $falmils_by_name->first()->id;
                                }  elseif (count($vists_by_name) == 1) {

                                    $family_id = Family::find($vists_by_name[0])->id;
                                } elseif ($falmils_by_code->count() == 1) {

                                    $family_id = $falmils_by_code->first()->id;
                                }
                                elseif (count($vists_by_code) == 1) {

                                    $family_id = Family::find($vists_by_code[0])->id;
                                } else {


                                    //oka oka
                                    $person = Person::create([
                                        'full_name_tr' => $full_name,
                                    ]);
                                    Family::create([
                                        'code' => $code,
                                        'parent_id' => null,
                                        'person_id' => $person->id,
                                        'visit_count' => 1,
                                        'family_classification_id' => 2,
                                        'funded_institution_id' => $his_founded ? $his_founded->id : null,
                                        'expense_id' => $expense->id,
                                        'visit_reason_id' => 7,
                                        'visit_date' => Carbon::now(),
                                    ]);
                                    $note_string = $note_string . "<br> تم صرف صرفية لشخص ليس لديه استمارة رقم $his_id  ";

                                    continue;
                                }

                                if ($family_id > 0 && $real_amount > 0 && $his_befor_amount > 0 && count($his_months_ids) > 0 &&
                                    $expense->id > 0 && $funded_institution->id > 0 && $last_month_id > 0) {
                                    $past_expense_detail = ExpenseDetail::where('funded_institution_id', $funded_institution->id)
                                        ->where('family_id', $family_id)
                                        ->whereHas('months'
                                            , function ($query) use ($last_month_id) {
                                                $query->where('months.id', $last_month_id);
                                            })
                                        ->whereHas('expense'
                                            , function ($query) use ($year, $family_project_id) {
                                                $query->where('year', $year)->where('family_project_id', $family_project_id);
                                            })->first();
                                    if ($past_expense_detail) {


                                        //$faildCollection->push($valus);
                                        $error_string = $error_string . "<br> لم يتم إضافة الصف رقم $his_id  لأنه استلم صرفية هذ الشهر من هذه الجهة من قبل في عملية سابقة ";

                                        continue;
                                    } else {

                                        $expense_detail = ExpenseDetail::create([
                                            'amount' => (float)number_format($real_amount, 2, ',', ' '),
                                            'amount_befor' => $his_befor_amount,
                                            'expense_id' => $expense->id,
                                            'family_id' => $family_id,
                                            'funded_institution_id' => $funded_institution->id,
                                            'discount' => $his_expense_amount->discount,
                                            'currency_id' => $his_expense_amount->currency_id
                                        ]);

                                        for ($i_month = 0; $i_month < count($his_months_ids); $i_month++) {
                                            ExpenseDetailMonth::create([
                                                'expense_detail_id' => $expense_detail->id,
                                                'month_id' => $his_months_ids[$i_month],
                                            ]);
                                        }
                                        if ($expense_detail->id > 0) {
                                            $his_sponsors_ids = [];
                                            if (strlen(preg_replace('/\s+/', '', trim($vals['الكافل']))) <= 0) {
                                                $note_string = $note_string . "<br> في الصف رقم $his_id  لم يتم إضافة كافل الصرفية، بسبب عدم وجود اسم أو كود للكافل  ";
                                            } else {
                                                $mystring = trim($vals['الكافل']);
                                                if (strpos($mystring, ' 604.') !== false) {
                                                    $mystring = str_replace(' 604.', PHP_EOL . '604.', $mystring);
                                                }
                                                if (strpos($mystring, '⥬.604.') !== false) {
                                                    $mystring = str_replace('⥬.604.', PHP_EOL . '604.', $mystring);
                                                } elseif (strpos($mystring, '⥬.') !== false) {
                                                    $mystring = str_replace('⥬.', PHP_EOL . '604.', $mystring);
                                                }
                                                if (strpos($mystring, "\n") !== false) {
                                                    $mystring = str_replace("\n", PHP_EOL, $mystring);
                                                }
                                                $sponsors = explode(PHP_EOL, $mystring);
                                                if ($family_project_id == 1) {
                                                    foreach ($sponsors as $sponsor) {
                                                        if ((substr(trim($vals['الكافل']), 0, 1) === '0') || (int)substr(trim($vals['الكافل']), 0, 1) != 0) {
                                                            $result = explode(" ", $sponsor, 2); //اذا كان مبدوء برقم
                                                        } else {
                                                            $result = preg_split('/(?=\d)/', $sponsor, 2);//اذا كان مبدوء بحرف

                                                        }
                                                        if (count($result) == 2) {//لكل سطر اسم وكود
                                                            if ((substr(trim($vals['الكافل']), 0, 1) === '0') || (int)substr(trim($vals['الكافل']), 0, 1) != 0) {
                                                                $his_sponsor_code = $result[0];
                                                                $his_sponsor_name = $result[1];
                                                            } else {
                                                                $his_sponsor_code = $result[1];
                                                                $his_sponsor_name = $result[0];
                                                            }
                                                        } elseif (count($result) == 1) {//كان بها فقط كود
                                                            if ((substr(trim($vals['الكافل']), 0, 1) === '0') || (int)substr(trim($vals['الكافل']), 0, 1) != 0) {
                                                                $his_sponsor_code = $result[0];
                                                                $his_sponsor_name = "";
                                                            } else {
                                                                $his_sponsor_code = "";
                                                                $his_sponsor_name = $result[0];
                                                            }
                                                        } else {
                                                            continue;
                                                        }

                                                        if (Sponsor::where('code', $his_sponsor_code)->count() > 1 && ($his_sponsor_code) && $his_sponsor_code != '000000000000') {
                                                            $note_string = $note_string . "<br> في الصف رقم $his_id  لم يتم إضافة كافل الصرفية، بسبب تكرر كوده  ";

                                                            continue;
                                                        } elseif (Sponsor::where('code', $his_sponsor_code)->count() == 1 && $his_sponsor_code != '000000000000' && ($his_sponsor_code)) {

                                                            array_push($his_sponsors_ids, Sponsor::where('code', $his_sponsor_code)->first()->id);
                                                            if (Sponsor::where('code', $his_sponsor_code)->first()->name != $his_sponsor_name) {
                                                                Sponsor::where('code', $his_sponsor_code)->update([
                                                                    'name' => $his_sponsor_name,
                                                                    'sponsor_status_id' => 1
                                                                ]);
                                                                $note_string = $note_string . "<br> تم تحديث اسم الكافل للمكفول في صف $his_id";
                                                            }
                                                        } elseif (Sponsor::where('name', $his_sponsor_name)->count() == 1 && ($his_sponsor_name)) {
                                                            array_push($his_sponsors_ids, Sponsor::where('name', $his_sponsor_name)->first()->id);
                                                            if (Sponsor::where('name', $his_sponsor_name)->first()->code != $his_sponsor_code) {
                                                                Sponsor::where('name', $his_sponsor_name)->update([
                                                                    'code' => $his_sponsor_code,
                                                                    'sponsor_status_id' => 1

                                                                ]);
                                                                $note_string = $note_string . "<br> تم تحديث كود الكافل للمكفول في صف $his_id";
                                                            }
                                                        } else {//count()==0 //انشاء يعني
                                                            array_push($his_sponsors_ids, Sponsor::create([
                                                                'code' => $his_sponsor_code,
                                                                'name' => $his_sponsor_name,
                                                                'sponsor_status_id' => 1

                                                            ])->id);
                                                        }
                                                    }
                                                    for ($i_sponsor = 0; $i_sponsor < count($his_sponsors_ids); $i_sponsor++) {
                                                        ExpenseDetailSponsor::create([
                                                            'expense_detail_id' => $expense_detail->id,
                                                            'sponsor_id' => $his_sponsors_ids[$i_sponsor],
                                                            'expense_id' => $expense->id,
                                                        ]);
                                                        array_push($all_sponsors_ids, $his_sponsors_ids[$i_sponsor]);

                                                    }
                                                } else {
                                                    foreach ($sponsors as $sponsor) {
                                                        if ((substr(trim($vals['الكافل']), 0, 4) === 'GRUP')) {
                                                            $result = explode(" ", $sponsor, 2); //اذا كان مبدوء GRUP
                                                        } else {
                                                            $result = preg_split("/(?=GRUP)/", $sponsor, 2);//اذا كان مبدوء بحرف

                                                        }
                                                        if (count($result) == 2) {
                                                            /**لكل سطر اسم وكود**/
                                                            if ((substr(trim($vals['الكافل']), 0, 4) === 'GRUP')) {
                                                                $his_sponsor_code = $result[0];
                                                                $his_sponsor_name = $result[1];
                                                            } else {
                                                                $his_sponsor_code = $result[1];
                                                                $his_sponsor_name = $result[0];
                                                            }
                                                        } elseif (count($result) == 1) {//كان بها فقط كود
                                                            if ((substr(trim($vals['الكافل']), 0, 4) === 'GRUP')) {
                                                                $his_sponsor_code = $result[0];
                                                                $his_sponsor_name = "";
                                                            } else {
                                                                $his_sponsor_code = "";
                                                                $his_sponsor_name = $result[0];
                                                            }
                                                        } else {
                                                            continue;
                                                        }

                                                        if (Sponsor::where('code', $his_sponsor_code)->count() > 1 && ($his_sponsor_code)) {
                                                            $note_string = $note_string . "<br> في الصف رقم $his_id  لم يتم إضافة كافل الصرفية، بسبب تكرر كوده   ";

                                                            continue;
                                                        } elseif (Sponsor::where('code', $his_sponsor_code)->count() == 1 && $his_sponsor_code != '000000000000' && ($his_sponsor_code)) {

                                                            array_push($his_sponsors_ids, Sponsor::where('code', $his_sponsor_code)->first()->id);
                                                            if (Sponsor::where('code', $his_sponsor_code)->first()->name != $his_sponsor_name) {
                                                                Sponsor::where('code', $his_sponsor_code)->update([
                                                                    'name' => $his_sponsor_name,
                                                                ]);
                                                                $note_string = $note_string . "<br> تم تحديث اسم الكافل للمكفول في صف $his_id";
                                                            }
                                                        } elseif (Sponsor::where('name', $his_sponsor_name)->count() == 1 && ($his_sponsor_name)) {
                                                            array_push($his_sponsors_ids, Sponsor::where('name', $his_sponsor_name)->first()->id);
                                                            if (Sponsor::where('name', $his_sponsor_name)->first()->code != $his_sponsor_code) {
                                                                Sponsor::where('name', $his_sponsor_name)->update([
                                                                    'code' => $his_sponsor_code,
                                                                ]);
                                                                $note_string = $note_string . "<br> تم تحديث كود الكافل للمكفول في صف $his_id";
                                                            }
                                                        } else {//count()==0 //انشاء يعني
                                                            array_push($his_sponsors_ids, Sponsor::create([
                                                                'code' => $his_sponsor_code,
                                                                'name' => $his_sponsor_name,
                                                                'sponsor_status_id' => 1
                                                            ])->id);


                                                        }
                                                    }
                                                    for ($i_sponsor = 0; $i_sponsor < count($his_sponsors_ids); $i_sponsor++) {
                                                        ExpenseDetailSponsor::create([
                                                            'expense_detail_id' => $expense_detail->id,
                                                            'sponsor_id' => $his_sponsors_ids[$i_sponsor],
                                                            'expense_id' => $expense->id,
                                                        ]);
                                                        array_push($all_sponsors_ids, $his_sponsors_ids[$i_sponsor]);
                                                    }
                                                }
                                            }
                                            $family = Family::whereHas('person')->find($family_id);
                                            if (!is_null($family)) {

                                                // year + year number visit
                                                $currentDate = Carbon::now();
                                                $currentYear = $currentDate->year;
                                                $familiesYearNumber = Family::whereNotNull('parent_id')->where(['year' => $currentYear])
                                                    ->get()->sortBy('visit_date');

                                                $numberCount = 1;
                                                foreach ($familiesYearNumber as $number) {
                                                    $number->update(['year_number' => $numberCount]);
                                                    $numberCount++;
                                                }

                                                $person = $family->person;


                                                array_push($families_ids, $family->id);

                                                $family_update = [];
                                                $person_update = [];
                                                $family_update['family_classification_id'] = 2;
                                                $family_update['expense_id'] = $expense->id;
                                                $family_update['visit_reason_id'] = 7;
                                                $family_update['visit_date'] = Carbon::now();
                                                $family_update['funded_institution_id'] = $his_founded ? $his_founded->id : null;
                                                if (!$family->need) {
                                                    $note_string = $note_string . "<br> تم صرف صرفية لشخص لا يحتاج في صف  $his_id";
                                                }


                                                $falmils_by_name_first = Family::where('id','!=',$family->id)->whereNull('parent_id')->whereHas('person'
                                                    , function ($query) use ($vals, $j, $full_name) {
                                                        $query->where('full_name_tr','like', '%'.$full_name.'%');
                                                    })->first();
                                                $vists_by_name_first = Family::whereNotNull('parent_id')->where('parent_id','!=',$family->id)->whereHas('person'
                                                    , function ($query) use ($vals, $j, $full_name) {
                                                        $query->where('full_name_tr','like', '%'.$full_name.'%');
                                                    })->first();


                                                if (!($falmils_by_name_first ) && !($vists_by_name_first) && $person->full_name_tr != $full_name) {
                                                    $person_update['full_name_tr'] = $full_name;
                                                    $note_string = $note_string . "<br> تم تحديث الاسم الكامل للمكفول في صف $his_id ";
                                                }
                                                if ($family->code != $code) {

                                                    $wrong_family= Family::whereNull('parent_id')->where('code',$code)->first();
                                                    if($wrong_family){
                                                        $wrong_family->update(['code'=>null]);
                                                    }

                                                    $family_update['code'] = $code;
                                                    $note_string = $note_string . "<br> تم تحديث الكود للمكفول في صف $his_id";
                                                    if ($family->funded_institution_id != $funded_institution->id) {
                                                        $family_update['funded_institution_id'] = $funded_institution->id;
                                                        $note_string = $note_string . "<br> تم تحديث الجهة للمكفول في صف $his_id";
                                                    }

                                                }
                                                if (count($family_update) > 0)
                                                    $family->update($family_update);
                                                if (count($person_update) > 0)
                                                    $person->update($person_update);

                                                // clone person
                                                $newPerson = $person->replicate();
                                                $newPerson->save();

                                                // clone family
                                                $newFamily = $family->replicate();
                                                $newFamily->save();
                                                // update family clone data
                                                $newFamily->update(
                                                    [
                                                        'visit_count' => $family->childs()->first() ? $family->childs()->orderByDesc('visit_count')->first()->visit_count + 1 : $family->visit_count,
                                                        'approve' => 1,
                                                        'archive' => 1,
                                                        'parent_id' => $family->id,
                                                        'person_id' => $newPerson->id,
                                                    ]);

                                                $updateData = [
                                                    'archive' => 0,
                                                    'approve' => 0,
                                                    'visit_count' => $newFamily->visit_count + 1,
                                                    'expense_id' => null,
                                                ];

                                                // update family
                                                $family->update($updateData);

                                                // clone income
                                                if ((isset($family->incomes)) && (!is_null($family->incomes))) {
                                                    foreach ($family->incomes as $item) {
                                                        $newIncome = $item->replicate();
                                                        $newIncome->family_id = $newFamily->id;
                                                        $newIncome->save();
                                                    }
                                                }

                                                // clone members
                                                if ((isset($family->members)) && (!is_null($family->members))) {
                                                    foreach ($family->members as $item) {
                                                        $itemPerson = $item->person;
                                                        $newMember = $item->replicate();
                                                        $newPerson = $itemPerson->replicate();
                                                        $newPerson->save();
                                                        $newMember->family_id = $newFamily->id;
                                                        $newMember->person_id = $newPerson->id;
                                                        $newMember->save();
                                                    }
                                                }

                                                // clone searcher
                                                if ((isset($family->searcher)) && (!is_null($family->searcher))) {
                                                    foreach ($family->searcher as $item) {
                                                        $newSearcher = $item->replicate();
                                                        $newSearcher->family_id = $newFamily->id;
                                                        $newSearcher->save();
                                                    }
                                                }

                                                // clone member diseases
                                                if ((isset($family->familyMemberDiseases)) && (!is_null($family->familyMemberDiseases))) {
                                                    foreach ($family->familyMemberDiseases as $item) {
                                                        $newIncome = $item->replicate();
                                                        $newIncome->family_id = $newFamily->id;
                                                        $newIncome->save();
                                                    }
                                                }
                                                //تم تحديث تصنيف الكفيل


                                            } else {
                                                $error_string = $error_string . "<br> لم يتم تحديث تصنيف الكفيل في صف $his_id لخلل برمجي في إيجاد استمارته  ";
                                                continue;
                                            }


                                        } else {
                                            $faildCollection->push($valus);
                                            $error_string = $error_string . "<br> لم يتم إضافة الصف رقم $his_id  لحدوث خطأ برمجي في التخزين ";

                                            continue;
                                        }

                                    }


                                } else {
                                    $faildCollection->push($valus);
                                    $error_string = $error_string . "<br> لم يتم إضافة الصف رقم $his_id  لوجود نقص في المعلومات اللازمة، خطأ برمجي ";

                                    continue;
                                }
                            } else { // قيمة المبلغ حروف خطأ
                                $faildCollection->push($valus);
                                $error_string = $error_string . "<br> الصف رقم $his_id  قيمة المبلغ به ليست رقم،أو أنها أقل من 1 ";

                                continue;
                            }
                        } else {
                            $faildCollection->push($valus);
                            $error_string = $error_string . "<br> الصف رقم $his_id  لا ينتمي لأي جهة مرشحة معتمدة ";

                            continue;
                        }

                    } else {
                        $faildCollection->push($valus);
                        $error_string = $error_string . "<br> الصف رقم $his_id  يحمل بيانات غير صحيحة البنية ";

                        continue;
                    }


                    

                }
                ////sleep(5);
            
                
                    
            }


                    
            $allsponsors = Sponsor::whereIn('id', $all_sponsors_ids)->update(['sponsor_status_id' => 1]);
            $othersponsors = Sponsor::whereNotIn('id', $all_sponsors_ids)->where('sponsor_status_id', '!=', 3)
                ->whereHas('expense_details', function ($q) use ($expense) {
                    $q->whereHas('expense', function ($q) use ($expense) {
                        $q->whereNotIn('recive_date', [$expense->recive_date]);
                    });
                })->get();

            // dd($allsponsors, $othersponsors);


         
            foreach ($othersponsors->chunk(30) as $sponsors) {
                set_time_limit(0);
                foreach ($sponsors as $sponsor) {
                    set_time_limit(0);
                    $last_4 = Expense::orderBy('id', 'desc')->take(4)->pluck('id')->toArray();
                    $has_in_last_4 = ExpenseDetailSponsor::where('sponsor_id', $sponsor->id)->whereIn('expense_id', $last_4)->first();
                    if ($has_in_last_4 && !(in_array($sponsor->id, $all_sponsors_ids))) {
                        $sponsor->update(['sponsor_status_id' => 2]);
                    } elseif (!(in_array($sponsor->id, $all_sponsors_ids))) {
                        $sponsor->update(['sponsor_status_id' => 3]);
                    }
                }
                ////sleep(5);
            }


            $otherfamileis = Family::whereNotIn('id', $families_ids)->whereNull('parent_id')
                ->where(function ($query) {
                    $query->where('family_classification_id', '!=', 4)
                        ->orWhereNull('family_classification_id');
                })->whereHas('person'
                    , function ($query) {
                        $query->whereNotNull('full_name_tr');
                    })
                ->where('need', '!=', 1)
                ->get();
            // حوالي 1037
            //بمشي منهم 1033
            //على الاستضافة ما بمشي ولا وحدة

            $bb = 0;
            


            if ($in_valid == 1) {

                foreach ($otherfamileis->chunk(30) as $families) {
                    set_time_limit(0);
                    foreach ($families as $family) {
                        set_time_limit(0);
                        $his_full_name = $family->person->full_name_tr;
                        $falmils_by_name = Family::whereNull('parent_id')->whereHas('person'
                            , function ($query) use ($his_full_name) {
                                $query->where('full_name_tr', $his_full_name);
                            });
                        if ($falmils_by_name->count() > 1) {
                            $error_string = $error_string . "<br> الأسرة برقم $family->code اسمها مكرر لخلل في ادخال الاستمارات";
                            continue;

                        } else {
                            $bb++;
                            /* if ($bb >= 17)
                                 break;*/
                            if ($family->person) {
                                $family_update = [];
                                $family_update['is_sent'] = 0;

                                if ($family->family_classification_id == 1 || !($family->family_classification_id)) {

                                    if ($family->need) {
                                        $family_update['family_classification_id'] = 5;
                                    } else {
                                        $family_update['family_classification_id'] = 4;
                                        array_push($invalidators_ids, $family->id);
                                    }

                                } elseif ($family->family_classification_id == 2) {
                                    if ($family->need) {
                                        $last_4 = Expense::orderBy('id', 'desc')->take(4)->pluck('id')->toArray();
                                        $all_his_viste = Family::whereNotNull('parent_id')
                                            ->whereHas('person'
                                                , function ($query) use ($his_full_name) {
                                                    $query->where('full_name_tr', $his_full_name);
                                                })->pluck('id')->toArray();
                                        $has_in_last_4 = Family::whereIn('id', $all_his_viste)->whereIn('expense_id', $last_4)->first();
                                        if ($has_in_last_4) {
                                            $family_update['family_classification_id'] = 2;
                                        } else {
                                            $family_update['family_classification_id'] = 3;
                                        }
                                    } else {
                                        $family_update['family_classification_id'] = 4;
                                        array_push($invalidators_ids, $family->id);

                                    }

                                } elseif ($family->family_classification_id == 3) {
                                    if (!($family->need)) {
                                        $family_update['family_classification_id'] = 4;
                                        array_push($invalidators_ids, $family->id);

                                    }

                                } elseif ($family->family_classification_id == 5) {
                                    if (!($family->need)) {
                                        $family_update['family_classification_id'] = 4;
                                        array_push($invalidators_ids, $family->id);

                                    }

                                }


//تعديل الآخرين


                                // year + year number visit
                                $currentDate = Carbon::now();
                                $currentYear = $currentDate->year;
                                $familiesYearNumber = Family::whereNotNull('parent_id')->where(['year' => $currentYear])
                                    ->get()->sortBy('visit_date');

                                $numberCount = 1;
                                foreach ($familiesYearNumber as $number) {
                                    $number->update(['year_number' => $numberCount]);
                                    $numberCount++;
                                }

                                $person = $family->person;


                                array_push($families_ids, $family->id);
                                $person_update = [];
                                $family_update['expense_id'] = $expense->id;
                                $family_update['visit_date'] = Carbon::now();
                                $family_update['is_sent'] = 0;

                                $family_update['visit_reason_id'] = 7;
                                if (count($family_update) > 0)
                                    $family->update($family_update);
                                if (count($person_update) > 0)
                                    $person->update($person_update);

                                if ($family->family_classification_id != 4) {//عدم استنساخ المبطلة لانها سوف تستنسخ في صفحة الإبطال

                                    // clone person
                                    $newPerson = $person->replicate();
                                    $newPerson->save();

                                    // clone family
                                    $newFamily = $family->replicate();
                                    $newFamily->save();

                                    // update family clone data
                                    $newFamily->update(
                                        [
                                            'visit_count' => $family->visit_count,
                                            'approve' => 1,
                                            'archive' => 1,
                                            'parent_id' => $family->id,
                                            'person_id' => $newPerson->id,
                                        ]);

                                    $updateData = [
                                        'archive' => 0,
                                        'approve' => 0,
                                        'visit_count' => $newFamily->visit_count + 1,
                                        'expense_id' => null,
                                    ];

                                    // update family
                                    $family->update($updateData);

                                    // clone income
                                    if ((isset($family->incomes)) && (!is_null($family->incomes))) {
                                        foreach ($family->incomes as $item) {
                                            $newIncome = $item->replicate();
                                            $newIncome->family_id = $newFamily->id;
                                            $newIncome->save();
                                        }
                                    }

                                    // clone members
                                    if ((isset($family->members)) && (!is_null($family->members))) {
                                        foreach ($family->members as $item) {
                                            $itemPerson = $item->person;
                                            $newMember = $item->replicate();
                                            $newPerson = $itemPerson->replicate();
                                            $newPerson->save();
                                            $newMember->family_id = $newFamily->id;
                                            $newMember->person_id = $newPerson->id;
                                            $newMember->save();
                                        }
                                    }

                                    // clone searcher
                                    if ((isset($family->searcher)) && (!is_null($family->searcher))) {
                                        foreach ($family->searcher as $item) {
                                            $newSearcher = $item->replicate();
                                            $newSearcher->family_id = $newFamily->id;
                                            $newSearcher->save();
                                        }
                                    }

                                    // clone member diseases
                                    if ((isset($family->familyMemberDiseases)) && (!is_null($family->familyMemberDiseases))) {
                                        foreach ($family->familyMemberDiseases as $item) {
                                            $newIncome = $item->replicate();
                                            $newIncome->family_id = $newFamily->id;
                                            $newIncome->save();
                                        }
                                    }
                                }
                                //تم تحديث تصنيف الكفيل


                            } else {
                                $error_string = $error_string . "<br> الأسرة برقم $family->code لا تملك معلومات فرد ";
                                continue;
                            }
                        }

                    }
                    ////sleep(5);
                }
            }


            $invalidators = Family::find($invalidators_ids);

            Session()->flash('error_string', $error_string);
            Session()->flash('note_string', $note_string);
            Session()->flash('faildCollection', $faildCollection);
            Session()->put('invalidators', $invalidators);
            Session()->put('expense_name', $expense->old_name);
            Session()->flash('expense_id', $expense->id);
            
            


            $all=json_encode(session()->all());
            $the_id=DB::table('sessions')->insertGetId([ 'all' => $all]);



            $action = Action::create(['title' => 'تم إضافة صرفية جديدة'
            .$expense->old_name, 'type' => Permission::findByName('list expenses')->title, 'link' => '/admin/expenses/invalidators?session_id='.$the_id]);
            $users = User::whereIn('id', [$id])->get();

            if ($users->first())
                Notification::send($users, new NotifyUsers($action));


             return redirect('/admin/expenses/invalidators?session_id='.$the_id);
        } else {
            return back()->with('error',
                '
          3        يرجى التأكد من إدخال جميع البيانات المطلوبة
                    '
            )->withInput(request()->all);
        }


    }

    public function invalidators()
    {


        if(request()['session_id']){
        $the_session = json_decode(DB::table("sessions")->find(\request()['session_id'])->all);


            $error_string = $the_session->error_string ?? "";
            $note_string = $the_session->note_string ?? "";
            $faild_collection = collect($the_session->faildCollection) ?? "";
            $invalidators = collect($the_session->invalidators) ?? "";
            $expense_id = $the_session->expense_id ?? "";
            $expense_name=$the_session->expense_name ?? "";
        }else {
            $error_string = Session::get('error_string') ?? "";
            $note_string = Session::get('note_string') ?? "";
            $faild_collection = Session::get('faildCollection') ?? "";
            $invalidators = Session::get('invalidators') ?? "";
            $expense_id = Session::get('expense_id') ?? "";
            $expense_name = Session::get('expense_name') ?? "";
        }
        
       

        return view('admin.expense.invalidators', compact('error_string', 'note_string',
            'faild_collection', 'invalidators', 'expense_id','expense_name'));

    }


//   public function storeImportExcel_2(Expense_2Request $request){

//         $myreq=$request->all();
//         $id=auth()->user()->id;

//       // MyJob::dispatch($myreq,$id);
//         Session()->put('myreq', $myreq);
//          Session()->put('id', $id);
//         \Illuminate\Support\Facades\Artisan::call('schedule:run');
//         Session()->flash('success','جاري رفع الصرفية، سيصلك اشعار عند اتمام العملية');
//         return redirect('/admin/expenses/invalidators?first');
//     }

//     public function invalidators()
//     {


//         if(request()['session_id']){
//         $the_session = json_decode(DB::table("sessions")->find(\request()['session_id'])->all);


//             $error_string = $the_session->error_string ?? "";
//             $note_string = $the_session->note_string ?? "";
//             $faild_collection = collect($the_session->faildCollection) ?? "";
//             $invalidators = collect($the_session->invalidators) ?? "";
//             $expense_id = $the_session->expense_id ?? "";
//             $expense_name=$the_session->expense_name ?? "";
//         }else {
//             $error_string = Session::get('error_string') ?? "";
//             $note_string = Session::get('note_string') ?? "";
//             $faild_collection = Session::get('faildCollection') ?? "";
//             $invalidators = Session::get('invalidators') ?? "";
//             $expense_id = Session::get('expense_id') ?? "";
//             $expense_name = Session::get('expense_name') ?? "";
//         }

//         return view('admin.expense.invalidators', compact('error_string', 'note_string',
//             'faild_collection', 'invalidators', 'expense_id','expense_name'));

//     }

    public function store_invalidators(Expense_invalidatorRequest $request)
    {
        $expense_id = $request['expense_id'];
        $ignore_date = $request['ignore_date'];
        $note = $request['note'];
        $error_string = "";
        if (!($expense_id) || (count($ignore_date) != count($note))) {
            return back()->with('error', 'يوجد قيم فارغة في إدخال الإبطال')->withInput(request()->all);
        } else {
            foreach ($ignore_date as $key => $his_ignore_date) {
                if (!($note[$key])) {
                    $error_string = $error_string . "لم يتم تحديث معلومات الأسرة برقم $key لتعارض المدخلات برمجيا ";
                    continue;
                } else {
                    $his_note = $note[$key];
                    $family = Family::WhereHas('person')->find($key);

                    $family_update['expense_id'] = $expense_id;
                    $family_update['visit_date'] = Carbon::now();
                    $family_update['ignore_reason'] = $his_note;
                    $family_update['ignore_date'] = $his_ignore_date;
                    $family_update['visit_reason_id'] = 7;

                    if (!is_null($family)) {
                        // year + year number visit
                        $currentDate = Carbon::now();
                        $currentYear = $currentDate->year;
                        $familiesYearNumber = Family::whereNotNull('parent_id')->where(['year' => $currentYear])
                            ->get()->sortBy('visit_date');

                        $numberCount = 1;
                        foreach ($familiesYearNumber as $number) {
                            $number->update(['year_number' => $numberCount]);
                            $numberCount++;
                        }

                        $person = $family->person;


                        if (count($family_update) > 0)
                            $family->update($family_update);

                        // clone person
                        $newPerson = $person->replicate();
                        $newPerson->save();

                        // clone family
                        $newFamily = $family->replicate();
                        $newFamily->save();

                        // update family clone data
                        $newFamily->update(
                            [
                                'visit_count' => $family->visit_count,
                                'approve' => 1,
                                'archive' => 1,
                                'parent_id' => $family->id,
                                'person_id' => $newPerson->id,
                            ]);

                        $updateData = [
                            'archive' => 0,
                            'approve' => 0,
                            'visit_count' => $newFamily->visit_count + 1,
                            'expense_id' => null,
                        ];

                        // update family
                        $family->update($updateData);

                        // clone income
                        if ((isset($family->incomes)) && (!is_null($family->incomes))) {
                            foreach ($family->incomes as $item) {
                                $newIncome = $item->replicate();
                                $newIncome->family_id = $newFamily->id;
                                $newIncome->save();
                            }
                        }

                        // clone members
                        if ((isset($family->members)) && (!is_null($family->members))) {
                            foreach ($family->members as $item) {
                                $itemPerson = $item->person;
                                $newMember = $item->replicate();
                                $newPerson = $itemPerson->replicate();
                                $newPerson->save();
                                $newMember->family_id = $newFamily->id;
                                $newMember->person_id = $newPerson->id;
                                $newMember->save();
                            }
                        }

                        // clone searcher
                        if ((isset($family->searcher)) && (!is_null($family->searcher))) {
                            foreach ($family->searcher as $item) {
                                $newSearcher = $item->replicate();
                                $newSearcher->family_id = $newFamily->id;
                                $newSearcher->save();
                            }
                        }

                        // clone member diseases
                        if ((isset($family->familyMemberDiseases)) && (!is_null($family->familyMemberDiseases))) {
                            foreach ($family->familyMemberDiseases as $item) {
                                $newIncome = $item->replicate();
                                $newIncome->family_id = $newFamily->id;
                                $newIncome->save();
                            }
                        }
                        //تم تحديث تصنيف الكفيل


                    } else {
                        $error_string = $error_string . "<br> لا يوجد أسرة بهذا الرقم $key";
                        continue;
                    }
                }
            }
            //session()->flush();
            session()->forget(['error_string', 'note_string', 'faildCollection', 'invalidators', 'expense_id']);
            session()->flash('error_string', $error_string);
            session()->flash('success', 'تم ارفاق صرفية بنجاح');
            return redirect('/admin/expenses');
        }

    }

    public function exportIgnoreFile(Request $request)
    {

        $faild_collection = collect(json_decode($request['faild_collection'], true));
        $file_name = $request['file_name'];
        // return Excel::download(new ExpenseExport($faild_collection), "الصفوف التي فشل اضافتها $file_name .xlsx");
        Excel::create("الصفوف التي فشل اضافتها $file_name", function ($excel) use ($faild_collection) {

            $excel->sheet('الزيارات', function ($sheet) use ($faild_collection) {
                $sheet->fromArray($faild_collection->first(), NULL, 'A1');
                $faild_collection->shift();
                $myArray = $faild_collection->toArray();
                foreach ($myArray as $key => $item) {
                    $sheet->row($key + 2, $item);
                }
            });

        })->download('xlsx');
    }

    public function details($id, Request $request)
    {
        $expense = Expense::find($id);

        if ($expense) {
            $funded_institutions_ids_yes = $request["funded_institutions_ids_yes"] ? array_filter($request["funded_institutions_ids_yes"]) : [];
            $funded_institutions_ids_no = $request["funded_institutions_ids_no"] ? array_filter($request["funded_institutions_ids_no"]) : [];
            $is_discount = $request['is_discount'];
            $delivery = $request["delivery"] ?? "";
            $min_id = $expense->expense_details()->first()->id ?? 1;
            $max_id = $expense->expense_details()->orderByDesc('id')->first()->id ?? 1;
            $from_id = $request["from_id"] ?? $min_id;
            $to_id = $request["to_id"] ?? $max_id;
            $from_recive_date = $request["from_recive_date"] ?? ""; // علاقة
            $to_recive_date = $request["to_recive_date"] ?? "";
            $family_project_id = $request["family_project_id"] ?? ""; // علاقة
            $families_yes = $request["families_yes"] ? array_filter($request["families_yes"]) : [];  // علاقة
            $families_no = $request["families_no"] ? array_filter($request["families_no"]) : [];  // علاقة
            $coulmn = $request["coulmn"] ?? "";

            $expense_details = $expense->expense_details()->when($funded_institutions_ids_yes, function ($query) use ($funded_institutions_ids_yes) {
                return $query->whereIn('funded_institution_id', $funded_institutions_ids_yes);
            })->when($funded_institutions_ids_no, function ($query) use ($funded_institutions_ids_no) {
                return $query->whereNotIn('funded_institution_id', $funded_institutions_ids_no);
            })->when($is_discount, function ($query) use ($is_discount) {
                return $query->where('discount', '>', 0);
            })->when($delivery, function ($query) use ($delivery) {
                return $query->where('delivery', '!=', "");
            })->when($from_id && $to_id, function ($query) use ($from_id, $to_id) {
                return $query->whereBetween('id', [$from_id, $to_id]);
            })->when($from_recive_date && $to_recive_date, function ($query) use ($from_recive_date, $to_recive_date) {
                return $query->whereHas('expense'
                    , function ($q) use ($from_recive_date, $to_recive_date) {
                        $q->whereBetween('recive_date', [$from_recive_date, $to_recive_date]);
                    });
            })->when($family_project_id, function ($query) use ($family_project_id) {
                return $query->whereHas('expense'
                    , function ($q) use ($family_project_id) {
                        $q->where('family_project_id', $family_project_id);
                    });
            })->when($families_yes, function ($query) use ($families_yes) {
                return $query->whereHas('family'
                    , function ($q) use ($families_yes) {
                        $q->whereIn('id', $families_yes);
                    });
            })->when($families_no, function ($query) use ($families_no) {
                return $query->whereHas('family'
                    , function ($q) use ($families_no) {
                        $q->whereNotIn('id', $families_no);
                    });
            });
            if ($request["coulmn"] == []) {
                $coulmn = ['id', 'full_name', 'code', 'amount', 'months', 'delivery', 'expense', 'operations'];
            }
            
            if ($request['theaction'] == 'print') {
                $the_date = Carbon::now();
                $expense_details = $expense_details->orderBy("expense_details.id", 'desc')->take(500)->get();
                if ($request['thetype'] == 'unv') {
                    $pdf = Pdf::loadView('admin.expense.print_unv', compact('items'));
                    return $pdf->stream("كشف الجامعة $the_date.pdf");
                } elseif ($request['thetype'] == 'ytm') {
                    $pdf = Pdf::loadView('admin.expense.print_ytm', compact('items'));
                    return $pdf->stream("كشف صرفية تعليم ايتام $the_date.pdf");
                } else {
                    $pdf = Pdf::loadView('admin.expense.print_fund', compact('items'));
                    return $pdf->stream("كشف الجهة $the_date.pdf");
                }
            } else {
                $expense_details = $expense_details->orderBy("expense_details.id", 'desc')->paginate(20)
                    ->appends([
                        "funded_institutions_ids_yes" => $funded_institutions_ids_yes, "funded_institutions_ids_no" => $funded_institutions_ids_no,
                        "is_discount" => $is_discount, "delivery" => $delivery, "from_id" => $from_id,
                        "is_discount" => $is_discount, "from_recive_date" => $from_recive_date, "to_recive_date" => $to_recive_date,
                        "families_no" => $families_no, "family_project_id" => $family_project_id, "families_yes" => $families_yes
                        , "coulmn" => $coulmn]);

                return view('admin.expense.show', compact('expense_details', "funded_institutions_ids_yes", "funded_institutions_ids_no",
                    "is_discount", "delivery", "from_id",
                    "is_discount", "from_recive_date", "to_recive_date",
                    "families_no", "family_project_id", "families_yes",
                    "coulmn", 'min_id', 'max_id'));

            }


        } else {
            event(new NewLogCreated('المحاوله للوصول لصرفية غير موجودة برقم : ', $id, 83, 0, null));
            return redirect("/admin/expenses")->with('error', 'الصرفية غير موجودة');
        }
    }

    public function families_in_expense_ajax($id, Request $request)
    {
        $q = $request['q'];

        $expense = Expense::find($id);

        if (!is_null($expense)) {
            $families_ids = $expense->expense_details->pluck('family_id')->toArray();
            return Family::find($families_ids)->whereHas('person'
                , function ($query) use ($q) {
                    $query->whereIn('full_name', $q);
                })
                ->orWhere('code', 'like', '%' . $q . '%')->take(10)->get();
        } else {
            return response()->json([
                'message' => 'الرجاء التاكد من الرابط المطلوب'
            ], 401);
        }


    }

    public function sendSMS(Request $request)
    {
        $ids = explode(",", $request['the_ids']);
        $expense = Expense::find($ids)->first();

        if ($expense) {
            $expense_details = $expense->expense_details()->get();
            foreach ($expense_details as $expense_detail) {
                $family = $expense_detail->family;
                if (!($family->mobile_one) && !($family->mobile_two)) {
                    continue;
                } else {
                    $mobile = $family->mobile_one ?? $family->mobile_two;
                    ltrim($mobile, "0");
                    if (!(strpos($mobile, '+970') !== false)) {
                        $mobile = '+970' . $mobile;
                    }

                    if (strlen($mobile) != 13) {
                        continue;
                    } else {
                        event(new SmsEvent($request['massage'], $mobile));
                    }
                }
            }
            event(new NewLogCreated('تم إبلاغ المستلمين بنجاح', $expense_detail->family->code, 83, 0, null));
            if (request()['the_type']) {
                return response()->json([
                    'message' => 'تم إبلاغ المستلمين بنجاح',
                ], 200);
            } else
                return redirect('admin/expenseDetails')->with('success', 'تم ابلاغ مستلم بنجاح');
        } else {
            event(new NewLogCreated('المحاوله للوصول لصرفية غير موجودة برقم : ', '', 83, 0, null));
            if (request()['the_type']) {
                return response()->json([
                    'message' => 'الرجاء التاكد من الرابط المطلوب'
                ], 401);
            } else
                return redirect("/admin/expenseDetails")->with('error', 'الصرفية غير موجود');
        }
    }

    public function delivery($id)
    {
        $expense = Expense::find($id);

        if ($expense) {
            $expense_details = $expense->expense_details()->get();
            foreach ($expense_details as $expense_detail) {
                $expense_detail->update(['delivery' => '1']);
            }
            event(new NewLogCreated('تسليم جميع كشوفات الصرفية برقم : ', $id, 83, 0, null));
            return redirect("/admin/expenses")->with('success', 'تم تسليم جميع كشوفت الصرفية');
        } else {
            event(new NewLogCreated('المحاوله للوصول لصرفية غير موجودة برقم : ', $id, 83, 0, null));
            return redirect("/admin/expenses")->with('error', 'الصرفية غير موجودة');
        }

    }

    public function show($id)
    {

    }

    public function importIgnoreFile()
    {
        return view('admin.expense.importIgnoreFile');

    }

    public function store_importIgnoreFile(Request $request)

    {
        $testeroor = $this->validate($request, [
            'excel_file' => 'required|mimes:csv,xlsx,xls',
        ]);
        $excel_file = $request["excel_file"];

        // $collection = Excel::toCollection(new IgnorImport, $excel_file);
        $collection = Excel::load($excel_file, 'UTF-8')->get();

      /*  if ($collection->count() > 100) {
            unlink(storage_path("/app/" . $excel_file));
            return back()->with('error', 'لا يمكن رفع ملف أكثر من 100 صف دفعة واحدة')->withInput($request->except(['excel_file']));
        }*/

        $error_string = "";
        $note_string = "";
        $headerRow = $collection->first()->keys()->toArray();
        $faildCollection = collect();
        $faildCollection->push($headerRow);
        $j = 0;
        foreach ($collection->chunk(20) as $collections) {
            set_time_limit(0);
            foreach ($collections as $keys => $vals) {
                set_time_limit(0);
                $output = json_decode('' . $vals, true);
                $valus = array_values($output);
                for ($i = 0; $i < count($headerRow); $i++) {
                    if (!(trim($headerRow[$i])))
                        break;
                    $x = 'index' . $i;
                    $$x = "" . trim($headerRow[$i]) . "";
                }
                if (count($headerRow) != 5) {
                    //error عدد الأعمدة أقل من المتعارف عليه
                    return back()->with('error', 'عدد الأعمدة أقل من التنسيق اللازم')->withInput(session()->getOldInput());
                }


                if (($index0 == "الرقم") &&
                    ($index1 == "الكود") &&
                    ($index2 == "الاسم") &&
                    ($index3 == "تاريخ الإبطال") &&
                    ($index4 == "سبب الإبطال")) {

                    /*if ($j >= 17)
                        break;*/

                    $j++;


                    $his_id = (int)trim($vals["الرقم"]);
                    /**يجب التعليق**/
                    /*  if ($j >= 17)
                          break;*/
                    /*********/
                    foreach($vals as $prop => $val)
                    {
                        unset($vals->{$prop});
                        $vals[trim($prop)] = trim($val);
                    }
                    if (($vals["الرقم"])&&(int)trim($vals["الرقم"]) != 0
                        && (substr(trim($vals['الكود']), 0, 9) === "633.KAP.F" || substr(trim($vals['الكود']), 0, 8) === "YTM.FLS.")
                        && (trim($vals['الاسم'])) && strlen(trim($vals['الاسم'])) > 3
                        && (!(trim($vals['تاريخ الإبطال'])) || \DateTime::createFromFormat('Y-m-d', trim($vals['تاريخ الإبطال'])) !== FALSE)
                        && (!(trim($vals['سبب الإبطال'])) || strlen(trim($vals['سبب الإبطال'])) > 3)
                    ) {

                        $array = explode('.', trim($vals['الكود']));
                        if (count($array) >= 5)
                            $family_code = $array[3];
                        elseif (count($array) == 3)
                            $family_code = $array[0];
                        else {
                            $error_string = $error_string . "<br> الصف رقم $his_id  الكود به غير سليم البنية ";
                            continue;
                        }

                        $full_name = trim($vals['الاسم']);
                        $code = trim($vals['الكود']);
                        if (strpos($vals['الكود'], '-1') !== false) {
                            $code = str_replace("-1", "", $code);
                        }
                        $search_code = $code;
                        $falmils_by_name = Family::whereNull('parent_id')->whereHas('person'
                            , function ($query) use ($vals, $j, $full_name) {
                                $query->where('full_name_tr', $full_name);
                            })->with('person');
                        if (strpos($vals['الكود'], '.M') !== false) {
                            $search_code = str_replace(".M", "", $code);
                        }
                        $falmils_by_code = Family::with('person')
                            ->where(function ($query) use ($code, $search_code) {
                                $query->where('code', $code)
                                    ->orWhere('code', $search_code);
                            })->whereNull('parent_id');
                        $vists_by_name = array_unique(array_filter(Family::whereNotNull('parent_id')->whereHas('person'
                            , function ($query) use ($vals, $j, $full_name) {
                                $query->where('full_name_tr', $full_name);
                            })->pluck('parent_id')->toArray()));
                        $vists_by_code = array_unique(array_filter(Family::with('person')
                            ->where(function ($query) use ($code, $search_code) {
                                $query->where('code', $code)
                                    ->orWhere('code', $search_code);
                            })->whereNotNull('parent_id')->pluck('parent_id')->toArray()));
                        if (/*(count($vists_by_code) > 1 || count($vists_by_name) > 1) ||
                            (count($vists_by_code) > 1 && count($vists_by_name) == 0) ||
                            (count($vists_by_code) == 0 && count($vists_by_name) > 1) ||*/
                            ($falmils_by_name->count() > 1 || $falmils_by_code->count() > 1) ||
                            ($falmils_by_name->count() > 1 && !($falmils_by_code->first())) ||
                            (!($falmils_by_name->first()) && $falmils_by_code->count() > 1)) {// التكرار اذا كان الاسم غير يونيك اوالكود غير يونيك، أو بالاسم غير موجود والكود غير يونيك، أو بالكود غير موجود والاسم غير يوميك
                            $faildCollection->push($valus);
                            $error_string = $error_string . "<br> لم يتم ابطال الصف رقم $his_id  لتكرر اسمه في العائلات، يرجى مراجعة الاستمارة وتعديلها ";

                            continue;
                        }
                        if (strpos(trim($vals['الكود']), 'Ü') !== false) {
                            $code = str_replace("Ü", "U", trim($vals['الكود']));
                        }

                        if ($falmils_by_name->count() == 1) {
                            $family_id = $falmils_by_name->first()->id;
                        } elseif ($falmils_by_code->count() == 1) {
                            $family_id = $falmils_by_code->first()->id;

                        } elseif (count($vists_by_code) == 1) {
                            $family_id = Family::find($vists_by_code[0])->id;


                        } elseif (count($vists_by_name) == 1) {
                            $family_id = Family::find($vists_by_name[0])->id;

                        } else {
                            $faildCollection->push($valus);
                            $error_string = $error_string . "<br> لم يتم إبطال الصف رقم $his_id  لعدم العثور على أسرة بهذا الإسم أو الكود ";

                            continue;
                        }
                        $family = Family::whereHas('person')->find($family_id);

                        if (!is_null($family)) {

                            if ($family->family_classification_id == 4) {
                                $note_string = $note_string . "<br> كانت مبطلة مسبقا في صف  $his_id";
                                continue;
                            }

                            // year + year number visit
                            $currentDate = Carbon::now();
                            $currentYear = $currentDate->year;
                            $familiesYearNumber = Family::whereNotNull('parent_id')->where(['year' => $currentYear])
                                ->get()->sortBy('visit_date');

                            $numberCount = 1;
                            foreach ($familiesYearNumber as $number) {
                                $number->update(['year_number' => $numberCount]);
                                $numberCount++;
                            }

                            $person = $family->person;

                            $family_update = [];
                            $person_update = [];
                            $family_update['family_classification_id'] = 4;
                            $family_update['visit_reason_id'] = 9;
                            $family_update['visit_date'] = Carbon::now();


                            if ($person->full_name_tr != $full_name) {
                                $person_update['full_name_tr'] = $full_name;
                                $note_string = $note_string . "<br> تم تحديث الاسم الكامل للمكفول في صف $his_id ";
                            }
                            if ($family->code != $code) {
                                
                                    $wrong_family= Family::whereNull('parent_id')->where('code',$code)->first();
                                                   if($wrong_family){
                                                       $wrong_family->update(['code'=>null]);
                                                   }
                                
                                $family_update['code'] = $code;
                                $note_string = $note_string . "<br> تم تحديث الكود للمكفول في صف $his_id";
                            }

                            if (!($family->ignore_date) && (trim($vals['تاريخ الإبطال']))) {
                                $family_update['ignore_date'] = trim($vals['تاريخ الإبطال']);
                                $note_string = $note_string . "<br> تم تحديث تاريخ الإبطال للمكفول في صف $his_id";
                            }
                            if (!($family->note) && (trim($vals['سبب الإبطال']))) {
                                $family_update['note'] = trim($vals['سبب الإبطال']);
                                $note_string = $note_string . "<br> تم تحديث سبب الإبطال للمكفول في صف $his_id";
                            }
                            if (count($family_update) > 0)
                                $family->update($family_update);
                            if (count($person_update) > 0)
                                $person->update($person_update);

                            // clone person
                            $newPerson = $person->replicate();
                            $newPerson->save();

                            // clone family
                            $newFamily = $family->replicate();
                            $newFamily->save();

                            // update family clone data
                            $newFamily->update(
                                [
                                    'visit_count' => $family->visit_count,
                                    'approve' => 1,
                                    'archive' => 1,
                                    'parent_id' => $family->id,
                                    'person_id' => $newPerson->id,
                                ]);

                            $updateData = [
                                'archive' => 0,
                                'approve' => 0,
                                'visit_count' => $newFamily->visit_count + 1,
                            ];

                            // update family
                            $family->update($updateData);

                            // clone income
                            if ((isset($family->incomes)) && (!is_null($family->incomes))) {
                                foreach ($family->incomes as $item) {
                                    $newIncome = $item->replicate();
                                    $newIncome->family_id = $newFamily->id;
                                    $newIncome->save();
                                }
                            }

                            // clone members
                            if ((isset($family->members)) && (!is_null($family->members))) {
                                foreach ($family->members as $item) {
                                    $itemPerson = $item->person;
                                    $newMember = $item->replicate();
                                    $newPerson = $itemPerson->replicate();
                                    $newPerson->save();
                                    $newMember->family_id = $newFamily->id;
                                    $newMember->person_id = $newPerson->id;
                                    $newMember->save();
                                }
                            }

                            // clone searcher
                            if ((isset($family->searcher)) && (!is_null($family->searcher))) {
                                foreach ($family->searcher as $item) {
                                    $newSearcher = $item->replicate();
                                    $newSearcher->family_id = $newFamily->id;
                                    $newSearcher->save();
                                }
                            }

                            // clone member diseases
                            if ((isset($family->familyMemberDiseases)) && (!is_null($family->familyMemberDiseases))) {
                                foreach ($family->familyMemberDiseases as $item) {
                                    $newIncome = $item->replicate();
                                    $newIncome->family_id = $newFamily->id;
                                    $newIncome->save();
                                }
                            }
                            //تم تحديث تصنيف الكفيل


                        } else {
                            $error_string = $error_string . "<br> لم يتم ابطال الصف رقم $his_id لخلل برمجي في إيجاد استمارته  ";
                            continue;
                        }

                    } else {
                        $faildCollection->push($valus);
                        $error_string = $error_string . "<br> الصف رقم $his_id  يحمل بيانات غير صحيحة البنية ";

                        continue;
                    }


                } else {

                    //error تنسيق ملف الإكسل غير صحيح (لا يحتوي اسم المشروع او كود المكفول أو اسم المكفول أو الكافل)
                    return back()->with('error', 'تنسيق ملف الإكسل غير صحيح ')->withInput(session()->getOldInput());
                }


            }
            //sleep(5);
        }


        Session()->flash('error_string', $error_string);
        Session()->flash('note_string', $note_string);
        Session()->flash('faildCollection', $faildCollection);

        return redirect('/admin/expenses/');


    }
}
