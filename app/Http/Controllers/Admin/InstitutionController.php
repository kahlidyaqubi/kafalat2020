<?php

namespace App\Http\Controllers\Admin;

use App\Events\NewLogCreated;
use App\FileType;
use App\Governorate;
use App\Http\Requests\InstitutionRequest;
use App\Institution;
use App\InstitutionMedia;
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

class InstitutionController extends Controller
{

    public function index(Request $request)
    {
        $name = $request["name"] ?? "";
        $responsible_person = $request["responsible_person"] ?? "";
        $address = $request["address"] ?? "";
        $institution_type_ids = $request["institution_type_ids"] ? array_filter($request["institution_type_ids"]) : [];
        $licensor_ids = $request["licensor_ids"] ? array_filter($request["licensor_ids"]) : [];
        $target_types_ids = $request["target_types_ids"] ? array_filter($request["target_types_ids"]) : [];
        $the_mobile = $request["the_mobile"] ?? "";
        $city_id = $request["city_id"] ?? "";
        $neighborhood_ids = $request["neighborhood_ids"] ? array_filter($request["neighborhood_ids"]) : [];
        $governorate_id = $request["governorate_id"] ?? "";
        $min_id = Institution::first()->id ?? 1;
        $max_id = Institution::orderByDesc('id')->first()->id ?? 1;
        $from_id = $request["from_id"] ?? $min_id;
        $to_id = $request["to_id"] ?? $max_id;
        $coulmn = $request["coulmn"] ?? "";

        $institutions = Institution::when($name, function ($query) use ($name) {
            return $query->where('name', 'like', '%' . $name . '%');
        })->when($from_id && $to_id, function ($query) use ($from_id, $to_id) {
            return $query->whereBetween('id', [$from_id, $to_id]);
        })->when($institution_type_ids, function ($query) use ($institution_type_ids) {
            return $query->whereIn('institution_type_id', $institution_type_ids);
        })->when($the_mobile, function ($query) use ($the_mobile) {
            $query->where('mobile_one', 'like', '%' . $the_mobile . '%')
                ->orWhere('mobile', 'like', '%' . $the_mobile . '%')
                ->orWhere('mobile_two', 'like', '%' . $the_mobile . '%');
        })->when($address, function ($query) use ($address) {
            $query->whereHas('neighborhood'
                , function ($q) use ($address) {
                    $q->where('name', 'like', '%' . $address . '%');
                })->orWhere('address', 'like', '%' . $address . '%');
        })->when($licensor_ids, function ($query) use ($licensor_ids) {
            return $query->whereIn('licensor_id', $licensor_ids);
        })->when($responsible_person, function ($query) use ($responsible_person) {
            return $query->where('responsible_person', 'like', '%' . $responsible_person . '%');
        })->when($neighborhood_ids, function ($query) use ($neighborhood_ids) {
            return $query->whereIn('neighborhood_id', $neighborhood_ids);
        })->when($from_id && $to_id, function ($query) use ($from_id, $to_id) {
            return $query->whereBetween('id', [$from_id, $to_id]);
        })->when(($governorate_id) && !($city_id) && !($neighborhood_ids), function ($query) use ($governorate_id) {
            $cities_ids = City::where('governorate_id', $governorate_id)->pluck('id')->toArray();
            $neighborhoods_ids = Neighborhood::whereIn('city_id', $cities_ids)->pluck('id')->toArray();
            return $query->whereIn('neighborhood_id', $neighborhoods_ids);
        })->when(($city_id) && !($neighborhood_ids), function ($query) use ($city_id) {
            $neighborhoods_ids = Neighborhood::where('city_id', $city_id)->pluck('id')->toArray();
            return $query->whereIn('neighborhood_id', $neighborhoods_ids);
        })->when($target_types_ids && ($target_types_ids[0] != null || count($target_types_ids) > 1), function ($query) use ($target_types_ids) {
            foreach ($target_types_ids as $target_type_id) {
                return $query->whereHas('target_types', function ($q) use ($target_type_id) {
                    $q->where('target_types.id', $target_type_id);
                });
            }
        })->orderBy("institutions.id",'desc')->paginate(20)
            ->appends([
                "name" => $name, "from_id" => $from_id, "to_id" => $to_id, "coulmn" => $coulmn,
                "the_mobile" => $the_mobile, "institution_type_ids" => $institution_type_ids,
                "city_id" => $city_id, "neighborhood_ids" => $neighborhood_ids, "governorate_id" => $governorate_id, "responsible_person" => $responsible_person, "licensor_ids" => $licensor_ids, "address" => $address,
                "target_types_ids" => $target_types_ids,]);

        if ($request["coulmn"] == []) {
            $coulmn = ['id', 'name', 'responsible_person', 'institution_type', 'address', 'mobile_one', 'operations'];
        }

        $target_types = TargetType::orderBy('name')->get();
        $governorates = Governorate::orderBy('name')->get();
        $licensors = licensor::orderBy('name')->get();
        $institution_types = InstitutionType::orderBy('name')->get();


        return view('admin.institution.index', compact('institutions', 'coulmn', 'from_id', 'to_id',
            'target_types', 'governorates', 'licensors', 'institution_types', 'name',
            "the_mobile", "institution_type_ids",
            "neighborhood_ids", "responsible_person", "licensor_ids", "address",
            "target_types_ids", 'max_id', 'min_id', "city_id", "governorate_id"));

    }

