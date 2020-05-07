<?php

namespace App\Http\Controllers\Admin;

use App\Events\NewLogCreated;
use App\Http\Requests\SeasonRequest;
use App\Project;
use App\Season;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Action;
use Illuminate\Validation\Rule;
use Notification;
use App\Notifications\NotifyUsers;
use Spatie\Permission\Models\Permission;

class SeasonController extends Controller
{
    public function index(Request $request)
    {
        $min_id = Season::first()->id ?? 1;
        $max_id = Season::orderByDesc('id')->first()->id ?? 1;
        $from_id = $request["from_id"] ?? $min_id;
        $to_id = $request["to_id"] ?? $max_id;
        $from_start_date = $request['from_start_date'] ?? "";
        $to_start_date = $request['to_start_date'] ?? "";
        $status = $request["status"] ?? "";
        $project_ids = $request["project_ids"] ? array_filter($request["project_ids"]) : [];

        $seasons = Season::when($from_start_date && $to_start_date, function ($query) use ($to_start_date, $from_start_date) {
            return $query->whereBetween('start_date', [$from_start_date . "-1", $to_start_date . "-2"]);
        })->when($project_ids, function ($query) use ($project_ids) {
            return $query->whereIn('project_id', $project_ids);
        })->when(($status || $status == '0'), function ($query) use ($status) {
            return $query->where('status', $status);
        })->when($from_id && $to_id, function ($query) use ($from_id, $to_id) {
            return $query->whereBetween('id', [$from_id, $to_id]);
        })->orderBy("seasons.id",'desc')->paginate(20)
            ->appends([
                "from_start_date" => $from_start_date,
                "to_start_date" => $to_start_date, "from_id" => $from_id, "to_id" => $to_id,
                'project_id' => $project_ids]);

        $projects = Project::orderBy('name')->get();

        return view('admin.season.index', compact('seasons', 'projects', 'from_id', 'to_id',
            'from_start_date', 'to_start_date', 'project_ids', 'max_id', 'min_id'
        ));

    }

    public function create()
    {
        $projects = Project::orderBy('name')->get();
        return view('admin.season.create', compact('projects'));
    }

    public function store(SeasonRequest $request)
    {
        request()['start_date'] = request()['start_date'] . "-01";

        $testeroor = $this->validate($request, [


            'start_date' => Rule::unique('seasons')->where(function ($query) {
                return $query->where('start_date', request()->start_date)
                    ->where('project_id', request()->project_id);
            })
        ]);

        $season = Season::create(request()->all());


        event(new NewLogCreated('تم انشاء موسم بنجاح', $season->name, 153, 0, null));
        $action = Action::create(['title' => 'تم إضافة موسم جديد', 'type' => Permission::findByName('list seasons')->title, 'link' => Permission::findByName('list seasons')->link]);
        $users = User::permission('seasons')->whereNotIn('id', [auth()->user()->id])->get();
        if ($users->first())
            Notification::send($users, new NotifyUsers($action));
        return back()->with('success', 'تم انشاء موسم بنجاح');

    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $season = Season::find($id);

        if (!is_null($season)) {
            $projects = Project::orderBy('name')->get();
            return view('admin.season.edit', compact('season', 'projects'));

        } else {
            event(new NewLogCreated('المحاولة للوصول لموسم غير موجود برقم : ', $id, 154, 1, null));
            return redirect("/admin/seasons")->with('error', 'الموسم غير موجود');
        }
    }

    public function update(SeasonRequest $request, $id)
    {
        $season = Season::find($id);
        request()['start_date'] = request()['start_date'] . "-01";
        if (!is_null($season)) {
            $testeroor = $this->validate($request, [
                'start_date' => Rule::unique('seasons')->where(function ($query) use ($id) {
                    return $query->where('start_date', request()->start_date)->where('id', '!=', $id)
                        ->where('project_id', request()->project_id);
                })

            ]);

            $season->update(request()->all());

            event(new NewLogCreated('تعديل البيانات بنجاح', $season->name, 154, 1, null));
            $action = Action::create(['title' => 'تم تعديل موسم', 'type' => Permission::findByName('list seasons')->title, 'link' => Permission::findByName('list seasons')->link]);
            $users = User::permission('seasons')->whereNotIn('id', [auth()->user()->id])->get();
            if ($users->first())
                Notification::send($users, new NotifyUsers($action));
            return redirect("/admin/seasons")->with('success', 'تم تعديل البيانات بنجاح');

        } else {
            event(new NewLogCreated('المحاولة للوصول لموسم غير موجود برقم : ', $id, 154, 1, null));
            return redirect("/admin/seasons")->with('error', 'الموسم غير موجود');
        }
    }

