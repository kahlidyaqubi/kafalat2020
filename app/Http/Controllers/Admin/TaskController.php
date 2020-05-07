<?php

namespace App\Http\Controllers\Admin;

use App\Events\NewLogCreated;
use App\FundedInstitution;
use App\Http\Requests\TaskRequest;
use App\Institution;
use App\Project;
use App\Task;
use App\TaskFamily;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Action;
use Notification;
use App\Notifications\NotifyUsers;
use Spatie\Permission\Models\Permission;

class TaskController extends Controller
{

    public function index(Request $request)
    {

        $done = $request["done"] ?? "";
        $full_done = $request["full_done"] ?? "";
        $type = $request["type"] ?? "";
        $admin_ids = $request["admin_ids"] ? array_filter($request["admin_ids"]) : [];
        $user_ids = $request["user_ids"] ? array_filter($request["user_ids"]) : [];
        $family_ids = $request["family_ids"] ? array_filter($request["family_ids"]) : [];
        $project_ids = $request["project_ids"] ?? [];
        $institution_ids = $request["institution_ids"] ?? [];
        $title = $request["title"] ?? "";
        $min_id = Task::first()->id ?? 1;
        $max_id = Task::orderByDesc('id')->first()->id ?? 1;
        $from_id = $request["from_id"] ?? $min_id;
        $to_id = $request["to_id"] ?? $max_id;
        $from_from_date = $request["from_from_date"] ?? "";
        $to_from_date = $request["to_from_date"] ?? "";
        $from_to_date = $request["from_to_date"] ?? "";
        $to_to_date = $request["to_to_date"] ?? "";
        $families_yes = $request['families_yes'] ? array_filter($request["family_ids"]) : [];  // علاقة
        $coulmn = $request["coulmn"] ?? "";

        $items = Task::
        when($admin_ids, function ($query) use ($admin_ids) {
            return $query->whereIn('admin_id', $admin_ids);
        })->when($type, function ($query) use ($type) {
            if ($type == 1)
                return $query->whereHas('task_families');
            elseif ($type == 2)
                return $query->whereNotNull('expense_date');
            elseif ($type == 3)
                return $query->whereNotNull('project_id');

        })->when($user_ids, function ($query) use ($user_ids) {
            return $query->whereIn('user_id', $user_ids);
        })->when($family_ids, function ($query) use ($family_ids) {
            return $query->whereIn('family_id', $family_ids);
        })->when($project_ids, function ($query) use ($project_ids) {
            return $query->whereIn('project_id', $project_ids);
        })->when($institution_ids, function ($query) use ($institution_ids) {
            return $query->whereIn('institution_id', $institution_ids);
        })->when($title, function ($query) use ($title) {
            return $query->where('title', 'like', "%" . $title . "%");
        })->when(($done || $done == '0'), function ($query) use ($done) {
            return $query->where('done', $done);
        })->when(($full_done || $full_done == '0'), function ($query) use ($full_done) {
            return $query->where('full_done', $full_done);
        })->when($from_id && $to_id, function ($query) use ($from_id, $to_id) {
            return $query->whereBetween('id', [$from_id, $to_id]);
        })->when($from_from_date && $to_from_date, function ($query) use ($from_from_date, $to_from_date) {
            return $query->whereBetween('from_date', [$from_from_date, $to_from_date]);
        })->when($from_to_date && $to_to_date, function ($query) use ($from_to_date, $to_to_date) {
            return $query->whereBetween('to_date', [$from_to_date, $to_to_date]);
        })->when($families_yes, function ($query) use ($families_yes) {
            return $query->whereHas('task_families'
                , function ($q) use ($families_yes) {
                    $q->whereIn('family_id', $families_yes);
                });
        })->orderBy("tasks.id", 'desc')->paginate(20)
            ->appends([
                "admin_ids" => $admin_ids, "user_ids" => $user_ids, "family_ids" => $family_ids,
                "project_ids" => $project_ids, "institution_ids" => $institution_ids, "title" => $title,
                "done" => $done, "from_id" => $from_id, "to_id" => $to_id,
                "from_to_date" => $from_to_date, "to_to_date" => $to_to_date,
                "from_from_date" => $from_from_date, "to_from_date" => $to_from_date, "families_yes" => $families_yes
                , "coulmn" => $coulmn, "type" => $type, "full_done" => $full_done]);


        if ($request["coulmn"] == []) {
            $coulmn = ['id', 'admin', 'user', 'type', "done", "full_done", 'operations'];
        }
        $institutions = Institution::orderBy('name')->get();
        $projects = Project::orderBy('name')->get();

        return view('admin.task.index', compact('items',
            "admin_ids", "user_ids", "family_ids",
            "project_ids", "institution_ids", "title",
            "done", "from_id", "to_id",
            "from_to_date", "to_to_date",
            "from_from_date", "to_from_date", "families_yes",
            "coulmn", 'min_id', 'max_id', 'type', 'full_done', 'institutions', 'projects'));


    }

