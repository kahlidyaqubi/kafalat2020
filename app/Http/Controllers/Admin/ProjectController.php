<?php

namespace App\Http\Controllers\Admin;

use App\Events\NewLogCreated;
use App\Http\Requests\ProjectRequest;
use App\Project;
use App\SeasonCoupon;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Action;
use Notification;
use App\Notifications\NotifyUsers;
use Spatie\Permission\Models\Permission;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $min_id = Project::first()->id ?? 1;
        $max_id = Project::orderByDesc('id')->first()->id ?? 1;
        $from_id = $request["from_id"] ?? $min_id;
        $to_id = $request["to_id"] ?? $max_id;
        $name = $request["name"] ?? "";

        $projects = Project::when($name, function ($query) use ($name) {
            return $query->where('name', 'like', '%' . $name . '%');
        })->when($from_id && $to_id, function ($query) use ($from_id, $to_id) {
            return $query->whereBetween('id', [$from_id, $to_id]);
        })->orderBy("projects.id", 'desc')->paginate(20)
            ->appends([
                "name" => $name, "from_id" => $from_id, "to_id" => $to_id]);


        return view('admin.project.index', compact('projects', 'from_id', 'to_id',
            'name', 'max_id', 'min_id'
        ));

    }

    public function create()
    {
        return view('admin.project.create');

    }

    public function store(ProjectRequest $request)
    {
        $project = Project::create(request()->all());

        event(new NewLogCreated('تم انشاء مشروع بنجاح', $project->name, 144, 0, null));
        $action = Action::create(['title' => 'تم إضافة مشروع جديد', 'type' => Permission::findByName('list projects')->title, 'link' => Permission::findByName('list projects')->link]);
        $users = User::permission('projects')->whereNotIn('id', [auth()->user()->id])->get();
        if ($users->first())
            Notification::send($users, new NotifyUsers($action));
        return back()->with('success', 'تم انشاء مشروع بنجاح');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $project = Project::find($id);

        if (!is_null($project)) {
            return view('admin.project.edit', compact('project'));

        } else {
            event(new NewLogCreated('المحاولة للوصول لمشروع غير موجود برقم : ', $id, 145, 1, null));
            return redirect("/admin/projects")->with('error', 'المشروع غير موجود');
        }
    }

    public function update(ProjectRequest $request, $id)
    {
        $project = Project::find($id);

        if (!is_null($project)) {
            $project->update(request()->all());

            event(new NewLogCreated('تعديل البيانات بنجاح', $project->name, 145, 1, null));
            $action = Action::create(['title' => 'تم تعديل مشروع', 'type' => Permission::findByName('list projects')->title, 'link' => Permission::findByName('list projects')->link]);
            $users = User::permission('projects')->whereNotIn('id', [auth()->user()->id])->get();
            if ($users->first())
                Notification::send($users, new NotifyUsers($action));
            return redirect("/admin/projects")->with('success', 'تم تعديل البيانات بنجاح');

        } else {
            event(new NewLogCreated('المحاولة للوصول لمشروع غير موجود برقم : ', $id, 145, 1, null));
            return redirect("/admin/projects")->with('error', 'المشروع غير موجود');
        }
    }

    public function destroy($id)
    {
        //
    }

    public function delete($id)
    {
        $project = Project::find($id);

        if (!is_null($project)) {
            if ($project->seasons->first()) {
                event(new NewLogCreated('لا يمكن حذف مشروع مرتبط بمواسم : ', $id, 146, 1, null));
                return redirect("/admin/projects")->with('error', 'لا يمكن حذف مشروع مرتبط بمواسم');
            }
            $project->delete();
            event(new NewLogCreated('حذف مشروع بنجاح', $project->name, 146, 1, null));
            $action = Action::create(['title' => 'تم حذف مشروع', 'type' => Permission::findByName('list projects')->title, 'link' => Permission::findByName('list projects')->link]);
            $users = User::permission('projects')->whereNotIn('id', [auth()->user()->id])->get();
            if ($users->first())
                Notification::send($users, new NotifyUsers($action));
            return redirect("/admin/projects")->with('success', 'تم حذف مشروع بنجاح');

        } else {
            event(new NewLogCreated('المحاولة للوصول لمشروع غير موجود برقم : ', $id, 146, 1, null));
            return redirect("/admin/projects")->with('error', 'المشروع غير موجود');
        }
    }

    public function seasons($id)
    {
        $project = Project::find($id);

        if (!is_null($project)) {
            $min_id = Project::find($id)->seasons->first()->id ?? 1;
            $max_id = Project::find($id)->seasons->orderByDesc('id')->first()->id ?? 1;
            $from_id = $request["from_id"] ?? $min_id;
            $to_id = $request["to_id"] ?? $max_id;
            $name = $request["name"] ?? "";
            $status = $request["status"] ?? "";

            $seasons = Project::find($id)->seasons->when($name, function ($query) use ($name) {
                return $query->where('name', 'like', '%' . $name . '%');
            })->when($status, function ($query) use ($status) {
                return $query->where('status', '!=', "");
            })->when($from_id && $to_id, function ($query) use ($from_id, $to_id) {
                return $query->whereBetween('id', [$from_id, $to_id]);
            })->orderBy("seasons.id", 'desc')->paginate(20)
                ->appends([
                    "name" => $name, "from_id" => $from_id, "to_id" => $to_id]);

            $projects = Project::orderBy('name')->get();

            return view('admin.project.seasons', compact('seasons', 'projects', 'from_id', 'to_id',
                'name', 'id', 'max_id', 'max_id'
            ));
        } else {
            event(new NewLogCreated('المحاولة للوصول لمشروع غير موجود برقم : ', $id, 146, 1, null));
            return redirect("/admin/projects")->with('error', 'المشروع غير موجود');
        }
    }

    public function season_coupons($id, Request $request)
    {
        $project = Project::find($id);
        $seasons_ids = $project->seasons()->pluck('id')->toArray();

        if (!is_null($project)) {

            $institutions_ids_yes = $request['institutions_ids_yes'];
            $institutions_ids_no = $request['institutions_ids_no'];
            $delivery_status = $request["delivery_status"] ?? "";
            $min_id = SeasonCoupon::whereIn('season_id', $seasons_ids)->first()->id ?? 1;
            $max_id = SeasonCoupon::whereIn('season_id', $seasons_ids)->orderByDesc('id')->first()->id ?? 1;
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

            $season_coupons = SeasonCoupon::whereIn('season_id', $seasons_ids)->when($institutions_ids_yes, function ($query) use ($institutions_ids_yes) {
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
            })->when($delivery_status, function ($query) use ($delivery_status) {
                return $query->where('delivery_status', '!=', "");
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
                $season_coupons = $season_coupons->orderBy("season_coupons.id", 'desc')->paginate(20)
                    ->appends([
                        "institutions_ids_yes" => $institutions_ids_yes, "institutions_ids_no" => $institutions_ids_no, "delivery_status" => $delivery_status,
                        "from_id" => $from_id, "to_id" => $to_id, "from_execution_date" => $from_execution_date, "to_execution_date" => $to_execution_date,
                        "from_execution_date" => $from_execution_date, "to_execution_date" => $to_execution_date, "from_application_date" => $from_application_date, "to_application_date" => $to_application_date,
                        "families_no" => $families_no, "families_yes" => $families_yes, "coulmn" => $coulmn,
                        "family_or_institution" => $family_or_institution, "delivery_place" => $delivery_place, "admin_status_ids" => $admin_status_ids, "delivery_place" => $delivery_place,
                        'season_ids' => $season_ids, 'project_id' => $project_id
                    ]);

                return view('admin.project.season_coupons', compact('season_coupons', "institutions_ids_yes", "institutions_ids_no", "delivery_status",
                    "from_id", "to_id", "from_delivery_date", "to_delivery_date", "from_execution_date", "to_execution_date", "from_application_date", "to_application_date", "families_no", "families_yes", "coulmn", 'min_id', 'max_id',
                    "family_or_institution", "admin_status_ids", "delivery_place"
                    , "admin_statuses", "institutions",
                    'season_ids', 'project_id', 'project'
                ));

            }


        } else {
            event(new NewLogCreated('المحاولة للوصول لمشروع غير موجود برقم : ', $id, 155, 1, null));
            return redirect("/admin/seasons")->with('error', 'المشروع غير موجود');
        }
    }

    public function season_ajax($id)
    {
        if (!is_null($id)) {
            $project = Project::find($id);

            if (!is_null($project)) {
                return $project->seasons()->get();
            } else {
                return response()->json([
                    'message' => 'الرجاء التاكد من الرابط المطلوب'
                ], 401);
            }
        } else {
            return response()->json([
                'message' => 'الرجاء التاكد من الرابط المطلوب'
            ], 401);
        }
    }
//
}
