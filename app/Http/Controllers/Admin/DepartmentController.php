<?php

namespace App\Http\Controllers\Admin;

use App\Department;
use App\Events\NewLogCreated;
use App\Http\Requests\DepartmentRequest;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Action;
use Notification;
use App\Notifications\NotifyUsers;
use Spatie\Permission\Models\Permission;

class DepartmentController extends Controller
{
    public function index(Request $request)
    {
        $min_id = Department::first()->id ?? 1;
        $max_id = Department::orderByDesc('id')->first()->id ?? 1;
        $from_id = $request["from_id"] ?? $min_id;
        $to_id = $request["to_id"] ?? $max_id;
        $name = $request["name"] ?? "";
        $status = $request["status"] ?? "";

        $departments = Department::when($name, function ($query) use ($name) {
            return $query->where('name', 'like', '%' . $name . '%');
        })->when($status || $status == '0', function ($query) use ($status) {
            return $query->where('status', '=', $status);
        })->when($from_id && $to_id, function ($query) use ($from_id, $to_id) {
            return $query->whereBetween('id', [$from_id, $to_id ]);
        })->orderBy("departments.id",'desc')->paginate(20)
            ->appends([
                "name" => $name, "from_id" => $from_id, "to_id" => $to_id]);


        return view('admin.department.index', compact('departments', 'from_id', 'to_id',
            'name', 'max_id', 'min_id', 'status'
        ));

    }

    public function create()
    {
        return view('admin.department.create');
    }

    public function store(DepartmentRequest $request)
    {
        request()['created_by'] = auth()->user()->id;

        request()['status'] = 1;
        $department = Department::create(request()->all());

        event(new NewLogCreated('تم انشاء قسم بنجاح', $department->name, 156, 0, null));

        $action = Action::create(['title' => 'تم إضافة قسم جديد', 'type' => Permission::findByName('list departments')->title, 'link' => Permission::findByName('list departments')->link]);
        $users = User::permission('departments')->whereNotIn('id', [auth()->user()->id])->get();
        if ($users->first())
            Notification::send($users, new NotifyUsers($action));
        return back()->with('success', 'تم انشاء قسم بنجاح');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $department = Department::find($id);

        if (!is_null($department)) {
            return view('admin.department.edit', compact('department'));

        } else {
            event(new NewLogCreated('المحاولة للوصول لقسم غير موجود برقم : ', $id, 157, 1, null));
            return redirect("/admin/departments")->with('error', 'القسم غير موجود');
        }
    }

    public function update(DepartmentRequest $request, $id)
    {
        $department = Department::find($id);

        if (!is_null($department)) {
            request()['updated_by'] = auth()->user()->id;
            request()['status'] = 1;
            $department->update(request()->all());

            event(new NewLogCreated('تعديل البيانات بنجاح', $department->name, 157, 1, null));
            $action = Action::create(['title' => 'تم تعديل قسم', 'type' => Permission::findByName('list departments')->title, 'link' => Permission::findByName('list departments')->link]);
            $users = User::permission('departments')->whereNotIn('id', [auth()->user()->id])->get();
            if ($users->first())
                Notification::send($users, new NotifyUsers($action));
            return redirect("/admin/departments")->with('success', 'تم تعديل البيانات بنجاح');

        } else {
            event(new NewLogCreated('المحاولة للوصول لقسم غير موجود برقم : ', $id, 157, 1, null));
            return redirect("/admin/departments")->with('error', 'القسم غير موجود');
        }
    }

    public function destroy($id)
    {
        //
    }

    public function delete($id)
    {
        $department = Department::find($id);

        if (!is_null($department)) {
            if ($department->users->first()) {
                event(new NewLogCreated('لا يمكن حذف قسم مرتبط بمستخدمين ', $id, 158, 1, null));
                return redirect("/admin/departments")->with('error', 'لا يمكن حذف قسم مرتبط بمستخدمين');
            }
            $department->delete();
            event(new NewLogCreated('حذف قسم بنجاح', $department->name, 158, 1, null));
            $action = Action::create(['title' => 'تم حذف قسم', 'type' => Permission::findByName('list departments')->title, 'link' => Permission::findByName('list departments')->link]);
            $users = User::permission('departments')->whereNotIn('id', [auth()->user()->id])->get();
            if ($users->first())
                Notification::send($users, new NotifyUsers($action));
            return redirect("/admin/departments")->with('success', 'تم حذف قسم بنجاح');

        } else {
            event(new NewLogCreated('المحاولة للوصول لقسم غير موجود برقم : ', $id, 158, 1, null));
            return redirect("/admin/departments")->with('error', 'القسم غير موجود');
        }
    }

    public function approve($id)
    {
        $department = Department::find($id);

        if (!(auth()->user()->hasPermissionTo('departments'))) {
            return response()->json([
                'message' => 'ليس لك صلاحية تعديل قسم',
            ], 401);
        }

        if ($department) {
            if ($department->status == 1) {
                $department->update(['status' => 0]);
                event(new NewLogCreated('تم الغاء قبول القسم بنجاح', $department->name, 157, 1, null));
                return response()->json([
                    'message' => 'تم إلغاء قبول قسم بنجاح',
                ], 200);
            } else {
                $department->update(['status' => 1]);
                event(new NewLogCreated('تم قبول القسم بنجاح', $department->name, 157, 1, null));
                return response()->json([
                    'message' => 'تم قبول قسم بنجاح',
                ], 200);
            }

        } else {

            event(new NewLogCreated('المحاولة للوصول لقسم غير موجود برقم : ', $id, 157, 1, null));
            return response()->json([
                'message' => 'المحاولة للوصول لقسم غير موجود',
            ], 401);
        }
    }
}
