<?php

namespace App\Http\Controllers\Admin;

use App\Events\NewLogCreated;
use App\Http\Requests\LicenseRequest;
use App\Http\Requests\LicensorRequest;
use App\InstitutionType;
use App\licensor;
use App\Neighborhood;
use App\TargetType;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Action;
use Notification;
use App\Notifications\NotifyUsers;
use Spatie\Permission\Models\Permission;

class LicensorController extends Controller
{
    public function index(Request $request)
    {
        $min_id = licensor::first()->id ?? 1;
        $max_id = licensor::orderByDesc('id')->first()->id ?? 1;
        $from_id = $request["from_id"] ?? $min_id;
        $to_id = $request["to_id"] ?? $max_id;
        $name = $request["name"] ?? "";
        $status = $request["status"] ?? "";

        $licensors = licensor::when($name, function ($query) use ($name) {
            return $query->where('name', 'like', '%'.$name.'%');
        })->when($status || $status == '0', function ($query) use ($status) {
            return $query->where('status', '=', $status);
        })->when($from_id && $to_id, function ($query) use ($from_id, $to_id) {
            return $query->whereBetween('id', [$from_id,$to_id ]);
        })->orderBy("licensors.id",'desc')->paginate(20)
            ->appends([
                "name" => $name, "from_id" => $from_id, "to_id" => $to_id]);


        return view('admin.licensor.index', compact('licensors', 'from_id', 'to_id',
            'name', 'max_id', 'min_id','status'
        ));

    }

    public function create()
    {
        return view('admin.licensor.create');
    }

    public function store(LicensorRequest $request)
    {
        request()['status'] = 1;
        $licensor = licensor::create(request()->all());

        event(new NewLogCreated('تم انشاء جهة ترخيص بنجاح', $licensor->name, 156, 0, null));
        $action = Action::create(['title' => 'تم إضافة جهة ترخيص جديدة', 'type' => Permission::findByName('list licensors')->title, 'link' => Permission::findByName('list licensors')->link]);
        $users = User::permission('licensors')->whereNotIn('id',[auth()->user()->id])->get();
        if ($users->first())
            Notification::send($users, new NotifyUsers($action));
        return back()->with('success', 'تم انشاء جهة ترخيص بنجاح');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $licensor = licensor::find($id);

        if (!is_null($licensor)) {
            return view('admin.licensor.edit', compact('licensor'));

        } else {
            event(new NewLogCreated('المحاولة للوصول لجهة ترخيص غير موجود برقم : ', $id, 157, 1, null));
            return redirect("/admin/licensors")->with('error', 'الجهة ترخيص غير موجود');
        }
    }

    public function update(LicensorRequest $request, $id)
    {
        $licensor = licensor::find($id);
        request()['status'] = 1;
        if (!is_null($licensor)) {
            $licensor->update(request()->all());

            event(new NewLogCreated('تعديل البيانات بنجاح', $licensor->name, 157, 1, null));
            $action = Action::create(['title' => 'تم تعديل جهة ترخيص', 'type' => Permission::findByName('list licensors')->title, 'link' => Permission::findByName('list licensors')->link]);
            $users = User::permission('licensors')->whereNotIn('id',[auth()->user()->id])->get();
            if ($users->first())
                Notification::send($users, new NotifyUsers($action));
            return redirect("/admin/licensors")->with('success', 'تم تعديل البيانات بنجاح');

        } else {
            event(new NewLogCreated('المحاولة للوصول لجهة ترخيص غير موجود برقم : ', $id, 157, 1, null));
            return redirect("/admin/licensors")->with('error', 'الجهة ترخيص غير موجود');
        }
    }

    public function destroy($id)
    {
        //
    }

    public function delete($id)
    {
        $licensor = licensor::find($id);

        if (!is_null($licensor)) {
            if ($licensor->institutions->first()) {
                event(new NewLogCreated('لا يمكن حذف جهة ترخيص مرتبطة بمؤسسات : ', $id, 158, 1, null));
                return redirect("/admin/licensors")->with('error', 'لا يمكن حذف جهة ترخيص مرتبط بمواسم');
            }
            $licensor->delete();
            event(new NewLogCreated('حذف جهة ترخيص بنجاح', $licensor->name, 158, 1, null));
            $action = Action::create(['title' => 'تم حذف جهة ترخيص', 'type' => Permission::findByName('list licensors')->title, 'link' => Permission::findByName('list licensors')->link]);
            $users = User::permission('licensors')->whereNotIn('id',[auth()->user()->id])->get();
            if ($users->first())
                Notification::send($users, new NotifyUsers($action));
            return redirect("/admin/licensors")->with('success', 'تم حذف جهة ترخيص بنجاح');

        } else {
            event(new NewLogCreated('المحاولة للوصول لجهة ترخيص غير موجود برقم : ', $id, 158, 1, null));
            return redirect("/admin/licensors")->with('error', 'الجهة ترخيص غير موجود');
        }
    }

