<?php

namespace App\Http\Controllers\Admin;

use App\AdminStatuse;
use App\Events\SmsEvent;
use App\City;
use App\Country;
use App\CouponReason;
use App\Currency;
use File;
use App\Disease;
use App\EducationalInstitution;
use App\Events\NewLogCreated;
use App\Export\UrgentCouponExport;
use App\Family;
use App\FamilyProject;
use App\FamilyStatus;
use App\FamilyType;
use App\FileType;
use App\InstitutionType;
use App\licensor;
use App\TargetType;
use App\FundedInstitution;
use App\FurnitureStatus;
use App\Governorate;
use App\HouseOwnership;
use App\HouseRoof;
use App\HouseStatus;
use App\Http\Requests\UrgentCouponRequest;
use App\IDType;
use App\IncomeType;
use App\Institution;
use App\ItemCategory;
use App\JobType;
use App\Neighborhood;
use App\Person;
use App\Qualification;
use App\QualificationLevels;
use App\Relationship;
use App\SocialStatus;
use App\StudyLevel;
use App\StudyPart;
use App\StudyType;
use App\UniversitySpecialty;
use App\UrgentCoupon;
use App\UrgentCouponMedia;
use App\User;
use App\VisitReason;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Action;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use niklasravnsborg\LaravelPdf\Facades\Pdf;
use Notification;
use App\Notifications\NotifyUsers;
use Spatie\Permission\Models\Permission;

