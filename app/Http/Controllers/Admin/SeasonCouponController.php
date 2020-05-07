<?php

namespace App\Http\Controllers\Admin;

use App\AdminStatuse;
use App\CouponItemType;
use App\Events\SmsEvent;
use App\CouponReason;
use App\Currency;
use File;
use App\Governorate;
use App\Http\Requests\SeasonCouponRequest;
use App\Institution;
use App\InstitutionType;
use App\ItemCategory;
use App\ItemType;
use App\licensor;
use App\Neighborhood;
use App\Project;
use App\Season;
use App\SeasonCoupon;
use App\SeasonCouponMedia;
use App\Setting;
use App\TargetType;
use App\User;
use App\VisitReason;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Action;
use Maatwebsite\Excel\Facades\Excel;
use niklasravnsborg\LaravelPdf\Facades\Pdf;
use Notification;
use App\Notifications\NotifyUsers;
use App\Events\NewLogCreated;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Permission;
use App\City;
use App\Country;
use App\Disease;
use App\EducationalInstitution;
use App\Family;
use App\FamilyProject;
use App\FamilyStatus;
use App\FamilyType;
use App\FileType;
use App\FundedInstitution;
use App\FurnitureStatus;
use App\HouseOwnership;
use App\HouseRoof;
use App\HouseStatus;
use App\IDType;
use App\IncomeType;
use App\JobType;
use App\Qualification;
use App\QualificationLevels;
use App\Relationship;
use App\SocialStatus;
use App\StudyLevel;
use App\StudyPart;
use App\StudyType;
use App\UniversitySpecialty;

class SeasonCouponController extends Controller
{


