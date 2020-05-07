<?php

namespace App\Http\Controllers\Admin;

use App\Call;
use App\Country;
use App\Events\NewLogCreated;
use App\ExpenseDetail;
use App\ExpenseDetailSponsor;
use App\Family;
use App\FamilyProject;
use App\FundedInstitution;
use App\Sponsor;
use App\SponsorStatus;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Action;
use Notification;
use App\Notifications\NotifyUsers;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\Facades\DataTables;

class SponsorController extends Controller
{
    public function index(Request $request)
    {
        $min_id = Sponsor::first()->id ?? 1;
        $max_id = Sponsor::orderByDesc('id')->first()->id ?? 1;
        $from_id = $request["from_id"] ?? $min_id;
        $to_id = $request["to_id"] ?? $max_id;
        //$families_count = $request["families_count"] ?? "";
        $name = $request["name"] ?? "";
        $code = $request["code"] ?? "";
        $mobile = $request["mobile"] ?? "";
        $sponsor_status_ids = $request["sponsor_status_ids"] ? array_filter($request["sponsor_status_ids"]) : [];
        $country_ids = $request["country_ids"] ? array_filter($request["country_ids"]) : [];
        $families_count = $request["families_count"] ?? "";
        $coulmn = $request["coulmn"] ?? "";
        $family_id = $request["family_id"] ?? "";

        if ($family_id)
            $sponsors_ids1 = Sponsor::whereIn('id', ExpenseDetailSponsor::whereIn('expense_detail_id', Family::find($family_id)->expense_details()->pluck('id')->toArray())->pluck('sponsor_id')->toArray());
        else
            $sponsors_ids1 = Sponsor::whereRaw(true);

        $sponsors_ids = $sponsors_ids1->when($name, function ($query) use ($name) {
            return $query->where('name', 'like', '%' . $name . '%');
        })/*->when($families_count, function ($query) {
            return $query->withcount(['expense_details'
            => function ($q) {
                    $q->groupBy('family_id');
                }]);
        })*/
        ->when($code, function ($query) use ($code) {
            return $query->where('code', $code);
        })->when($mobile, function ($query) use ($mobile) {
            return $query->where('mobile', $mobile);
        })->when($sponsor_status_ids, function ($query) use ($sponsor_status_ids) {
            return $query->whereIn('sponsor_status_id', $sponsor_status_ids);
        })->when($country_ids, function ($query) use ($country_ids) {
            return $query->whereIn('country_id', $country_ids);
        })->when($from_id && $to_id, function ($query) use ($from_id, $to_id) {
            return $query->whereBetween('id', [$from_id, $to_id]);
        })->orderBy("sponsors.id")
            ->get()
            /* ->when($families_count, function ($query) use ($families_count) {
               return $query->where('expense_details_count', $families_count);
           })*/
            ->pluck("id")->toArray();
        $sponsors = Sponsor::whereIn('id', $sponsors_ids)
            ->withcount('expense_details')
            ->paginate(20)
            ->appends([
                "name" => $name, "code" => $code, "from_id" => $from_id
                , "to_id" => $to_id, "mobile" => $mobile, "sponsor_status_ids" => $sponsor_status_ids
                , "country_ids" => $country_ids, "family_id" => $family_id, "coulmn" => $coulmn]);


        if ($request["coulmn"] == []) {
            $coulmn = ['id', 'name', 'code', 'country', 'families_count', 'operations', 'select'];
        }

        $sponsor_statuses = SponsorStatus::orderBy('name')->get();
        $countries = Country::orderBy('name')->get();

        return view('admin.sponsor.index', compact('countries', 'sponsor_statuses',
            'sponsors', 'coulmn', 'from_id', 'to_id', 'max_id', 'min_id', 'family_id',
            'name', 'code', 'mobile', 'country_ids', 'sponsor_status_ids', 'families_count'));

    }


    public function create()
    {
        //
    }

    public function store(Request $request)
    {

    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $sponsor = Sponsor::find($id);
        $sponsor_statuses = SponsorStatus::orderBy('name')->get();
         $countries = Country::whereNotNull('code')->orderBy('name')->get();
        if ($sponsor) {
            return view('admin.sponsor.edit', compact('sponsor', 'sponsor_statuses', 'countries'));
        } else {
            event(new NewLogCreated('المحاوله للوصول لكافل غير موجود برقم : ', $id, 90, 0, null));
            return redirect("/admin/sponsors")->with('error', 'الكافل غير موجود');
        }
    }

