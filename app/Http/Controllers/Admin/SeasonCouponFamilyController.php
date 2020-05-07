<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\SeasonCouponFamilyRequest;
use App\SeasonCouponFamily;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Action;
use Notification;
use App\Notifications\NotifyUsers;

class SeasonCouponFamilyController extends Controller
{
    public function index(Request $request)
    {
        $delivery_status = $request["delivery_status"] ?? "";
        $min_id = SeasonCouponFamily::first()->id ?? 1;
        $max_id = SeasonCouponFamily::orderByDesc('id')->first()->id ?? 1;
        $from_id = $request["from_id"] ?? $min_id;
        $to_id = $request["to_id"] ?? $max_id;
        $institution_id = $request['institution_id'];
        $families_yes = $request['families_yes'] ? array_filter($request["families_yes"]) : [];  // علاقة
        $families_no = $request['families_no'] ? array_filter($request["families_no"]) : [];  // علاقة

        $season_coupon_families = SeasonCouponFamily::when(($delivery_status || $delivery_status == '0'), function ($query) use ($delivery_status) {
            return $query->where('delivery_status',$delivery_status);
        })->when($from_id && $to_id, function ($query) use ($from_id, $to_id) {
            return $query->whereBetween('id', [$from_id,$to_id ]);
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
            $pdf = Pdf::loadView('admin.season_coupon_family.print_all', compact('season_coupon_families'));
            return $pdf->stream("المساعدات $the_date.pdf");
        } else {
            $season_coupon_families = $season_coupon_families->orderBy("season_coupon_families.id",'desc')->paginate(20)
                ->appends(["delivery_status" => $delivery_status,
                    "from_id" => $from_id, "to_id" => $to_id, "institution_id" => $institution_id,
                    "families_no" => $families_no, "families_yes" => $families_yes,
                ]);

            return view('admin.season_coupon_family.index', compact('season_coupon_families', "delivery_status",
                "from_id", "to_id", "families_no", "families_yes", "institution_id", 'min_id', 'max_id'

            ));

        }


    }

    public function searctoaddcoupon($type)
    {
        return view("admin.season_coupon_family.search", compact('type'));
    }

    public function editorcreat(Request $request)
    {

        $type = $request['type'] ?? "";
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
            $come_by = 'season_coupon_family';
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
            $neighborhoods = Neighborhood::orderBy('name')->where('status', 1)->get();
            $licensors = licensor::orderBy('name')->where('status', 1)->get();
            $institution_types = InstitutionType::orderBy('name')->get();
            if ($institution) {
                return view('admin.institution.edit', compact('come_by', 'target_types', 'institution', 'neighborhoods', 'licensors', 'institution_types'));

            } else {
                return view('admin.institution.create', compact('target_types', 'neighborhoods', 'licensors', 'institution_types'));
            }
        }
    }

    public function create(Request $request)
    {
        $admin_statuses = AdminStatuse::orderBy('name')->get();
        $institutions = Institution::orderBy('name')->get();
        $family_id = $request['family_id'];
        $institution = $request['institution_id'];
        return view('admin.season_coupon_family.create', compact('family_id', 'institution', 'admin_statuses', 'institutions'));
    }

    public function store(SeasonCouponFamilyRequest $request)
    {
        request()['created_by'] = auth()->user()->id;
        $season_coupon_family = SeasonCouponFamily::create(request()->all());

        $item_types_ids = $request['item_types_ids'] ? array_filter($request["item_types_ids"]) : [];
        $item_types_numbers = $request['item_types_numbers'] ? array_filter($request["item_types_numbers"]) : [];
        $item_types_values = $request['item_types_values'] ? array_filter($request["item_types_values"]) : [];
        if (($item_types_ids) && $item_types_ids == count($item_types_numbers)
            && $item_types_ids == count($item_types_values)) {
            $pivotData = array();
            for ($i = 0; $i < count($item_types_ids); $i++) {
                $pivotData['number'] = $item_types_numbers;
                $pivotData['value'] = $item_types_values;
            }
            $syncData = array_combine($item_types_ids, $pivotData);
            $season_coupon_family->item_types()->sync(
                $syncData
            );
        }


        event(new NewLogCreated('تم اضافة مساعدة بنجاح', $season_coupon_family->id, 176, 0, null));
        $action = Action::create(['title' => 'تم إضافة مساعدة موسمية جديدة', 'type' => Permission::findByName('list urgent_coupons')->title, 'link' => Permission::findByName('list urgent_coupons')->link]);
        $users = User::permission('urgent_coupons')->whereNotIn('id', [auth()->user()->id])->get();
        if ($users->first())
            Notification::send($users, new NotifyUsers($action));
        return back()->with('success', 'تم اضافة مساعدة بنجاح');

    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $season_coupon_family = SeasonCouponFamily::find($id);

        if (!is_null($season_coupon_family)) {
            $admin_statuses = AdminStatuse::orderBy('name')->get();
            $institutions = Institution::orderBy('name')->get();
            return view('admin.season_coupon_family.edit', compact('season_coupon_family', 'admin_statuses', 'institutions'));

        } else {
            event(new NewLogCreated('المحاولة للوصول لمساعدة غير موجودة برقم : ', $id, 177, 1, null));
            return redirect("/admin/season_coupon_families")->with('error', 'المساعدة غير موجودة');
        }
    }