    public function index(Request $request)
    {

        /**/
        $funded_institutions_ids_yes = $request['funded_institutions_ids_yes'] ? array_filter($request["funded_institutions_ids_yes"]) : [];
        /**/
        $funded_institutions_ids_no = $request['funded_institutions_ids_no'] ? array_filter($request["funded_institutions_ids_no"]) : [];
        /**/
        $delivery_status = $request["delivery_status"] ?? "";
        /**/
        $min_id = SeasonCoupon::first()->id ?? 1;
        /**/
        $max_id = SeasonCoupon::orderByDesc('id')->first()->id ?? 1;
        /**/
        $from_id = $request["from_id"] ?? $min_id;
        /**/
        $to_id = $request["to_id"] ?? $max_id;
        /**/
        $from_delivery_date = $request["from_delivery_date"] ?? "";
        /**/
        $to_delivery_date = $request["to_delivery_date"] ?? "";
        /**/
        $from_application_date = $request["from_application_date"] ?? "";
        /**/
        $to_application_date = $request["to_application_date"] ?? "";
        /**/
        $from_execution_date = $request["from_execution_date"] ?? "";
        /**/
        $to_execution_date = $request["to_execution_date"] ?? "";
        /**/
        $families_yes = $request['families_yes'] ? array_filter($request["families_yes"]) : [];  // علاقة
        /**/
        $families_no = $request['families_no'] ? array_filter($request["families_no"]) : []; // علاقة
        $delivery_place = $request['delivery_place'];
        /**/
        $admin_status_ids = $request['admin_status_ids'] ? array_filter($request["admin_status_ids"]) : [];
        /**/
        $season_ids = $request['season_ids'] ? array_filter($request["season_ids"]) : [];
        /**/
        $project_id = $request['project_id'] ?? '';
        $coupon_type = $request['coupon_type'] ?? '';
        /**/
        $family_or_institution = $request['family_or_institution'];
        $coulmn = $request["coulmn"] ?? "";

        $season_coupons = SeasonCoupon::when($funded_institutions_ids_yes, function ($query) use ($funded_institutions_ids_yes) {
            return $query->whereIn('institution_id', $funded_institutions_ids_yes);
        })->when($funded_institutions_ids_no, function ($query) use ($funded_institutions_ids_no) {
            return $query->whereNotIn('institution_id', $funded_institutions_ids_no);
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
        })->when($coupon_type, function ($query) use ($coupon_type) {
            return $query->where('coupon_type', $coupon_type);
        })->when($from_id && $to_id, function ($query) use ($from_id, $to_id) {
            return $query->whereBetween('id', [$from_id, $to_id]);
        })->when($from_delivery_date && $to_delivery_date, function ($query) use ($from_delivery_date, $to_delivery_date) {
            return $query->whereBetween('delivery_date', [$from_delivery_date, $to_delivery_date]);

        })->when($from_execution_date && $to_execution_date, function ($query) use ($from_execution_date, $to_execution_date) {
            return $query->whereBetween('execution_date', [$from_execution_date, $to_execution_date]);

        })->when($from_application_date && $to_application_date, function ($query) use ($from_application_date, $to_application_date) {
            return $query->whereBetween('application_date', [$from_application_date, $to_application_date]);

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
        //$request["coulmn"] == "" && ($request->all() == null || $request['page'])
        if ($request["coulmn"] == []) {
            $coulmn = ['id', 'select', 'family_or_institution', 'coupon_type', 'execution_date', 'delivery_date', 'application_date', 'amount', 'delivery_status', 'admin_status', 'operations'];
        }

        $admin_statuses = AdminStatuse::orderBy('name')->get();
        $institutions = Institution::orderBy('name')->get();
        $seasons = Season::orderBy('start_date')->get();
        $projects = Project::orderBy('name')->get();
        if ($request['theaction'] == 'print') {
            $the_date = Carbon::now();
            $season_coupons = $season_coupons->orderBy("season_coupons.id", 'desc')->take(500)->get();
            $pdf = Pdf::loadView('admin.season_coupon.print_all', compact('season_coupons', 'coulmn'));
            return $pdf->stream("المساعدات $the_date.pdf");
        } elseif ($request['theaction'] == 'excel') {
            $the_date = Carbon::now();
            $season_coupons = $season_coupons->orderBy("season_coupons.id", 'desc')->take(500)->get();

            return
                Excel::create("المساعدات $the_date.xlsx", function ($excel) use ($season_coupons, $coulmn) {

                    $excel->sheet('New sheet', function ($sheet) use ($season_coupons, $coulmn) {


                        $sheet->loadView('admin.season_coupon.print_all', [
                            'season_coupons' => $season_coupons,
                            'coulmn' => $coulmn,
                        ]);


                    });

                })->export('xlsx');
            //return Excel::download(new  SeasonCouponExport($coulmn, $season_coupons), "المساعدات $the_date.xlsx");

        } else {
            $season_coupons = $season_coupons->orderBy("season_coupons.id", 'desc')->paginate(20)
                ->appends([
                    "funded_institutions_ids_yes" => $funded_institutions_ids_yes, "funded_institutions_ids_no" => $funded_institutions_ids_no, "delivery_status" => $delivery_status,
                    "from_id" => $from_id, "to_id" => $to_id, "from_execution_date" => $from_execution_date, "to_execution_date" => $to_execution_date,
                    "from_execution_date" => $from_execution_date, "to_execution_date" => $to_execution_date, "from_application_date" => $from_application_date, "to_application_date" => $to_application_date,
                    "families_no" => $families_no, "families_yes" => $families_yes, "coulmn" => $coulmn,
                    "family_or_institution" => $family_or_institution, "delivery_place" => $delivery_place, "admin_status_ids" => $admin_status_ids, "delivery_place" => $delivery_place,
                    'season_ids' => $season_ids, 'project_id' => $project_id,
                    "projects" => $projects, "seasons" => $seasons,
                    "coupon_type" => $coupon_type
                ]);

            return view('admin.season_coupon.index', compact('season_coupons', "funded_institutions_ids_yes", "funded_institutions_ids_no", "delivery_status",
                "from_id", "to_id", "from_delivery_date", "to_delivery_date", "from_execution_date", "to_execution_date", "from_application_date", "to_application_date", "families_no", "families_yes", "coulmn", 'min_id', 'max_id',
                "family_or_institution", "admin_status_ids", "delivery_place"
                , "admin_statuses", "institutions",
                'season_ids', 'project_id', "projects", "seasons", "coupon_type"
            ));

        }


    }

    public function sendSMS(Request $request)
    {


        $ids = explode(",", $request['the_ids']);
        $season_coupons = SeasonCoupon::find($ids);

        if ($season_coupons && $season_coupons->first()) {
            foreach ($season_coupons as $season_coupon) {
                if ($season_coupon->family) {
                    $family = $season_coupon->family;
                    if (!($family->mobile_one) && !($family->mobile_two)) {
                        continue;
                    } else {
                        $mobile = ($family->mobile_one) && $family->mobile_one>0 ?$family->mobile_one: $family->mobile_two;
                        ltrim($mobile, "0");
                        if (!(strpos($mobile, '+970') !== false)) {
                            $mobile = '+970' . $mobile;
                        }

                        if (strlen($mobile) != 13) {
                            continue;
                        } else {
                            event(new SmsEvent($request['massage'], $mobile));
                        }
                    }
                } elseif ($season_coupon->institution) {
                    $institution = $season_coupon->institution;
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
                return redirect('admin/season_coupon')->with('success', 'تم ابلاغ مستلم بنجاح');

        } else {
            event(new NewLogCreated('المحاوله للوصول لمساعدة غير موجودة برقم : ', '', 86, 0, null));
            if (request()['the_type']) {
                return response()->json([
                    'message' => 'الرجاء التاكد من الرابط المطلوب'
                ], 401);
            } else
                return redirect("/admin/season_coupon")->with('error', 'الصرفية غير موجود');
        }
    }


    public function searctoaddcoupon()
    {
        $institutions = Institution::orderBy('name')->get();
        return view("admin.season_coupon.search", compact("institutions"));
        //زرين سابميت
    }

    public function editorcreate(Request $request)
    {
        //زر جديد يجب على نفس المكان ويعطه فاميلي اي ديه مستحيل
        $type = $request['type'] ?? "";
        $family_id = $request['family_id'] ?? "";
        $institution_id = $request['institution_id'] ?? "";
        $testeroor = $this->validate($request, [
            'type' => 'required',
        ]);
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
            $come_by = 'season_coupon';
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
            $come_by = 'season_coupon';
            if ($institution) {
                return view('admin.institution.edit', compact('come_by', 'target_types', 'institution', 'governorates', 'licensors', 'institution_types'));

            } else {
                return view('admin.institution.create', compact('come_by', 'target_types', 'neighborhoods', 'governorates', 'licensors', 'institution_types'));
            }
        }
    }

    public function create(Request $request)
    {
        $admin_statuses = AdminStatuse::orderBy('name')->get();
        $seasons = Season::all();
        $projects = Project::orderBy('name')->get();
        $item_categories = ItemCategory::orderBy('name')->get();
        $currencies = Currency::orderBy('name')->get();
        $coupon_reasons = CouponReason::orderBy('name')->get();
        $family_id = $request['family_id'] ?? "";
        $institution_id = $request['institution_id'] ?? "";

        if (!($institution_id) && !($family_id)) {
            event(new NewLogCreated('المحاولة للوصول لمساعدة غير موجودة  : ', null, 171, 1, null));
            return redirect("/admin/season_coupons")->with('error', 'المساعدة غير موجودة');
        }

        return view('admin.season_coupon.create', compact('family_id', 'projects', 'coupon_reasons', 'currencies', 'seasons', 'item_categories', 'institution_id', 'admin_statuses'));
    }

    public function store(SeasonCouponRequest $request)
    {
        //فحص الركيوست
        //فحص الركيوست بعد تعديل العرض شو هدين
        //فحص اضافة مع جمعية
        //فحص مع تعديل جمعية
        //فحص مع تعديل أسرة
        //فحص مع اضافة اسرة
        //فحص البوفيوت داتا
        request()['created_by'] = auth()->user()->id;

        $season_coupon = SeasonCoupon::create(request()->except(
            ['project_id', 'item_types_ids', 'item_categories', 'item_types_numbers', 'item_types_values', 'item_types_ids_other']
        ));


$item_categories = $request['item_categories'] ? array_values(array_filter($request["item_categories"])) : [];
        $item_types_ids = $request['item_types_ids'] ? array_values(array_filter($request["item_types_ids"])) : [];
        $item_types_numbers = $request['item_types_numbers'] ? array_values(array_filter($request["item_types_numbers"])) : [];
        $item_types_values = $request['item_types_values'] ? array_values(array_filter($request["item_types_values"])) : [];
        $item_types_ids_other = $request['item_types_ids_other'] ? array_values(array_filter($request["item_types_ids_other"])) : [];

        if($request['coupon_type'] == 1){
             $season_coupon->item_types()->sync(
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
                if ($item_types_ids[$i] == -1 && !empty($item_types_ids_other[$i])) {
                    $item_type = ItemType::where('name', $item_types_ids_other[$i])->first();

                    if ($item_type)
                        $item_types_ids[$i] = $item_type->id;
                    else
                        $item_types_ids[$i] = ItemType::create(['name' => $item_types_ids_other[$i], 'status' => 0 ,'item_category_id'=>$item_categories[$i]])->id;

                }
            }

            $item_types_ids = array_filter($item_types_ids, function ($v) {
                return $v > 0;
            });
            $season_coupon->item_types()->sync(
                $item_types_ids
            );
            if ($request['coupon_type'] == 1) {
                $season_coupon->item_types()->sync(
                    []
                );
            }
            for ($i = 0; $i < count($item_types_ids); $i++) {
                $season_coupon->coupon_item_types()->where('item_type_id', $item_types_ids[$i])
                    ->first()->update(['number' => $item_types_numbers[$i], 'value' => $item_types_values[$i]]);
            }

        } else {
            return back()->with('error', 'خانات مقدار المساعدة غير مدخلة بشكل صحيح')->withInput(request()->all());
        }   
        }
        
       


        event(new NewLogCreated('تم اضافة مساعدة بنجاح', $season_coupon->id, 165, 0, null));
        $action = Action::create(['title' => 'تم إضافة مساعدة موسمية جديدة', 'type' => Permission::findByName('list season_coupons')->title, 'link' => Permission::findByName('list season_coupons')->link]);
        $users = User::permission('season_coupons')->whereNotIn('id', [auth()->user()->id])->get();
        if ($users->first())
            Notification::send($users, new NotifyUsers($action));
        return redirect("/admin/season_coupons")->with('success', 'تم اضافة مساعدة بنجاح');

    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $season_coupon = SeasonCoupon::find($id);

        if (!is_null($season_coupon)) {
            $admin_statuses = AdminStatuse::orderBy('name')->get();
            $seasons = Season::all();
            $item_categories = ItemCategory::orderBy('name')->get();
            $currencies = Currency::orderBy('name')->get();
            $coupon_reasons = CouponReason::orderBy('name')->get();
            $family_id = $season_coupon->family_id ?? "";
            $institution_id = $season_coupon->institution_id ?? "";
            $projects = Project::orderBy('name')->get();

            return view('admin.season_coupon.edit', compact('currencies', 'projects', 'institution_id', 'family_id', 'coupon_reasons', 'coupon_reasons', 'season_coupon', 'seasons', 'admin_statuses', 'item_categories'));

        } else {
            event(new NewLogCreated('المحاولة للوصول لمساعدة غير موجودة برقم : ', $id, 166, 1, null));
            return redirect("/admin/season_coupons")->with('error', 'المساعدة غير موجودة');
        }
    }

    public function update(SeasonCouponRequest $request, $id)
    {
        $season_coupon = SeasonCoupon::find($id);

        if (!is_null($season_coupon)) {
            request()['updated_by'] = auth()->user()->id;
            $season_coupon->update(request()->except(
                ['file_type_id', 'files', 'file_type_id_other', 'project_id', 'item_types_ids', 'item_categories', 'item_types_numbers', 'item_types_values', 'item_types_ids_other']));

$item_categories = $request['item_categories'] ? array_values(array_filter($request["item_categories"])) : [];
 
            $item_types_ids = $request['item_types_ids'] ? array_values(array_filter($request["item_types_ids"])) : [];
            $item_types_numbers = $request['item_types_numbers'] ? array_values(array_filter($request["item_types_numbers"])) : [];
            $item_types_values = $request['item_types_values'] ? array_values(array_filter($request["item_types_values"])) : [];
            $item_types_ids_other = $request['item_types_ids_other'] ? array_values(array_filter($request["item_types_ids_other"])) : [];

          
          if($request['coupon_type'] == 1){
             $season_coupon->item_types()->sync(
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
                    if ($item_types_ids[$i] == -1 && !empty($item_types_ids_other[$i])) {
                        $item_type = ItemType::where('name', $item_types_ids_other[$i])->first();
                        if ($item_type)
                            $item_types_ids[$i] = $item_type->id;
                        else
                            $item_types_ids[$i] = ItemType::create(['name' => $item_types_ids_other[$i], 'status' => 0 ,'item_category_id'=>$item_categories[$i]])->id;

                    }


                }

                $item_types_ids = array_filter($item_types_ids, function ($v) {
                    return $v > 0;
                });
                $season_coupon->item_types()->sync(
                    $item_types_ids
                );
                for ($i = 0; $i < count($item_types_ids); $i++) {
                    $season_coupon->coupon_item_types()->where('item_type_id', $item_types_ids[$i])
                        ->first()->update(['number' => $item_types_numbers[$i], 'value' => $item_types_values[$i]]);
                }

            }
            else {
            return back()->with('error', 'خانات مقدار المساعدة غير مدخلة بشكل صحيح')->withInput(request()->all());
        }
            
        }
          
            


           


            if ($request['files']) {

                if (count($request['files']) != count($request['file_type_id'])) {
                    event(new NewLogCreated(' يرجى ادخال نوع الملف ', $season_coupon->name, 142, 0, 0));
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
                        $path = 'uploads/season_coupon/';
                        if (!file_exists($path)) {
                            File::makeDirectory($path, $mode = 0777, true, true);
                        }
                        $upload = $file['files']->move($path, $fileName);
                        $file_type_id = $file['file_type_id'];

                        $mediaData = [
                            'path' => $upload,
                            'file_type_id' => $file_type_id,
                            'season_coupon_id' => $season_coupon->id
                        ];
                        SeasonCouponMedia::create($mediaData);
                    }


                } else {
                    event(new NewLogCreated(' لم يتم إضافة مرفقات ', $season_coupon->name, 142, 0, 0));
                    return back()->with('error', 'لم  يتم إضافة مرفقات ');
                }
            }

            event(new NewLogCreated('تعديل البيانات بنجاح', $season_coupon->id, 166, 1, null));
            $action = Action::create(['title' => 'تم تعديل مساعدة موسمية', 'type' => Permission::findByName('list urgent_coupons')->title, 'link' => Permission::findByName('list urgent_coupons')->link]);
            $users = User::permission('urgent_coupons')->whereNotIn('id', [auth()->user()->id])->get();
            if ($users->first())
                Notification::send($users, new NotifyUsers($action));
            return redirect("/admin/season_coupons")->with('success', 'تم تعديل البيانات بنجاح');

        } else {
            event(new NewLogCreated('المحاولة للوصول لمساعدة غير موجودة برقم : ', $id, 166, 1, null));
            return redirect("/admin/season_coupons")->with('error', 'المساعدة غير موجودة');
        }
    }