    public function destroy($id)
    {
        //
    }

    public function delete($id)
    {
        $season = Season::find($id);

        if (!is_null($season)) {
            if ($season->season_coupons->first()) {
                event(new NewLogCreated('لا يمكن حذف موسم مرتبط بمساعدات : ', $id, 155, 1, null));
                return redirect("/admin/seasons")->with('error', 'لا يمكن حذف موسم مرتبط بمساعدات');
            }
            $season->delete();
            event(new NewLogCreated('حذف موسم بنجاح', $season->name, 155, 1, null));
            $action = Action::create(['title' => 'تم حذف موسم', 'type' => Permission::findByName('list seasons')->title, 'link' => Permission::findByName('list seasons')->link]);
            $users = User::permission('seasons')->whereNotIn('id', [auth()->user()->id])->get();
            if ($users->first())
                Notification::send($users, new NotifyUsers($action));
            return redirect("/admin/seasons")->with('success', 'تم حذف موسم بنجاح');

        } else {
            event(new NewLogCreated('المحاولة للوصول لموسم غير موجود برقم : ', $id, 155, 1, null));
            return redirect("/admin/seasons")->with('error', 'الموسم غير موجود');
        }
    }

    public function season_coupons($id, Request $request)
    {
        $season = Season::find($id);

        if (!is_null($season)) {

            $institutions_ids_yes = $request['institutions_ids_yes'];
            $institutions_ids_no = $request['institutions_ids_no'];
            $delivery_status = $request["delivery_status"] ?? "";
            $min_id = $season->season_coupons->first()->id ?? 1;
            $max_id = $season->season_coupons->orderByDesc('id')->first()->id ?? 1;
            $from_id = $request["from_id"] ?? $min_id;
            $to_id = $request["to_id"] ?? $max_id;
            $from_delivery_date = $request["from_delivery_date"] ?? "";
            $to_delivery_date = $request["to_delivery_date"] ?? "";
            $from_application_date = $request["from_application_date"] ?? "";
            $to_application_date = $request["to_application_date"] ?? "";
            $from_execution_date = $request["from_execution_date"] ?? "";
            $to_execution_date = $request["to_execution_date"] ?? "";
            $families_yes = $request['families_yes'];  // علاقة
            $families_no = $request['families_no'];  // علاقة
            $delivery_place = $request['delivery_place'];
            $admin_status_ids = $request['admin_status_ids'];
            $season_ids = $request['season_ids'];
            $project_id = $request['project_id'];
            $family_or_institution = $request['family_or_institution'];
            $coulmn = $request["coulmn"] ?? "";

            $season_coupons = $season->season_coupons->when($institutions_ids_yes, function ($query) use ($institutions_ids_yes) {
                return $query->whereIn('institution_id', $institutions_ids_yes);
            })->when($institutions_ids_no, function ($query) use ($institutions_ids_no) {
                return $query->whereNotIn('institution_id', $institutions_ids_no);
            })->when($delivery_place, function ($query) use ($delivery_place) {
                return $query->where('delivery_place', $delivery_place);
            })->when($admin_status_ids, function ($query) use ($admin_status_ids) {
                return $query->whereIn('admin_status_id', $admin_status_ids);
            })->when($season_ids, function ($query) use ($season_ids) {
                return $query->whereIn('season_id', $season_ids);
            })->when(($project_id) && !($season_ids), function ($query) use ($project_id) {
                $seasons_ids = Season::where('project_id', $project_id)->pluck('id')->toArray();
                return $query->whereIn('season_id', $seasons_ids);
            })->when($family_or_institution, function ($query) use ($family_or_institution) {
                if ($family_or_institution == 2)
                    return $query->where('institution_id', '>', 0);
                elseif ($family_or_institution == 1)
                    return $query->where('family_id', '>', 0);
            })->when(($delivery_status || $delivery_status == '0'), function ($query) use ($delivery_status) {
                return $query->where('delivery_status', $delivery_status);
            })->when($from_id && $to_id, function ($query) use ($from_id, $to_id) {
                return $query->whereBetween('id', [$from_id, $to_id]);
            })->when($from_delivery_date && $to_delivery_date, function ($query) use ($from_delivery_date, $to_delivery_date) {
                return $query->whereHas('expense'
                    , function ($q) use ($from_delivery_date, $to_delivery_date) {
                        $q->whereBetween('delivery_date', [$from_delivery_date, $to_delivery_date]);
                    });
            })->when($from_execution_date && $to_execution_date, function ($query) use ($from_execution_date, $to_execution_date) {
                return $query->whereHas('expense'
                    , function ($q) use ($from_execution_date, $to_execution_date) {
                        $q->whereBetween('execution_date', [$from_execution_date, $to_execution_date]);
                    });
            })->when($from_application_date && $to_application_date, function ($query) use ($from_application_date, $to_application_date) {
                return $query->whereHas('expense'
                    , function ($q) use ($from_application_date, $to_application_date) {
                        $q->whereBetween('application_date', [$from_application_date, $to_application_date]);
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
                $coulmn = ['id', 'family_or_institution', 'coupon_type', 'execution_date', 'execution_date', 'application_date', 'delivery_status', 'operations'];
            }

            $admin_statuses = AdminStatuse::orderBy('name')->get();
            $institutions = Institution::orderBy('name')->get();
            if ($request['theaction'] == 'print') {
                $the_date = Carbon::now();
                $season_coupons = $season_coupons->orderBy("season_coupons.id", 'desc')->get();
                $pdf = Pdf::loadView('admin.season_coupon.print_all', compact('season_coupons'));
                return $pdf->stream("المساعدات $the_date.pdf");
            } elseif ($request['theaction'] == 'excel') {
                $the_date = Carbon::now();
                $season_coupons = $season_coupons->orderBy("season_coupons.id", 'desc')->get();
                return Excel::download(new  SeasonCouponExport($coulmn, $season_coupons), "المساعدات $the_date.xlsx");

            } else {
                $season_coupons = $season_coupons->orderBy("season_coupons.id",'desc')->paginate(20)
                    ->appends([
                        "institutions_ids_yes" => $institutions_ids_yes, "institutions_ids_no" => $institutions_ids_no, "delivery_status" => $delivery_status,
                        "from_id" => $from_id, "to_id" => $to_id, "from_execution_date" => $from_execution_date, "to_execution_date" => $to_execution_date,
                        "from_execution_date" => $from_execution_date, "to_execution_date" => $to_execution_date, "from_application_date" => $from_application_date, "to_application_date" => $to_application_date,
                        "families_no" => $families_no, "families_yes" => $families_yes, "coulmn" => $coulmn,
                        "family_or_institution" => $family_or_institution, "delivery_place" => $delivery_place, "admin_status_ids" => $admin_status_ids, "delivery_place" => $delivery_place,
                        'season_ids' => $season_ids, 'project_id' => $project_id
                    ]);

                return view('admin.season.season_coupons', compact('season_coupons', "institutions_ids_yes", "institutions_ids_no", "delivery_status",
                    "from_id", "to_id", "from_delivery_date", "to_delivery_date", "from_execution_date", "to_execution_date", "from_application_date", "to_application_date", "families_no", "families_yes", "coulmn", 'min_id', 'max_id',
                    "family_or_institution", "admin_status_ids", "delivery_place"
                    , "admin_statuses", "institutions",
                    'season_ids', 'project_id', 'season'
                ));

            }


        } else {
            event(new NewLogCreated('المحاولة للوصول لموسم غير موجود برقم : ', $id, 155, 1, null));
            return redirect("/admin/seasons")->with('error', 'الموسم غير موجود');
        }
    }
}