    public function update(Request $request, $id)
    {
        $sponsor = Sponsor::find($id);
        if ($sponsor) {
            $sponsor->update($request->all());
            event(new NewLogCreated('تم تعديل كافل بنجاح ', $sponsor->code, 90, 0, null));


            $action = Action::create(['title' => 'تم تعديل كافل', 'type' => Permission::findByName('list sponsors')->title, 'link' => Permission::findByName('list sponsors')->link]);
            $users = User::permission('sponsors')->whereNotIn('id', [auth()->user()->id])->get();
            if ($users->first())
                Notification::send($users, new NotifyUsers($action));

            return redirect('admin/sponsors')->with('success', 'تم تعديل كافل بنجاح');

        } else {
            event(new NewLogCreated('المحاوله للوصول لكافل غير موجود برقم : ', $id, 90, 0, null));
            return redirect("/admin/sponsors")->with('error', 'الكافل غير موجود');
        }
    }

    public function delete($id)
    {
        $sponsor = Sponsor::find($id);

        if ($sponsor) {
            if (!$sponsor->expense_detail_sponsors->first()) {
                $calls = $sponsor->calls()->pluck('id')->toArray();
                if (count($calls) > 0) {
                    Call::destroy($calls);
                }
                $sponsor->delete();
                event(new NewLogCreated('تم حذف كافل بنجاج', $sponsor->code, 91, 0, null));


                $action = Action::create(['title' => 'تم حذف كافل', 'type' => Permission::findByName('list sponsors')->title, 'link' => Permission::findByName('list sponsors')->link]);
                $users = User::permission('sponsors')->whereNotIn('id', [auth()->user()->id])->get();
                if ($users->first())
                    Notification::send($users, new NotifyUsers($action));
                return redirect('admin/sponsors')->with('success', 'تم حذف كافل بنجاح');

            } else {
                event(new NewLogCreated('لا يمكن حذف كافل مرتبط بصرفيات ومكفولين : ', $sponsor->code, 91, 0, null));
                return redirect("/admin/sponsors")->with('error', 'لا يمكن حذف كافل مرتبط بصرفيات ومكفولين');

            }
        } else {
            event(new NewLogCreated('المحاوله للوصول لكافل غير موجود برقم : ', $id, 91, 0, null));
            return redirect("/admin/sponsors")->with('error', 'الكافل غير موجود');
        }

        //expense_detail_sponsors
    }

    public function delete_group(Request $request)
    {
        $ids = explode(",", $request['the_ids']);
        $sponsors = Sponsor::find($ids);
        if ($sponsors && $sponsors->first()) {
            DB::beginTransaction();
            foreach ($sponsors as $sponsor) {
                if (!$sponsor->expense_detail_sponsors->first()) {
                    $calls = $sponsor->calls()->pluck('id')->toArray();
                    if (count($calls) > 0) {
                        Call::destroy($calls);
                    }
                    $sponsor->delete();

                } else {
                    DB::rollback();
                    event(new NewLogCreated('لم تتم عملية الحذف لأن بعض الكفلاء مرتبطين بصرفيات: ', $sponsor->code, 91, 0, null));
                    return redirect("/admin/sponsors")->with('error', 'لم تتم عملية الحذف لأن بعض الكفلاء مرتبطين بصرفيات:');

                }

            }
            DB::commit();
        } else {
            return redirect("/admin/sponsors")->with('error', 'لم يتم تحديد أي عنصر لحذفه')->withInput();
        }
        event(new NewLogCreated('تم حذف كافلاء باتصالاتهم بنجاج', null, 91, 0, null));
        return redirect('admin/sponsors')->with('success', 'تم حذف كافلاء باتصالاتهم بنجاح');

    }