    public function create()
    {
        $institutions = Institution::orderBy('name')->get();
        $projects = Project::orderBy('name')->get();
        return view('admin.task.create', compact('institutions', 'projects'));
    }

    public function store(TaskRequest $request)
    {
        //dd(array_map('intval', request()["families_yes"]));
        //dd([1, 2, 3 , 4]);


        if ($request['to_date'] < $request['from_date']) {
            
            return redirect('admin/tasks/create')->with("error", "لا يمكن أن يكون تاريخ الانتهاء قبل تاريخ البدء ")->withInput();
       
        }

        $request['admin_id'] = auth()->user()->id;
        if ($request['expense_date'])
            $request['expense_date'] = $request['expense_date'] . '-1';
        $task = Task::create($request->except(['families_yes']));
        if (request()["families_yes"] && count(array_filter(request()["families_yes"])) > 0) {
            $task->families()->sync(request()["families_yes"]);
        }


        event(new NewLogCreated('تم اضافة المهمة', $task->title, 11, 1, null));
        $action = Action::create(['title' => "أضاف " . auth()->user()->full_name . " مهمة جديدة", 'type' => Permission::findByName('list tasks')->title, 'link' => Permission::findByName('list tasks')->link . "/" . $task->id]);
        $users = User::where('id', $task->user_id)->get();
        if ($users->first())
            Notification::send($users, new NotifyUsers($action));
        return redirect("/admin/tasks")->with('success', 'تم اضافة مهمة بنجاح');
    }

    public function show($id)
    {
        $task = Task::find($id);
        $institutions = Institution::orderBy('name')->get();
        $projects = Project::orderBy('name')->get();
        if (!is_null($task)) {
            return view('admin.task.show', compact('task', 'institutions', 'projects'));
        } else {
            event(new NewLogCreated('محاولة الوصول لمهمة برقم:', $id, 11, 1, null));
            return redirect("/admin/tasks")->with('error', 'المهمة غير موجود');
        }
    }

    public function edit($id)
    {
        $task = Task::find($id);
        $institutions = Institution::orderBy('name')->get();
        $projects = Project::orderBy('name')->get();
        if (!is_null($task) && auth()->user()->id == $task->admin_id) {
            return view('admin.task.edit', compact('task', 'institutions', 'projects'));
        } else {
            event(new NewLogCreated('محاولة الوصول لمهمة برقم:', $id, 11, 1, null));
            return redirect("/admin/tasks")->with('error', 'لا تملك صلاحية الدخول لهذه المهمة');
        }
    }

    public function update(TaskRequest $request, $id)
    {
        $task = Task::find($id);
        if ($request['expense_date'])
            $request['expense_date'] = $request['expense_date'] . '-1';
        if (!is_null($task)) {

            if ($request['to_date'] < $request['from_date']) {
                 
            return back()->with("error", "لا يمكن أن يكون تاريخ الانتهاء قبل تاريخ البدء ")->withInput();
       
            }

            $task->update($request->except(['families_yes']));
            if (request()["families_yes"] && count(array_filter(request()["families_yes"])) > 0) {
                $task->families()->sync(request()["families_yes"]);
            }

            event(new NewLogCreated('تم تعديل المهمة', $task->title, 11, 1, null));
            $action = Action::create(['title' => 'تم تعديل مهمة', 'type' => Permission::findByName('list tasks')->title, 'link' => Permission::findByName('list tasks')->link]);
            $users = User::where('id', $task->user_id)->get();
            if ($users->first())
                Notification::send($users, new NotifyUsers($action));
            return redirect("/admin/tasks")->with('success', 'تم تعديل مهمة بنجاح');
        } else {
            event(new NewLogCreated('محاولة الوصول لمهمة برقم:', $id, 11, 1, null));
            return redirect("/admin/tasks")->with('error', 'المهمة غير موجود');
        }
    }

