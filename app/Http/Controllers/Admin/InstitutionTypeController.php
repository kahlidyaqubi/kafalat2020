<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\InstitutionTypeRequest;
use App\InstitutionType;
use App\institution_type;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Notification;

class InstitutionTypeController extends Controller
{
    public function index(Request $request)
    {
        $min_id = InstitutionType::first()->id ?? 1;
        $max_id = InstitutionType::orderByDesc('id')->first()->id ?? 1;
        $from_id = $request["from_id"] ?? $min_id;
        $to_id = $request["to_id"] ?? $max_id;
        $name = $request["name"] ?? "";
        $status = $request["status"] ?? "";

        $institution_types = InstitutionType::when($name, function ($query) use ($name) {
            return $query->where('name', 'like', '%' . $name . '%');
        })->when($status, function ($query) use ($status) {
            return $query->where('status', '!=', "");
        })->when($from_id && $to_id, function ($query) use ($from_id, $to_id) {
            return $query->whereBetween('id', [$from_id, $to_id]);
        })->orderBy("institution_types.id",'desc')->paginate(20)
            ->appends([
                "name" => $name, "from_id" => $from_id, "to_id" => $to_id]);


        return view('admin.institution_type.index', compact('institution_types', 'from_id', 'to_id',
            'name', 'max_id', 'min_id', 'status'
        ));

    }

    public function create()
    {
        return view('admin.institution_type.create');
    }

    public function store(InstitutionTypeRequest $request)
    {
        $institution_type = InstitutionType::create(request()->all());

        event(new NewLogCreated('تم انشاء نوع مؤسسة بنجاح', $institution_type->name, 162, 0, null));
        return back()->with('success', 'تم انشاء نوع مؤسسة بنجاح');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $institution_type = InstitutionType::find($id);

        if (!is_null($institution_type)) {
            return view('admin.institution_type.edit', compact('institution_type'));

        } else {
            event(new NewLogCreated('المحاولة للوصول لنوع مؤسسة غير موجود برقم : ', $id, 163, 1, null));
            return redirect("/admin/institution_types")->with('error', 'نوع مؤسسة غير موجود');
        }
    }

    public function update(InstitutionTypeRequest $request, $id)
    {
        $institution_type = InstitutionType::find($id);

        if (!is_null($institution_type)) {
            $institution_type->update(request()->all());

            event(new NewLogCreated('تعديل البيانات بنجاح', $institution_type->name, 163, 1, null));
            return redirect("/admin/institution_types")->with('success', 'تم تعديل البيانات بنجاح');

        } else {
            event(new NewLogCreated('المحاولة للوصول لنوع مؤسسة غير موجود برقم : ', $id, 163, 1, null));
            return redirect("/admin/institution_types")->with('error', 'النوع مؤسسة غير موجود');
        }
    }

    public function destroy($id)
    {
        //
    }

    public function delete($id)
    {
        $institution_type = InstitutionType::find($id);

        if (!is_null($institution_type)) {
            if ($institution_type->institutions->first()) {
                event(new NewLogCreated('لا يمكن حذف نوع مؤسسة مرتبط بمؤسسات : ', $id, 164, 1, null));
                return redirect("/admin/institution_types")->with('error', 'لا يمكن حذف نوع مؤسسة مرتبط بمساعدات');
            }
            $institution_type->delete();
            event(new NewLogCreated('حذف نوع مؤسسة بنجاح', $institution_type->name, 164, 1, null));
            return redirect("/admin/institution_types")->with('success', 'تم حذف نوع مؤسسة بنجاح');

        } else {
            event(new NewLogCreated('المحاولة للوصول لنوع مؤسسة غير موجود برقم : ', $id, 164, 1, null));
            return redirect("/admin/institution_types")->with('error', 'النوع مؤسسة غير موجود');
        }
    }

    public function approve($id)
    {
        $institution_type = InstitutionType::find($id);


        if (!(auth()->user()->hasPermissionTo('institution_types'))) {
            return response()->json([
                'message' => 'ليس لك صلاحية تعديل نوع مؤسسة',
            ], 401);
        }

        if ($institution_type) {
            if ($institution_type->status == 1) {
                $institution_type->update(['status' => 0]);
                event(new NewLogCreated('تم الغاء قبول نوع مؤسسة بنجاح', $institution_type->name, 163, 1, null));
                return response()->json([
                    'message' => 'تم إلغاء قبول نوع مؤسسة بنجاح',
                ], 200);
            } else {
                $institution_type->update(['status' => 1]);
                event(new NewLogCreated('تم قبول نوع مؤسسة بنجاح', $institution_type->name, 163, 1, null));
                return response()->json([
                    'message' => 'تم قبول نوع مؤسسة بنجاح',
                ], 200);
            }

        } else {

            event(new NewLogCreated('المحاولة للوصول لنوع مؤسسة غير موجود برقم : ', $id, 163, 1, null));
            return response()->json([
                'message' => 'المحاولة للوصول لنوع مؤسسة غير موجود',
            ], 401);
        }
    }
}