    public function create()
    {
        $target_types = TargetType::orderBy('name')->where('status', 1)->get();
        $neighborhoods = Neighborhood::orderBy('name')->where('status', 1)->get();
        $licensors = licensor::orderBy('name')->where('status', 1)->get();
        $governorates = Governorate::orderBy('name')->get();
        $institution_types = InstitutionType::orderBy('name')->get();

        return view('admin.institution.create', compact('target_types', 'governorates', 'neighborhoods', 'licensors', 'institution_types'));

    }

    public function store(InstitutionRequest $request)
    {
        $come_by = $request['come_by'] ?? "";
        if ($request['neighborhood_id'] == 1 && ($request['neighborhood_id_other']) && ($request['city_id'])) {
            $neighborhood = Neighborhood::where('name', $request['neighborhood_id_other'])->first();
            if ($neighborhood)
                $neighborhood_id = $neighborhood->id;
            else
                $neighborhood_id = Neighborhood::create(['name' => $request['neighborhood_id_other'], 'status' => 0, 'city_id' => $request['city_id']])->id;
            $request['neighborhood_id'] = $neighborhood_id;
            request()['neighborhood_id'] = $neighborhood_id;
        }
        if ($request['licensor_id'] == 1 && ($request['licensor_id_other'])) {
            $licensor = licensor::where('name', $request['licensor_id_other'])->first();
            if ($licensor)
                $licensor_id = $licensor->id;
            else
                $licensor_id = licensor::create(['name' => $request['licensor_id_other'], 'status' => 0])->id;
            $request['licensor_id'] = $licensor_id;
            request()['licensor_id'] = $licensor_id;
        }
        if ($request['institution_type_id'] == 1 && ($request['institution_type_id_other'])) {
            $institution_type = InstitutionType::where('name', $request['institution_type_id_other'])->first();
            if ($institution_type)
                $institution_type_id = $institution_type->id;
            else
                $institution_type_id = InstitutionType::create(['name' => $request['institution_type_id_other'], 'status' => 0])->id;
            $request['institution_type_id'] = $institution_type_id;
            request()['institution_type_id'] = $institution_type_id;
        }

        $institution = Institution::create(request()->except(
            ['neighborhood_id_other', 'come_by', 'other_targets', 'licensor_id_other', 'target_types_ids', 'institution_type_id_other', 'city_id', 'governorate_id']
        ));


        if ($request["other_targets"]) {
            $other_targets = explode(",", $request["other_targets"]);
            $other_targets_ids = [];
            for ($i = 0; $i < count($other_targets); $i++) {
                if (!TargetType::where('name', $other_targets[$i])->first()) {
                    $target_id = TargetType::create([
                        'name' => $other_targets[$i],
                        'status' => "0"
                    ])->id;
                } else {
                    $target_id = TargetType::where('name', $other_targets[$i])->first()->id;
                }
                $other_targets_ids[$i] = $target_id;
            }

        }

        if (request()['target_types_ids']) {
            if ($request["other_targets"])
                $all_targets = array_merge($other_targets_ids, request()['target_types_ids'] ? array_filter($request["target_types_ids"]) : []);
            else
                $all_targets = request()['target_types_ids'] ? array_filter($request["target_types_ids"]) : [];

            $institution->target_types()->sync(
                $all_targets
            );
        } else {
            if ($request["other_targets"]) {
                $all_targets = $other_targets_ids;
                $institution->target_types()->sync(
                    $all_targets
                );
            }
        }
        event(new NewLogCreated('تم انشاء جمعية بنجاح', $institution->name, 141, 0, null));
        $action = Action::create(['title' => 'تم إضافة جمعية جديدة', 'type' => Permission::findByName('list institutions')->title, 'link' => Permission::findByName('list institutions')->link]);
        $users = User::permission('institutions')->whereNotIn('id', [auth()->user()->id])->get();
        if ($users->first())
            Notification::send($users, new NotifyUsers($action));

        if ($come_by == "season_coupon")
            return redirect('/admin/season_coupons/create?institution_id=' . $institution->id);
        elseif ($come_by == "urgent_coupon")
            return redirect('/admin/urgent_coupons/create?institution_id=' . $institution->id);
        else
            return back()->with('success', 'تم انشاء جمعية بنجاح');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $institution = Institution::find($id);

        if (!is_null($institution)) {
            $target_types = TargetType::orderBy('name')->get();
            $licensors = licensor::orderBy('name')->get();
            $institution_types = InstitutionType::orderBy('name')->get();
            $governorates = Governorate::orderBy('name')->get();
            return view('admin.institution.edit', compact('target_types', 'institution', 'governorates', 'licensors', 'institution_types'));

        } else {
            event(new NewLogCreated('المحاولة للوصول لجمعية غير موجودة برقم : ', $id, 142, 1, null));
            return redirect("/admin/institutions")->with('error', 'الجمعية غير موجودة');
        }

    }