    public function expenseLog($id, Request $request)
    {
        $sponsor = Sponsor::find($id);

        if ($sponsor) {
            $is_discount = $request['is_discount'];
            $family_project_id = $request["family_project_id"] ?? ""; // علاقة
            $delivery = $request["delivery"] ?? "";
            $funded_institutions_ids_yes = $request["funded_institutions_ids_yes"] ? array_filter($request["funded_institutions_ids_yes"]) : [];
            $funded_institutions_ids_no = $request["funded_institutions_ids_no"] ? array_filter($request["funded_institutions_ids_no"]) : [];
            $families_yes = $request["families_yes"] ? array_filter($request["families_yes"]) : [];
            $families_no = $request["families_no"] ? array_filter($request["families_no"]) : [];
            $min_id = $sponsor->expense_details()->first()->id ?? 1;
            $max_id = $sponsor->expense_details()->orderByDesc('id')->first()->id ?? 1;
            $from_id = $request["from_id"] ?? $min_id;
            $to_id = $request["to_id"] ?? $max_id;
            $from_recive_date = $request["from_recive_date"] ?? ""; // علاقة
            $to_recive_date = $request["to_recive_date"] ?? "";
            $coulmn = $request["coulmn"] ?? "";
            $expense_in = $request['the_ids'] ? array_filter(explode(",", $request['the_ids'])) : [];
            //تغير الكولم بناء على نوع الطباعة
            $expense_details = $sponsor->expense_details()->when($funded_institutions_ids_yes, function ($query) use ($funded_institutions_ids_yes) {
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
                return $query->whereBetween('expense_details.id', [$from_id, $to_id]);
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
                $coulmn = ['id', 'full_name', 'code', 'amount', 'months', 'delivery', 'select'];
            }
            $funded_institutions = FundedInstitution::orderBy('name')->get();
            $family_projects = FamilyProject::orderBy('name')->get();
            $expense_details = $expense_details->orderBy("expense_details.id", 'desc')->paginate(20)
                ->appends([
                    "funded_institutions_ids_yes" => $funded_institutions_ids_yes, "funded_institutions_ids_no" => $funded_institutions_ids_no,
                    "is_discount" => $is_discount, "delivery" => $delivery, "from_id" => $from_id, "to_id" => $to_id,
                    "is_discount" => $is_discount, "from_recive_date" => $from_recive_date, "to_recive_date" => $to_recive_date,
                    "families_no" => $families_no, "families_yes" => $families_yes, "family_project_id" => $family_project_id,
                    "coulmn" => $coulmn, "expense_in" => $expense_in]);

            return view('admin.sponsor.expense_details', compact('sponsor', 'expense_details', "funded_institutions_ids_yes", "funded_institutions_ids_no",
                "is_discount", "delivery", "from_id", "to_id",
                "is_discount", "from_recive_date", "to_recive_date",
                "families_no", "family_project_id", "families_yes", "expense_in",
                "coulmn", 'min_id', 'max_id', 'funded_institutions', 'family_projects'));

        } else {
            event(new NewLogCreated('المحاوله للوصول لكافل غير موجودة برقم : ', $id, 90, 0, null));
            return redirect("/admin/sponsors")->with('error', 'الكافل غير موجود');
        }
    }

    public function callLog($id, Request $request)
    {
        $sponsor = Sponsor::find($id);

        if ($sponsor) {
            $calls = $sponsor->calls();
            $reason = $request["reason"] ?? "";
            $min_id = $calls->first()->id ?? 1;
            $max_id = $calls->orderByDesc('id')->first()->id ?? 1;
            $from_id = $request["from_id"] ?? $min_id;
            $to_id = $request["to_id"] ?? $max_id;
            $status = $request["status"] ?? "";
            $family_ids = $request["family_ids"] ? array_filter($request["family_ids"]) : [];
            $sponsor_ids = $request["sponsor_ids"] ? array_filter($request["sponsor_ids"]) : [];
            $coulmn = $request["coulmn"] ?? "";
            $from_date = $request["from_date"] ?? "";
            $to_date = $request["to_date"] ?? "";


            $calls = $calls->when($family_ids, function ($query) use ($family_ids) {
                return $query->whereIn('family_id', $family_ids);
            })->when($reason, function ($query) use ($reason) {
                return $query->where('reason', $reason);
            })->when($sponsor_ids, function ($query) use ($sponsor_ids) {
                return $query->where('sponsor_id', $sponsor_ids);
            })->when(($status || $status == '0'), function ($query) use ($status) {
                return $query->where('status', $status);
            })->when($from_id && $to_id, function ($query) use ($from_id, $to_id) {
                return $query->whereBetween('id', [$from_id, $to_id]);
            })->when($from_date && $to_date, function ($query) use ($from_date, $to_date) {
                return $query->whereBetween('his_date', [$from_date, $to_date]);
            })->orderBy("calls.id", 'desc')->paginate(20)
                ->appends(["from_id" => $from_id, "to_id" => $to_id, "coulmn" => $coulmn
                    , "status" => $status, "family_ids" => $family_ids
                    , "sponsor_ids" => $sponsor_ids
                    , "from_date" => $from_date
                    , "to_date" => $to_date]);

            if ($request["coulmn"] == []) {
                $coulmn = ['id', 'family', 'sponsor', 'status', 'his_date', 'operations'];
            }

            return view('admin.sponsor.calls', compact('sponsor',
                'calls', 'status', 'sponsor_ids',
                'coulmn', 'from_id', 'to_id', 'family_ids',
                'from_date', 'to_date', 'min_id', 'max_id', 'reason'));
        } else {
            event(new NewLogCreated('المحاوله للوصول لكافل غير موجود برقم : ', $id, 90, 0, null));
            return redirect("/admin/sponsors")->with('error', 'الكافل غير موجود');
        }
    }

    public function sponsors_ajax(Request $request)
    {
        $q = $request['q'];
        $sponsors = Sponsor::where('name', 'like', '%' . $q . '%')
            ->orWhere('code', 'like', '%' . $q . '%')
            ->select([
                'id',
                DB::raw("CONCAT(COALESCE(`name`,''), ' - ',COALESCE(`code`,'')) as text")
            ]);
        if ($sponsors->first())
            return json_encode($sponsors->take(10)->get());
        else {
            return ['q' => $q];
        }
    }

    public function sponsors_ajax_id(Request $request)
    {
        $q = $request['q'];
        $sponsors = Sponsor::where('id', $q);
        if ($sponsors->first())
            return $sponsors->with('country')->first();
        else {
            return ['q' => $q];
        }
    }

    public function familyLog($id)
    {
        $sponsor = Sponsor::find($id);

        if ($sponsor) {
            return view('admin.sponsor.familyLog', compact('sponsor'));
        } else {
            event(new NewLogCreated('المحاوله للوصول لكافل غير موجود برقم : ', $id, 91, 0, null));
            return redirect("/admin/sponsors")->with('error', 'الكافل غير موجود');
        }


    }

    public function familyLogData($id)
    {
        $sponsor = Sponsor::find($id);
        if ($sponsor) {
            $families = Family::whereIn('id', ExpenseDetail::whereIn('id', ExpenseDetailSponsor::where('sponsor_id', $id)->pluck('expense_detail_id')->toArray())->pluck('family_id')->toArray())
                ->with(['person', 'house_ownership', 'person.qualification', 'breadwinner', 'person.social_status', 'job_type', 'educational_institution', 'status', 'searcher', 'fundedInstitution', 'project', 'classification'])
                ->where(['parent_id' => null])
                ->where(['hidden' => 0])
                //->whereIn('year', ['2019'])
                ->get();

            return DataTables::of($families)
                ->addColumn('id', function ($value) {
                    return $value->id;
                })->addColumn('name', function ($value) {

                    $person = $value->person;
                    return !is_null($person->first_name && $person->second_name && $person->third_name && $person->family_name) ? $person->first_name . ' ' . $person->second_name . ' ' . $person->third_name . ' ' . $person->family_name : '-';
                })->editColumn('image', function ($value) {
                    $path = '../../../assets/images/users/2.jpg';

                    $images = isset($value->media) ? $value->media : null;
                    if (!is_null($images)) {
                        foreach ($images as $image) {
                            if ($image->file_type_id == 2) {
                                $path = asset('uploads/attachments/' . $image->path);
                            }
                        }
                    }

                    return "<image width='50px' height='50px' src='$path'/>";

                })->addColumn('code', function ($value) {
                    return !is_null($value->code) ? $value->code : '-';
                })->addColumn('id_number', function ($value) {
                    $person = $value->person;
                    return !is_null($person->id_number) ? $person->id_number : '-';
                })->addColumn('family_type', function ($value) {
                    return isset($value->type) ? $value->type->name : '-';
                })->addColumn('house', function ($value) {
                    return isset($value->house_ownership) ? $value->house_ownership->name : '-';
                })->addColumn('member_count', function ($value) {
                    $members = isset($value->members) ? $value->members : null;
                    return !is_null($members) ? count($members) : 0;
                })->addColumn('qualification', function ($value) {
                    $person = $value->person;
                    return isset($person->qualification) ? $person->qualification->name : '-';
                })->addColumn('work', function ($value) {
                    $person = $value->person;
                    return !is_null($person) ? $person->work == 0 ? 'لا يعمل ' : 'يعمل' : '-';
                })->addColumn('social_status', function ($value) {
                    $person = $value->person;
                    return isset($person->social_status) ? $person->social_status->name : '-';
                })->addColumn('health_status', function ($value) {
                    $person = $value->person;
                    return !is_null($person) ? $person->health_status == 0 ? 'سليم' : 'مريض' : '-';
                })->addColumn('breadwinner', function ($value) {
                    return isset($value->breadwinner) ? $value->breadwinner->name : '-';
                })->addColumn('income_value', function ($value) {
                    return !is_null($value->income_value) ? $value->income_value : '-';
                })->addColumn('job_type', function ($value) {
                    return isset($value->job_type) ? $value->job_type->name : '-';
                })->addColumn('need', function ($value) {
                    return !is_null($value->need) ? $value->need == 0 ? 'يحتاج' : 'لا يحتاج' : '-';
                })->addColumn('hour_price', function ($value) {
                    return !is_null($value->study_hour_price) ? $value->study_hour_price : '-';
                })->addColumn('educational_institution', function ($value) {
                    return isset($value->educational_institution) ? $value->educational_institution->name : '-';
                })->addColumn('visit_reason', function ($value) {
                    return isset($value->visit_reason) ? $value->visit_reason->name : '-';
                })->addColumn('status', function ($value) {
                    return isset($value->status) ? $value->status->name : '-';
                })->addColumn('visit_count', function ($value) {
                    $count = null;
                    if ($value->visit_count == 1) {
                        $count = 1;
                    } else if ($value->visit_count > 1) {
                        $count = $value->visit_count - 1;
                    } else {
                        $count = $value->visit_count;
                    }
                    return $count;
                })->addColumn('searcher', function ($value) {

                    $arrayData = [];
                    if ((isset($value->searcher)) && (!is_null($value->searcher))) {
                        foreach ($value->searcher as $item) {
                            if ((isset($item->searcher)) && (!is_null($item->searcher))) {
                                array_push($arrayData, $item->searcher->full_name);
                            }
                        }
                    }
                    return implode(" | ", $arrayData);

                })->addColumn('translation', function ($value) {
                    $person = $value->person;
                    return !is_null($person->full_name_tr) ? 'مترجمة' : 'غير مترجمة';
                })->addColumn('funded_institution', function ($value) {
                    return isset($value->fundedInstitution) ? $value->fundedInstitution->name : '-';
                })->addColumn('project', function ($value) {
                    return isset($value->project) ? $value->project->name : '-';
                })->addColumn('classification', function ($value) {
                    return isset($value->classification) ? $value->classification->name : '-';
                })->addColumn('visit_year', function ($value) {
                    $split = null;
                    $year = null;
                    if (!is_null($value->visit_date)) {
                        $date = str_replace('.', '/', $value->visit_date);
                        $split = explode('/', $date);
                        $year = $split[0];
                    }
                    return $year;
                })->addColumn('visit_month', function ($value) {
                    $split = null;
                    $month = null;
                    if (!is_null($value->visit_date)) {
                        $date = str_replace('.', '/', $value->visit_date);
                        $split = explode('/', $date);
                        if (count($split) > 1) {
                            $month = $split[1];
                        }
                    }
                    return $month;
                })->addColumn('visit_day', function ($value) {
                    $split = null;
                    $day = null;
                    if (!is_null($value->visit_date)) {
                        $date = str_replace('.', '/', $value->visit_date);
                        $split = explode('/', $date);
                        if (count($split) > 1) {
                            $split2 = explode(' ', $split[2]);
                            $day = $split2[0];
                        }
                    }
                    return $day;
                })->addColumn('visit_date', function ($value) {
                    return !is_null($value->visit_date) ? str_replace('.', '/', $value->visit_date) : '-';
                })->addColumn('sent', function ($value) {
                    return $value->is_sent == 1 ? 'تم الإرسال' : 'ليست قيد الإرسال';
                })->addColumn('complete', function ($value) {
                    if ((!is_null($value->note)) &&
                        ((isset($value->visit_reason)) && (!is_null($value->visit_reason))) &&
                        ((isset($value->searcher)) && (!is_null($value->searcher))) &&
                        (!is_null($value->need)) &&
                        ((isset($value->type)) && (!is_null($value->type))) &&
                        ((isset($value->project)) && (!is_null($value->project))) &&
                        ((isset($value->status)) && (!is_null($value->status))) &&
                        ((isset($value->city)) && (!is_null($value->city))) &&
                        ((isset($value->neighborhood)) && (!is_null($value->neighborhood))) &&
                        ((isset($value->person)) && (!is_null($value->person)) && (!is_null($value->person->id_number))) &&
                        (!is_null($value->address)) &&
                        (!is_null($value->total_income_value)) &&
                        (!is_null($value->code)) &&
                        ((isset($value->person)) && (!is_null($value->person)) && (!is_null($value->person->family_name_tr)))
                        (!is_null($value->note)) &&
                        (!is_null($value->note_turkey)) &&
                        (!is_null($value->mobile_one)) &&
                        (!is_null($value->mobile_two)) &&
                        (!is_null($value->telephone)) &&
                        (!is_null($value->id_university)) &&
                        ((isset($value->job_type)) && (!is_null($value->job_type))) &&
                        ((!is_null($value->visit_date))) &&
                        ((isset($value->person)) && (!is_null($value->person)) && (!is_null($value->person->age))) &&
                        ((isset($value->person)) && (!is_null($value->person)) && (!is_null($value->person->health))) &&
                        ((isset($value->person)) && (!is_null($value->person)) && (isset($value->person->qualification)) && (!is_null($value->person->qualification)))
                        ((isset($value->members)) && (count($value->members) > 0))
                    ) {
                        return 'غير منقوصة';

                    }
                    return 'منقوصة';
                })->addColumn('note_turkey', function ($value) {
                    return !is_null($value->note_turkey) ? 'تم التقييم' : 'لم يتم التقييم';
                })
                ->addColumn('disease', function ($value) {
                    $arrayData = [];
                    if ((isset($value->familyMemberDiseases)) && (!is_null($value->familyMemberDiseases))) {
                        foreach ($value->familyMemberDiseases as $item) {
                            if ((isset($item->disease)) && (!is_null($item->disease))) {
                                array_push($arrayData, $item->disease->name);
                            }
                        }
                    }
                    return implode(" | ", $arrayData);
//
                })->editColumn('actions', function ($value) {
                    $exportType = $value->family_project_id == 2 ? 'ytm' : 'visit';

                    $archiveUrl = url('admin/families/archive/' . $value->id);
                    $addMemberUrl = url('admin/families/addMember/' . $value->id);
                    $updateUrl = url('admin/families/' . $value->id . '/edit');
                    $mediaUrl = url('admin/families/' . $value->id . '/addMedia');
                    $exportTurkeyUrl = url('admin/families/export/word/' . $exportType . '/' . $value->id);
                    $exportExcelUrl = url('admin/families/export/excel/' . $exportType . '/' . $value->id);
                    $exportPDFUrl = url('admin/families/export/pdf/' . $exportType . '/' . $value->id);
                    $deleteUrl = url('admin/families/delete/' . $value->id);


                    return "<div class='dropdown dropdown-inline'>
                                            <button type='button'
                                                    class='btn btn-success btn-hover-success btn-elevate-hover btn-icon btn-sm btn-icon-md btn-circle'
                                                    data-toggle='dropdown' aria-haspopup='true'
                                                    aria-expanded='false'>
                                                <i class='la la-cog'></i>
                                            </button>
                                            <div class='dropdown-menu dropdown-menu-right'>
                                                                                                 
                                                    <a class='dropdown-item' href='" . url('admin/season_coupons?families_yes[]=' . $value->id) . "'><i
                                                    class='fa fa-edit'></i>المساعدات الموسمية</a>
                                                    <a class='dropdown-item' href='" . url('admin/urgent_coupons?families_yes[]=' . $value->id) . "'><i
                                                    class='fa fa-edit'></i>المساعدات الطارئة</a>
                                                    <a class='dropdown-item' href='" . url('admin/expenseDetails?families_yes[]=' . $value->id) . "'><i
                                                    class='fa fa-edit'></i>الصرفيات</a>
                                                    <a class='dropdown-item' href='" . url('admin/sponsors?family_id=' . $value->id) . "'><i
                                                    class='fa fa-edit'></i>الكفلاء</a>
                                                    <a class='dropdown-item' href='" . url('admin/calls?family_ids[]=' . $value->id) . "'><i
                                                    class='fa fa-edit'></i>الاتصالات</a>
                                            </div>
                                        </div>
                                   ";
                })->rawColumns(['actions', 'image'])->make(true);


        } else {
            event(new NewLogCreated('المحاوله للوصول لكافل غير موجود برقم : ', $id, 91, 0, null));
            return redirect("/admin/sponsors")->with('error', 'الكافل غير موجود');
        }
    }

    public function checkStatus($id)
    {
        //
    }

}
