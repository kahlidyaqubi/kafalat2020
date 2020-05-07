<?php

namespace App\Http\Controllers\Admin;

use App\Events\NewLogCreated;
use App\Http\Requests\TargetTypeRequest;
use App\InstitutionType;
use App\licensor;
use App\Neighborhood;
use App\TargetType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TargetTypeController extends Controller
{
    public function index(Request $request)
    {
        $min_id = TargetType::first()->id ?? 1;
        $max_id = TargetType::orderByDesc('id')->first()->id ?? 1;
        $from_id = $request["from_id"] ?? $min_id;
        $to_id = $request["to_id"] ?? $max_id;
        $name = $request["name"] ?? "";
        $status = $request["status"] ?? "";

        $target_types = TargetType::when($name, function ($query) use ($name) {
            return $query->where('name', 'like', '%'.$name.'%');
        })->when(($status || $status == '0'), function ($query) use ($status) {
            return $query->where('status', $status);
        })->when($from_id && $to_id, function ($query) use ($from_id, $to_id) {
            return $query->whereBetween('id', [$from_id,$to_id ]);
        })->orderBy("target_types.id",'desc')->paginate(20)
            ->appends([
                "name" => $name, "from_id" => $from_id, "to_id" => $to_id]);


        return view('admin.target_type.index', compact('target_types', 'from_id', 'to_id',
            'name', 'max_id', 'min_id','status'
        ));

    }

    public function create()
    {
        return view('admin.target_type.create');
    }

    public function store(TargetTypeRequest $request)
    {
        request()['status'] = 1;
        $target_type = TargetType::create(request()->all());

        event(new NewLogCreated('تم انشاء فئة استهداف بنجاح', $target_type->name, 159, 0, null));
        return back()->with('success', 'تم انشاء فئة استهداف بنجاح');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $target_type = TargetType::find($id);

        if (!is_null($target_type)) {
            return view('admin.target_type.edit', compact('target_type'));

        } else {
            event(new NewLogCreated('المحاولة للوصول لفئة استهداف غير موجودة برقم : ', $id, 160, 1, null));
            return redirect("/admin/target_types")->with('error', 'الفئة استهداف غير موجودة');
        }
    }

    public function update(TargetTypeRequest $request, $id)
    {
        $target_type = TargetType::find($id);

        if (!is_null($target_type)) {
            request()['status'] = 1;
            $target_type->update(request()->all());

            event(new NewLogCreated('تعديل البيانات بنجاح', $target_type->name, 160, 1, null));
            return redirect("/admin/target_types")->with('success', 'تم تعديل البيانات بنجاح');

        } else {
            event(new NewLogCreated('المحاولة للوصول لمشروع غير موجودة برقم : ', $id, 160, 1, null));
            return redirect("/admin/target_types")->with('error', 'المشروع غير موجودة');
        }
    }

    public function destroy($id)
    {
        //
    }

    public function delete($id)
    {
        $target_type = TargetType::find($id);

        if (!is_null($target_type)) {
            if ($target_type->institutions->first()) {
                event(new NewLogCreated('لا يمكن حذف فئة استهداف مرتبطة بمؤسسات : ', $id, 161, 1, null));
                return redirect("/admin/target_types")->with('error', 'لا يمكن حذف مشروع مرتبط بمواسم');
            }
            $target_type->delete();
            event(new NewLogCreated('حذف فئة استهداف بنجاح', $target_type->name, 161, 1, null));
            return redirect("/admin/target_types")->with('success', 'تم حذف مشروع بنجاح');

        } else {
            event(new NewLogCreated('المحاولة للوصول لفئة استهداف غير موجودة برقم : ', $id, 161, 1, null));
            return redirect("/admin/target_types")->with('error', 'الفئة استهداف غير موجودة');
        }
    }

    public function approve($id)
    {
        $target_type = TargetType::find($id);


        if (!(auth()->user()->hasPermissionTo('target_types'))) {
            return response()->json([
                'message' => 'ليس لك صلاحية تعديل فئة استهداف',
            ], 401);
        }

        if ($target_type) {
            if ($target_type->status == 1) {
                $target_type->update(['status' => 0]);
                event(new NewLogCreated('تم الغاء قبول الفئة استهداف بنجاح', $target_type->name, 160, 1, null));
                return response()->json([
                    'message' => 'تم إلغاء قبول فئة استهداف بنجاح',
                ], 200);
            } else {
                $target_type->update(['status' => 1]);
                event(new NewLogCreated('تم قبول الفئة استهداف بنجاح', $target_type->name, 160, 1, null));
                return response()->json([
                    'message' => 'تم قبول فئة استهداف بنجاح',
                ], 200);
            }

        } else {

            event(new NewLogCreated('المحاولة للوصول لفئة استهداف غير موجودة برقم : ', $id, 160, 1, null));
            return response()->json([
                'message' => 'المحاولة للوصول لفئة استهداف غير موجودة',
            ], 401);
        }
    }

    public function institutions($id)
    {
        $target_type = TargetType::find($id);

        if (!is_null($target_type)) {
            $min_id = $target_type->institutions->first()->id ?? 1;
            $max_id = $target_type->institutions->orderByDesc('id')->first()->id ?? 1;
            $from_id = $request["from_id"] ?? $min_id;
            $to_id = $request["to_id"] ?? $max_id;
            $name = $request["name"] ?? "";
            $institution_type_id = $request["institution_type_id"] ?? "";
            $mobile = $request["mobile"] ?? "";
            $mobile_one = $request["mobile_one"] ?? "";
            $mobile_two = $request["mobile_two"] ?? "";
            $address = $request["address"] ?? "";
            $target_type_id = $request["target_type_id"] ?? "";
            $responsible_person = $request["responsible_person"] ?? "";
            $neighborhood_id = $request["neighborhood_id"] ?? "";
            $target_types_ids = $request["target_types_ids"] ?? "";
            $coulmn = $request["coulmn"] ?? "";

            $institutions = $target_type->institutions()->when($name, function ($query) use ($name) {
                return $query->where('name', 'like', '%'.$name.'%');
            })->when($from_id && $to_id, function ($query) use ($from_id, $to_id) {
                return $query->whereBetween('id', [$from_id,$to_id ]);
            })->when($institution_type_id, function ($query) use ($institution_type_id) {
                return $query->where('institution_type_id', $institution_type_id);
            })->when($mobile_one, function ($query) use ($mobile_one) {
                return $query->where('mobile_one', $mobile_one);
            })->when($mobile, function ($query) use ($mobile) {
                return $query->where('mobile', $mobile);
            })->when($mobile_two, function ($query) use ($mobile_two) {
                return $query->where('mobile_two', $mobile_two);
            })->when($address, function ($query) use ($address) {
                return $query->where('address', $address);
            })->when($target_type_id, function ($query) use ($target_type_id) {
                return $query->where('target_type_id', $target_type_id);
            })->when($responsible_person, function ($query) use ($responsible_person) {
                return $query->where('responsible_person', $responsible_person);
            })->when($neighborhood_id, function ($query) use ($neighborhood_id) {
                return $query->where('neighborhood_id', $neighborhood_id);
            })->when($target_types_ids && ($target_types_ids[0] != null || count($target_types_ids) > 1), function ($query) use ($target_types_ids) {
                foreach ($target_types_ids as $target_type_id) {
                    return $query->whereHas('target_types', function ($q) use ($target_type_id) {
                        $q->where('target_types.id', $target_type_id);
                    });
                }
            })->orderBy("institutions.id",'desc')->paginate(20)
                ->appends([
                    "name" => $name, "from_id" => $from_id, "to_id" => $to_id, "coulmn" => $coulmn,
                    "mobile_two" => $mobile_two, "mobile" => $mobile, "mobile_one" => $mobile_one, "institution_type_id" => $institution_type_id,
                    "neighborhood_id" => $neighborhood_id, "responsible_person" => $responsible_person, "target_type_id" => $target_type_id, "address" => $address,
                    "target_types_ids" => $target_types_ids,]);

            if ($request["coulmn"] == []) {
                $coulmn = ['id', 'name', 'responsible_person', 'institution_type_id', 'operations'];
            }

            $target_types = TargertType::orderBy('name')->get();
            $neighborhoods = Neighborhood::orderBy('name')->get();
            $licensors = licensor::orderBy('name')->get();
            $institution_types = InstitutionType::orderBy('name')->get();


            return view('admin.target_type.institutions', compact('target_type', 'institutions', 'coulmn', 'from_id', 'to_id',
                'licensors', 'neighborhoods', 'target_types', 'institution_types', 'name',
                "mobile_two", "mobile", "mobile_one", "institution_type_id",
                "neighborhood_id", "responsible_person", "target_type_id", "address",
                "target_types_ids", 'max_id', 'max_id'));
        } else {
            event(new NewLogCreated('المحاولة للوصول لفئة استهداف غير موجودة برقم : ', $id, 161, 1, null));
            return redirect("/admin/target_types")->with('error', 'الفئة استهداف غير موجودة');
        }
    }

}