    public function update(InstitutionRequest $request, $id)
    {
        $come_by = $request['come_by'] ?? "";
        $institution = Institution::find($id);

        if (!is_null($institution)) {
            if ($request['neighborhood_id'] == 1 && ($request['neighborhood_id_other']) && ($request['city_id'])) {
                $neighborhood = Neighborhood::where('name', $request['neighborhood_id_other'])->first();
                if ($neighborhood)
                    $neighborhood_id = $neighborhood->id;
                else
                    $neighborhood_id = Neighborhood::create(['name' => $request['neighborhood_id_other'], 'status' => 0, 'city_id' => $request['city_id']])->id;
                $request['neighborhood_id'] = $neighborhood_id;
                request()['neighborhood_id'] = $neighborhood_id;
            }
            if ($request['licensor_id'] == 1 && ($request['licensor_id_other'])) {
                $licensor = licensor::where('name', $request['licensor_id_other'])->first();
                if ($licensor)
                    $licensor_id = $licensor->id;
                else
                    $licensor_id = licensor::create(['name' => $request['licensor_id_other'], 'status' => 0])->id;
                $request['licensor_id'] = $licensor_id;
                request()['licensor_id'] = $licensor_id;
            }
            if ($request['institution_type_id'] == 1 && ($request['institution_type_id_other'])) {
                $institution_type = InstitutionType::where('name', $request['institution_type_id_other'])->first();
                if ($institution_type)
                    $institution_type_id = $institution_type->id;
                else
                    $institution_type_id = InstitutionType::create(['name' => $request['institution_type_id_other'], 'status' => 0])->id;
                $request['institution_type_id'] = $institution_type_id;
                request()['institution_type_id'] = $institution_type_id;
            }
            $institution->update(request()->except(
                ['file_type_id', 'files', 'file_type_id_other', "come_by", 'other_targets', 'target_types_ids', 'neighborhood_id_other', 'licensor_id_other', 'institution_type_id_other', 'city_id', 'governorate_id']));
            if ($request["other_targets"]) {
                $other_targets = explode(",", $request["other_targets"]);
                $other_targets_ids = [];
                for ($i = 0; $i < count($other_targets); $i++) {
                    if (!TargetType::where('name', $other_targets[$i])->first()) {
                        $target_id = TargetType::create([
                            'name' => $other_targets[$i],
                            'status' => "0"
                        ])->id;
                    } else {
                        $target_id = TargetType::where('name', $other_targets[$i])->first()->id;
                    }
                    $other_targets_ids[$i] = $target_id;
                }
            }

            if (request()['target_types_ids']) {
                if ($request["other_targets"])
                    $all_targets = array_merge($other_targets_ids, request()['target_types_ids'] ? array_filter($request["target_types_ids"]) : []);
                else
                    $all_targets = request()['target_types_ids'] ? array_filter($request["target_types_ids"]) : [];

                $institution->target_types()->sync(
                    $all_targets
                );
            } else {
                if ($request["other_targets"]) {
                    $all_targets = $other_targets_ids;
                    $institution->target_types()->sync(
                        $all_targets
                    );
                }
            };
            if ($request['files']) {

                if (count($request['files']) != count($request['file_type_id'])) {
                    event(new NewLogCreated(' يرجى ادخال نوع الملف ', $institution->name, 142, 0, 0));
                    return back()->with('error', 'يرجى ادخال نوع الملف ');
                }

                $fileArray = [];
                for ($i = 0; $i < count($request['files']); $i++) {
                    if (
                        (!is_null($request['files'][$i])) &&
                        (!is_null($request['file_type_id'][$i]))

                    ) {
                        $fileArray[$i]['files'] = $request['files'][$i];
                        if ($request['file_type_id'][$i] == 1 && ($request['file_type_id_other'][$i])) {
                            $file_type = FileType::where('name', $request['file_type_id_other'][$i])->first();
                            if ($file_type)
                                $file_type_id = $file_type->id;
                            else
                                $file_type_id = FileType::create(['name' => $request['file_type_id_other'][$i], 'status' => 0])->id;

                            $fileArray[$i]['file_type_id'] = $file_type_id;
                        } else {
                            $fileArray[$i]['file_type_id'] = $request['file_type_id'][$i];
                        }

                    }
                }

                if (count($fileArray) > 0) {

                    foreach ($fileArray as $file) {
                        $fileName = time() . '.' . $file['files']->getClientOriginalExtension();
                        $path = 'uploads/institutions/';
                        $upload = $file['files']->move($path, $fileName);
                        $file_type_id = $file['file_type_id'];

                        $mediaData = [
                            'path' => $upload,
                            'file_type_id' => $file_type_id,
                            'institution_id' => $institution->id
                        ];
                        InstitutionMedia::create($mediaData);
                    }

                } else {
                    event(new NewLogCreated(' لم يتم إضافة مرفقات ', $institution->name, 142, 0, 0));
                    return back()->with('error', 'لم  يتم إضافة مرفقات ');
                }
            }
            event(new NewLogCreated('تعديل البيانات بنجاح', $institution->name, 142, 1, null));
            $action = Action::create(['title' => 'تم تعديل جمعية', 'type' => Permission::findByName('list institutions')->title, 'link' => Permission::findByName('list institutions')->link]);
            $users = User::permission('institutions')->whereNotIn('id', [auth()->user()->id])->get();
            if ($users->first())
                Notification::send($users, new NotifyUsers($action));
            if ($come_by == "season_coupon")
                return redirect('/admin/season_coupons/create?institution_id=' . $institution->id);
            elseif ($come_by == "urgent_coupon")
                return redirect('/admin/urgent_coupons/create?institution_id=' . $institution->id);
            else
                return redirect("/admin/institutions")->with('success', 'تم تعديل البيانات بنجاح');

        } else {
            event(new NewLogCreated('المحاولة للوصول لجمعية غير موجودة برقم : ', $id, 142, 1, null));
            return redirect("/admin/institutions")->with('error', 'الجمعية غير موجودة');
        }
    }