class UrgentCouponController extends Controller
{
    public function index(Request $request)
    {

        /**/
        $funded_institutions_ids_yes = $request['funded_institutions_ids_yes'] ? array_filter($request["funded_institutions_ids_yes"]) : [];
        /**/
        $funded_institutions_ids_no = $request['funded_institutions_ids_no'] ? array_filter($request["funded_institutions_ids_no"]) : [];
        /**/
        $delivery_status = $request["delivery_status"] ?? "";
        $min_id = UrgentCoupon::first()->id ?? 1;
        $max_id = UrgentCoupon::orderByDesc('id')->first()->id ?? 1;
        $from_id = $request["from_id"] ?? $min_id;
        $to_id = $request["to_id"] ?? $max_id;
        /**/
        $from_his_date = $request["from_his_date"] ?? "";
        /**/
        $to_his_date = $request["to_his_date"] ?? "";
        /**/
        $families_yes = $request['families_yes'] ? array_filter($request["families_yes"]) : []; // علاقة
        /**/
        $families_no = $request['families_no'] ? array_filter($request["families_no"]) : [];  // علاقة
        /**/
        $coupon_type = $request['coupon_type'];
        /**/
        $funder_type = $request['funder_type'];
        /**/
        $sponsors_ids = $request['sponsors_ids'] ? array_filter($request["sponsors_ids"]) : [];
        /**/
        $admin_status_ids = $request['admin_status_ids'] ? array_filter($request["admin_status_ids"]) : [];
        /**/
        $family_or_institution = $request['family_or_institution'];
        $coulmn = $request["coulmn"] ?? "";

        $urgent_coupons = UrgentCoupon::when($funded_institutions_ids_yes, function ($query) use ($funded_institutions_ids_yes) {
            return $query->whereIn('institution_id', $funded_institutions_ids_yes);
        })->when($funded_institutions_ids_no, function ($query) use ($funded_institutions_ids_no) {
            return $query->whereNotIn('institution_id', $funded_institutions_ids_no);
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
            return $query->whereBetween('his_date', [$from_his_date, $to_his_date]);
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
            $coulmn = ['id', 'select', 'family_or_institution', 'coupon_type', 'his_date', 'delivery_status', 'operations'];
        }

        $admin_statuses = AdminStatuse::orderBy('name')->get();
        $institutions = Institution::orderBy('name')->get();
        if ($request['theaction'] == 'print') {
            $the_date = Carbon::now();
            $urgent_coupons = $urgent_coupons->orderBy("urgent_coupons.id", 'desc')->take(500)->get();
            $pdf = Pdf::loadView('admin.urgent_coupon.print_all', compact('urgent_coupons', 'coulmn'));
            return $pdf->stream("المساعدات $the_date.pdf");
        } elseif ($request['theaction'] == 'excel') {
            $the_date = Carbon::now();
            $urgent_coupons = $urgent_coupons->orderBy("urgent_coupons.id", 'desc')->take(500)->get();

            return
                Excel::create("المساعدات $the_date.xlsx", function ($excel) use ($urgent_coupons, $coulmn) {

                    $excel->sheet('New sheet', function ($sheet) use ($urgent_coupons, $coulmn) {


                        $sheet->loadView('admin.urgent_coupon.print_all', [
                            'urgent_coupons' => $urgent_coupons,
                            'coulmn' => $coulmn,
                        ]);


                    });

                })->export('xlsx');

            //return Excel::download(new  UrgentCouponExport($coulmn, $urgent_coupons), "المساعدات $the_date.xlsx");

        } else {
            $urgent_coupons = $urgent_coupons->orderBy("urgent_coupons.id", 'desc')->paginate(20)
                ->appends([
                    "funded_institutions_ids_yes" => $funded_institutions_ids_yes, "funded_institutions_ids_no" => $funded_institutions_ids_no, "delivery_status" => $delivery_status,
                    "from_id" => $from_id, "to_id" => $to_id, "from_his_date" => $from_his_date, "to_his_date" => $to_his_date,
                    "families_no" => $families_no, "families_yes" => $families_yes, "coulmn" => $coulmn,
                    "family_or_institution" => $family_or_institution, "funder_type" => $funder_type, "admin_status_ids" => $admin_status_ids, "sponsors_ids" => $sponsors_ids, "funder_type" => $funder_type, "coupon_type" => $coupon_type,
                ]);

            return view('admin.urgent_coupon.index', compact('urgent_coupons', "funded_institutions_ids_yes", "funded_institutions_ids_no", "delivery_status",
                "from_id", "to_id", "from_his_date", "to_his_date", "families_no", "families_yes", "coulmn", 'min_id', 'max_id',
                "family_or_institution", "funder_type", "admin_status_ids", "sponsors_ids", "funder_type", "coupon_type"
                , "admin_statuses", "institutions"
            ));

        }


    }

    public function searctoaddcoupon()
    {
        $institutions = Institution::orderBy('name')->get();
        return view("admin.urgent_coupon.search", compact('institutions'));
    }

    public function editorcreat(Request $request)
    {

        $testeroor = $this->validate($request, [
            'type' => 'required',
        ]);


        $type = $request['type'] ?? "";

        if ($type == 1) {
            $testeroor = $this->validate($request, [
                'family_id' => 'required',
            ]);
        } elseif ($type == 2) {
            $testeroor = $this->validate($request, [
                'institution_id' => 'required',
            ]);
        } elseif ($type == 3) {
            $family_id = -1;
            $type = 1;
        } elseif ($type == 4) {
            $institution_id = -1;
            $type = 2;
        }

        $family_id = $request['family_id'] ?? "";
        $institution_id = $request['institution_id'] ?? "";
        if ($type == 1) {
            $projects = FamilyProject::all();
            $idTypes = IDType::all();
            $relationships = Relationship::where('status', 1)->get();
            $qualifications = Qualification::all();
            $jobTypes = JobType::all();
            $socialStatuses = SocialStatus::all();
            $cities = City::all();
            $houseOwners = HouseOwnership::all();
            $houseRoofs = HouseRoof::all();
            $houseStatuses = HouseStatus::all();
            $types = FamilyType::all();
            $studyLevels = StudyLevel::all();
            $studyParts = StudyPart::all();
            $studyTypes = StudyType::all();
            $fundedInstitutions = FundedInstitution::where('status', 1)->get();
            $statuses = FamilyStatus::all();
            $visitReasons = VisitReason::where('status', 1)->get();
            $users = User::all();
            $diseases = Disease::all();
            $universitySpecialties = UniversitySpecialty::where('status', 1)->get();
            $educationalInstitutions = EducationalInstitution::where('status', 1)->get();
            $incomeTypes = IncomeType::all();
            $fileTypes = FileType::all();
            $countries = Country::all();
            $qualificationLevels = QualificationLevels::all();
            $neighborhoods = Neighborhood::all();
            $governorates = Governorate::all();
            $furnitureStatuses = FurnitureStatus::all();
            $come_by = 'urgent_coupon';
            $first_family = Family::find($family_id);
            if ($first_family) {
                if ($first_family->parent_id > 0) {
                    $family = Family::find($first_family->parent_id);
                } else {
                    $family = Family::find($first_family->id);
                }
                if ($family) {

                    return view('admin.family.edit', compact('come_by', 'furnitureStatuses', 'qualificationLevels', 'governorates', 'neighborhoods', 'countries', 'projects', 'fileTypes', 'family', 'incomeTypes', 'countries', 'educationalInstitutions', 'universitySpecialties', 'diseases', 'idTypes', 'relationships', 'jobTypes', 'qualifications', 'socialStatuses', 'cities', 'houseOwners', 'houseRoofs', 'houseStatuses', 'types', 'studyLevels', 'studyParts', 'studyTypes', 'fundedInstitutions', 'statuses', 'visitReasons', 'users'));

                } else {
                    return view('admin.family.create', compact('come_by', 'qualificationLevels', 'neighborhoods', 'governorates', 'projects', 'jobTypes', 'incomeTypes', 'countries', 'educationalInstitutions', 'universitySpecialties', 'diseases', 'idTypes', 'relationships', 'jobTypes', 'qualifications', 'socialStatuses', 'cities', 'houseOwners', 'houseRoofs', 'houseStatuses', 'types', 'studyLevels', 'studyParts', 'studyTypes', 'fundedInstitutions', 'statuses', 'visitReasons', 'users'));

                }
            } else {
                return view('admin.family.create', compact('come_by', 'qualificationLevels', 'neighborhoods', 'governorates', 'projects', 'jobTypes', 'incomeTypes', 'countries', 'educationalInstitutions', 'universitySpecialties', 'diseases', 'idTypes', 'relationships', 'jobTypes', 'qualifications', 'socialStatuses', 'cities', 'houseOwners', 'houseRoofs', 'houseStatuses', 'types', 'studyLevels', 'studyParts', 'studyTypes', 'fundedInstitutions', 'statuses', 'visitReasons', 'users'));

            }
        } else {
            $institution = Institution::find($institution_id);
            $target_types = TargetType::orderBy('name')->where('status', 1)->get();
            $governorates = Governorate::orderBy('name')->get();
            $licensors = licensor::orderBy('name')->where('status', 1)->get();
            $institution_types = InstitutionType::orderBy('name')->get();
            $come_by = 'urgent_coupon';
            if ($institution) {
                return view('admin.institution.edit', compact('come_by', 'target_types', 'institution', 'governorates', 'licensors', 'institution_types'));

            } else {
                return view('admin.institution.create', compact('come_by', 'target_types', 'governorates', 'licensors', 'institution_types'));
            }
        }
    }

    public function create(Request $request)
    {


        $admin_statuses = AdminStatuse::orderBy('name')->get();
        $item_categories = ItemCategory::orderBy('name')->get();
        $currencies = Currency::orderBy('name')->get();
        $coupon_reasons = CouponReason::orderBy('name')->get();
        $family_id = $request['family_id'] ?? "";
        $institution_id = $request['institution_id'] ?? "";
        $countries = Country::orderBy('name')->get();

        if (!($institution_id) && !($family_id)) {
            event(new NewLogCreated('المحاولة للوصول لمساعدة غير موجودة  : ', null, 171, 1, null));
            return redirect("/admin/urgent_coupons")->with('error', 'المساعدة غير موجودة');
        }

        return view('admin.urgent_coupon.create', compact('institution_id', 'countries', 'admin_statuses', 'item_categories', 'currencies', 'coupon_reasons', 'family_id'));
    }

    public function store(UrgentCouponRequest $request)
    {

        request()['created_by'] = auth()->user()->id;

        $urgent_coupon = UrgentCoupon::create(request()->except(['item_types_ids', 'item_categories', 'item_types_numbers', 'item_types_values', 'item_types_ids_other']));

        $item_categories = $request['item_categories'] ? array_values(array_filter($request["item_categories"])) : [];
        $item_types_ids = $request['item_types_ids'] ? array_values(array_filter($request["item_types_ids"])) : [];
        $item_types_numbers = $request['item_types_numbers'] ? array_values(array_filter($request["item_types_numbers"])) : [];
        $item_types_values = $request['item_types_values'] ? array_values(array_filter($request["item_types_values"])) : [];
        $item_types_ids_other = $request['item_types_ids_other'] ? array_values(array_filter($request["item_types_ids_other"])) : [];

        if ($request['coupon_type'] == 1) {
                $urgent_coupon->item_types()->sync(
                    []
                );
            }else{
       if (
            (($item_types_ids) && count($item_types_ids) == count($item_types_numbers)
            && count($item_categories) == count($item_types_ids)
                && count($item_types_ids) == count($item_types_values))
            || !($item_types_ids) && !($item_types_numbers)) {
            for ($i = 0; $i < count($item_types_ids); $i++) {
                if ($item_types_ids[$i] == -1 && empty($item_types_ids_other[$i]))
                    continue;
                if ($item_types_ids[$i] == -1 && empty($item_types_ids_other[$i])) {
                    $item_type = ItemType::where('name', $item_types_ids_other[$i])->first();
                    if ($item_type)
                        $item_types_ids[$i] = $item_type->id;
                    else
                        $item_types_ids[$i] = ItemType::create(['name' => $item_types_ids_other[$i], 'status' => 0
                        ,'item_category_id'=>$item_categories[$i]])->id;

                }

            }

            $item_types_ids = array_filter($item_types_ids, function ($v) {
                return $v > 0;
            });

            $urgent_coupon->item_types()->sync(
                $item_types_ids
            );
            if ($request['coupon_type'] == 1) {
                $urgent_coupon->item_types()->sync(
                    []
                );
            }
            for ($i = 0; $i < count($item_types_ids); $i++) {
                $urgent_coupon->coupon_item_types()->where('item_type_id', $item_types_ids[$i])
                    ->first()->update(['number' => $item_types_numbers[$i], 'value' => $item_types_values[$i]]);
            }
        }
           else {
            return back()->with('error', 'خانات مقدار المساعدة غير مدخلة بشكل صحيح')->withInput(request()->all());
        }
}
        if ($request['funder_type'] == 0) {
            $urgent_coupon->update(['sponsor_id' => null]);
        }
        event(new NewLogCreated('تم اضافة مساعدة بنجاح', $urgent_coupon->id, 170, 0, null));
        $action = Action::create(['title' => 'تم إضافة مساعدة طارئة جديدة', 'type' => Permission::findByName('list urgent_coupons')->title, 'link' => Permission::findByName('list urgent_coupons')->link]);
        $users = User::permission('urgent_coupons')->whereNotIn('id', [auth()->user()->id])->get();
        if ($users->first())
            Notification::send($users, new NotifyUsers($action));
        return redirect("/admin/urgent_coupons")->with('success', 'تم اضافة مساعدة بنجاح');

    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $urgent_coupon = UrgentCoupon::find($id);

        if (!is_null($urgent_coupon)) {
            $admin_statuses = AdminStatuse::orderBy('name')->get();
            $item_categories = ItemCategory::orderBy('name')->get();
            $currencies = Currency::orderBy('name')->get();
            $coupon_reasons = CouponReason::orderBy('name')->get();
            $family_id = $urgent_coupon->family_id ?? "";
            $institution_id = $urgent_coupon->institution_id ?? "";
            $countries = Country::orderBy('name')->get();
            return view('admin.urgent_coupon.edit', compact('countries', 'institution_id', 'family_id', 'coupon_reasons', 'urgent_coupon', 'item_categories', 'admin_statuses', 'currencies'));

        } else {
            event(new NewLogCreated('المحاولة للوصول لمساعدة غير موجودة برقم : ', $id, 171, 1, null));
            return redirect("/admin/urgent_coupons")->with('error', 'المساعدة غير موجودة');
        }
    }

    public function update(UrgentCouponRequest $request, $id)
    {
        $urgent_coupon = UrgentCoupon::find($id);
        if (!is_null($urgent_coupon)) {
            request()['updated_by'] = auth()->user()->id;
            $urgent_coupon->update(request()->except(['file_type_id', 'files', 'file_type_id_other', 'item_types_ids', 'item_categories', 'item_types_numbers', 'item_types_values', 'item_types_ids_other']));

            $item_categories = $request['item_categories'] ? array_values(array_filter($request["item_categories"])) : [];
            $item_types_ids = $request['item_types_ids'] ? array_values(array_filter($request["item_types_ids"])) : [];
            $item_types_numbers = $request['item_types_numbers'] ? array_values(array_filter($request["item_types_numbers"])) : [];
            $item_types_values = $request['item_types_values'] ? array_values(array_filter($request["item_types_values"])) : [];
            $item_types_ids_other = $request['item_types_ids_other'] ? array_values(array_filter($request["item_types_ids_other"])) : [];

if ($request['coupon_type'] == 1) {
                $urgent_coupon->item_types()->sync(
                    []
                );
            }else{
            if ((($item_types_ids) && count($item_types_ids) == count($item_types_numbers)
            && count($item_categories) == count($item_types_ids)
                && count($item_types_ids) == count($item_types_values))
            || !($item_types_ids) && !($item_types_numbers)) {
                for ($i = 0; $i < count($item_types_ids); $i++) {

                    if ($item_types_ids[$i] == -1 && empty($item_types_ids_other[$i]))
                        continue;
                    if ($item_types_ids[$i] == -1 && !empty($item_types_ids_other[$i])) {
                        $item_type = ItemType::where('name', $item_types_ids_other[$i])->first();
                        if ($item_type)
                            $item_types_ids[$i] = $item_type->id;
                        else
                            $item_types_ids[$i] = ItemType::create(['name' => $item_types_ids_other[$i], 'status' => 0
                             ,'item_category_id'=>$item_categories[$i]])->id;

                    }
                }

                $item_types_ids = array_filter($item_types_ids, function ($v) {
                    return $v > 0;
                });

                $urgent_coupon->item_types()->sync(
                    $item_types_ids
                );
                if ($request['coupon_type'] == 1) {
                    $urgent_coupon->item_types()->sync(
                        []
                    );
                }
                for ($i = 0; $i < count($item_types_ids); $i++) {
                    $urgent_coupon->coupon_item_types()->where('item_type_id', $item_types_ids[$i])
                        ->first()->update(['number' => $item_types_numbers[$i], 'value' => $item_types_values[$i]]);
                }


            }
            else {
            return back()->with('error', 'خانات مقدار المساعدة غير مدخلة بشكل صحيح')->withInput(request()->all());
        }
}
            
            if ($request['funder_type'] == 0) {
                $urgent_coupon->update(['sponsor_id' => null]);
            }

            if ($request['files']) {

                if (count($request['files']) != count($request['file_type_id'])) {
                    event(new NewLogCreated(' يرجى ادخال نوع الملف ', $urgent_coupon->name, 142, 0, 0));
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
                        $path = 'uploads/urgent_coupon/';
                        if (!file_exists($path)) {
                            File::makeDirectory($path, $mode = 0777, true, true);
                        }
                        $upload = $file['files']->move($path, $fileName);
                        $file_type_id = $file['file_type_id'];

                        $mediaData = [
                            'path' => $upload,
                            'file_type_id' => $file_type_id,
                            'urgent_coupon_id' => $urgent_coupon->id
                        ];
                        UrgentCouponMedia::create($mediaData);
                    }


                } else {
                    event(new NewLogCreated(' لم يتم إضافة مرفقات ', $urgent_coupon->name, 142, 0, 0));
                    return back()->with('error', 'لم  يتم إضافة مرفقات ');
                }
            }

            event(new NewLogCreated('تعديل البيانات بنجاح', $urgent_coupon->id, 171, 1, null));
            $action = Action::create(['title' => 'تم تعديل مساعدة طارئة', 'type' => Permission::findByName('list urgent_coupons')->title, 'link' => Permission::findByName('list urgent_coupons')->link]);
            $users = User::permission('urgent_coupons')->whereNotIn('id', [auth()->user()->id])->get();
            if ($users->first())
                Notification::send($users, new NotifyUsers($action));
            return redirect("/admin/urgent_coupons")->with('success', 'تم تعديل البيانات بنجاح');

        } else {
            event(new NewLogCreated('المحاولة للوصول لمساعدة غير موجودة برقم : ', $id, 171, 1, null));
            return redirect("/admin/urgent_coupons")->with('error', 'المساعدة غير موجودة');
        }
    }