    public function update(SeasonCouponFamilyRequest $request, $id)
    {
        $season_coupon_family = SeasonCouponFamily::find($id);

        if (!is_null($season_coupon_family)) {
            request()['updated_by'] = auth()->user()->id;
            $season_coupon_family->update(request()->all());

            $item_types_ids = $request['item_types_ids'] ? array_filter($request["item_types_ids"]) : [];
            $item_types_numbers = $request['item_types_numbers'] ? array_filter($request["item_types_numbers"]) : [];
            $item_types_values = $request['item_types_values'] ? array_filter($request["item_types_values"]) : [];
            if (($item_types_ids) && $item_types_ids == count($item_types_numbers)
                && $item_types_ids == count($item_types_values)) {

                $pivotData = array();
                for ($i = 0; $i < count($item_types_ids); $i++) {
                    $pivotData['number'] = $item_types_numbers;
                    $pivotData['value'] = $item_types_values;
                }
                $syncData = array_combine($item_types_ids, $pivotData);
                $season_coupon_family->item_types()->sync(
                    $syncData
                );
            }

            event(new NewLogCreated('تعديل البيانات بنجاح', $season_coupon_family->id, 177, 1, null));
            return redirect("/admin/season_coupon_families")->with('success', 'تم تعديل البيانات بنجاح');

        } else {
            event(new NewLogCreated('المحاولة للوصول لمساعدة غير موجودة برقم : ', $id, 177, 1, null));
            return redirect("/admin/season_coupon_families")->with('error', 'المساعدة غير موجودة');
        }
    }

    public function destroy($id)
    {
        //
    }

    public function delete($id)
    {
        $season_coupon_family = SeasonCouponFamily::find($id);

        if (!is_null($season_coupon_family)) {
            $season_coupon_family->delete();
            event(new NewLogCreated('حذف مساعدة بنجاح', $season_coupon_family->name, 178, 1, null));
            $action = Action::create(['title' => 'تم حذف مساعدة موسمية', 'type' => Permission::findByName('list urgent_coupons')->title, 'link' => Permission::findByName('list urgent_coupons')->link]);
            $users = User::permission('urgent_coupons')->whereNotIn('id', [auth()->user()->id])->get();
            if ($users->first())
                Notification::send($users, new NotifyUsers($action));
            return redirect("/admin/seasons")->with('success', 'تم حذف مساعدة بنجاح');

        } else {
            event(new NewLogCreated('المحاولة للوصول لمساعدة غير موجودة برقم : ', $id, 178, 1, null));
            return redirect("/admin/season_coupon_families")->with('error', 'المساعدة غير موجودة');
        }
    }

    public function delivery($id, Request $request)
    {
        $season_coupon_family = SeasonCouponFamily::find($id);

        if (!(auth()->user()->hasPermissionTo('edit season_coupon'))) {
            return response()->json([
                'message' => 'ليس لك صلاحية تعديل مساعدة',
            ], 401);
        }

        if ($season_coupon_family) {
            if ($season_coupon_family->delivery_status == 1) {
                $season_coupon_family->update(['delivery_status' => 0]);
                event(new NewLogCreated('تم الغاء تسليم مساعدة بنجاح', $season_coupon_family->id, 180, 1, null));
                return response()->json([
                    'message' => 'تم إلغاء تسليم مساعدة بنجاح',
                ], 200);
            } else {
                $season_coupon_family->update(['delivery_status' => 1, 'delivery_date' => Carbon::now(), 'delivery_place' => $request['delivery_place']]);
                event(new NewLogCreated('تم تسليم مساعدة بنجاح', $season_coupon_family->id, 180, 1, null));
                return response()->json([
                    'message' => 'تم تسليم مساعدة بنجاح',
                ], 200);
            }

        } else {

            event(new NewLogCreated('المحاولة للوصول لمساعدة غير موجودة برقم : ', $id, 180, 1, null));
            return response()->json([
                'message' => 'المحاولة للوصول لمساعدة غير موجودة',
            ], 401);
        }
    }
}