    public function destroy($id)
    {
        //
    }

    public function delete($id)
    {
        $institution = Institution::find($id);
       
        if (!is_null($institution)) {
 $institutionName = $institution->name;
            if ($institution->urgent_coupons->first() || $institution->season_coupons->first()) {
                event(new NewLogCreated('لا يمكن حذف مؤسسة مرتبط بمساعدات : ', $id, 143, 1, null));
                return redirect("/admin/institutions")->with('error', 'لا يمكن حذف مؤسسة مرتبط بمساعدات');
            }

            $institution->target_types()->sync([
            ]);
            $institution->delete();
            event(new NewLogCreated('تم حذف جمعية بنجاح ', $institutionName, 143, 0, null));
            $action = Action::create(['title' => 'تم حذف جمعية', 'type' => Permission::findByName('list institutions')->title, 'link' => Permission::findByName('list institutions')->link]);
            $users = User::permission('institutions')->whereNotIn('id', [auth()->user()->id])->get();
            if ($users->first())
                Notification::send($users, new NotifyUsers($action));
            return redirect("/admin/institutions")->with('success', 'تم حذف جمعية بنجاح');
        } else {
            event(new NewLogCreated('المحاولة للوصول لجمعية غير موجودة برقم : ', $id, 142, 1, null));
            return redirect("/admin/institutions")->with('error', 'الجمعية غير موجودة');
        }
    }