    public function destroy($id)
    {
        //
    }

    public function removeMedia($id)
    {

        if (!is_null($id)) {
            $media = UrgentCouponMedia::find($id);

            if (!is_null($media)) {
                $institutionId = $media->urgent_coupon_id;
                $mypath = public_path() . "/" . $media->path; // مكان التخزين في البابليك ثم مجلد ابلودز
                if (file_exists($mypath) && $mypath != null) {//اذا يوجد ملف قديم مخزن
                    unlink($mypath);//يقوم بحذف القديم
                }

                if ($media->delete()) {
                    event(new NewLogCreated('تم حذف مرفق  جمعية برقم :  ', $institutionId, 100, 1, url('admin/season_coupons/' . $institutionId . '/edit')));
                    return back()->with('success', 'تم حذف مرفق  جمعية بنجاح  ');
                }
                event(new NewLogCreated('لم يتم حذف مرفق  جمعية برقم :  ', $institutionId, 100, 1, url('admin/season_coupons/' . $institutionId . '/edit')));
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

    public function delete($id)
    {
        $urgent_coupon = UrgentCoupon::find($id);

        if (!is_null($urgent_coupon)) {
            $urgent_coupon->delete();
            event(new NewLogCreated('حذف مساعدة بنجاح', $urgent_coupon->name, 172, 1, null));
            $action = Action::create(['title' => 'تم حذف مساعدة طارئة', 'type' => Permission::findByName('list urgent_coupons')->title, 'link' => Permission::findByName('list urgent_coupons')->link]);
            $users = User::permission('urgent_coupons')->whereNotIn('id', [auth()->user()->id])->get();
            if ($users->first())
                Notification::send($users, new NotifyUsers($action));
            return redirect("/admin/urgent_coupons")->with('success', 'تم حذف مساعدة بنجاح');

        } else {
            event(new NewLogCreated('المحاولة للوصول لمساعدة غير موجودة برقم : ', $id, 172, 1, null));
            return redirect("/admin/urgent_coupons")->with('error', 'المساعدة غير موجودة');
        }
    }

    public function approve(Request $request)
    {
        $id = explode(",", $request['the_ids'])[0];
        $urgent_coupon = UrgentCoupon::find($id);

        if (!(auth()->user()->hasPermissionTo('edit urgent_coupons'))) {
            return response()->json([
                'message' => 'ليس لك صلاحية تعديل مساعدة',
            ], 401);
        }

        if ($urgent_coupon) {
            $urgent_coupon->update(['admin_status_id' => $request['admin_status_id']]);
            event(new NewLogCreated('تم تعديل قبول المساعدة بنجاح', $urgent_coupon->id, 173, 1, null));
            return response()->json([
                'message' => 'تم تعديل قبول المساعدة بنجاح',
            ], 200);

        } else {

            event(new NewLogCreated('المحاولة للوصول لمساعدة غير موجودة برقم : ', $id, 173, 1, null));
            return response()->json([
                'message' => 'المحاولة للوصول لمساعدة غير موجودة',
            ], 401);
        }
    }

    public function delivery(Request $request)
    {
        $id = explode(",", $request['the_ids'])[0];
        $urgent_coupon = UrgentCoupon::find($id);

        /*if (!(auth()->user()->hasPermissionTo('edit urgent_coupons'))) {
            return response()->json([
                'message' => 'ليس لك صلاحية تعديل مساعدة',
            ], 401);
        }*/

        if ($urgent_coupon) {
            if ($urgent_coupon->delivery_status == 1) {
                $urgent_coupon->update(['delivery_status' => 0]);
                event(new NewLogCreated('تم الغاء تسليم مساعدة بنجاح', $urgent_coupon->id, 174, 1, null));
                return response()->json([
                    'message' => 'تم إلغاء تسليم مساعدة بنجاح',
                ], 200);
            } else {
                $urgent_coupon->update(['delivery_status' => 1]);

                //word_export
                if ($urgent_coupon->institution) {
                    $responsible_person = $urgent_coupon->institution->responsible_person ?? "";
                    $institution_name = $urgent_coupon->institution ? ($urgent_coupon->institution->name ?? "") : "-";
                    $licensor_number = $urgent_coupon->institution->licensor_number ?? "";
                    $mobile = $urgent_coupon->institution->mobile ?? $urgent_coupon->institution->mobile_one ?? $urgent_coupon->institution->mobile_two ?? "";
                    if ($urgent_coupon->coupon_type == 2) {
                        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor(public_path('word_templates/coupons/urgent/kind/institution.docx'));
                        $the_path = 'word_templates_results/coupons/urgent/kind/' . $urgent_coupon->id . '/';;
                    } else {
                        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor(public_path('word_templates/coupons/urgent/cash/institution.docx'));
                        $the_path = 'word_templates_results/coupons/urgent/cash/' . $urgent_coupon->id . '/';;
                    }
                    $templateProcessor->setValue('licensor_number', $licensor_number);
                    $templateProcessor->setValue('responsible_person', $responsible_person);
                    $templateProcessor->setValue('institution_name', $institution_name);
                } elseif ($urgent_coupon->family) {
                    $full_name = $urgent_coupon->family->person->full_name ?? "";
                    $id_number = $urgent_coupon->family->person->id_number ?? "";
                    $mobile = $urgent_coupon->family->telephone ?? $urgent_coupon->family->mobile_one ?? $urgent_coupon->family->mobile_two ?? "";
                    if ($urgent_coupon->coupon_type == 2) {
                        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor(public_path('word_templates/coupons/urgent/kind/person.docx'));
                        $the_path = 'word_templates_results/coupons/urgent/kind/' . $urgent_coupon->id . '/';
                    } else {
                        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor(public_path('word_templates/coupons/urgent/cash/person.docx'));
                        $the_path = 'word_templates_results/coupons/urgent/cash/' . $urgent_coupon->id . '/';
                    }
                    $templateProcessor->setValue('full_name', $full_name);
                    $templateProcessor->setValue('id_number', $id_number);
                }
                if ($urgent_coupon->coupon_type == 2) {
                    $count = "";
                    $z = 0;
                    foreach ($urgent_coupon->coupon_item_types as $coupon_item_types) {
                        if ($z > 0)
                            $count = $count . " و";
                        $count = $count . "" . $coupon_item_types->number . " " . $coupon_item_types->item_type->name . "-" . $coupon_item_types->item_type->item_category->name . "";
                        $z++;
                    }

                    $templateProcessor->setValue('count', $count);
                }

                $amount = $urgent_coupon->amount . "" . $urgent_coupon->amount_currency->icon;
                $his_date = $urgent_coupon->his_date;

                $templateProcessor->setValue('id', $id);
                $templateProcessor->setValue('mobile', $mobile);
                $templateProcessor->setValue('amount', $amount);
                $templateProcessor->setValue('his_date', $his_date);

                $path = public_path($the_path);
                if (!file_exists($path)) {
                    Storage::disk('real_public')->makeDirectory($the_path);
                }

                // delete old files
                $oldFiles = \Illuminate\Support\Facades\File::allfiles($path);

                foreach ($oldFiles as $file) {
                    \Illuminate\Support\Facades\File::delete(public_path($the_path . "" . $file->getRelativePathname()));
                }

                $templateProcessor->saveAs(public_path($the_path . "" . $urgent_coupon->family->id . 'سند استلام.docx'));


                event(new NewLogCreated('تم تسليم مساعدة بنجاح', $urgent_coupon->id, 174, 1, null));
                
                $action = Action::create(['title' => 'تم تسليم مساعدة طارئة بنجاح', 'type' => Permission::findByName('list urgent_coupons')->title, 'link' => Permission::findByName('list urgent_coupons')->link]);
        $users = User::permission('urgent_coupons')->whereNotIn('id', [auth()->user()->id])->get();
        if ($users->first())
            Notification::send($users, new NotifyUsers($action));
                
                return response()->json([
                    'message' => "تم تسليم مساعدة بنجاح <a href='" . asset($the_path . "" . $urgent_coupon->family->id . 'سند استلام.docx') . "'>  تحميل</a>",
                ], 200);
            }

        } else {

            event(new NewLogCreated('المحاولة للوصول لمساعدة غير موجودة برقم : ', $id, 171, 1, null));
            return response()->json([
                'message' => 'المحاولة للوصول لمساعدة غير موجودة',
            ], 401);
        }
    }

    public function sendSMS(Request $request)
    {


        $ids = explode(",", $request['the_ids']);
        $urgent_coupons = UrgentCoupon::find($ids);

        if ($urgent_coupons && $urgent_coupons->first()) {
            foreach ($urgent_coupons as $urgent_coupon) {
                if ($urgent_coupon->family) {
                    $family = $urgent_coupon->family;
                    if (!($family->mobile_one) && !($family->mobile_two)) {
                        continue;
                    } else {
                        $mobile = ($family->mobile_one) && $family->mobile_one>0 ?$family->mobile_one: $family->mobile_two;
                        if (!(strpos($mobile, '+970') !== false)) {
                            $mobile = '+970' . $mobile;
                        }

                        if (strlen($mobile) != 13) {
                            continue;
                        } else {
                            event(new SmsEvent($request['massage'], $mobile));
                        }
                    }
                } elseif ($urgent_coupon->institution) {
                    $institution = $urgent_coupon->institution;
                    if (!($institution->mobile_one) && !($institution->mobile_two)) {
                        continue;
                    } else {
                        $mobile = ($institution->mobile_one) && $institution->mobile_one>0 ? $institution->mobile_one : $institution->mobile_two;
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
            }
            event(new NewLogCreated('تم ابلاغ مستلم بنجاح', "", 86, 0, null));
            if (request()['the_type']) {
                return response()->json([
                    'message' => 'تم ابلاغ مستلم بنجاح',
                ], 200);
            } else
                return redirect('admin/urgent_coupons')->with('success', 'تم ابلاغ مستلم بنجاح');

        } else {
            event(new NewLogCreated('المحاوله للوصول لمساعدة غير موجودة برقم : ', '', 86, 0, null));
            if (request()['the_type']) {
                return response()->json([
                    'message' => 'الرجاء التاكد من الرابط المطلوب'
                ], 401);
            } else
                return redirect("/admin/urgent_coupons")->with('error', 'الصرفية غير موجود');
        }
    }


    public function import_urgent_coupon()
    {
        return view('admin.urgent_coupon.import_urgent_coupon');

    }

    public function store_import_urgent_coupon(Request $request)
    {
        //dd('test');
        $excel_file = $request["excel_file"];

        // $collection = Excel::toCollection(new IgnorImport, $excel_file);
        $collection = Excel::load($excel_file, 'UTF-8')->get();
        $error_string = "";
        $note_string = "";
        $headerRow = $collection->first()->keys()->toArray();

        if ($collection->count() > 100) {
            return back()->with('error', 'لا يمكن رفع ملف أكثر من 100 صف دفعة واحدة')->withInput($request->except(['excel_file']));
        }

        $faildCollection = collect();
        $faildCollection->push($headerRow);
        $j = 1;
        foreach ($collection->chunk(20) as $collections) {
            set_time_limit(0);
            foreach ($collections as $keys => $vals) {
                set_time_limit(0);
                $output = json_decode('' . $vals, true);
                $valus = array_values($output);

                for ($i = 0; $i < count($headerRow); $i++) {
                    if (!(trim($headerRow[$i])))
                        break;
                    $x = 'index' . $i;
                    $$x = "" . trim($headerRow[$i]) . "";
                }

                $i = 0;
                foreach ($vals as $key => &$prop) {
                    $v = trim($prop);
                    if ($v == '**')
                        $v = '';
                    unset($vals[$key]);
                    $x = 'index' . $i;
                    $vals[$$x] = $v;
                    $i++;
                }
                if (count($headerRow) < 12) {
                    //error عدد الأعمدة أقل من المتعارف عليه
                    return back()->with('error', 'عدد الأعمدة أقل من التنسيق اللازم')->withInput(session()->getOldInput());
                }


                /*if ($j >= 17)
                    break;*/
                $j++;


                if ($j == 1) {
                    if (!(($index0 == "الرقم") &&
                        ($index1 == "اسم المستفيد") &&
                        ($index2 == "رقم الهوية") &&
                        ($index3 == "رقم الجوال") &&
                        ($index4 == "السكن") &&
                        ($index5 == "المرشح") &&
                        ($index6 == "المصدر") &&
                        ($index7 == "ملاحظات") &&
                        (($index8 == "₪") || ($index8 == '$')) &&
                        ($index9 == "نوع المساعدة") &&
                        ($index10 == "سبب المساعدة") &&
                        ($index11 == "التاريخ"))) {

                        //error تنسيق ملف الإكسل غير صحيح (لا يحتوي اسم المشروع او كود المكفول أو اسم المكفول أو الكافل)
                        return back()->with('error', 'تنسيق ملف الإكسل غير صحيح ')->withInput(session()->getOldInput());
                    }
                }

                $his_id = (int)trim($vals[$index0]);
                /*if ($his_id != 3)
                    continue;*/

                /*********/
                if ((int)trim($vals[$index0]) != 0
                    && (trim($vals[$index1])) && strlen(trim($vals[$index1])) > 4
                    && (trim($vals[$index2])) && strlen(trim($vals[$index2])) == 9 && is_numeric((float)(trim($vals[$index2])))
                    && (!(trim($vals[$index3])) || (strlen(trim($vals[$index3])) > 5) && is_numeric((float)(trim($vals[$index3]))))
                    && (!(trim($vals[$index4])) || strlen(trim($vals[$index4])) > 3)
                    && (!(trim($vals[$index5])) || strlen(trim($vals[$index5])) > 3)
                    && (!(trim($vals[$index6])) || strlen(trim($vals[$index6])) > 3)
                    && (!(trim($vals[$index7])) || strlen(trim($vals[$index7])) > 3)
                    && (!(trim($vals[$index8])) || is_numeric((float)(trim($vals[$index8]))))
                    && ((trim($vals[$index9]) == 'نقدي') || (trim($vals[$index9]) == 'عيني'))
                    && (!(trim($vals[$index10])) || strlen(trim($vals[$index10])) > 3)
                    && (!(trim($vals[$index11])) || \DateTime::createFromFormat('Y-m-d', date('Y-m-d', strtotime(trim($vals[$index11])))) !== FALSE)
                ) {

                    $personData['full_name'] = $vals[$index1];
                    $personData['id_number'] = $vals[$index2];
                    $familyData['mobile_one'] = $vals[$index3];
                    $array = explode('-', trim($vals[$index4]));
                    $neighborhood_name = "";
                    $city_name = "";
                    if (count($array) == 2) {
                        $city_name = $array[0];
                        $neighborhood_name = $array[1];
                    } elseif (count($array) == 1) {
                        $city_name = $array[0];
                    }
                    $city_id = 0;
                    if ($city_name) {
                        $city_name_search = $city_name;
                        if (strpos($city_name, 'ال') !== false) {
                            $city_name_search = str_replace("ال", "", $city_name);
                        }
                        if (strpos($city_name, 'مدينة') !== false) {
                            $city_name_search = str_replace("مدينة", "", $city_name);
                        }
                        $city = City::where('name', 'like', '%' . trim($city_name_search))
                            ->orWhere('name', 'like', '%' . trim($city_name))->first();
                        if ($city) {
                            $city_id = $city->id;
                        } else {
                            $city_id = City::create(['name' => trim($city_name)])->id;
                        }

                    }
                    if ($neighborhood_name) {
                        $neighborhood = Neighborhood::where('name', 'like', '%' . trim($neighborhood_name))->first();
                        if ($neighborhood) {
                            $familyData['neighborhood_id'] = $neighborhood->id;
                        } else {
                            $familyData['neighborhood_id'] = Neighborhood::create(['name' => trim($neighborhood_name), 'city_id' => $city_id])->id;
                        }
                    } else {
                        if ($city_id) {
                            $neighborhood = Neighborhood::where('name', "أخرى - " . $city_name)->where('city_id', $city_id)->first();
                            if ($neighborhood)
                                $familyData['neighborhood_id'] = $neighborhood->id;
                            else
                                $familyData['neighborhood_id'] = Neighborhood::create(['name' => "أخرى - " . $city_name, "city_id" => $city_id])->id;
                        }
                    }

                    $familyData['visit_reason_id'] = 10;
                    $familyData['visit_date'] = Carbon::now();

                    $falmils_by_name = Family::whereNull('parent_id')->whereHas('person'
                        , function ($query) use ($vals, $j, $personData) {
                            $query->where('full_name', $personData['full_name']);
                        })->with('person');
                    $falmils_by_id_number = Family::whereNull('parent_id')->whereHas('person'
                        , function ($query) use ($vals, $j, $personData) {
                            $query->where('id_number', $personData['id_number']);
                        })->with('person');
                    $vists_by_name = array_unique(array_filter(Family::whereNotNull('parent_id')->whereHas('person'
                        , function ($query) use ($vals, $j, $personData) {
                            $query->where('full_name', $personData['full_name']);
                        })->pluck('parent_id')->toArray()));
                    $vists_by_id_number = array_unique(array_filter(Family::whereNotNull('parent_id')->whereHas('person'
                        , function ($query) use ($vals, $j, $personData) {
                            $query->where('id_number', $personData['id_number']);
                        })->pluck('parent_id')->toArray()));


                    if ((count($vists_by_name) > 1 || count($vists_by_id_number) > 1) ||
                        (count($vists_by_name) > 1 && count($vists_by_id_number) == 0) ||
                        (count($vists_by_name) == 0 && count($vists_by_id_number) > 1) ||
                        ($falmils_by_name->count() > 1 || $falmils_by_id_number->count() > 1) ||
                        ($falmils_by_name->count() > 1 && !($falmils_by_id_number->first())) ||
                        (!($falmils_by_name->first()) && $falmils_by_id_number->count() > 1)) {// التكرار اذا كان الاسم غير يونيك اوالكود غير يونيك، أو بالاسم غير موجود والكود غير يونيك، أو بالكود غير موجود والاسم غير يوميك
                        $faildCollection->push($valus);
                        $error_string = $error_string . "<br> لم يتم اضافة مساعدة للصف رقم $his_id  لتكرر اسمه في العائلات، يرجى مراجعة الاستمارة وتعديلها ";

                        continue;
                    }
                    $family_id = 0;
                    $family = '';
                    if ($falmils_by_name->count() == 1) {
                        $family_id = $falmils_by_name->first()->id;
                        //  dd("1");
                    } elseif ($falmils_by_id_number->count() == 1) {
                        $family_id = $falmils_by_id_number->first()->id;
                        // dd("11");
                    } elseif (count($vists_by_id_number) == 1) {
                        $family_id = Family::find($vists_by_id_number[0])->id;
                        // dd("111");
                    } elseif (count($vists_by_name) == 1) {
                        $family_id = Family::find($vists_by_name[0])->id;
                        //dd("1111");
                    }

                    if ($family_id)
                        $family = Family::whereHas('person')->find($family_id);
                    $other_family = Family::find($family_id);

                    // dd($family);

//dd($family);
                    if ($family) {

                        $urgentCouponData['family_id'] = $family->id;


                        $urgentCouponData['his_date'] = date('Y-m-d', strtotime($vals[$index11]));

                        if ($urgentCouponData['his_date'] == '1970-01-01') {
                            $faildCollection->push($valus);
                            $error_string = $error_string . "<br> لم يتم اضافة مساعدة للصف رقم $his_id  لان فورمات التاريخ غير صحيح ";

                            continue;
                        }


                        if (UrgentCoupon::where('family_id', '=', $urgentCouponData['family_id'])->
                        where('his_date', '=', $urgentCouponData['his_date'])->first()) {
                            $faildCollection->push($valus);
                            $error_string = $error_string . "<br> لم يتم اضافة مساعدة للصف رقم $his_id  لانه استلم مساعدة بنفس التاريخ ";

                            continue;
                        }


                        if ($family->code) {
                            $note_string = $note_string . "<br> في الصف رقم $his_id  تم اعتبارها اكسترا ياردم لأنه مكوّد ";
                        }
                        $family->update($familyData);
                        $person = $family->person;
                        $person->update($personData);
                        /****************************************/
                        // clone person
                        $newPerson = $person->replicate();
                        $newPerson->save();

                        // clone family
                        $newFamily = $family->replicate();
                        $newFamily->save();

                        $newFamily->update(
                            [
                                'visit_count' => $family->visit_count,
                                'approve' => 1,
                                'archive' => 1,
                                'parent_id' => $family->id,
                                'person_id' => $newPerson->id,
                            ]);

                        $updateData = [
                            'archive' => 0,
                            'approve' => 0,
                            'visit_count' => $newFamily->visit_count + 1,
                            'expense_id' => null,
                        ];

                        // update family
                        $family->update($updateData);

                        // clone income
                        if ((isset($family->incomes)) && (!is_null($family->incomes))) {
                            foreach ($family->incomes as $item) {
                                $newIncome = $item->replicate();
                                $newIncome->family_id = $newFamily->id;
                                $newIncome->save();
                            }
                        }

                        // clone members
                        if ((isset($family->members)) && (!is_null($family->members))) {
                            foreach ($family->members as $item) {
                                $itemPerson = $item->person;
                                $newMember = $item->replicate();
                                $newPerson = $itemPerson->replicate();
                                $newPerson->save();
                                $newMember->family_id = $newFamily->id;
                                $newMember->person_id = $newPerson->id;
                                $newMember->save();
                            }
                        }

                        // clone searcher
                        if ((isset($family->searcher)) && (!is_null($family->searcher))) {
                            foreach ($family->searcher as $item) {
                                $newSearcher = $item->replicate();
                                $newSearcher->family_id = $newFamily->id;
                                $newSearcher->save();
                            }
                        }

                        // clone member diseases
                        if ((isset($family->familyMemberDiseases)) && (!is_null($family->familyMemberDiseases))) {
                            foreach ($family->familyMemberDiseases as $item) {
                                $newIncome = $item->replicate();
                                $newIncome->family_id = $newFamily->id;
                                $newIncome->save();
                            }
                        }

                    } elseif (!($family) && !($other_family)) {
                        $person_id = Person::create($personData)->id;
                        $familyData['person_id'] = $person_id;
                        $family_id = Family::create($familyData)->id;
                        $urgentCouponData['family_id'] = $family_id;
                        $note_string = $note_string . "<br> في الصف رقم $his_id  المستفيد شخص جديد تم إضافته ";
                    } else {
                        continue;
                    }
                    $familyData = [];
                    $personData = [];

                    if ($index8 == "₪") {
                        $urgentCouponData['amount_currency_id'] = 3;
                    } elseif ($index8 == '$') {
                        $urgentCouponData['amount_currency_id'] = 2;
                    } elseif ($index8 == '€') {
                        $urgentCouponData['amount_currency_id'] = 1;
                    }
                    $urgentCouponData['amount'] = (float)$vals[$index8];
                    if ($vals[$index9] == 'نقدي') {
                        $urgentCouponData['coupon_type'] = 1;
                    } elseif ($vals[$index9] == 'عيني') {
                        $urgentCouponData['coupon_type'] = 2;
                    }

                    $urgentCouponData['note'] = $vals[$index5] . " " . $vals[$index7];

                    if ($vals[$index6]) {
                        $urgentCouponData['funder_type'] = 1;
                        $country = Country::where('name', '=', $vals[$index6])->first();
                        if ($country) {
                            $urgentCouponData['country_id'] = $country->id;
                        } else {
                            $urgentCouponData['country_id'] = Country::create(['name' => $vals[$index6]])->id;
                        }
                    } else {
                        $urgentCouponData['funder_type'] = 0;
                    }

                    if ($vals[$index10]) {
                        $coupon_reason = CouponReason::where('name', '=', $vals[$index10])->first();
                        if ($coupon_reason) {
                            $urgentCouponData['coupon_reason_id'] = $coupon_reason->id;
                        } else {
                            $urgentCouponData['coupon_reason_id'] = CouponReason::create(['name' => $vals[$index10]])->id;
                        }
                    }
                    $urgentCouponData['admin_status_id'] = 1;
                    $urgentCouponData['his_date'] = date('Y-m-d', strtotime($vals[$index11]));

                    UrgentCoupon::create($urgentCouponData);
                    $urgentCouponData = [];
                } else {
                    $faildCollection->push($valus);
                    $error_string = $error_string . "<br> الصف رقم $his_id  يحمل بيانات غير صحيحة البنية ";

                    continue;
                }


            }
        }


        session()->flash('error_string', $error_string);
        session()->flash('note_string', $note_string);
        session()->flash('faildCollection', $faildCollection);
        dd(session()->all());
        return redirect('/admin/urgent_coupons/');
    }

    public function import_urgent_coupon_extra()
    {
        return view('admin.urgent_coupon.import_urgent_coupon_extra');

    }

    public function store_import_urgent_coupon_extra(Request $request)
    {
        $excel_file = $request["excel_file"];

        $collection = Excel::load($excel_file, 'UTF-8')->get();
        $error_string = "";
        $note_string = "";
        $headerRow = $collection->first()->keys()->toArray();
        $faildCollection = collect();
        $faildCollection->push($headerRow);
        $j = 1;


        if ($collection->count() > 100) {
            return back()->with('error', 'لا يمكن رفع ملف أكثر من 100 صف دفعة واحدة')->withInput($request->except(['excel_file']));
        }

        foreach ($collection->chunk(20) as $collections) {
            set_time_limit(0);
            foreach ($collections as $keys => $vals) {
                set_time_limit(0);
                $output = json_decode('' . $vals, true);
                $valus = array_values($output);
                for ($i = 0; $i < count($headerRow); $i++) {
                    if (!(trim($headerRow[$i])))
                        break;
                    $x = 'index' . $i;
                    $$x = "" . trim($headerRow[$i]) . "";
                }
                $i = 0;

                if (count($headerRow) < 15) {
                    //error عدد الأعمدة أقل من المتعارف عليه
                    return back()->with('error', 'عدد الأعمدة أقل من التنسيق اللازم')->withInput(session()->getOldInput());
                }

                foreach ($vals as $key => &$prop) {
                    $v = trim($prop);
                    if ($v == '**')
                        $v = '';
                    unset($vals[$key]);
                    $x = 'index' . $i;
                    $vals[$$x] = $v;
                    $i++;
                }


                /* if ($j >= 20)
                     break;*/
                $j++;


                if ($j == 1) {
                    if (!(($index0 == "الرقم") &&
                        ($index1 == "اسم المستفيد") &&
                        ($index2 == "رقم الهوية") &&
                        ($index3 == "الكود") &&
                        ($index4 == "رقم الجوال") &&
                        ($index5 == "المدينة") &&
                        ($index6 == "الحي") &&
                        ($index7 == "العنوان") &&
                        ($index8 == "المرشح") &&
                        ($index9 == "₪") &&
                        ($index10 == "$") &&
                        ($index11 == "€") &&
                        ($index12 == "نوع المساعدة") &&
                        ($index13 == "سبب المساعدة") &&
                        ($index14 == "التاريخ"))) {

                        //error تنسيق ملف الإكسل غير صحيح (لا يحتوي اسم المشروع او كود المكفول أو اسم المكفول أو الكافل)
                        return back()->with('error', 'تنسيق ملف الإكسل غير صحيح ')->withInput(session()->getOldInput());
                    }
                }

                $his_id = (int)trim($vals[$index0]);
                /*if ($his_id != 3)
                    continue;*/

                /*********/
                if ((int)trim($vals[$index0]) != 0
                    && (trim($vals[$index1])) && strlen(trim($vals[$index1])) > 4
                    && (trim($vals[$index2])) && strlen(trim($vals[$index2])) == 9 && is_numeric((float)(trim($vals[$index2])))
                    && (substr(trim($vals[$index3]), 0, 9) === "633.KAP.F" || substr(trim($vals[$index3]), 0, 8) === "YTM.FLS.")
                    && (!(trim($vals[$index4])) || (strlen(trim($vals[$index4])) > 5) && is_numeric((float)(trim($vals[$index3]))))
                    && (!(trim($vals[$index5])) || strlen(trim($vals[$index5])) > 3)
                    && (!(trim($vals[$index6])) || strlen(trim($vals[$index6])) > 3)
                    && (!(trim($vals[$index7])) || strlen(trim($vals[$index7])) > 3)
                    && (!(trim($vals[$index8])) || strlen(trim($vals[$index8])) > 3)
                    && (!(trim($vals[$index9])) || is_numeric((float)(trim($vals[$index9]))))
                    && (!(trim($vals[$index10])) || is_numeric((float)(trim($vals[$index10]))))
                    && (!(trim($vals[$index11])) || is_numeric((float)(trim($vals[$index11]))))
                    && ((trim($vals[$index12]) == 'نقدي') || (trim($vals[$index12]) == 'عيني'))
                    && (!(trim($vals[$index13])) || strlen(trim($vals[$index13])) > 3)
                    && (!(trim($vals[$index14])) || \DateTime::createFromFormat('Y-m-d', date('Y-m-d', strtotime(trim($vals[$index14])))) !== FALSE)
                ) {

                    $personData['full_name'] = $vals[$index1];
                    $personData['id_number'] = $vals[$index2];
                    if (strpos($vals[$index3], '-1') !== false) {
                        $vals[$index3] = str_replace("-1", "", $vals[$index3]);
                    }
                    $familyData['code'] = $vals[$index3];
                    $familyData['mobile_one'] = $vals[$index4];
                    $city_name = $vals[$index5];
                    $neighborhood_name = $vals[$index6];
                    $familyData['address'] = $vals[$index7];

                    if ($city_name) {
                        $city_name_search = $city_name;
                        if (strpos($city_name, 'ال') !== false) {
                            $city_name_search = str_replace("ال", "", $city_name);
                        }
                        if (strpos($city_name, 'مدينة') !== false) {
                            $city_name_search = str_replace("مدينة", "", $city_name);
                        }
                        $city = City::where('name', 'like', '%' . trim($city_name_search))
                            ->orWhere('name', 'like', '%' . trim($city_name))->first();
                        if ($city) {
                            $familyData['city_id'] = $city->id;
                        } else {
                            $familyData['city_id'] = City::create(['name' => trim($city_name)])->id;
                        }
                    }
                    if ($neighborhood_name) {

                        $neighborhood = Neighborhood::where('name', 'like', '%' . trim($neighborhood_name))->first();
                        if ($neighborhood) {
                            $familyData['neighborhood_id'] = $neighborhood->id;
                        } else {
                            if (!$familyData['city_id'])
                                $familyData['neighborhood_id'] = Neighborhood::create(['name' => trim($neighborhood_name)])->id;
                            elseif ($familyData['city_id'])
                                $familyData['neighborhood_id'] = Neighborhood::create(['name' => trim($neighborhood_name), 'city_id' => $familyData['city_id']])->id;
                        }
                    }


                    $familyData['visit_reason_id'] = 10;
                    $familyData['visit_date'] = Carbon::now();

                    $falmils_by_code = Family::with('person')
                        ->where(function ($query) use ($familyData) {
                            $query->where('code', $familyData['code']);
                        })->whereNull('parent_id');

                    $falmils_by_id_number = Family::whereNull('parent_id')->whereHas('person'
                        , function ($query) use ($vals, $j, $personData) {
                            $query->where('id_number', $personData['id_number']);
                        })->with('person');
                    $vists_by_id_number = array_unique(array_filter(Family::whereNotNull('parent_id')->whereHas('person'
                        , function ($query) use ($vals, $j, $personData) {
                            $query->where('id_number', $personData['id_number']);
                        })->pluck('parent_id')->toArray()));
                    $vists_by_code = array_unique(array_filter(Family::with('person')
                        ->where(function ($query) use ($familyData) {
                            $query->where('code', $familyData['code']);
                        })->whereNotNull('parent_id')->pluck('parent_id')->toArray()));

                    if ((count($vists_by_code) > 1 || count($vists_by_id_number) > 1) ||
                        (count($vists_by_code) > 1 && count($vists_by_id_number) == 0) ||
                        (count($vists_by_code) == 0 && count($vists_by_id_number) > 1) ||
                        ($falmils_by_code->count() > 1 || $falmils_by_id_number->count() > 1) ||
                        ($falmils_by_code->count() > 1 && !($falmils_by_id_number->first())) ||
                        (!($falmils_by_code->first()) && $falmils_by_id_number->count() > 1)) {// التكرار اذا كان الاسم غير يونيك اوالكود غير يونيك، أو بالاسم غير موجود والكود غير يونيك، أو بالكود غير موجود والاسم غير يوميك
                        $faildCollection->push($valus);
                        $error_string = $error_string . "<br> لم يتم اضافة مساعدة للصف رقم $his_id  لتكرر اسمه في العائلات، يرجى مراجعة الاستمارة وتعديلها ";

                        continue;
                    }
                    $family_id = 0;
                    $family = '';
                    if ($falmils_by_code->count() == 1) {
                        $family_id = $falmils_by_code->first()->id;
                    } elseif ($falmils_by_id_number->count() == 1) {
                        $family_id = $falmils_by_id_number->first()->id;
                    } elseif (count($vists_by_id_number) == 1) {
                        $family_id = Family::find($vists_by_id_number[0])->id;
                    } elseif (count($vists_by_code) == 1) {
                        $family_id = Family::find($vists_by_code[0])->id;
                    }

                    if ($family_id)
                        $family = Family::whereHas('person')->find($family_id);
                    $other_family = Family::find($family_id);
                    if ($family) {

                        $urgentCouponData['family_id'] = $family->id;

                        $urgentCouponData['his_date'] = date('Y-m-d', strtotime($vals[$index14]));

                        if ($urgentCouponData['his_date'] == '1970-01-01') {
                            $faildCollection->push($valus);
                            $error_string = $error_string . "<br> لم يتم اضافة مساعدة للصف رقم $his_id  لان فورمات التاريخ غير صحيح ";

                            continue;
                        }
                        if (UrgentCoupon::where('family_id', '=', $urgentCouponData['family_id'])->
                        where('his_date', '=', $urgentCouponData['his_date'])->first()) {
                            $faildCollection->push($valus);
                            $error_string = $error_string . "<br> لم يتم اضافة مساعدة للصف رقم $his_id  لانه استلم مساعدة بنفس التاريخ ";

                            continue;
                        }
                        $family->update($familyData);
                        $person = $family->person;
                        $person->update($personData);
                        /****************************************/
                        // clone person
                        $newPerson = $person->replicate();
                        $newPerson->save();

                        // clone family
                        $newFamily = $family->replicate();
                        $newFamily->save();

                        $newFamily->update(
                            [
                                'visit_count' => $family->visit_count,
                                'approve' => 1,
                                'archive' => 1,
                                'parent_id' => $family->id,
                                'person_id' => $newPerson->id,
                            ]);

                        $updateData = [
                            'archive' => 0,
                            'approve' => 0,
                            'visit_count' => $newFamily->visit_count + 1,
                            'expense_id' => null,
                        ];

                        // update family
                        $family->update($updateData);

                        // clone income
                        if ((isset($family->incomes)) && (!is_null($family->incomes))) {
                            foreach ($family->incomes as $item) {
                                $newIncome = $item->replicate();
                                $newIncome->family_id = $newFamily->id;
                                $newIncome->save();
                            }
                        }

                        // clone members
                        if ((isset($family->members)) && (!is_null($family->members))) {
                            foreach ($family->members as $item) {
                                $itemPerson = $item->person;
                                $newMember = $item->replicate();
                                $newPerson = $itemPerson->replicate();
                                $newPerson->save();
                                $newMember->family_id = $newFamily->id;
                                $newMember->person_id = $newPerson->id;
                                $newMember->save();
                            }
                        }

                        // clone searcher
                        if ((isset($family->searcher)) && (!is_null($family->searcher))) {
                            foreach ($family->searcher as $item) {
                                $newSearcher = $item->replicate();
                                $newSearcher->family_id = $newFamily->id;
                                $newSearcher->save();
                            }
                        }

                        // clone member diseases
                        if ((isset($family->familyMemberDiseases)) && (!is_null($family->familyMemberDiseases))) {
                            foreach ($family->familyMemberDiseases as $item) {
                                $newIncome = $item->replicate();
                                $newIncome->family_id = $newFamily->id;
                                $newIncome->save();
                            }
                        }

                    } elseif (!($family) && !($other_family)) {
                        $person_id = Person::create($personData)->id;
                        $familyData['person_id'] = $person_id;
                        $family_id = Family::create($familyData)->id;
                        $urgentCouponData['family_id'] = $family_id;
                        $note_string = $note_string . "<br> في الصف رقم $his_id  المستفيد شخص جديد تم إضافته ";
                    } else {
                        continue;
                    }
                    $familyData = [];
                    $personData = [];

                    if ($vals[$index9]) {
                        $urgentCouponData['amount_currency_id'] = 3;
                        $urgentCouponData['amount'] = (float)$vals[$index9];
                    } elseif ($vals[$index10]) {
                        $urgentCouponData['amount_currency_id'] = 2;
                        $urgentCouponData['amount'] = (float)$vals[$index10];
                    } elseif ($vals[$index11]) {
                        $urgentCouponData['amount_currency_id'] = 1;
                        $urgentCouponData['amount'] = (float)$vals[$index11];
                    }
                    if ($vals[$index12] == 'نقدي') {
                        $urgentCouponData['coupon_type'] = 1;
                    } elseif ($vals[$index12] == 'عيني') {
                        $urgentCouponData['coupon_type'] = 2;
                    }

                    $urgentCouponData['note'] = $vals[$index8];
                    $urgentCouponData['funder_type'] = 0;
                    if ($vals[$index13]) {
                        $coupon_reason = CouponReason::where('name', '=', $vals[$index13])->first();
                        if ($coupon_reason) {
                            $urgentCouponData['coupon_reason_id'] = $coupon_reason->id;
                        } else {
                            $urgentCouponData['coupon_reason_id'] = CouponReason::create(['name' => $vals[$index13]])->id;
                        }
                    }
                    $urgentCouponData['admin_status_id'] = 1;
                    $urgentCouponData['his_date'] = date('Y-m-d', strtotime($vals[$index11]));

                    UrgentCoupon::create($urgentCouponData);
                    $urgentCouponData = [];
                } else {
                    $faildCollection->push($valus);
                    $error_string = $error_string . "<br> الصف رقم $his_id  يحمل بيانات غير صحيحة البنية ";

                    continue;
                }


            }
        }


        session()->flash('error_string', $error_string);
        session()->flash('note_string', $note_string);
        session()->flash('faildCollection', $faildCollection);
        dd(session()->all());
        return redirect('/admin/urgent_coupons/');
    }


}
