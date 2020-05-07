<?php

namespace App\Http\Controllers\Admin;

use App\Country;
use App\Events\NewLogCreated;
use App\Events\SmsEvent;
use App\ExpenseDetail;
use App\Export\Expense2Export;
use App\FamilyProject;
use App\FundedInstitution;
use App\Sponsor;
use App\SponsorStatus;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use niklasravnsborg\LaravelPdf\Facades\Pdf;

class ExpenseDetailController extends Controller
{
    public function index(Request $request)
    {

        $is_discount = $request['is_discount'] ?? "";
        $family_project_id = $request["family_project_id"] ?? ""; // علاقة
        $delivery = $request["delivery"] ?? "";
        $funded_institutions_ids_yes = $request["funded_institutions_ids_yes"] ? array_filter($request["funded_institutions_ids_yes"]) : [];
        $funded_institutions_ids_no = $request["funded_institutions_ids_no"] ? array_filter($request["funded_institutions_ids_no"]) : [];
        $families_yes = $request["families_yes"] ? array_filter($request["families_yes"]) : [];
        $families_no = $request["families_no"] ? array_filter($request["families_no"]) : [];
        $min_id = ExpenseDetail::first()->id ?? 1;
        $max_id = ExpenseDetail::orderByDesc('id')->first()->id ?? 1;
        $from_id = $request["from_id"] ?? $min_id;
        $to_id = $request["to_id"] ?? $max_id;
        $from_recive_date = $request["from_recive_date"] ?? ""; // علاقة
        $to_recive_date = $request["to_recive_date"] ?? "";
        $coulmn = $request["coulmn"] ?? "";
        $expense_in = $request['the_ids'] ? array_filter(explode(",", $request['the_ids'])) : [];
        //تغير الكولم بناء على نوع الطباعة

        $expense_details = ExpenseDetail::when($funded_institutions_ids_yes, function ($query) use ($funded_institutions_ids_yes) {
            return $query->whereIn('funded_institution_id', $funded_institutions_ids_yes);
        })->when($expense_in, function ($query) use ($expense_in) {
            return $query->whereIn('expense_id', $expense_in);
        })->when($funded_institutions_ids_no, function ($query) use ($funded_institutions_ids_no) {
            return $query->whereNotIn('funded_institution_id', $funded_institutions_ids_no);
        })->when($is_discount, function ($query) use ($is_discount) {
            return $query->where('discount', '>', 0);
        })->when(($delivery || $delivery == '0'), function ($query) use ($delivery) {
            return $query->where('delivery', $delivery);
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
        if ($request["coulmn"] == "" && ($request->except('the_ids') == null || $request['page'])) {
            $coulmn = ['id', 'full_name', 'code', 'amount','amount_befor', 'months', 'delivery', 'select', 'operations'];
        }
        $funded_institutions = FundedInstitution::orderBy('name')->get();
        $family_projects = FamilyProject::orderBy('name')->get();
        $thetype = $request['thetype'];
        $theaction = $request['theaction'];
        if ($request['theaction'] == 'print') {
            $the_date = Carbon::now();
            if ($request['thetype'] == 'unv') {
                $expens_name = "كشف الجامعة $the_date.pdf";
            } elseif ($request['thetype'] == 'ytm') {
                $expens_name = "كشف صرفية تعليم ايتام$the_date.pdf";
            } else {
                $expens_name = "كشف صرفية الجهات$the_date.pdf";
            }
            $expense_details = $expense_details->orderBy("expense_details.id", 'desc')->take(500)->get();
            if ($expense_details->first()) {

                $pdf = Pdf::loadView('admin.expense.print_all', compact('expense_details', 'thetype', 'theaction'));
                return $pdf->stream($expens_name);
            } else {
                event(new NewLogCreated('المحاوله للوصول لصرفية غير موجودة برقم : ', null, 86, 0, null));
                return redirect("/admin/expenseDetails")->with('error', 'الصرفية غير موجود');
            }

        } elseif ($request['theaction'] == 'excel') {
            $the_date = Carbon::now();

            $expense_details = $expense_details->orderBy("expense_details.id", 'desc')->take(500)->get();
            if ($request['thetype'] == 'unv') {
                $expens_name = "كشف الجامعة $the_date.xlsx";
            } elseif ($request['thetype'] == 'ytm') {
                $expens_name = "كشف صرفية تعليم ايتام$the_date.xlsx";
            } else {
                $expens_name = "كشف صرفية الجهات$the_date.xlsx";
            }
            if ($expense_details->first()) {
                return
                    Excel::create($expens_name, function ($excel) use ($expense_details, $thetype, $theaction) {

                        $excel->sheet('New sheet', function ($sheet) use ($expense_details, $thetype, $theaction) {

                            $sheet->loadView('admin.expense.print_all', [
                                'expense_details' => $expense_details,
                                'thetype' => $thetype,
                                'theaction' => $theaction
                            ]);


                        });

                    })->export('xlsx');
            } else {
                event(new NewLogCreated('المحاوله للوصول لصرفية غير موجودة برقم : ', null, 86, 0, null));
                return redirect("/admin/expenseDetails")->with('error', 'الصرفية غير موجود');
            }
            // return Excel::download(new  Expense2Export($coulmn, $expense_details), $expens_name);

        } else {
            $expense_details = $expense_details->orderBy("expense_details.id", 'desc')->paginate(20)
                ->appends([
                    "funded_institutions_ids_yes" => $funded_institutions_ids_yes, "funded_institutions_ids_no" => $funded_institutions_ids_no,
                    "is_discount" => $is_discount, "delivery" => $delivery, "from_id" => $from_id, "to_id" => $to_id,
                    "is_discount" => $is_discount, "from_recive_date" => $from_recive_date, "to_recive_date" => $to_recive_date,
                    "families_no" => $families_no, "families_yes" => $families_yes, "family_project_id" => $family_project_id,
                    "coulmn" => $coulmn, "the_ids" => $request['the_ids']]);

            return view('admin.expense_detail.index', compact('expense_details', "funded_institutions_ids_yes", "funded_institutions_ids_no",
                "is_discount", "delivery", "from_id", "to_id",
                "is_discount", "from_recive_date", "to_recive_date",
                "families_no", "family_project_id", "families_yes", "expense_in",
                "coulmn", 'min_id', 'max_id', 'funded_institutions', 'family_projects'));

        }


    }

    public function delete($id)
    {
        //
    }

    public function sendSMS(Request $request)
    {


        $ids = explode(",", $request['the_ids']);
        $expense_details = ExpenseDetail::find($ids);

        if ($expense_details && $expense_details->first()) {
            foreach ($expense_details as $expense_detail) {
                $family = $expense_detail->family;
                if (!($family->mobile_one) && !($family->mobile_two)) {
                    continue;
                } else {
                    $mobile =  ($family->mobile_one) && $family->mobile_one>0 ?$family->mobile_one: $family->mobile_two;
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
            event(new NewLogCreated('تم ابلاغ مستلم بنجاح', $expense_detail->family->code, 86, 0, null));
            if (request()['the_type']) {
                return response()->json([
                    'message' => 'تم ابلاغ مستلم بنجاح',
                ], 200);
            } else
                return redirect('admin/expenseDetails')->with('success', 'تم ابلاغ مستلم بنجاح');

        } else {
            event(new NewLogCreated('المحاوله للوصول لصرفية غير موجودة برقم : ', '', 86, 0, null));
            if (request()['the_type']) {
                return response()->json([
                    'message' => 'الرجاء التاكد من الرابط المطلوب'
                ], 401);
            } else
                return redirect("/admin/expenseDetails")->with('error', 'الصرفية غير موجود');
        }
    }


    public function delivery(Request $request)
    {

        $ids = explode(",", $request['the_ids']);
        $expense_details = ExpenseDetail::find($ids);

        if ($expense_details && $expense_details->first()) {
            $html = '';
            if (/*$expense_details->count() != 1*/!(request()['the_type'])) {

                $pdf = Pdf::loadView('admin.expense_detail.print_card', compact('expense_details'));
                return $pdf->stream("كرت الصرفية.pdf");

            } else {


                foreach ($expense_details as $expense_detail) {
                    $temp = !($expense_detail->delivery);
                    $temp_2 = $temp ? 1 : 0;
                    $expense_detail->update(['delivery' => ($temp_2)]);

                }
                event(new NewLogCreated('تم تغيير تسليم الصرفية بنجاح', $expense_detail->id, 86, 0, null));
                return response()->json([
                    'message' => 'تم تغيير تسليم الصرفية بنجاح',
                ], 200);
            }
        } else {
            event(new NewLogCreated('المحاوله للوصول لصرفية غير موجودة برقم : ', '', 86, 0, null));
            if (request()['the_type']) {
                return response()->json([
                    'message' => 'الرجاء التاكد من الرابط المطلوب'
                ], 401);
            } else
                return redirect("/admin/expenseDetails")->with('error', 'الصرفية غير موجود');
        }

    }

    public function sponsor($id, Request $request)
    {
        $expense_detail = ExpenseDetail::find($id);

        if ($expense_detail) {
            $min_id = $expense_detail->sponsors()->first()->id ?? 1;
            $max_id = $expense_detail->sponsors()->orderByDesc('id')->first()->id ?? 1;
            $from_id = $request["from_id"] ?? $min_id;
            $to_id = $request["to_id"] ?? $max_id;
            $families_count = $request["families_count"] ?? "";
            $name = $request["name"] ?? "";
            $code = $request["code"] ?? "";
            $mobile = $request["mobile"] ?? "";
            $sponsor_status_ids = $request["sponsor_status_ids"] ? array_filter($request["sponsor_status_ids"]) : [];
            $country_ids = $request["country_ids"] ? array_filter($request["country_ids"]) : [];
            $families_count = $request["families_count"] ?? "";
            $coulmn = $request["coulmn"] ?? "";

            $sponsors_ids = $expense_detail->sponsors()->when($name, function ($query) use ($name) {
                return $query->where('name', 'like', '%' . $name . '%');
            })->when($families_count, function ($query) {
                return $query->withcount(['expense_details'
                => function ($q) {
                        $q->groupBy('family_id');
                    }]);
            })->when($code, function ($query) use ($code) {
                return $query->where('code', $code);
            })->when($mobile, function ($query) use ($mobile) {
                return $query->where('mobile', $mobile);
            })->when($sponsor_status_ids, function ($query) use ($sponsor_status_ids) {
                return $query->whereIn('sponsor_status_id', $sponsor_status_ids);
            })->when($country_ids, function ($query) use ($country_ids) {
                return $query->whereIn('country_id', $country_ids);
            })->when($from_id && $to_id, function ($query) use ($from_id, $to_id) {
                return $query->whereBetween('sponsors.id', [$from_id, $to_id]);
            })->orderBy("sponsors.id")
                ->select('sponsors.*')
                ->get()
                ->when($families_count, function ($query) use ($families_count) {
                    return $query->where('expense_details_count', $families_count);
                })->pluck("id")->toArray();
            $sponsors = Sponsor::whereIn('id', $sponsors_ids)
                ->withcount('expense_details')
                ->paginate(20)
                ->appends([
                    "name" => $name, "code" => $code, "from_id" => $from_id
                    , "to_id" => $to_id, "mobile" => $mobile, "sponsor_status_ids" => $sponsor_status_ids
                    , "country_ids" => $country_ids, "coulmn" => $coulmn]);

            if ($request["coulmn"] == []) {
                $coulmn = ['id', 'name', 'code', 'country', 'families_count', 'operations', 'select'];
            }

            $sponsor_statuses = SponsorStatus::orderBy('name')->get();
            $countries = Country::orderBy('name')->get();

            return view('admin.expense_detail.sponsors', compact('expense_detail',
                'countries', 'sponsor_statuses',
                'sponsors', 'coulmn', 'from_id', 'to_id', 'max_id', 'min_id',
                'name', 'code', 'mobile', 'country_ids', 'sponsor_status_ids', 'families_count'));
        } else {
            event(new NewLogCreated('المحاوله للوصول لصرفية غير موجودة برقم : ', $id, 86, 0, null));
            return redirect("/admin/expenseDetails")->with('error', 'الصرفية غير موجود');
        }
    }


}