    public function urgent_coupons($id, Request $request)
    {
        $institution = Institution::find($id);
        if (!is_null($institution)) {

            $institutions_ids_yes = $request['institutions_ids_yes'];
            $institutions_ids_no = $request['institutions_ids_no'];
            $delivery_status = $request["delivery_status"] ?? "";
            $min_id = Institution::find($id)->urgent_coupons->first()->id ?? 1;
            $max_id = Institution::find($id)->urgent_coupons->orderByDesc('id')->first()->id ?? 1;
            $from_id = $request["from_id"] ?? $min_id;
            $to_id = $request["to_id"] ?? $max_id;
            $from_his_date = $request["from_his_date"] ?? "";
            $to_his_date = $request["to_his_date"] ?? "";
            $families_yes = $request['families_yes'];  // علاقة
            $families_no = $request['families_no'];  // علاقة
            $coupon_type = $request['coupon_type'];
            $funder_type = $request['funder_type'];
            $sponsors_ids = $request['sponsors_ids'];
            $admin_status_ids = $request['admin_status_ids'];
            $family_or_institution = $request['family_or_institution'];
            $coulmn = $request["coulmn"] ?? "";

            $urgent_coupons = Institution::find($id)->urgent_coupons->when($institutions_ids_yes, function ($query) use ($institutions_ids_yes) {
                return $query->whereIn('institution_id', $institutions_ids_yes);
            })->when($institutions_ids_no, function ($query) use ($institutions_ids_no) {
                return $query->whereNotIn('institution_id', $institutions_ids_no);
            })->when($coupon_type, function ($query) use ($coupon_type) {
                return $query->where('coupon_type', $coupon_type);
            })->when($funder_type, function ($query) use ($funder_type) {
                return $query->where('funder_type', $funder_type);
            })->when($sponsors_ids, function ($query) use ($sponsors_ids) {
                return $query->whereIn('sponsors_id', $sponsors_ids);
            })->when($admin_status_ids, function ($query) use ($admin_status_ids) {
                return $query->whereIn('admin_status_id', $admin_status_ids);
            })->when($family_or_institution, function ($query) use ($family_or_institution) {
                if ($family_or_institution == 2)
                    return $query->where('institution_id', '>', 0);
                elseif ($family_or_institution == 1)
                    return $query->where('family_id', '>', 0);
            })->when(($delivery_status || $delivery_status == '0'), function ($query) use ($delivery_status) {
                return $query->where('delivery_status', $delivery_status);
            })->when($from_id && $to_id, function ($query) use ($from_id, $to_id) {
                return $query->whereBetween('id', [$from_id, $to_id]);
            })->when($from_his_date && $to_his_date, function ($query) use ($from_his_date, $to_his_date) {
                return $query->whereHas('expense'
                    , function ($q) use ($from_his_date, $to_his_date) {
                        $q->whereBetween('his_date', [$from_his_date, $to_his_date]);
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
                $coulmn = ['id', 'family_or_institution', 'coupon_type', 'his_date', 'delivery_status', 'operations'];
            }

            $admin_statuses = AdminStatuse::orderBy('name')->get();
            $institutions = Institution::orderBy('name')->get();
            if ($request['theaction'] == 'print') {
                $the_date = Carbon::now();
                $urgent_coupons = $urgent_coupons->orderBy("urgent_coupons.id", 'desc')->get();
                $pdf = Pdf::loadView('admin.urgent_coupon.print_all', compact('urgent_coupons'));
                return $pdf->stream("المساعدات $the_date.pdf");
            } elseif ($request['theaction'] == 'excel') {
                $the_date = Carbon::now();
                $urgent_coupons = $urgent_coupons->orderBy("urgent_coupons.id", 'desc')->get();
                return Excel::download(new  UrgentCouponExport($coulmn, $urgent_coupons), "المساعدات $the_date.xlsx");

            } else {
                $urgent_coupons = $urgent_coupons->orderBy("urgent_coupons.id",'desc')->paginate(20)
                    ->appends([
                        "institutions_ids_yes" => $institutions_ids_yes, "institutions_ids_no" => $institutions_ids_no, "delivery_status" => $delivery_status,
                        "from_id" => $from_id, "to_id" => $to_id, "from_his_date" => $from_his_date, "to_his_date" => $to_his_date,
                        "families_no" => $families_no, "families_yes" => $families_yes, "coulmn" => $coulmn,
                        "family_or_institution" => $family_or_institution, "funder_type" => $funder_type, "admin_status_ids" => $admin_status_ids, "sponsors_ids" => $sponsors_ids, "funder_type" => $funder_type, "coupon_type" => $coupon_type,
                    ]);

                return view('admin.institution.urgent_coupons', compact('urgent_coupons', "institutions_ids_yes", "institutions_ids_no", "delivery_status",
                    "from_id", "to_id", "from_his_date", "to_his_date", "families_no", "families_yes", "coulmn", 'min_id', 'max_id',
                    "family_or_institution", "funder_type", "admin_status_ids", "sponsors_ids", "funder_type", "coupon_type"
                    , "admin_statuses", "institutions", "institution"
                ));

            }


        } else {
            event(new NewLogCreated('المحاولة للوصول لجمعية غير موجودة برقم : ', $id, 142, 1, null));
            return redirect("/admin/institutions")->with('error', 'الجمعية غير موجودة');
        }
    }

    public function season_coupons($id, Request $request)
    {
        $institution = Institution::find($id);
        if (!is_null($institution)) {
            $institutions_ids_yes = $request['institutions_ids_yes'];
            $institutions_ids_no = $request['institutions_ids_no'];
            $delivery_status = $request["delivery_status"] ?? "";
            $min_id = Institution::find($id)->season_coupons->first()->id ?? 1;
            $max_id = Institution::find($id)->season_coupons->orderByDesc('id')->first()->id ?? 1;
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
            $family_or_institution = $request['family_or_institution'];
            $coulmn = $request["coulmn"] ?? "";

            $season_coupons = Institution::find($id)->season_coupons->when($institutions_ids_yes, function ($query) use ($institutions_ids_yes) {
                return $query->whereIn('institution_id', $institutions_ids_yes);
            })->when($institutions_ids_no, function ($query) use ($institutions_ids_no) {
                return $query->whereNotIn('institution_id', $institutions_ids_no);
            })->when($delivery_place, function ($query) use ($delivery_place) {
                return $query->where('delivery_place', $delivery_place);
            })->when($admin_status_ids, function ($query) use ($admin_status_ids) {
                return $query->whereIn('admin_status_id', $admin_status_ids);
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
                    ]);

                return view('admin.institution.season_coupons', compact('season_coupons', "institutions_ids_yes", "institutions_ids_no", "delivery_status",
                    "from_id", "to_id", "from_delivery_date", "to_delivery_date", "from_execution_date", "to_execution_date", "from_application_date", "to_application_date", "families_no", "families_yes", "coulmn", 'min_id', 'max_id',
                    "family_or_institution", "admin_status_ids", "delivery_place"
                    , "admin_statuses", "institutions", "institution"
                ));
            }
        } else {
            event(new NewLogCreated('المحاولة للوصول لجمعية غير موجودة برقم : ', $id, 142, 1, null));
            return redirect("/admin/institutions")->with('error', 'الجمعية غير موجودة');
        }
    }

    public function removeMedia($id)
    {

        if (!is_null($id)) {
            $media = InstitutionMedia::find($id);

            if (!is_null($media)) {
                $institutionId = $media->institution_id;
                $mypath = public_path() . "/" . $media->path; // مكان التخزين في البابليك ثم مجلد ابلودز
                if (file_exists($mypath) && $mypath != null) {//اذا يوجد ملف قديم مخزن
                    unlink($mypath);//يقوم بحذف القديم
                }

                if ($media->delete()) {
                    event(new NewLogCreated('تم حذف مرفق  جمعية برقم :  ', $institutionId, 100, 1, url('admin/institutions/'.$institutionId.'/edit')));
                    return back()->with('success', 'تم حذف مرفق  جمعية بنجاح  ');
                }
                event(new NewLogCreated('لم يتم حذف مرفق  جمعية برقم :  ', $institutionId, 100, 1, url('admin/institutions/'.$institutionId.'/edit')));
                return back()->with('error', 'لم يتم حذف مرفق  بنجاح  ');

            } else {
                event(new NewLogCreated('لم يتم العثور على  مرفق جمعية بنجاح برقم : ', $id, 100, 0, null));
                return back()->with('error', 'لم يتم العثور على  مرفق جمعية بنجاح');
            }

        } else {
            event(new NewLogCreated('لم يتم العثور على  مرفق جمعية بنجاح برقم : ', $id, 100, 0, null));
            return back()->with('error', 'لم يتم العثور على  مرفق جمعية بنجاح');
        }
    }
}