    public function destroy($id)
    {
        //
    }

    public function delete($id)
    {
        $task = Task::find($id);

        if (!is_null($task) && auth()->user()->id == $task->admin_id) {
            $task->families()->sync([]);
            $task->delete();
            event(new NewLogCreated('تم حذف المهمة', $task->title, 12, 1, null));
            $action = Action::create(['title' => 'تم حذف مهمة', 'type' => Permission::findByName('list tasks')->title, 'link' => Permission::findByName('list tasks')->link]);
            $users = User::permission('tasks')->whereNotIn('id', [auth()->user()->id])->get();
            if ($users->first())
                Notification::send($users, new NotifyUsers($action));
            return redirect("/admin/tasks")->with('success', 'تم حذف مهمة بنجاح');
        } else {
            event(new NewLogCreated('محاولة الوصول لمهمة برقم:', $id, 12, 1, null));
            return redirect("/admin/tasks")->with('error', 'المهمة غير موجود');
        }
    }

    public function done($id, Request $request)
    {
        $task = Task::find($id);

        if (!is_null($task) && auth()->user()->id == $task->user_id) {

            if (!$task->done) {
                $task->update(['done' => 1, 'user_note' => $request['user_note']]);
                event(new NewLogCreated('تم تسجيل انجاز المهم', $task->title, 11, 1, null));
                $action = Action::create(['title' => 'أنجز ' . auth()->user()->full_name . ' مهمة', 'type' => Permission::findByName('list tasks')->title, 'link' => Permission::findByName('list tasks')->link . "/" . $task->id]);
                $users = User::permission('tasks')->whereNotIn('id', [auth()->user()->id])->get();
                if ($users->first())
                    Notification::send($users, new NotifyUsers($action));
                return response()->json([
                    'message' => 'تم تسجيل انجاز المهم',
                ], 200);
            } else {
                $task->update(['done' => 0, 'user_note' => '']);
                return response()->json([
                    'message' => 'تم التراجع عن انجاز المهمة',
                ], 200);
            }
        } else {
            event(new NewLogCreated('محاولة الوصول لمهمة برقم:', $id, 11, 1, null));
            return response()->json([
                'message' => 'الرجاء التاكد من الرابط المطلوب'
            ], 401);
        }
    }

    public function full_done($id)
    {
        $task = Task::find($id);

        if (!(auth()->user()->hasPermissionTo('edit tasks'))) {
            return response()->json([
                'message' => 'ليس لك صلاحية تعديل الصلاحيات',
            ], 401);
        }

        if (!is_null($task) && auth()->user()->id == $task->admin_id) {

            if (!$task->full_done) {
                $task->update(['full_done' => 1]);
                event(new NewLogCreated('تم تسجيل انجاز المهم', $task->full_done, 11, 1, null));
                $action = Action::create(['title' => 'تم تأكيد انجاز مهمة', 'type' => Permission::findByName('list tasks')->title, 'link' => Permission::findByName('list tasks')->link . "/" . $task->id]);
                $users = User::permission('tasks')->whereNotIn('id', [auth()->user()->id])->get();
                $users2 = User::whereIn('id', [$task->user_id])->get();
                
                if ($users->first())
                    Notification::send(User::whereIn('id',$users->pluck('id')->toArray())->orWhereIn('id',$users2->pluck('id')->toArray())->get(), new NotifyUsers($action));
                return response()->json([
                    'message' => 'تم تأكيد انجاز المهم',
                ], 200);
            } else {
                $task->update(['full_done' => 0]);
                return response()->json([
                    'message' => 'تم التراجع عن تأكيد انجاز المهمة',
                ], 200);
            }
        } else {
            event(new NewLogCreated('محاولة الوصول لمهمة برقم:', $id, 11, 1, null));
            return response()->json([
                'message' => 'الرجاء التاكد من الرابط المطلوب'
            ], 401);
        }
    }
}