    public function destroy($id)
    {
        //
    }

    public function removeMedia($id)
    {

        if (!is_null($id)) {
            $media = SeasonCouponMedia::find($id);

            if (!is_null($media)) {
                $institutionId = $media->season_coupon_id;
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
        $season_coupon = SeasonCoupon::find($id);

        if (!is_null($season_coupon)) {

            if ($season_coupon->season_coupon_families->first())
                SeasonCouponFamily::destroy($season_coupon->season_coupon_families->pluck('id')->toArray());

            $season_coupon->delete();
            event(new NewLogCreated('حذف مساعدة بنجاح', $season_coupon->name, 167, 1, null));
            $action = Action::create(['title' => 'تم حذف مساعدة موسمية', 'type' => Permission::findByName('list urgent_coupons')->title, 'link' => Permission::findByName('list urgent_coupons')->link]);
            $users = User::permission('urgent_coupons')->whereNotIn('id', [auth()->user()->id])->get();
            if ($users->first())
                Notification::send($users, new NotifyUsers($action));
            return redirect("/admin/seasons")->with('success', 'تم حذف مساعدة بنجاح');

        } else {
            event(new NewLogCreated('المحاولة للوصول لمساعدة غير موجودة برقم : ', $id, 167, 1, null));
            return redirect("/admin/season_coupons")->with('error', 'المساعدة غير موجودة');
        }
    }

    public function approve(Request $request)
    {
        $id = explode(",", $request['the_ids'])[0];
        $season_coupon = SeasonCoupon::find($id);


        if (!(auth()->user()->hasPermissionTo('edit season_coupons'))) {
            return response()->json([
                'message' => 'ليس لك صلاحية تعديل مساعدة',
            ], 401);
        }

        if ($season_coupon) {
            $season_coupon->update(['admin_status_id' => $request['admin_status_id']]);
            event(new NewLogCreated('تم تعديل قبول المساعدة بنجاح', $season_coupon->id, 168, 1, null));
            return response()->json([
                'message' => 'تم تعديل قبول المساعدة بنجاح',
            ], 200);

        } else {

            event(new NewLogCreated('المحاولة للوصول لمساعدة غير موجودة برقم : ', $id, 168, 1, null));
            return response()->json([
                'message' => 'المحاولة للوصول لمساعدة غير موجودة',
            ], 401);
        }
    }

    public function delivery(Request $request)
    {
        $id = explode(",", $request['the_ids'])[0];


        $season_coupon = SeasonCoupon::find($id);

        if (!(auth()->user()->hasPermissionTo('edit season_coupons'))) {
            return response()->json([
                'message' => 'ليس لك صلاحية تعديل مساعدة',
            ], 401);
        }

        if ($season_coupon) {
            if ($season_coupon->delivery_status == 1) {
                $season_coupon->update(['delivery_status' => 0]);
                $season_coupon->season_coupon_families()->update(['delivery_status' => 0]);
                event(new NewLogCreated('تم الغاء تسليم مساعدة بنجاح', $season_coupon->id, 169, 1, null));
                return response()->json([
                    'message' => 'تم إلغاء تسليم مساعدة بنجاح',
                ], 200);
            } else {

                $season_coupon->update(['delivery_status' => 1, 'delivery_date' => Carbon::now(), 'delivery_place' => $request['delivery_place']]);
                $season_coupon->season_coupon_families()->update(['delivery_status' => 1, 'delivery_date' => Carbon::now(), 'delivery_place' => $request['delivery_place']]);
                //word_export
                $settings = Setting::whereIn('key', ['sessionEnd', 'footer', 'name', 'number_one', 'number_two', 'logo', 'address', 'fax', 'phone', 'email', 'facebook', 'twitter', 'youtube', 'welcomeBackground', 'welcomeMainText', 'welcomeSubText', 'welcomeReadMoreLink', 'welcomeReadMoreText'])->get();

                $phone = $settings->where('key', 'phone')->first()->value;
                $number_one = $settings->where('key', 'number_one')->first()->value;
                $number_two = $settings->where('key', 'number_two')->first()->value;
                $address = $settings->where('key', 'address')->first()->value;
                $email = $settings->where('key', 'email')->first()->value;

                $id = $id;
                if ($season_coupon->season->project->name == 'أضاحي') {
                    $a = '⦿';
                    $b = $c = $d = '';
                } elseif ($season_coupon->season->project->name == 'طرود') {
                    $b = '⦿';
                    $a = $c = $d = '';
                } elseif ($season_coupon->season->project->name == 'كسوة') {
                    $c = '⦿';
                    $b = $a = $d = '';
                } else {
                    $d = '⦿';
                    $b = $a = $c = '';
                }
                if ($d)
                    $project_name = $season_coupon->season->project->name ?? "";
                else
                    $project_name = "";

                if ($season_coupon->institution) {
                    $the_name = $season_coupon->institution->name;
                    $responsible_person = $season_coupon->institution->responsible_person ?? "";
                    $name = $season_coupon->institution ? ($season_coupon->institution->name ?? "") : "-";
                    $licensor_number = $season_coupon->institution->licensor_number ?? "";
                    $mobile = $season_coupon->institution->mobile ?? $season_coupon->institution->mobile_one ?? $season_coupon->institution->mobile_two ?? "";
                    if ($season_coupon->coupon_type == 2) {
                        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor(public_path('word_templates/coupons/season/kind/institution.docx'));
                        $the_path = 'word_templates_results/coupons/season/kind/' . $season_coupon->id . '/';;
                    } else {
                        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor(public_path('word_templates/coupons/season/cash/institution.docx'));
                        $the_path = 'word_templates_results/coupons/season/cash/' . $season_coupon->id . '/';;
                    }
                    $templateProcessor->setValue('responsible_person', $responsible_person);
                    $templateProcessor->setValue('name', $name);
                    $templateProcessor->setValue('licensor_number', $licensor_number);
                } elseif ($season_coupon->family) {
                    $the_name = $season_coupon->family->full_name ?? "";
                    $full_name = $season_coupon->family->full_name ?? "";
                    $id_number = $season_coupon->family->person->id_number ?? "";
                    $mobile = $season_coupon->family->telephone ?? $season_coupon->family->mobile_one ?? $season_coupon->family->mobile_two ?? "";
                    if ($season_coupon->coupon_type == 2) {
                        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor(public_path('word_templates/coupons/season/kind/person.docx'));
                        $the_path = 'word_templates_results/coupons/season/kind/' . $season_coupon->id . '/';
                    } else {
                        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor(public_path('word_templates/coupons/season/cash/person.docx'));
                        $the_path = 'word_templates_results/coupons/season/cash/' . $season_coupon->id . '/';
                    }
                    $templateProcessor->setValue('full_name', $full_name);
                    $templateProcessor->setValue('id_number', $id_number);
                }
                if ($season_coupon->coupon_type == 2) {
                    $count = "";
                    $z = 0;
                    foreach ($season_coupon->coupon_item_types as $coupon_item_types) {
                        if ($z > 0)
                            $count = $count . " و";

                        $count = $count . "" . $coupon_item_types->number . " " . $coupon_item_types->item_type->name . "-" . $coupon_item_types->item_type->item_category->name . "";
                        $z++;
                    }
                    $templateProcessor->setValue('count', $count);
                }
                if ($season_coupon->amount)
                    $amount = $season_coupon->amount . "" . $season_coupon->amount_currency->icon;
                else
                    $amount = " ";
                $delivery_place = $season_coupon->delivery_place;
                $delivery_date = $season_coupon->delivery_date;


                $templateProcessor->setValue('phone', $phone);
                $templateProcessor->setValue('number_one', $number_one);
                $templateProcessor->setValue('number_two', $number_two);
                $templateProcessor->setValue('address1', $address);
                $templateProcessor->setValue('email', $email);
                $templateProcessor->setValue('id', $id);
                $templateProcessor->setValue('project_name', $project_name);
                $templateProcessor->setValue('mobile', $mobile);
                $templateProcessor->setValue('amount', $amount);
                $templateProcessor->setValue('delivery_place', $delivery_place);
                $templateProcessor->setValue('delivery_date', $delivery_date);
                $templateProcessor->setValue('a', $a);
                $templateProcessor->setValue('b', $b);
                $templateProcessor->setValue('c', $c);
                $templateProcessor->setValue('d', $d);

                $path = public_path($the_path);
                if (!file_exists($path)) {
                    Storage::disk('real_public')->makeDirectory($the_path);
                }

                // delete old files
                $oldFiles = \Illuminate\Support\Facades\File::allfiles($path);

                foreach ($oldFiles as $file) {
                    \Illuminate\Support\Facades\File::delete(public_path($the_path . "" . $file->getRelativePathname()));
                }


                $templateProcessor->saveAs(public_path($the_path . "" . $the_name . 'سند استلام.docx'));


                event(new NewLogCreated('تم تسليم مساعدة بنجاح', $season_coupon->id, 169, 1, null));
                $action = Action::create(['title' => 'تم تسليم مساعدة موسمية بنجاح', 'type' => Permission::findByName('list season_coupons')->title, 'link' => Permission::findByName('list season_coupons')->link]);
        $users = User::permission('season_coupons')->whereNotIn('id', [auth()->user()->id])->get();
        if ($users->first())
            Notification::send($users, new NotifyUsers($action));
                return response()->json([
                    'message' => "تم تسليم مساعدة بنجاح <a href='" . asset($the_path . "" . $the_name . 'سند استلام.docx') . "'>  تحميل</a>",
                ], 200);
            }

        } else {

            event(new NewLogCreated('المحاولة للوصول لمساعدة غير موجودة برقم : ', $id, 169, 1, null));
            return response()->json([
                'message' => 'المحاولة للوصول لمساعدة غير موجودة',
            ], 401);
        }
    }

    public function add_pesrons($id)
    {
        //
    }

    public function add_pesrons_post($id)
    {
        //
    }

    public function show_pesrons($id)
    {
        $season_coupon = SeasonCoupon::find($id);

        if (!is_null($season_coupon)) {
            $delivery_status = $request["delivery_status"] ?? "";
            $min_id = $season_coupon->season_coupon_families->first()->id ?? 1;
            $max_id = $season_coupon->season_coupon_families->orderByDesc('id')->first()->id ?? 1;
            $from_id = $request["from_id"] ?? $min_id;
            $to_id = $request["to_id"] ?? $max_id;
            $institution_id = $request['institution_id'];
            $families_yes = $request['families_yes'];  // علاقة
            $families_no = $request['families_no'];  // علاقة

            $season_coupon_families = $season_coupon->season_coupon_families->when(($delivery_status || $delivery_status == '0'), function ($query) use ($delivery_status) {
                return $query->where('delivery_status', $delivery_status);
            })->when($from_id && $to_id, function ($query) use ($from_id, $to_id) {
                return $query->whereBetween('id', [$from_id, $to_id]);
            })->when($institution_id, function ($query) use ($institution_id) {
                return $query->where('institution_id', $institution_id);
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

            if ($request['theaction'] == 'print') {
                $the_date = Carbon::now();
                $season_coupon_families = $season_coupon_families->orderBy("season_coupon_families.id", 'desc')->get();
                $pdf = Pdf::loadView('admin.season_coupon_family.print_all', compact('season_coupon_families', 'coulmn'));
                return $pdf->stream("المساعدات $the_date.pdf");
            } else {
                $season_coupon_families = $season_coupon_families->orderBy("season_coupon_families.id", 'desc')->paginate(20)
                    ->appends(["delivery_status" => $delivery_status,
                        "from_id" => $from_id, "to_id" => $to_id, "institution_id" => $institution_id,
                        "families_no" => $families_no, "families_yes" => $families_yes,
                    ]);

                return view('admin.season_coupon.season_coupon_families', compact('season_coupon_families', "delivery_status",
                    "from_id", "to_id", "families_no", "families_yes", "institution_id", 'min_id', 'max_id', 'season_coupon'

                ));

            }


        } else {
            event(new NewLogCreated('المحاولة للوصول لمساعدة غير موجودة برقم : ', $id, 167, 1, null));
            return redirect("/admin/season_coupons")->with('error', 'المساعدة غير موجودة');
        }
    }

    public function import_season_coupon()
    {
        return view('admin.season_coupon.import_season_coupon');

    }

    public function store_import_season_coupon(Request $request)
    {
        $excel_file = $request["excel_file"];

        // $collection = Excel::toCollection(new IgnorImport, $excel_file);
        $collection = Excel::load($excel_file, 'UTF-8')->get();
        $error_string = "";
        $note_string = "";
        $headerRow = $collection->first()->keys()->toArray();
        $faildCollection = collect();
        $faildCollection->push($headerRow);
        $j = 1;
        foreach ($collection->chunk(20) as $collections) {
            foreach ($collections as $keys => $vals) {

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
                if (count($headerRow) < 25) {
                    //error عدد الأعمدة أقل من المتعارف عليه
                    return back()->with('error', 'عدد الأعمدة أقل من التنسيق اللازم')->withInput(session()->getOldInput());
                }


                if ($j == 1) {
                    if (!(($index0 == "الرقم") &&
                        ($index1 == "اسم الجمعية") &&
                        ($index2 == "المحافظة") &&
                        ($index3 == "العنوان") &&
                        ($index4 == "المسؤول المباشر") &&
                        ($index5 == "جوال") &&
                        ($index6 == "هاتف") &&
                        ($index7 == "ايميل"))) {

                        //error تنسيق ملف الإكسل غير صحيح (لا يحتوي اسم المشروع او كود المكفول أو اسم المكفول أو الكافل)
                        return back()->with('error', 'تنسيق ملف الإكسل غير صحيح ')->withInput(session()->getOldInput());
                    }
                }

                $his_id = (int)trim($vals[$index0]);
                /*if ($his_id != 1)
                    continue;*/

                /*********/
                if ((int)trim($vals[$index0]) != 0
                    && (trim($vals[$index1])) && strlen(trim($vals[$index1])) > 4
                    && (!(trim($vals[$index2])) || strlen(trim($vals[$index2])) > 3)
                    && (!(trim($vals[$index3])) || strlen(trim($vals[$index3])) > 3)
                    && (!(trim($vals[$index4])) || strlen(trim($vals[$index4])) > 3)
                    && (!(trim($vals[$index5])) || (strlen(trim($vals[$index5])) > 5) && is_numeric((float)(trim($vals[$index3]))))
                    && (!(trim($vals[$index6])) || (strlen(trim($vals[$index6])) > 5) && is_numeric((float)(trim($vals[$index3]))))
                    && (!(trim($vals[$index7])) || strlen(trim($vals[$index7])) > 3)
                    && (!(trim($vals[$index8])) || is_numeric((float)(trim($vals[$index8]))))
                    && (!(trim($vals[$index9])) || is_numeric((float)(trim($vals[$index9]))))
                    && (!(trim($vals[$index10])) || is_numeric((float)(trim($vals[$index10]))))
                    && (!(trim($vals[$index11])) || is_numeric((float)(trim($vals[$index11]))))
                    && (!(trim($vals[$index12])) || is_numeric((float)(trim($vals[$index12]))))
                    && (!(trim($vals[$index13])) || is_numeric((float)(trim($vals[$index13]))))
                    && (!(trim($vals[$index14])) || is_numeric((float)(trim($vals[$index14]))))
                    && (!(trim($vals[$index15])) || is_numeric((float)(trim($vals[$index15]))))
                    && (!(trim($vals[$index16])) || is_numeric((float)(trim($vals[$index16]))))
                    && (!(trim($vals[$index17])) || is_numeric((float)(trim($vals[$index17]))))
                    && (!(trim($vals[$index18])) || is_numeric((float)(trim($vals[$index18]))))
                    && (!(trim($vals[$index19])) || is_numeric((float)(trim($vals[$index19]))))
                    && (!(trim($vals[$index20])) || is_numeric((float)(trim($vals[$index20]))))
                    && (!(trim($vals[$index21])) || is_numeric((float)(trim($vals[$index21]))))
                    && (!(trim($vals[$index22])) || is_numeric((float)(trim($vals[$index22]))))
                    && (!(trim($vals[$index23])) || is_numeric((float)(trim($vals[$index23]))))
                    && (!(trim($vals[$index24])) || strlen(trim($vals[$index24])) > 3)
                ) {

                    $institutionData['name'] = $vals[$index1];
                    $city_id = Governorate::where('name', 'like', '%' . $vals[$index2] . '%')->first()->city()->orderBy('id', 'DESC')->first()->id;
                    $neighborhood = Neighborhood::where('name', "أخرى - " . $vals[$index2])->where('city_id', $city_id)->first();
                    if ($neighborhood)
                        $institutionData['neighborhood_id'] = $neighborhood->id;
                    else
                        $institutionData['neighborhood_id'] = Neighborhood::create(['name' => "أخرى - " . $vals[$index2], "city_id" => $city_id])->id;

                    $institutionData['responsible_person'] = $vals[$index4];

                    if (strpos($vals[$index5], "\n") !== false) {
                        $vals[$index5] = str_replace("\n", PHP_EOL, $vals[$index5]);
                    }
                    $mobiles = explode(PHP_EOL, $vals[$index5]);
                    $institutionData['mobile'] = $mobiles[0];
                    if (count($mobiles) > 1) {
                        $institutionData['mobile_one'] = $mobiles[1];
                    }

                    if (strpos($vals[$index6], "\n") !== false) {
                        $vals[$index6] = str_replace("\n", PHP_EOL, $vals[$index6]);
                    }
                    $phones = explode(PHP_EOL, $vals[$index6]);
                    $institutionData['mobile_two'] = $phones[0];

                    $institutionData['email'] = $vals[$index7];
                    $institutionData['note'] = $vals[$index24];
                    $institution = Institution::create($institutionData);
                    $institutionData = [];
                    if ($institution) {
                        if ($vals[$index8]) {
                            $seasons = explode("-", $index8);
                            $project_id = Project::where('name', trim($seasons[0]))->first()->id;
                            $date = Carbon::createFromFormat('Y-m-d', '' . trim($seasons[1]) . '-01-01');

                            $season = Season::where('project_id', $project_id)->where('start_date', date('Y-m-d', strtotime($date)))->first();

                            if ($season) {
                                $seasonCouponData['season_id'] = $season->id;
                            } else {
                                $seasonCouponData['season_id'] = Season::create(['project_id' => $project_id, 'start_date' => $date])->id;
                            }
                            $seasonCouponData['institution_id'] = $institution->id;
                            $seasonCouponData['coupon_type'] = 2;
                            $seasonCouponData['admin_status_id'] = 1;
                            $couponItemTypeDate['season_coupon_id'] = SeasonCoupon::create($seasonCouponData)->id;
                            $seasonCouponData = [];
                            $couponItemTypeDate['number'] = $vals[$index8];
                            if ($project_id == 1)
                                $couponItemTypeDate['item_type_id'] = 2;
                            else
                                $couponItemTypeDate['item_type_id'] = 1;
                            CouponItemType::create($couponItemTypeDate);
                            $couponItemTypeDate = [];
                        }
                        if ($vals[$index9]) {
                            $seasons = explode("-", $index9);
                            $project_id = Project::where('name', trim($seasons[0]))->first()->id;
                            $date = Carbon::createFromFormat('Y-m-d', '' . trim($seasons[1]) . '-01-01');
                            $season = Season::where('project_id', $project_id)->where('start_date', date('Y-m-d', strtotime($date)))->first();
                            if ($season) {
                                $seasonCouponData['season_id'] = $season->id;
                            } else {
                                $seasonCouponData['season_id'] = Season::create(['project_id' => $project_id, 'start_date' => $date])->id;
                            }
                            $seasonCouponData['institution_id'] = $institution->id;
                            $seasonCouponData['coupon_type'] = 2;
                            $seasonCouponData['admin_status_id'] = 1;
                            $couponItemTypeDate['season_coupon_id'] = SeasonCoupon::create($seasonCouponData)->id;
                            $seasonCouponData = [];
                            $couponItemTypeDate['number'] = $vals[$index9];
                            if ($project_id == 1)
                                $couponItemTypeDate['item_type_id'] = 2;
                            else
                                $couponItemTypeDate['item_type_id'] = 1;
                            CouponItemType::create($couponItemTypeDate);
                            $couponItemTypeDate = [];
                        }
                        if ($vals[$index10]) {
                            $seasons = explode("-", $index10);
                            $project_id = Project::where('name', trim($seasons[0]))->first()->id;
                            $date = Carbon::createFromFormat('Y-m-d', '' . trim($seasons[1]) . '-01-01');
                            $season = Season::where('project_id', $project_id)->where('start_date', date('Y-m-d', strtotime($date)))->first();
                            if ($season) {
                                $seasonCouponData['season_id'] = $season->id;
                            } else {
                                $seasonCouponData['season_id'] = Season::create(['project_id' => $project_id, 'start_date' => $date])->id;
                            }
                            $seasonCouponData['institution_id'] = $institution->id;
                            $seasonCouponData['coupon_type'] = 2;
                            $seasonCouponData['admin_status_id'] = 1;
                            $couponItemTypeDate['season_coupon_id'] = SeasonCoupon::create($seasonCouponData)->id;
                            $seasonCouponData = [];
                            $couponItemTypeDate['number'] = $vals[$index10];
                            if ($project_id == 1)
                                $couponItemTypeDate['item_type_id'] = 2;
                            else
                                $couponItemTypeDate['item_type_id'] = 1;
                            CouponItemType::create($couponItemTypeDate);
                            $couponItemTypeDate = [];
                        }
                        if ($vals[$index11]) {
                            $seasons = explode("-", $index11);
                            $project_id = Project::where('name', trim($seasons[0]))->first()->id;
                            $date = Carbon::createFromFormat('Y-m-d', '' . trim($seasons[1]) . '-01-01');
                            $season = Season::where('project_id', $project_id)->where('start_date', date('Y-m-d', strtotime($date)))->first();
                            if ($season) {
                                $seasonCouponData['season_id'] = $season->id;
                            } else {
                                $seasonCouponData['season_id'] = Season::create(['project_id' => $project_id, 'start_date' => $date])->id;
                            }
                            $seasonCouponData['institution_id'] = $institution->id;
                            $seasonCouponData['coupon_type'] = 2;
                            $seasonCouponData['admin_status_id'] = 1;
                            $couponItemTypeDate['season_coupon_id'] = SeasonCoupon::create($seasonCouponData)->id;
                            $seasonCouponData = [];
                            $couponItemTypeDate['number'] = $vals[$index11];
                            if ($project_id == 1)
                                $couponItemTypeDate['item_type_id'] = 2;
                            else
                                $couponItemTypeDate['item_type_id'] = 1;
                            CouponItemType::create($couponItemTypeDate);
                            $couponItemTypeDate = [];
                        }
                        if ($vals[$index12]) {
                            $seasons = explode("-", $index12);
                            $project_id = Project::where('name', trim($seasons[0]))->first()->id;
                            $date = Carbon::createFromFormat('Y-m-d', '' . trim($seasons[1]) . '-01-01');
                            $season = Season::where('project_id', $project_id)->where('start_date', date('Y-m-d', strtotime($date)))->first();
                            if ($season) {
                                $seasonCouponData['season_id'] = $season->id;
                            } else {
                                $seasonCouponData['season_id'] = Season::create(['project_id' => $project_id, 'start_date' => $date])->id;
                            }
                            $seasonCouponData['institution_id'] = $institution->id;
                            $seasonCouponData['coupon_type'] = 2;
                            $seasonCouponData['admin_status_id'] = 1;
                            $couponItemTypeDate['season_coupon_id'] = SeasonCoupon::create($seasonCouponData)->id;
                            $seasonCouponData = [];
                            $couponItemTypeDate['number'] = $vals[$index12];
                            if ($project_id == 1)
                                $couponItemTypeDate['item_type_id'] = 2;
                            else
                                $couponItemTypeDate['item_type_id'] = 1;
                            CouponItemType::create($couponItemTypeDate);
                            $couponItemTypeDate = [];
                        }
                        if ($vals[$index13]) {
                            $seasons = explode("-", $index13);
                            $project_id = Project::where('name', trim($seasons[0]))->first()->id;
                            $date = Carbon::createFromFormat('Y-m-d', '' . trim($seasons[1]) . '-01-01');
                            $season = Season::where('project_id', $project_id)->where('start_date', date('Y-m-d', strtotime($date)))->first();
                            if ($season) {
                                $seasonCouponData['season_id'] = $season->id;
                            } else {
                                $seasonCouponData['season_id'] = Season::create(['project_id' => $project_id, 'start_date' => $date])->id;
                            }
                            $seasonCouponData['institution_id'] = $institution->id;
                            $seasonCouponData['coupon_type'] = 2;
                            $seasonCouponData['admin_status_id'] = 1;
                            $couponItemTypeDate['season_coupon_id'] = SeasonCoupon::create($seasonCouponData)->id;
                            $seasonCouponData = [];
                            $couponItemTypeDate['number'] = $vals[$index13];
                            if ($project_id == 1)
                                $couponItemTypeDate['item_type_id'] = 2;
                            else
                                $couponItemTypeDate['item_type_id'] = 1;
                            CouponItemType::create($couponItemTypeDate);
                            $couponItemTypeDate = [];
                        }
                        if ($vals[$index14]) {
                            $seasons = explode("-", $index14);
                            $project_id = Project::where('name', trim($seasons[0]))->first()->id;
                            $date = Carbon::createFromFormat('Y-m-d', '' . trim($seasons[1]) . '-01-01');
                            $season = Season::where('project_id', $project_id)->where('start_date', date('Y-m-d', strtotime($date)))->first();
                            if ($season) {
                                $seasonCouponData['season_id'] = $season->id;
                            } else {
                                $seasonCouponData['season_id'] = Season::create(['project_id' => $project_id, 'start_date' => $date])->id;
                            }
                            $seasonCouponData['institution_id'] = $institution->id;
                            $seasonCouponData['coupon_type'] = 2;
                            $seasonCouponData['admin_status_id'] = 1;
                            $couponItemTypeDate['season_coupon_id'] = SeasonCoupon::create($seasonCouponData)->id;
                            $seasonCouponData = [];
                            $couponItemTypeDate['number'] = $vals[$index14];
                            if ($project_id == 1)
                                $couponItemTypeDate['item_type_id'] = 2;
                            else
                                $couponItemTypeDate['item_type_id'] = 1;
                            CouponItemType::create($couponItemTypeDate);
                            $couponItemTypeDate = [];
                        }
                        if ($vals[$index15]) {
                            $seasons = explode("-", $index15);
                            $project_id = Project::where('name', trim($seasons[0]))->first()->id;
                            $date = Carbon::createFromFormat('Y-m-d', '' . trim($seasons[1]) . '-01-01');
                            $season = Season::where('project_id', $project_id)->where('start_date', date('Y-m-d', strtotime($date)))->first();

                            if ($season) {
                                $seasonCouponData['season_id'] = $season->id;
                            } else {
                                $seasonCouponData['season_id'] = Season::create(['project_id' => $project_id, 'start_date' => $date])->id;
                            }
                            $seasonCouponData['institution_id'] = $institution->id;
                            $seasonCouponData['coupon_type'] = 2;
                            $seasonCouponData['admin_status_id'] = 1;
                            $couponItemTypeDate['season_coupon_id'] = SeasonCoupon::create($seasonCouponData)->id;
                            $seasonCouponData = [];
                            $couponItemTypeDate['number'] = $vals[$index15];
                            if ($project_id == 1)
                                $couponItemTypeDate['item_type_id'] = 2;
                            else
                                $couponItemTypeDate['item_type_id'] = 1;
                            CouponItemType::create($couponItemTypeDate);
                            $couponItemTypeDate = [];
                        }
                        if ($vals[$index16]) {
                            $seasons = explode("-", $index16);
                            $project_id = Project::where('name', trim($seasons[0]))->first()->id;
                            $date = Carbon::createFromFormat('Y-m-d', '' . trim($seasons[1]) . '-01-01');
                            $season = Season::where('project_id', $project_id)->where('start_date', date('Y-m-d', strtotime($date)))->first();
                            if ($season) {
                                $seasonCouponData['season_id'] = $season->id;
                            } else {
                                $seasonCouponData['season_id'] = Season::create(['project_id' => $project_id, 'start_date' => $date])->id;
                            }
                            $seasonCouponData['institution_id'] = $institution->id;
                            $seasonCouponData['coupon_type'] = 2;
                            $seasonCouponData['admin_status_id'] = 1;
                            $couponItemTypeDate['season_coupon_id'] = SeasonCoupon::create($seasonCouponData)->id;
                            $seasonCouponData = [];
                            $couponItemTypeDate['number'] = $vals[$index16];
                            if ($project_id == 1)
                                $couponItemTypeDate['item_type_id'] = 2;
                            else
                                $couponItemTypeDate['item_type_id'] = 1;
                            CouponItemType::create($couponItemTypeDate);
                            $couponItemTypeDate = [];
                        }
                        if ($vals[$index17]) {
                            $seasons = explode("-", $index17);
                            $project_id = Project::where('name', trim($seasons[0]))->first()->id;
                            $date = Carbon::createFromFormat('Y-m-d', '' . trim($seasons[1]) . '-01-01');
                            $season = Season::where('project_id', $project_id)->where('start_date', date('Y-m-d', strtotime($date)))->first();
                            if ($season) {
                                $seasonCouponData['season_id'] = $season->id;
                            } else {
                                $seasonCouponData['season_id'] = Season::create(['project_id' => $project_id, 'start_date' => $date])->id;
                            }
                            $seasonCouponData['institution_id'] = $institution->id;
                            $seasonCouponData['coupon_type'] = 2;
                            $seasonCouponData['admin_status_id'] = 1;
                            $couponItemTypeDate['season_coupon_id'] = SeasonCoupon::create($seasonCouponData)->id;
                            $seasonCouponData = [];
                            $couponItemTypeDate['number'] = $vals[$index17];
                            if ($project_id == 1)
                                $couponItemTypeDate['item_type_id'] = 2;
                            else
                                $couponItemTypeDate['item_type_id'] = 1;
                            CouponItemType::create($couponItemTypeDate);
                            $couponItemTypeDate = [];
                        }
                        if ($vals[$index18]) {
                            $seasons = explode("-", $index18);
                            $project_id = Project::where('name', trim($seasons[0]))->first()->id;
                            $date = Carbon::createFromFormat('Y-m-d', '' . trim($seasons[1]) . '-01-01');
                            $season = Season::where('project_id', $project_id)->where('start_date', date('Y-m-d', strtotime($date)))->first();
                            if ($season) {
                                $seasonCouponData['season_id'] = $season->id;
                            } else {
                                $seasonCouponData['season_id'] = Season::create(['project_id' => $project_id, 'start_date' => $date])->id;
                            }
                            $seasonCouponData['institution_id'] = $institution->id;
                            $seasonCouponData['coupon_type'] = 2;
                            $seasonCouponData['admin_status_id'] = 1;
                            $couponItemTypeDate['season_coupon_id'] = SeasonCoupon::create($seasonCouponData)->id;
                            $seasonCouponData = [];
                            $couponItemTypeDate['number'] = $vals[$index18];
                            if ($project_id == 1)
                                $couponItemTypeDate['item_type_id'] = 2;
                            else
                                $couponItemTypeDate['item_type_id'] = 1;
                            CouponItemType::create($couponItemTypeDate);
                            $couponItemTypeDate = [];
                        }
                        if ($vals[$index19]) {
                            $seasons = explode("-", $index19);
                            $project_id = Project::where('name', trim($seasons[0]))->first()->id;
                            $date = Carbon::createFromFormat('Y-m-d', '' . trim($seasons[1]) . '-01-01');
                            $season = Season::where('project_id', $project_id)->where('start_date', date('Y-m-d', strtotime($date)))->first();
                            if ($season) {
                                $seasonCouponData['season_id'] = $season->id;
                            } else {
                                $seasonCouponData['season_id'] = Season::create(['project_id' => $project_id, 'start_date' => $date])->id;
                            }
                            $seasonCouponData['institution_id'] = $institution->id;
                            $seasonCouponData['coupon_type'] = 2;
                            $seasonCouponData['admin_status_id'] = 1;
                            $couponItemTypeDate['season_coupon_id'] = SeasonCoupon::create($seasonCouponData)->id;
                            $seasonCouponData = [];
                            $couponItemTypeDate['number'] = $vals[$index19];
                            if ($project_id == 1)
                                $couponItemTypeDate['item_type_id'] = 2;
                            else
                                $couponItemTypeDate['item_type_id'] = 1;
                            CouponItemType::create($couponItemTypeDate);
                            $couponItemTypeDate = [];
                        }
                        if ($vals[$index20]) {
                            $seasons = explode("-", $index20);
                            $project_id = Project::where('name', trim($seasons[0]))->first()->id;
                            $date = Carbon::createFromFormat('Y-m-d', '' . trim($seasons[1]) . '-01-01');
                            $season = Season::where('project_id', $project_id)->where('start_date', date('Y-m-d', strtotime($date)))->first();
                            if ($season) {
                                $seasonCouponData['season_id'] = $season->id;
                            } else {
                                $seasonCouponData['season_id'] = Season::create(['project_id' => $project_id, 'start_date' => $date])->id;
                            }
                            $seasonCouponData['institution_id'] = $institution->id;
                            $seasonCouponData['coupon_type'] = 2;
                            $seasonCouponData['admin_status_id'] = 1;
                            $couponItemTypeDate['season_coupon_id'] = SeasonCoupon::create($seasonCouponData)->id;
                            $seasonCouponData = [];
                            $couponItemTypeDate['number'] = $vals[$index20];
                            if ($project_id == 1)
                                $couponItemTypeDate['item_type_id'] = 2;
                            else
                                $couponItemTypeDate['item_type_id'] = 1;
                            CouponItemType::create($couponItemTypeDate);
                            $couponItemTypeDate = [];
                        }
                        if ($vals[$index21]) {
                            $seasons = explode("-", $index21);
                            $project_id = Project::where('name', trim($seasons[0]))->first()->id;
                            $date = Carbon::createFromFormat('Y-m-d', '' . trim($seasons[1]) . '-01-01');
                            $season = Season::where('project_id', $project_id)->where('start_date', date('Y-m-d', strtotime($date)))->first();
                            if ($season) {
                                $seasonCouponData['season_id'] = $season->id;
                            } else {
                                $seasonCouponData['season_id'] = Season::create(['project_id' => $project_id, 'start_date' => $date])->id;
                            }
                            $seasonCouponData['institution_id'] = $institution->id;
                            $seasonCouponData['coupon_type'] = 2;
                            $seasonCouponData['admin_status_id'] = 1;
                            $couponItemTypeDate['season_coupon_id'] = SeasonCoupon::create($seasonCouponData)->id;
                            $seasonCouponData = [];
                            $couponItemTypeDate['number'] = $vals[$index21];
                            if ($project_id == 1)
                                $couponItemTypeDate['item_type_id'] = 2;
                            else
                                $couponItemTypeDate['item_type_id'] = 1;
                            CouponItemType::create($couponItemTypeDate);
                            $couponItemTypeDate = [];
                        }
                        if ($vals[$index22]) {
                            $seasons = explode("-", $index22);
                            $project_id = Project::where('name', trim($seasons[0]))->first()->id;
                            $date = Carbon::createFromFormat('Y-m-d', '' . trim($seasons[1]) . '-01-01');
                            $season = Season::where('project_id', $project_id)->where('start_date', date('Y-m-d', strtotime($date)))->first();
                            if ($season) {
                                $seasonCouponData['season_id'] = $season->id;
                            } else {
                                $seasonCouponData['season_id'] = Season::create(['project_id' => $project_id, 'start_date' => $date])->id;
                            }
                            $seasonCouponData['institution_id'] = $institution->id;
                            $seasonCouponData['coupon_type'] = 2;
                            $seasonCouponData['admin_status_id'] = 1;
                            $couponItemTypeDate['season_coupon_id'] = SeasonCoupon::create($seasonCouponData)->id;
                            $seasonCouponData = [];
                            $couponItemTypeDate['number'] = $vals[$index22];
                            if ($project_id == 1)
                                $couponItemTypeDate['item_type_id'] = 2;
                            else
                                $couponItemTypeDate['item_type_id'] = 1;
                            CouponItemType::create($couponItemTypeDate);
                            $couponItemTypeDate = [];
                        }
                        if ($vals[$index23]) {
                            $seasons = explode("-", $index23);
                            $project_id = Project::where('name', trim($seasons[0]))->first()->id;
                            $date = Carbon::createFromFormat('Y-m-d', '' . trim($seasons[1]) . '-01-01');
                            $season = Season::where('project_id', $project_id)->where('start_date', date('Y-m-d', strtotime($date)))->first();
                            if ($season) {
                                $seasonCouponData['season_id'] = $season->id;
                            } else {
                                $seasonCouponData['season_id'] = Season::create(['project_id' => $project_id, 'start_date' => $date])->id;
                            }
                            $seasonCouponData['institution_id'] = $institution->id;
                            $seasonCouponData['coupon_type'] = 2;
                            $seasonCouponData['admin_status_id'] = 1;
                            $couponItemTypeDate['season_coupon_id'] = SeasonCoupon::create($seasonCouponData)->id;
                            $seasonCouponData = [];
                            $couponItemTypeDate['number'] = $vals[$index23];
                            if ($project_id == 1)
                                $couponItemTypeDate['item_type_id'] = 2;
                            else
                                $couponItemTypeDate['item_type_id'] = 1;
                            CouponItemType::create($couponItemTypeDate);
                            $couponItemTypeDate = [];
                        }
                    }

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

        return redirect('/admin/season_coupons/');
    }
}