    public function approve($id)
    {
        $licensor = licensor::find($id);


        if (!(auth()->user()->hasPermissionTo('licensors'))) {
            return response()->json([
                'message' => 'ليس لك صلاحية تعديل جهة ترخيص',
            ], 401);
        }

        if ($licensor) {
            if ($licensor->status == 1) {
                $licensor->update(['status' => 0]);
                event(new NewLogCreated('تم الغاء قبول الجهة ترخيص بنجاح', $licensor->name, 157, 1, null));
                return response()->json([
                    'message' => 'تم إلغاء قبول جهة ترخيص بنجاح',
                ], 200);
            } else {
                $licensor->update(['status' => 1]);
                event(new NewLogCreated('تم قبول الجهة ترخيص بنجاح', $licensor->name, 157, 1, null));
                return response()->json([
                    'message' => 'تم قبول جهة ترخيص بنجاح',
                ], 200);
            }

        } else {

            event(new NewLogCreated('المحاولة للوصول لجهة ترخيص غير موجود برقم : ', $id, 157, 1, null));
            return response()->json([
                'message' => 'المحاولة للوصول لجهة ترخيص غير موجود',
            ], 401);
        }
    }

    public function institutions($id)
    {
        $licensor = licensor::find($id);

        if (!is_null($licensor)) {
            $min_id = $licensor->institutions->first()->id ?? 1;
            $max_id = $licensor->institutions->orderByDesc('id')->first()->id ?? 1;
            $from_id = $request["from_id"] ?? $min_id;
            $to_id = $request["to_id"] ?? $max_id;
            $name = $request["name"] ?? "";
            $institution_type_ids = $request["institution_type_ids"] ?? [];
            $mobile = $request["mobile"] ?? "";
            $mobile_one = $request["mobile_one"] ?? "";
            $mobile_two = $request["mobile_two"] ?? "";
            $address = $request["address"] ?? "";
            $licensor_ids = $request["licensor_ids"] ?? [];
            $responsible_person = $request["responsible_person"] ?? "";
            $neighborhood_id = $request["neighborhood_id"] ?? "";
            $target_types_ids = $request["target_types_ids"] ?? [];
            $coulmn = $request["coulmn"] ?? "";

            $institutions = $licensor->institutions()->when($name, function ($query) use ($name) {
                return $query->where('name', 'like', '%'.$name.'%');
            })->when($from_id && $to_id, function ($query) use ($from_id, $to_id) {
                return $query->whereBetween('id', [$from_id,$to_id ]);
            })->when($institution_type_ids, function ($query) use ($institution_type_ids) {
                return $query->whereIn('institution_type_id', $institution_type_ids);
            })->when($mobile_one, function ($query) use ($mobile_one) {
                return $query->where('mobile_one', $mobile_one);
            })->when($mobile, function ($query) use ($mobile) {
                return $query->where('mobile', $mobile);
            })->when($mobile_two, function ($query) use ($mobile_two) {
                return $query->where('mobile_two', $mobile_two);
            })->when($address, function ($query) use ($address) {
                return $query->where('address', $address);
            })->when($licensor_ids, function ($query) use ($licensor_ids) {
                return $query->whereIn('licensor_id', $licensor_ids);
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
                    "mobile_two" => $mobile_two, "mobile" => $mobile, "mobile_one" => $mobile_one, "institution_type_ids" => $institution_type_ids,
                    "neighborhood_id" => $neighborhood_id, "responsible_person" => $responsible_person, "licensor_ids" => $licensor_ids, "address" => $address,
                    "target_types_ids" => $target_types_ids,]);

            if ($request["coulmn"] == []) {
                $coulmn = ['id', 'name', 'responsible_person', 'institution_type_ids', 'operations'];
            }

            $target_types = TargetType::orderBy('name')->get();
            $neighborhoods = Neighborhood::orderBy('name')->get();
            $licensors = licensor::orderBy('name')->get();
            $institution_types = InstitutionType::orderBy('name')->get();


            return view('admin.licensor.institutions', compact('licensor', 'institutions', 'coulmn', 'from_id', 'to_id',
                'target_types', 'neighborhoods', 'licensors', 'institution_types', 'name',
                "mobile_two", "mobile", "mobile_one", "institution_type_ids",
                "neighborhood_id", "responsible_person", "licensor_ids", "address",
                "target_types_ids", 'max_id', 'max_id'));
        } else {
            event(new NewLogCreated('المحاولة للوصول لجهة ترخيص غير موجود برقم : ', $id, 158, 1, null));
            return redirect("/admin/licensors")->with('error', 'الجهة ترخيص غير موجود');
        }
    }
}
