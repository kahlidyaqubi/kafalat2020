<?php

namespace App\Jobs;

use App\Action;
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
use App\Month;
use App\Person;
use Notification;
use App\Notifications\NotifyUsers;
use App\Sponsor;
use App\User;
use Carbon\Carbon;
use DataTables;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use DB;
use Spatie\Permission\Models\Permission;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class MyJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $myreq;
    public $id;
    //test
    public function __construct($myreq,$id)
    {
        $this->myreq = $myreq;
        $this->id = $id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()

    {
        set_time_limit(0);
        $request=$this->myreq;
        $id=$this->id;



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
                                        array_push($his_months_ids, Month::where('name_en', trim($headerRow[$z]))->first()->id);

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



            $action = Action::create(['title' => 'تم إضافة صرفية جديدة', 'type' => Permission::findByName('list expenses')->title, 'link' => '/admin/expenses/invalidators?session_id='.$the_id]);
            $users = User::whereIn('id', [$id])->get();

            if ($users->first())
                Notification::send($users, new NotifyUsers($action));

        } else {
            return back()->with('error',
                '
           3        يرجى التأكد من إدخال جميع البيانات المطلوبة
                    '
            )->withInput(request()->all);
        }


    }
}
