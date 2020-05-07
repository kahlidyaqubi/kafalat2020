<?php

namespace App\Http\Controllers\Admin;

use App\Action;
use App\City;
use App\Country;
use App\Disease;
use App\EducationalInstitution;
use App\Events\SmsEvent;
use App\Family;
use App\FamilyIncome;
use App\FamilyMedia;
use App\FamilyMemberDiseases;
use App\FamilySearcher;
use App\FileType;
use App\FundedInstitution;
use App\FurnitureStatus;
use App\Gender;
use App\Governorate;
use App\Health;
use App\HouseOwnership;
use App\HouseRoof;
use App\HouseStatus;
use App\Http\Requests\FamilyRequest;
use App\IDType;
use App\Immovable;
use App\IncomeType;
use App\JobType;
use App\Member;
use App\NameTranslation;
use App\Need;
use App\Neighborhood;
use App\Task;
use App\TaskFamily;
use Illuminate\Support\Facades\DB;
use Notification;
use App\Notifications\NotifyUsers;
use App\Person;
use App\Qualification;
use App\FamilyProject;
use App\FamilyStatus;
use App\FamilyType;
use App\QualificationLevels;
use App\Relationship;
use App\Setting;
use App\SocialStatus;
use App\StudyLevel;
use App\StudyPart;
use App\StudyType;
use App\UniversitySpecialty;
use App\User;
use App\Http\Controllers\Controller;
use App\Events\NewLogCreated;
use App\VisitReason;
use App\Work;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Maatwebsite\Excel\Facades\Excel;
use File;
use niklasravnsborg\LaravelPdf\Facades\Pdf as PDF;
use Spatie\Permission\Models\Permission;

/**
 * Class FamilyController
 * @package App\Http\Controllers\Admin
 */
class FamilyController extends Controller
{


    public function __construct()
    {
        Config::set('excel.import.heading', 'slugged');
    }

    public function index(Request $request)
    {
        //dd($request->all());
        //dd(Family::find(15939)->childs);
        //dd(Family::find(11855)->parent);
        $coulmn = $request["coulmn"] ?? "";
        $full_name = $request["full_name"] ?? "";
        $full_name_tr = $request["full_name_tr"] ?? "";
        $qualification_ids = $request["qualification_ids"] ? array_filter($request["qualification_ids"]) : [];
        $from_date_of_birth = $request["from_date_of_birth"] ?? "";
        $to_date_of_birth = $request["to_date_of_birth"] ?? "";
        $gender = $request["gender"] ?? "";
        $qualification_level_ids = $request["qualification_level_ids"] ? array_filter($request["qualification_level_ids"]) : [];
        $id_number = $request["id_number"] ?? "";
        $social_status_ids = $request["social_status_ids"] ? array_filter($request["social_status_ids"]) : [];
        $family_name_tr = $request["family_name_tr"] ?? "";
        $health_status = $request["health_status"] ?? "";
        $family_diseases = $request["family_diseases"] ? array_filter($request["family_diseases"]) : [];
        $work = $request["work"] ?? "";
        $code = $request["code"] ?? "";
        
        $from_recive_date = $request["from_recive_date"] ?? ""; // علاقة
        $to_recive_date = $request["to_recive_date"] ?? "";
        $from_total_income_value = $request["from_total_income_value"] ?? "";
        $to_total_income_value = $request["to_total_income_value"] ?? "";
        $job_type_ids = $request["job_type_ids"] ? array_filter($request["job_type_ids"]) : [];
        $governorate_id = $request["governorate_id"] ?? "";
        $city_id = $request["city_id"] ?? "";
        $neighborhood_ids = $request["neighborhood_ids"] ? array_filter($request["neighborhood_ids"]) : [];
        $house_roof_ids = $request["house_roof_ids"] ? array_filter($request["house_roof_ids"]) : [];
        $house_ownership_ids = $request["house_ownership_ids"] ? array_filter($request["house_ownership_ids"]) : [];
        $from_rent_value = $request["from_rent_value"] ?? "";
        $to_rent_value = $request["to_rent_value"] ?? "";
        $house_status_ids = $request["house_status_ids"] ? array_filter($request["house_status_ids"]) : [];
        $furniture_status_ids = $request["furniture_status_ids"] ? array_filter($request["furniture_status_ids"]) : [];
        $from_room_number = $request["from_room_number"] ?? "";
        $to_room_number = $request["to_room_number"] ?? "";
        $representative_id_number = $request["representative_id_number"] ?? "";
        $representative_full_name = $request["representative_full_name"] ?? "";
        $representative_job_type_ids = $request["representative_job_type_ids"] ? array_filter($request["representative_job_type_ids"]) : [];
        $representative_reason = $request["representative_reason"] ?? "";
        $family_type_ids = $request["family_type_ids"] ? array_filter($request["family_type_ids"]) : [];
        $family_project_ids = $request["family_project_ids"] ? array_filter($request["family_project_ids"]) : [];
        $funded_institution_ids = $request["funded_institution_ids"] ? array_filter($request["funded_institution_ids"]) : [];
        $is_evaluted = $request["is_evaluted"] ?? "";
        $need = $request["need"] ?? "";
        $family_classification_ids = $request["family_classification_ids"] ? array_filter($request["family_classification_ids"]) : [];
        $translation = $request["translation"] ?? "";
        $is_sent = $request["is_sent"] ?? "";
        $complete = $request["complete"] ?? "";
        $family_status_ids = $request["family_status_ids"] ? array_filter($request["family_status_ids"]) : [];
        $searchers = $request["searchers"] ? array_filter($request["searchers"]) : [];
        $visit_reason_ids = $request["visit_reason_ids"] ? array_filter($request["visit_reason_ids"]) : [];
        $from_visit_mission_date = $request["from_visit_mission_date"] ?? "";
        $to_visit_mission_date = $request["to_visit_mission_date"] ?? "";
        $from_visit_count = $request["from_visit_count"] ?? "";
        $to_visit_count = $request["to_visit_count"] ?? "";
        $from_members_count = $request["from_members_count"] ?? "";
        $to_members_count = $request["to_members_count"] ?? "";
        $from_members_date_of_birth = $request["from_members_date_of_birth"] ?? "";
        $to_members_date_of_birth = $request["to_members_date_of_birth"] ?? "";
        $members_relationship_ids = $request["members_relationship_ids"] ? array_filter($request["members_relationship_ids"]) : [];
        $members_qualification_level_ids = $request["members_qualification_level_ids"] ? array_filter($request["members_qualification_level_ids"]) : [];
        $members_health_status = $request["members_health_status"] ?? "";
        $members_social_status_ids = $request["members_social_status_ids"] ? array_filter($request["members_social_status_ids"]) : [];
        $members_disease = $request["members_disease"] ? array_filter($request["members_disease"]) : [];
        $members_full_name = $request["members_full_name"] ?? "";
        $representative_relationship_ids = $request["representative_relationship_ids"] ? array_filter($request["representative_relationship_ids"]) : [];
        $father_death_date = $request["father_death_date"] ?? "";
        $mother_death_date = $request["mother_death_date"] ?? "";
        $mother_death_reason = $request["mother_death_reason"] ?? "";
        $father_death_reason = $request["father_death_reason"] ?? "";
        $id_university = $request["id_university"] ?? "";
        $educational_institution_ids = $request["educational_institution_ids"] ? array_filter($request["educational_institution_ids"]) : [];
        $university_specialty_ids = $request["university_specialty_ids"] ? array_filter($request["university_specialty_ids"]) : [];
        $study_level_ids = $request["study_level_ids"] ? array_filter($request["study_level_ids"]) : [];
        $from_graduated_date = $request["from_graduated_date"] ?? "";
        $to_graduated_date = $request["to_graduated_date"] ?? "";
        $study_type_ids = $request["study_type_ids"] ? array_filter($request["study_type_ids"]) : [];
        $from_study_hour_price = $request["from_study_hour_price"] ?? "";
        $to_study_hour_price = $request["to_study_hour_price"] ?? "";

        // dd($request->all());

        if ($request["coulmn"] == "" && ($request->except('the_ids') == null || $request['page'])) {
            $coulmn = ['تحديد', 'الصورة', 'الاسم الكامل', 'الكود', 'الهوية', 'الاسم التركي', 'عدد الزيارات', 'تقييم الحالة', 'العمليات'];
        }

        $families = Family::with(['person', 'house_ownership', 'person.qualification', 'breadwinner', 'person.social_status', 'job_type', 'educational_institution', 'status', 'searcher', 'fundedInstitution', 'project', 'classification'])
            ->whereNull('parent_id')
            ->whereHas('person')
            ->when($full_name, function ($query) use ($full_name) {
                
                $parents_ids=array_unique(Family::whereHas('person'
                        , function ($q) use ($full_name) {
                            $q->where('full_name', 'like', '%' . $full_name . '%');
                        })->pluck('parent_id')->toArray());
                return $query->where(function ($q) use ($full_name,$parents_ids) {
                    $q->whereHas('person'
                        , function ($q) use ($full_name) {
                            $q->where('full_name', 'like', '%' . $full_name . '%');
                        })->orWhereIn('id',$parents_ids)
                        
                        /*->orWhereHas('childs'
                        , function ($q) use ($full_name) {
                            $q->whereHas('person'
                                , function ($q) use ($full_name) {
                                    $q->where('full_name', 'like', '%' . $full_name . '%');
                                });
                        })*/
                    ;
                });
            })->when($full_name_tr, function ($query) use ($full_name_tr) {
                 $parents_ids=array_unique(Family::whereHas('person'
                        , function ($q) use ($full_name_tr) {
                            $q->where('full_name_tr', 'like', '%' . $full_name_tr . '%');
                        })->pluck('parent_id')->toArray());
                return $query->where(function ($q) use ($full_name_tr,$parents_ids) {
                    $q->whereHas('person'
                        , function ($q) use ($full_name_tr) {
                            $q->where('full_name_tr', 'like', '%' . $full_name_tr . '%');
                        })->orWhereIn('id',$parents_ids)
                        /*->orWhereHas('childs'
                        , function ($q) use ($full_name_tr) {
                            $q->whereHas('person'
                                , function ($q) use ($full_name_tr) {
                                    $q->where('full_name_tr', 'like', '%' . $full_name_tr . '%');
                                });
                        })*/
                    ;
                });
            })->when($qualification_ids, function ($query) use ($qualification_ids) {
                return $query->whereHas('person'
                    , function ($q) use ($qualification_ids) {
                        $q->whereIn('qualification_id', $qualification_ids);
                    });
            })->when($from_date_of_birth && $to_date_of_birth, function ($query) use ($from_date_of_birth, $to_date_of_birth) {
                return $query->whereHas('person'
                    , function ($q) use ($from_date_of_birth, $to_date_of_birth) {
                        $q->where('date_of_birth', $from_date_of_birth, $to_date_of_birth);
                    });
            })->when($gender, function ($query) use ($gender) {
                return $query->whereHas('person'
                    , function ($q) use ($gender) {
                        $q->where('gender', $gender);
                    });
            })->when($qualification_level_ids, function ($query) use ($qualification_level_ids) {
                return $query->whereHas('person'
                    , function ($q) use ($qualification_level_ids) {
                        $q->whereIn('qualification_level_id', $qualification_level_ids);
                    });
            })->when($id_number, function ($query) use ($id_number) {
                $parents_ids=array_unique(Family::whereHas('person'
                        , function ($q) use ($id_number) {
                            $q->where('id_number', 'like', '%' . $id_number . '%');
                        })->pluck('parent_id')->toArray());
                return $query->where(function ($q) use ($id_number,$parents_ids) {
                    $q->whereHas('person'
                        , function ($q) use ($id_number) {
                            $q->where('id_number', 'like', '%' . $id_number . '%');
                        })->orWhereIn('id',$parents_ids)
                        /*->orWhereHas('childs'
                        , function ($q) use ($id_number) {
                            $q->whereHas('person'
                                , function ($q) use ($id_number) {
                                    $q->where('id_number', 'like', '%' . $id_number . '%');
                                });
                        })*/
                    ;
                });
            })->when($social_status_ids, function ($query) use ($social_status_ids) {
                return $query->whereHas('person'
                    , function ($q) use ($social_status_ids) {
                        $q->whereIn('social_status_id', $social_status_ids);
                    });
            })->when($family_name_tr, function ($query) use ($family_name_tr) {
                return $query->where(function ($q) use ($family_name_tr) {
                    $q->whereHas('person'
                        , function ($q) use ($family_name_tr) {
                            $q->where('family_name_tr', 'like', '%' . $family_name_tr . '%')
                                ->orWhere('family_name', 'like', '%' . $family_name_tr . '%');
                        })/*->orWhereHas('childs'
                        , function ($q) use ($family_name_tr) {
                            $q->whereHas('person'
                                , function ($q) use ($family_name_tr) {
                                    $q->where('family_name_tr', 'like', '%' . $family_name_tr . '%')
                                        ->orWhere('family_name', 'like', '%' . $family_name_tr . '%');
                                });
                        })*/
                    ;
                });
            })->when(($health_status || $health_status == '0'), function ($query) use ($health_status) {
                return $query->whereHas('person'
                    , function ($q) use ($health_status) {
                        $q->where('health_status', $health_status);
                    });
            })->when($family_diseases, function ($query) use ($family_diseases) {
                return $query->whereHas('person'
                    , function ($q) use ($family_diseases) {
                        $q->whereHas('diseases'
                            , function ($q) use ($family_diseases) {
                                $q->whereIn('disease_id', $family_diseases);
                            });
                    });
            })->when(($work || $work == '0'), function ($query) use ($work) {
                return $query->whereHas('person'
                    , function ($q) use ($work) {
                        $q->where('work', $work);
                    });
            })->when($code, function ($query) use ($code) {
                 $parents_ids=array_unique(Family::where('code', 'like', '%' . $code . '%')->pluck('parent_id')->toArray());
                return $query->where(function ($q) use ($code,$parents_ids) {
                    /*$q->whereHas('childs'
                        , function ($q) use ($code) {
                            $q->where('code', 'like', '%' . $code . '%');
                        })->orWhere('code', 'like', '%' . $code . '%');*/
                    $q->where('code', 'like', '%' . $code . '%')
                    ->orWhereIn('id', $parents_ids);
                });
            })->when($from_recive_date && $to_recive_date, function ($query) use ($from_recive_date, $to_recive_date) {
                return $query->whereHas('expense'
                    , function ($q) use ($from_recive_date, $to_recive_date) {
                        $q->whereBetween('recive_date', [$from_recive_date, $to_recive_date]);
                    });
            })->when($from_total_income_value && $to_total_income_value, function ($query) use ($from_total_income_value, $to_total_income_value) {
                return $query->whereBetween('total_income_value', [$from_total_income_value, $to_total_income_value]);
            })->when($job_type_ids, function ($query) use ($job_type_ids) {
                return $query->whereIn('job_type_id', $job_type_ids);
            })->when(($governorate_id) && !($city_id) && !($neighborhood_ids), function ($query) use ($governorate_id) {
                $cities_ids = City::where('governorate_id', $governorate_id)->pluck('id')->toArray();
                $neighborhood_ids = Neighborhood::whereIn('city_id', $cities_ids)->pluck('id')->toArray();
                return $query->whereIn('neighborhood_id', $neighborhood_ids);
            })->when(($city_id) && !($neighborhood_ids), function ($query) use ($city_id) {
                $neighborhood_ids = Neighborhood::where('city_id', $city_id)->pluck('id')->toArray();
                return $query->whereIn('neighborhood_id', $neighborhood_ids);
            })->when($neighborhood_ids, function ($query) use ($neighborhood_ids) {
                return $query->whereIn('neighborhood_id', $neighborhood_ids);
            })->when($house_roof_ids, function ($query) use ($house_roof_ids) {
                return $query->whereIn('house_roof_id', $house_roof_ids);
            })->when($house_ownership_ids, function ($query) use ($house_ownership_ids) {
                return $query->whereIn('house_ownership_id', $house_ownership_ids);
            })->when($from_rent_value && $to_rent_value, function ($query) use ($from_rent_value, $to_rent_value) {
                return $query->whereBetween('rent_value', [$from_rent_value, $to_rent_value]);
            })->when($house_status_ids, function ($query) use ($house_status_ids) {
                return $query->whereIn('house_status_id', $house_status_ids);
            })->when($furniture_status_ids, function ($query) use ($furniture_status_ids) {
                return $query->whereIn('furniture_status_id', $furniture_status_ids);
            })->when($from_room_number && $to_room_number, function ($query) use ($from_room_number, $to_room_number) {
                return $query->whereBetween('room_number', [$from_room_number, $to_room_number]);
            })->when($representative_id_number, function ($query) use ($representative_id_number) {
                return $query->whereHas('representative'
                    , function ($q) use ($representative_id_number) {
                        $q->where('id_number', 'like', '%' . $representative_id_number . '%');
                    });
            })->when($representative_full_name, function ($query) use ($representative_full_name) {
                return $query->whereHas('representative'
                    , function ($q) use ($representative_full_name) {
                        $q->where('full_name', 'like', '%' . $representative_full_name . '%');
                    });
            })->when($representative_job_type_ids, function ($query) use ($representative_job_type_ids) {
                return $query->whereIn('representative_job_type_id', $representative_job_type_ids);
            })->when($representative_reason, function ($query) use ($representative_reason) {
                return $query->where('representative_reason', 'like', '%' . $representative_reason . '%');
            })->when($family_type_ids, function ($query) use ($family_type_ids) {
                return $query->whereIn('family_type_id', $family_type_ids);
            })->when($family_project_ids, function ($query) use ($family_project_ids) {
                return $query->whereIn('family_project_id', $family_project_ids);
            })->when($funded_institution_ids, function ($query) use ($funded_institution_ids) {
                return $query->whereIn('funded_institution_id', $funded_institution_ids);
            })->when($is_evaluted, function ($query) use ($is_evaluted) {
                if ($is_evaluted == 1)
                    return $query->whereNotNull('need');
                elseif ($is_evaluted == 2)
                    return $query->whereNull('need');
            })->when(($need || $need == '0'), function ($query) use ($need) {
                return $query->where('need', $need);
            })->when($family_classification_ids, function ($query) use ($family_classification_ids) {
                return $query->whereIn('family_classification_id', $family_classification_ids);
            })->when($translation, function ($query) use ($translation) {
                if ($translation == 1)
                    return $query->whereHas('person'
                        , function ($q) {
                            $q->whereNotNull('need');
                        });
                elseif ($translation == 2)
                    return $query->whereHas('person'
                        , function ($q) {
                            $q->whereNull('need');
                        });
            })->when(($is_sent || $is_sent == '0'), function ($query) use ($is_sent) {
                return $query->where('is_sent', $is_sent);
            })->when($complete, function ($query) use ($complete) {
                if ($complete == 1) {
                    return $query->whereHas('person'
                        , function ($q) {
                            $q
                                ->whereNotNull('id_number')
                                ->whereNotNull('family_name_tr')
                                ->whereNotNull('first_name_tr')
                                ->whereNotNull('date_of_birth')
                                ->whereNotNull('date_of_birth_place')
                                ->whereNotNull('qualification_id')
                                ->whereNotNull('work')
                                ->whereNotNull('health_status');
                        })
                        ->whereNotNull('need')
                        ->whereNotNull('code')
                        ->whereNotNull('family_status_id')
                        ->whereNotNull('family_project_id')
                        ->whereNotNull('neighborhood_id')
                        ->whereNotNull('note_turkey')
                        ->whereNotNull('mobile_one')
                        ->whereNotNull('visit_date');
                } elseif ($complete == 2) {

                    return $query->whereHas('person'
                        , function ($q) {
                            $q->where(function ($qq) {
                                $qq->whereNull('need')
                                    ->whereNull('id_number')
                                    ->orWhereNull('family_name_tr')
                                    ->orWhereNull('first_name_tr')
                                    ->orWhereNull('date_of_birth')
                                    ->orWhereNull('date_of_birth_place')
                                    ->orWhereNull('qualification_id')
                                    ->orWhereNull('health');
                            })
                                ->orWhereNull('need')
                                ->orWhereNull('code')
                                ->orWhereNull('family_status_id')
                                ->orWhereNull('family_project_id')
                                ->orWhereNull('neighborhood_id')
                                ->orWhereNull('note_turkey')
                                ->orWhereNull('mobile_one')
                                ->orWhereNull('visit_date');
                        });
                }
            })->when($family_status_ids, function ($query) use ($family_status_ids) {
                return $query->whereIn('family_status_id', $family_status_ids);
            })->when($searchers, function ($query) use ($searchers) {
                return $query->whereHas('searcher'
                    , function ($q) use ($searchers) {
                        $q->whereIn('id', $searchers);
                    });
            })->when($visit_reason_ids, function ($query) use ($visit_reason_ids) {
                return $query->whereIn('visit_reason_id', $visit_reason_ids);
            })->when($from_visit_mission_date && $to_visit_mission_date, function ($query) use ($from_visit_mission_date, $to_visit_mission_date) {
                return $query->whereBetween('visit_mission_date', [$from_visit_mission_date, $to_visit_mission_date]);
            })->when($from_visit_count && $to_visit_count, function ($query) use ($from_visit_count, $to_visit_count) {
                return $query->whereBetween('visit_count', [$from_visit_count, $to_visit_count]);
            })->when($from_members_count && $to_members_count, function ($query) use ($from_members_count, $to_members_count) {
                return $query->has('members', '>=', $from_members_count)
                    ->has('members', '<=', $to_members_count);
            })->when($from_members_date_of_birth && $to_members_date_of_birth, function ($query) use ($from_members_date_of_birth, $to_members_date_of_birth) {
                return $query->whereHas('members'
                    , function ($q) use ($from_members_date_of_birth, $to_members_date_of_birth) {
                        $q->whereHas('person'
                            , function ($q) use ($from_members_date_of_birth, $to_members_date_of_birth) {
                                $q->whereBetween('date_of_birth', [$from_members_date_of_birth, $to_members_date_of_birth]);
                            });
                    });
            })->when($members_relationship_ids, function ($query) use ($members_relationship_ids) {
                return $query->whereHas('members'
                    , function ($q) use ($members_relationship_ids) {
                        $q->whereIn('relationship_id', $members_relationship_ids);

                    });
            })->when($members_qualification_level_ids, function ($query) use ($members_qualification_level_ids) {
                return $query->whereHas('members'
                    , function ($q) use ($members_qualification_level_ids) {
                        $q->whereHas('person'
                            , function ($q) use ($members_qualification_level_ids) {
                                $q->whereIn('qualification_level_id', $members_qualification_level_ids);
                            });

                    });
            })->when($members_health_status || $members_health_status === '0', function ($query) use ($members_health_status) {
                return $query->whereHas('members'
                    , function ($q) use ($members_health_status) {
                        $q->whereHas('person'
                            , function ($q) use ($members_health_status) {
                                $q->whereIn('health_status', $members_health_status);
                            });

                    });
            })->when($members_social_status_ids, function ($query) use ($members_social_status_ids) {
                return $query->whereHas('members'
                    , function ($q) use ($members_social_status_ids) {
                        $q->whereHas('person'
                            , function ($q) use ($members_social_status_ids) {
                                $q->whereIn('social_status_id', $members_social_status_ids);
                            });

                    });
            })->when($members_disease, function ($query) use ($members_disease) {
                return $query->whereHas('members'
                    , function ($q) use ($members_disease) {
                        $q->whereHas('person'
                            , function ($q) use ($members_disease) {
                                $q->whereHas('diseases'
                                    , function ($q) use ($members_disease) {
                                        $q->whereIn('disease_id', $members_disease);
                                    });
                            });
                    });
            })->when($members_full_name, function ($query) use ($members_full_name) {
                return $query->whereHas('representative'
                    , function ($q) use ($members_full_name) {
                        $q->whereHas('members'
                            , function ($q) use ($members_full_name) {
                                $q->where('full_name', 'like', '%' . $members_full_name . '%');
                            });

                    });
            })->when($representative_relationship_ids, function ($query) use ($representative_relationship_ids) {
                return $query->whereIn('representative_relationship_id', $representative_relationship_ids);
            })->when($mother_death_date, function ($query) use ($mother_death_date) {
                return $query->where('mother_death_date', $mother_death_date)
                    ->orWhere('mother_death_date_old', date('d/m/Y', strtotime($mother_death_date)));
            })->when($father_death_date, function ($query) use ($father_death_date) {
                return $query->where('father_death_date', $father_death_date)
                    ->orWhere('father_death_date_old', date('d/m/Y', strtotime($father_death_date)));
            })->when($father_death_reason, function ($query) use ($father_death_reason) {
                return $query->where('father_death_reason', 'like', '%' . $father_death_reason . '%')/*->orWhereHas('childs'
                        , function ($q) use ($father_death_reason) {
                            $q->where('father_death_reason', 'like', '%' . $father_death_reason . '%');
                        })*/
                    ;
            })->when($mother_death_reason, function ($query) use ($mother_death_reason) {
                return $query->where('mother_death_reason', 'like', '%' . $mother_death_reason . '%')/*->orWhereHas('childs'
                        , function ($q) use ($mother_death_reason) {
                            $q->where('mother_death_reason', 'like', '%' . $mother_death_reason . '%');
                        })*/
                    ;
            })->when($id_university, function ($query) use ($id_university) {
                return $query->where('id_university', 'like', '%' . $id_university . '%')/*->orWhereHas('childs'
                        , function ($q) use ($id_university) {
                            $q->where('id_university', 'like', '%' . $id_university . '%');
                        })*/
                    ;
            })->when($educational_institution_ids, function ($query) use ($educational_institution_ids) {
                return $query->whereIn('educational_institution_id', $educational_institution_ids);
            })->when($university_specialty_ids, function ($query) use ($university_specialty_ids) {
                return $query->whereIn('university_specialty_id', $university_specialty_ids);
            })->when($study_level_ids, function ($query) use ($study_level_ids) {
                return $query->whereIn('study_level_id', $study_level_ids);
            })->when($from_graduated_date && $to_graduated_date, function ($query) use ($from_graduated_date, $to_graduated_date) {
                return $query->whereBetween('graduated_date', [$from_graduated_date, $to_graduated_date]);
            })->when($study_type_ids, function ($query) use ($study_type_ids) {
                return $query->whereIn('study_type_id', $study_type_ids);
            })->when($from_study_hour_price && $to_study_hour_price, function ($query) use ($from_study_hour_price, $to_study_hour_price) {
                return $query->whereBetween('study_hour_price', [$from_study_hour_price, $to_study_hour_price]);
            })->whereNull('families.parent_id')
            ->orderBy('families.id', 'Desc')
            ->paginate(20)
            ->appends([
                "coulmn" => $coulmn, "family_name_tr" => $family_name_tr,
                "to_study_hour_price" => $to_study_hour_price, "from_study_hour_price" => $from_study_hour_price,
                "to_graduated_date" => $to_graduated_date, "from_graduated_date" => $from_graduated_date, "study_type_ids" => $study_type_ids,
                "mother_death_date" => $mother_death_date, "father_death_date" => $father_death_date, "mother_death_reason" => $mother_death_reason,
                "members_full_name" => $members_full_name, "father_death_reason" => $father_death_reason, "educational_institution_ids" => $educational_institution_ids,
                "members_social_status_ids" => $members_social_status_ids, "members_disease" => $members_disease, "university_specialty_ids" => $university_specialty_ids,
                "members_qualification_level_ids" => $members_qualification_level_ids, "members_health_status" => $members_health_status,
                "to_members_count" => $to_members_count, "from_members_date_of_birth" => $from_members_date_of_birth, "to_members_date_of_birth" => $to_members_date_of_birth,
                "to_visit_count" => $to_visit_count, "from_visit_count" => $from_visit_count, "from_members_count" => $from_members_count,
                'searchers' => $searchers, 'visit_reason_ids' => $visit_reason_ids, "from_visit_mission_date" => $from_visit_mission_date, "to_visit_mission_date" => $to_visit_mission_date,
                'translation' => $translation, 'is_sent' => $is_sent, "complete" => $complete, 'family_status_ids' => $family_status_ids,
                'is_evaluted' => $is_evaluted, 'need' => $need, 'family_classification_ids' => $family_classification_ids,
                'family_type_ids' => $family_type_ids, 'funded_institution_ids' => $funded_institution_ids, "members_relationship_ids" => $members_relationship_ids,
                "social_status_ids" => $social_status_ids, "job_type_ids" => $job_type_ids, 'family_project_ids' => $family_project_ids,
                "full_name" => $full_name, "full_name_tr" => $full_name_tr, "gender" => $gender, "from_date_of_birth" => $from_date_of_birth, "to_date_of_birth" => $to_date_of_birth,
                "representative_relationship_ids" => $representative_relationship_ids, "qualification_ids" => $qualification_ids,
                "qualification_level_ids" => $qualification_level_ids, "id_number" => $id_number, "id_university" => $id_university,
                "health_status" => $health_status, "work" => $work, "code" => $code, "from_recive_date" => $from_recive_date,
                "to_recive_date" => $to_recive_date, "from_total_income_value" => $from_total_income_value, "to_total_income_value" => $to_total_income_value,
                "family_diseases" => $family_diseases, "governorate_id" => $governorate_id, "city_id" => $city_id, "neighborhood_ids" => $neighborhood_ids,
                "house_roof_ids" => $house_roof_ids, "house_ownership_ids" => $house_ownership_ids, "from_rent_value" => $from_rent_value,
                "to_rent_value" => $to_rent_value, "house_status_ids" => $house_status_ids, "furniture_status_ids" => $furniture_status_ids,
                'to_room_number' => $to_room_number, "from_room_number" => $from_room_number, "study_level_ids" => $study_level_ids,
                "representative_id_number" => $representative_id_number, "representative_full_name" => $representative_full_name,
                "representative_job_type_ids" => $representative_job_type_ids, "representative_reason" => $representative_reason]);


        return view('admin.family.list', compact("families",
            "father_death_date", "father_death_reason", "mother_death_reason", "study_type_ids", "to_study_hour_price", "from_study_hour_price",
            "family_name_tr", "members_social_status_ids", "members_disease", "members_full_name", "representative_relationship_ids", "university_specialty_ids",
            "from_members_date_of_birth", "to_members_date_of_birth", "members_relationship_ids", "members_qualification_level_ids",
            "searchers", "visit_reason_ids", "from_visit_mission_date", "to_visit_mission_date", "to_members_count", "mother_death_date",
            "social_status_ids", "job_type_ids", "family_status_ids", "to_visit_count", "from_visit_count", "from_members_count",
            "full_name", "full_name_tr", "gender", "from_date_of_birth", "to_date_of_birth", "qualification_ids", "id_university",
            "qualification_level_ids", "id_number", "family_diseases", "health_status", "work", "code", "from_recive_date", "to_recive_date",
            "from_total_income_value", "to_total_income_value", "governorate_id", "city_id", "neighborhood_ids", "educational_institution_ids",
            "house_roof_ids", "house_ownership_ids", "from_rent_value", "to_rent_value", "house_status_ids", "furniture_status_ids", 'to_room_number', "from_room_number"
            , "representative_id_number", "representative_full_name", "representative_job_type_ids", "representative_reason"
            , 'family_type_ids', 'family_project_ids', 'funded_institution_ids', 'is_evaluted', 'need', 'family_classification_ids',
            "coulmn", 'translation', 'is_sent', "complete", "members_health_status", "study_level_ids", "to_graduated_date", "from_graduated_date"
        ));

    }

    public function getFamilies(Request $request)
    {


        $families = Family::with(['person', 'house_ownership', 'person.qualification', 'breadwinner', 'person.social_status', 'job_type', 'educational_institution', 'status', 'searcher', 'fundedInstitution', 'project', 'classification'])
            ->where(['parent_id' => null])
            ->where(['hidden' => 1])
            //->whereIn('year', ['2019', '2020'])
            ->whereHas('person')
            ->get()->sortByDesc('person.full_name_tr');


        return DataTables::of($families)
            ->addColumn('id', function ($value) {
                return $value->id;
            })->addColumn('name', function ($value) {

                $person = $value->person;
                return !is_null($person->full_name) ? $person->full_name : '-';
            })->editColumn('image', function ($value) {
                $path = '../../assets/images/users/2.jpg';

                $images = isset($value->media) ? $value->media : null;
                if (!is_null($images)) {
                    foreach ($images as $image) {
                        if ($image->file_type_id == 2) {
                            $path = asset('uploads/attachments/' . $image->path);
                        }
                    }
                }

                return "<image width='50px' height='50px' src='$path'/>";

            })->addColumn('code', function ($value) {
                return !is_null($value->code) ? $value->code : '-';
            })->addColumn('id_number', function ($value) {
                $person = $value->person;
                return !is_null($person->id_number) ? $person->id_number : '-';
            })->addColumn('family_type', function ($value) {
                return isset($value->type) ? $value->type->name : '-';
            })->addColumn('house', function ($value) {
                return isset($value->house_ownership) ? $value->house_ownership->name : '-';
            })->addColumn('member_count', function ($value) {
                $members = isset($value->members) ? $value->members : null;
                return !is_null($members) ? count($members) : 0;
            })->addColumn('qualification', function ($value) {
                $person = $value->person;
                return isset($person->qualification) ? $person->qualification->name : '-';
            })->addColumn('work', function ($value) {
                $person = $value->person;
                return !is_null($person) ? $person->work == 0 ? 'لا يعمل ' : 'يعمل' : '-';
            })->addColumn('social_status', function ($value) {
                $person = $value->person;
                return isset($person->social_status) ? $person->social_status->name : '-';
            })->addColumn('health_status', function ($value) {
                $person = $value->person;
                return !is_null($person) ? $person->health_status == 0 ? 'سليم' : 'مريض' : '-';
            })->addColumn('breadwinner', function ($value) {
                return isset($value->breadwinner) ? $value->breadwinner->name : '-';
            })->addColumn('income_value', function ($value) {
                return !is_null($value->income_value) ? $value->income_value : '-';
            })->addColumn('job_type', function ($value) {
                return isset($value->job_type) ? $value->job_type->name : '-';
            })->addColumn('need', function ($value) {
                return !is_null($value->need) ? $value->need == 0 ? 'يحتاج' : 'لا يحتاج' : '-';
            })->addColumn('hour_price', function ($value) {
                return !is_null($value->study_hour_price) ? $value->study_hour_price : '-';
            })->addColumn('educational_institution', function ($value) {
                return isset($value->educational_institution) ? $value->educational_institution->name : '-';
            })->addColumn('visit_reason', function ($value) {
                return isset($value->visit_reason) ? $value->visit_reason->name : '-';
            })->addColumn('status', function ($value) {
                return isset($value->status) ? $value->status->name : '-';
            })->addColumn('visit_count', function ($value) {
                $count = null;
                if ($value->visit_count == 1) {
                    $count = 1;
                } else if ($value->visit_count > 1) {
                    $count = $value->visit_count - 1;
                } else {
                    $count = $value->visit_count;
                }
                return $count;
            })->addColumn('searcher', function ($value) {

                $arrayData = [];
                if ((isset($value->searcher)) && (!is_null($value->searcher))) {
                    foreach ($value->searcher as $item) {
                        if ((isset($item->searcher)) && (!is_null($item->searcher))) {
                            array_push($arrayData, $item->searcher->full_name);
                        }
                    }
                }
                return implode(" | ", $arrayData);

            })->addColumn('translation', function ($value) {
                $person = $value->person;
                return !is_null($person->full_name_tr) ? 'مترجمة' : 'غير مترجمة';
            })->addColumn('funded_institution', function ($value) {
                return isset($value->fundedInstitution) ? $value->fundedInstitution->name : '-';
            })->addColumn('project', function ($value) {
                return isset($value->project) ? $value->project->name : '-';
            })->addColumn('classification', function ($value) {
                return isset($value->classification) ? $value->classification->name : '-';
            })->addColumn('visit_year', function ($value) {
                $split = null;
                $year = null;
                if (!is_null($value->visit_date)) {
                    $date = str_replace('.', '/', $value->visit_date);
                    $split = explode('/', $date);
                    $year = $split[0];
                }
                return $year;
            })->addColumn('visit_month', function ($value) {
                $split = null;
                $month = null;
                if (!is_null($value->visit_date)) {
                    $date = str_replace('.', '/', $value->visit_date);
                    $split = explode('/', $date);
                    if (count($split) > 1) {
                        $month = $split[1];
                    }
                }
                return $month;
            })->addColumn('visit_day', function ($value) {
                $split = null;
                $day = null;
                if (!is_null($value->visit_date)) {
                    $date = str_replace('.', '/', $value->visit_date);
                    $split = explode('/', $date);
                    if (count($split) > 1) {
                        $split2 = explode(' ', $split[2]);
                        $day = $split2[0];
                    }
                }
                return $day;
            })->addColumn('visit_date', function ($value) {
                return !is_null($value->visit_date) ? str_replace('.', '/', $value->visit_date) : '-';
            })->addColumn('sent', function ($value) {
                return $value->is_sent == 1 ? 'تم الإرسال' : 'ليست قيد الإرسال';
            })->addColumn('complete', function ($value) {
                if ((!is_null($value->note)) &&
                    ((isset($value->visit_reason)) && (!is_null($value->visit_reason))) &&
                    ((isset($value->searcher)) && (!is_null($value->searcher))) &&
                    (!is_null($value->need)) &&
                    ((isset($value->type)) && (!is_null($value->type))) &&
                    ((isset($value->project)) && (!is_null($value->project))) &&
                    ((isset($value->status)) && (!is_null($value->status))) &&
                    ((isset($value->city)) && (!is_null($value->city))) &&
                    ((isset($value->neighborhood)) && (!is_null($value->neighborhood))) &&
                    ((isset($value->person)) && (!is_null($value->person)) && (!is_null($value->person->id_number))) &&
                    (!is_null($value->address)) &&
                    (!is_null($value->total_income_value)) &&
                    (!is_null($value->code)) &&
                    ((isset($value->person)) && (!is_null($value->person)) && (!is_null($value->person->family_name_tr)))
                    (!is_null($value->note)) &&
                    (!is_null($value->note_turkey)) &&
                    (!is_null($value->mobile_one)) &&
                    (!is_null($value->mobile_two)) &&
                    (!is_null($value->telephone)) &&
                    (!is_null($value->id_university)) &&
                    ((isset($value->job_type)) && (!is_null($value->job_type))) &&
                    ((!is_null($value->visit_date))) &&
                    ((isset($value->person)) && (!is_null($value->person)) && (!is_null($value->person->age))) &&
                    ((isset($value->person)) && (!is_null($value->person)) && (!is_null($value->person->health))) &&
                    ((isset($value->person)) && (!is_null($value->person)) && (isset($value->person->qualification)) && (!is_null($value->person->qualification)))
                    ((isset($value->members)) && (count($value->members) > 0))
                ) {
                    return 'غير منقوصة';

                }
                return 'منقوصة';
            })->addColumn('note_turkey', function ($value) {
                return !is_null($value->note_turkey) ? 'تم التقييم' : 'لم يتم التقييم';
            })
            ->addColumn('disease', function ($value) {
                $arrayData = [];
                if ((isset($value->familyMemberDiseases)) && (!is_null($value->familyMemberDiseases))) {
                    foreach ($value->familyMemberDiseases as $item) {
                        if ((isset($item->disease)) && (!is_null($item->disease))) {
                            array_push($arrayData, $item->disease->name);
                        }
                    }
                }
                return implode(" | ", $arrayData);
//
            })->editColumn('actions', function ($value) {
                $exportType = $value->family_project_id == 2 ? 'ytm' : 'visit';

                $archiveUrl = url('admin/families/archive/' . $value->id);
                $addMemberUrl = url('admin/families/addMember/' . $value->id);
                $updateUrl = url('admin/families/' . $value->id . '/edit');
                $mediaUrl = url('admin/families/' . $value->id . '/addMedia');
                $exportTurkeyUrl = url('admin/families/export/word/' . $exportType . '/' . $value->id);
                $exportExcelUrl = url('admin/families/export/excel/' . $exportType . '/' . $value->id);
                $exportPDFUrl = url('admin/families/export/pdf/' . $exportType . '/' . $value->id);
                $deleteUrl = url('admin/families/delete/' . $value->id);


                return "<div class='dropdown dropdown-inline'>
                                            <button type='button'
                                                    class='btn btn-success btn-hover-success btn-elevate-hover btn-icon btn-sm btn-icon-md btn-circle'
                                                    data-toggle='dropdown' aria-haspopup='true'
                                                    aria-expanded='false'>
                                                <i class='la la-cog'></i>
                                            </button>
                                            <div class='dropdown-menu dropdown-menu-right'>
                                                <a class='dropdown-item Confirm' href='" . $deleteUrl . "'><i
                                                            class='fa fa-trash'></i>
                                                    حذف
                                                </a>
                                                <a class='dropdown-item' href='" . $archiveUrl . "'><i
                                                    class='fa fa-edit'></i>الأرشيف</a>
                                                <a class='dropdown-item' href='" . $addMemberUrl . "'>
                                                    <i class='fa fa-shopping-bag'></i>
                                                    إضافة أفراد</a>
                                                <a class='dropdown-item ' href='" . $exportTurkeyUrl . "'>
                                                    <i class='fa fa-pen'></i>
                                                    تصدير الاستمارة التركية</a>
                                                    <a class='dropdown-item' href='" . $exportExcelUrl . "'><i
                                                    class='fa fa-pen'></i>تصدير اكسل</a>
                                                    <a class='dropdown-item' href='" . $exportPDFUrl . "'><i
                                                    class='fa fa-pen'></i>تصدير PDF</a>
                                                    <a class='dropdown-item' href='" . $mediaUrl . "'><i
                                                    class='fa fa-shopping-bag'></i>المرفقات</a>
                                                    <a class='dropdown-item' href='" . $updateUrl . "'><i
                                                    class='fa fa-edit'></i>تحديث</a>
                                                    <a class='dropdown-item' href='" . url('admin/season_coupons?families_yes[]=' . $value->id) . "'><i
                                                    class='fa fa-edit'></i>المساعدات الموسمية</a>
                                                    <a class='dropdown-item' href='" . url('admin/urgent_coupons?families_yes[]=' . $value->id) . "'><i
                                                    class='fa fa-edit'></i>المساعدات الطارئة</a>
                                                    <a class='dropdown-item' href='" . url('admin/expenseDetails?families_yes[]=' . $value->id) . "'><i
                                                    class='fa fa-edit'></i>الصرفيات</a>
                                                    <a class='dropdown-item' href='" . url('admin/sponsors?family_id=' . $value->id) . "'><i
                                                    class='fa fa-edit'></i>الكفلاء</a>
                                                    <a class='dropdown-item' href='" . url('admin/calls?family_ids[]=' . $value->id) . "'><i
                                                    class='fa fa-edit'></i>الاتصالات</a>
                                            </div>
                                        </div>
                                   ";
            })->rawColumns(['actions', 'image'])->make(true);
    }

    public function create()
    {
        $projects = FamilyProject::all();
        $idTypes = IDType::all();
        $relationships = Relationship::where('status', 1)->get();
        $qualifications = Qualification::all();
        $socialStatuses = SocialStatus::all();
        $cities = City::all();
        $governorates = Governorate::all();
        $houseOwners = HouseOwnership::all();
        $houseRoofs = HouseRoof::all();
        $houseStatuses = HouseStatus::all();
        $types = FamilyType::all();
        $studyLevels = StudyLevel::all();
        $studyParts = StudyPart::all();
        $studyTypes = StudyType::all();
        $fundedInstitutions = FundedInstitution::where('status', 1)->get();
        $statuses = FamilyStatus::all();
        $visitReasons = VisitReason::all();
        $users = User::all();
        $diseases = Disease::all();
        $universitySpecialties = UniversitySpecialty::where('status', 1)->get();
        $educationalInstitutions = EducationalInstitution::where('status', 1)->get();
        $countries = Country::all();
        $incomeTypes = IncomeType::all();
        $jobTypes = JobType::all();
        $qualificationLevels = QualificationLevels::all();
        $neighborhoods = Neighborhood::all();

        return view('admin.family.create', compact('qualificationLevels', 'neighborhoods', 'governorates', 'projects', 'jobTypes', 'incomeTypes', 'countries', 'educationalInstitutions', 'universitySpecialties', 'diseases', 'idTypes', 'relationships', 'jobTypes', 'qualifications', 'socialStatuses', 'cities', 'houseOwners', 'houseRoofs', 'houseStatuses', 'types', 'studyLevels', 'studyParts', 'studyTypes', 'fundedInstitutions', 'statuses', 'visitReasons', 'users'));
    }

    public function store(FamilyRequest $request)
    {
        // person data
        $personData = [
            'first_name' => $request['first_name'],
            'second_name' => $request['second_name'],
            'third_name' => $request['third_name'],
            'family_name' => $request['family_name'],
            'first_name_tr' => $request['first_name_tr'],
            'second_name_tr' => $request['second_name_tr'],
            'third_name_tr' => $request['third_name_tr'],
            'family_name_tr' => $request['family_name_tr'],
            'id_type_id' => $request['id_type_id'],
            'id_number' => $request['id_number'],
            'social_status_id' => $request['social_status_id'],
            'health_status' => $request['health_status'],
            'qualification_id' => $request['qualification_id'],
            'qualification_level_id' => $request['qualification_level_id'],
            'work' => $request['work'],
            'gender' => $request['gender'],
            'date_of_birth' => $request['date_of_birth'],
            'date_of_birth_place' => $request['date_of_birth_place'],

        ];

        $this->checkTranslation($request['first_name'], $request['first_name_tr'], $request['second_name'], $request['second_name_tr'], $request['third_name'], $request['third_name_tr'], $request['family_name'], $request['family_name_tr']);

        if (($request['first_name_tr'] != null) && ($request['second_name_tr'] != null) && ($request['third_name_tr'] != null) && ($request['family_name_tr'] != null)) {
            $personData['full_name_tr'] = $request['first_name_tr'] . ' ' . $request['second_name_tr'] . ' ' . $request['third_name_tr'] . ' ' . $request['family_name_tr'];
        }

        /********************************************************/
        $personData['full_name'] = $request['first_name'] . ' ' . $request['second_name'] . ' ' . $request['third_name'] . ' ' . $request['family_name'];

        $full_name = $personData['full_name_tr']; //الاسم التركي
        $id_number = $personData['id_number']; // رقم الهوية
//
        $falmils_by_name = Family::whereNull('parent_id')->whereHas('person'
            , function ($query) use ($full_name) {
                $query->where('full_name_tr', $full_name);
            })->with('person');
        $falmils_by_id_number = Family::whereNull('parent_id')->whereHas('person'
            , function ($query) use ($id_number) {
                $query->where('id_number', $id_number);
            })->with('person');
        $vists_by_name = array_unique(array_filter(Family::whereNotNull('parent_id')->whereHas('person'
            , function ($query) use ($full_name) {
                $query->where('full_name_tr', $full_name);
            })->pluck('parent_id')->toArray()));
        $vists_by_id_number = array_unique(array_filter(Family::whereNotNull('parent_id')->whereHas('person'
            , function ($query) use ($id_number) {
                $query->where('id_number', $id_number);
            })->pluck('parent_id')->toArray()));

        if (/*(count($vists_by_name) > 1 || count($vists_by_id_number) > 1) ||
            (count($vists_by_name) > 1 && count($vists_by_id_number) == 0) ||
            (count($vists_by_name) == 0 && count($vists_by_id_number) > 1) ||*/
            ($falmils_by_name->count() > 1 || $falmils_by_id_number->count() > 1) ||
            ($falmils_by_name->count() > 1 && !($falmils_by_id_number->first())) ||
            (!($falmils_by_name->first()) && $falmils_by_id_number->count() > 1)) {

            return back()->with('error', " لم تتم الإضافة،يوجد شخص بهذا الاسم أو رقم الهوية ومكرر أيضاً")->withInput(request()->all);

        } else {
            if ($falmils_by_name->count() == 1 || count($vists_by_name) == 1
                || $falmils_by_id_number->count() == 1 || count($vists_by_id_number) == 1) {

                return back()->with('error', "لم تتم الإضافة،يوجد شخص بهذا الاسم أو رقم الهوية")->withInput(request()->all);
            }
        }

        /********************************************************/
        // add new person
        $person = Person::create($personData);

        if ($person) {

            // family data
            $familyData = [
                'person_id' => $person->id,
                'family_project_id' => $request['family_project_id'],
                'mobile_one' => $request['mobile_one'],
                'mobile_two' => $request['mobile_two'],
                'telephone' => $request['telephone'],
                'country_id' => $request['country_id'],
                'address' => $request['address'],
                'house_ownership_id' => $request['house_ownership_id'],
                'house_roof_id' => $request['house_roof_id'],
                'house_status_id' => $request['house_status_id'],
                'need' => $request['need'],
                'family_status_id' => $request['family_status_id'],
                'city_id' => $request['city_id'],
                'neighborhood_id' => $request['neighborhood_id'],
                'note' => $request['note'],
                'note_turkey' => $request['note_turkey'],
                'income_value' => $request['income_value'],
                'visit_reason_id' => 2,
                'data_entry_id' => Auth::user()->id,
                'family_type_id' => $request['family_type_id'],
                'searcher_note' => $request['searcher_note'],
                'step' => $request['checkStep'],
                'parent_id' => null,
                'visit_count' => 1,
                'year' => Carbon::now()->year,
                'family_classification_id' => $request['need'] == 0 ? 5 : 1,// new
                'ignore_date' => ($request['need'] == 0) ? Carbon::now()->toDateString() : null,
                'ignore_reason' => ($request['need'] == 0) ? $request['searcher_note'] : "",
                'representative_id' => $request['representative_id'],
                'immovable_id' => $request['immovable_id'],
                'home_space' => $request['home_space'],
                'number_school_students' => $request['number_school_students'],
                'number_university_students' => $request['number_university_students'],
                'supplies_card' => $request['supplies_card'],
                'city_id' => $request['city_id'],
                'country_id' => $request['country_id'],
                'neighborhood_id' => $request['neighborhood_id'],
            ];

            // if other breadwinner
            if (($request['breadwinner_id'] == 1) && (!is_null($request['breadwinner_other']))) {

                $data = [
                    'name' => $request['breadwinner_other'],
                    'name_tr' => '',
                    'status' => 0,
                ];

                $relationship = Relationship::create($data);

                $familyData['breadwinner_id'] = $relationship->id;

            } else {
                $familyData['breadwinner_id'] = $request['breadwinner_id'];
            }


            // if other relation
            if (($request['representative_relationship_id'] == 1) && (!is_null($request['representative_relationship_other']))) {

                $data = [
                    'name' => $request['representative_relationship_other'],
                    'name_tr' => '',
                    'status' => 0,
                ];

                $relationship = Relationship::create($data);

                $familyData['representative_relationship_id'] = $relationship->id;

            } else {
                $familyData['representative_relationship_id'] = $request['representative_relationship_id'];
            }

            // if work
            if ($request['work'] == 1) {
                $familyData['job_type_id'] = $request['job_type_id'];
                $familyData['income_value'] = $request['income_value'];
            } else {
                $familyData['job_type_id'] = null;
                $familyData['income_value'] = null;
            }

            // if rent house
            if ($request['house_ownership_id'] == 2) {
                $familyData['rent_value'] = $request['rent_value'];
            } else {
                $familyData['rent_value'] = null;
            }

            // if un
            if ($request['family_type_id'] == 7) {
                $familyData['id_university'] = $request['id_university'];
                $familyData['study_type_id'] = $request['study_type_id'];
                $familyData['study_part_id'] = $request['study_part_id'];
                $familyData['study_level_id'] = $request['study_level_id'];
                $familyData['graduated_date'] = $request['graduated_date'];
                $familyData['study_hour_price'] = $request['study_hour_price'];
            } else {
                $familyData['id_university'] = null;
                $familyData['study_type_id'] = null;
                $familyData['study_part_id'] = null;
                $familyData['study_level_id'] = null;
                $familyData['graduated_date'] = null;
                $familyData['study_hour_price'] = null;
            }

            // other un
            if (($request['family_type_id'] == 7) && ($request['educational_institution_id'] == 1)) {
                $data = [
                    'name' => $request['educational_institution_other'],
                    'status' => 0,
                ];

                $educationalInstitution = EducationalInstitution::create($data);
                $familyData['educational_institution_id'] = $educationalInstitution->id;
            } else {
                $familyData['educational_institution_id'] = $request['educational_institution_id'];
            }

            // other un
            if (($request['family_type_id'] == 7) && ($request['university_specialty_id'] == 1)) {
                $data = [
                    'name' => $request['university_specialty_other'],
                    'status' => 0,
                ];
                $universitySpecialty = UniversitySpecialty::create($data);
                $familyData['university_specialty_id'] = $universitySpecialty->id;
            } else {
                $familyData['university_specialty_id'] = $request['university_specialty_id'];
            }

            // if YTM
            if ($request['family_type_id'] == 5) {
                $familyData['father_death_reason'] = $request['father_death_reason'];
                $familyData['father_death_date'] = $request['father_death_date'];
                $familyData['mother_death_reason'] = $request['mother_death_reason'];
                $familyData['mother_death_date'] = $request['mother_death_date'];
            } else {
                $familyData['father_death_reason'] = null;
                $familyData['father_death_date'] = null;
                $familyData['mother_death_reason'] = null;
                $familyData['mother_death_date'] = null;
            }

            if ($request['funded_institution_id'] == 1) {
                $data = [
                    'name' => $request['funded_institution_other'],
                    'code' => null,
                    'logo' => null,
                    'status' => 0
                ];

                $fundedInstitution = FundedInstitution::create($data);
                $familyData['funded_institution_id'] = $fundedInstitution->id;
            } else {
                $familyData['funded_institution_id'] = $request['funded_institution_id'];
            }

            // add new family
            $family = Family::create($familyData);

            if ($family) {

                if (
                    (!is_null($request['representative_relationship_id'])) || (!is_null($request['representative_id_number'])) ||
                    (!is_null($request['representative_first_name'])) || (!is_null($request['representative_second_name'])) ||
                    (!is_null($request['representative_third_name'])) || (!is_null($request['representative_family_name'])) ||
                    (!is_null($request['representative_full_name'])) || (!is_null($request['representative_job_type_id']))
                ) {

                    $representativePersonData = [
                        'id_number' => $request['representative_id_number'],
                        'first_name' => $request['representative_first_name'],
                        'second_name' => $request['representative_second_name'],
                        'third_name' => $request['representative_third_name'],
                        'family_name' => $request['representative_family_name'],
                        'full_name' => $request['representative_first_name'] . " " . $request['representative_second_name'] . " "
                            . $request['representative_third_name'] . " "
                            . $request['representative_family_name'],

                    ];

                    $representativePerson = Person::create($representativePersonData);

                    $representativeData = [
                        'representative_id' => $representativePerson->id,
                        'representative_relationship_id' => $request['representative_relationship_id'],
                        'representative_job_type_id' => $request['representative_job_type_id'],
                    ];

                    $family->update($representativeData);

                }

                // income type
//                $incomeTypeArray = [];
//                for ($i = 0; $i < count($request['income_type_id']); $i++) {
//                    if ((!is_null($request['income_type_id'][$i])) && (!is_null($request['income_type_value'][$i])) && (!is_null($request['income_note'][$i]))) {
//                        $incomeTypeArray[$i]['income_type_id'] = $request['income_type_id'][$i];
//                        $incomeTypeArray[$i]['value'] = $request['income_type_value'][$i];
//                        $incomeTypeArray[$i]['note'] = $request['income_note'][$i];
//                    }
//                }
//
//                if (count($incomeTypeArray) > 0) {
//                    foreach ($incomeTypeArray as $item) {
//                        $itemData = [
//                            'income_type_id' => $item['income_type_id'],
//                            'value' => $item['value'],
//                            'note' => $item['note'],
//                            'family_id' => $family->id,
//                        ];
//                        FamilyIncome::create($itemData);
//                    }
//                }

                // if diseases
                if ($person->health_status == 1) {
                    if (!is_null($request['family_diseases'])) {
                        foreach ($request['family_diseases'] as $disease) {
                            FamilyMemberDiseases::create([
                                'person_id' => $person->id,
                                'disease_id' => $disease,
                                'family_id' => $family->id,
                            ]);
                        }
                    }
                }


                $message = ' تم حفظ استمارة بنجاح';


                event(new NewLogCreated($message, $request['first_name'], 67, 0, 0, 'admin/families/' . $family->id . '/edit'));

                $action = Action::create(['title' => $message, 'type' => 'إدارة الترجمات', 'link' => '/admin/families/' . $family->id . '/edit']);
                $users = User::permission('edit families')->get();
                if ($users->first())
                    Notification::send($users, new NotifyUsers($action));

                $come_by = $request['come_by'] ?? "";

                if ($come_by == "season_coupon")
                    return redirect('admin/families/' . $family->id . '/edit?come_by=season_coupon')->with('success', $message);
                elseif ($come_by == "urgent_coupon")
                    return redirect('admin/families/' . $family->id . '/edit?come_by=urgent_coupon')->with('success', $message);
                else {
                    if (auth()->user()->hasPermissionTo('edit families'))
                        return redirect('admin/families/' . $family->id . '/edit')->with('success', $message);
                    else
                        return redirect('admin/families')->with('success', $message);

                }
            }

        } else {
            $message = 'لم يتم حفظ استمارة بنجاح';

            event(new NewLogCreated($message, $request['first_name'], 67, 0, 0, null));
            return redirect('admin/families')->with('error', $message);
        }
    }

    public function edit($id)
    {
        if (!is_null($id)) {
            $family = Family::where('id', $id)->with(['members', 'incomes', 'media'])->first();
            if ($family) {
                $parent_id = $family->parent_id;
                if ($parent_id) {
                    $family = Family::where('id', $parent_id)->with(['members', 'incomes', 'media'])->first();
                }
            }


            if (!is_null($family)) {
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
                $come_by = request()['come_by'];

                return view('admin.family.edit', compact('furnitureStatuses', 'come_by', 'qualificationLevels', 'governorates', 'neighborhoods', 'countries', 'projects', 'fileTypes', 'family', 'incomeTypes', 'countries', 'educationalInstitutions', 'universitySpecialties', 'diseases', 'idTypes', 'relationships', 'jobTypes', 'qualifications', 'socialStatuses', 'cities', 'houseOwners', 'houseRoofs', 'houseStatuses', 'types', 'studyLevels', 'studyParts', 'studyTypes', 'fundedInstitutions', 'statuses', 'visitReasons', 'users'));
            } else {
                event(new NewLogCreated('لم يتم العثور على  الاستماره بنجاح برقم : ', $id, 68, 0, null));
                return redirect('admin/families')->with('error', 'لم يتم العثور على  الاستماره بنجاح');
            }

        } else {
            event(new NewLogCreated('لم يتم العثور على الاستماره بنجاح برقم : ', $id, 68, 0, null));
            return redirect('admin/families')->with('error', 'لم يتم العثور على  الاستماره بنجاح');
        }
    }

    public function update(FamilyRequest $request, $id)
    {


        $message = null;

        if (!is_null($request['person_id'])) {
            $person = Person::find($request['person_id']);

            // update person data
            $personData = [
                'first_name' => $request['first_name'],
                'second_name' => $request['second_name'],
                'third_name' => $request['third_name'],
                'family_name' => $request['family_name'],
                'first_name_tr' => $request['first_name_tr'],
                'second_name_tr' => $request['second_name_tr'],
                'third_name_tr' => $request['third_name_tr'],
                'family_name_tr' => $request['family_name_tr'],
                'id_type_id' => $request['id_type_id'],
                'id_number' => $request['id_number'],
                'social_status_id' => $request['social_status_id'],
                'health_status' => $request['health_status'],
                'qualification_id' => $request['qualification_id'],
                'qualification_level_id' => $request['qualification_level_id'],
                'work' => $request['work'],
                'gender' => $request['gender'],
                'date_of_birth' => $request['date_of_birth'],
                'date_of_birth_place' => $request['date_of_birth_place'],

            ];

            $this->checkTranslation($request['first_name'], $request['first_name_tr'], $request['second_name'], $request['second_name_tr'], $request['third_name'], $request['third_name_tr'], $request['family_name'], $request['family_name_tr']);

            if (($request['first_name_tr'] != null) && ($request['second_name_tr'] != null) && ($request['third_name_tr'] != null) && ($request['family_name_tr'] != null)) {
                $personData['full_name_tr'] = $request['first_name_tr'] . ' ' . $request['second_name_tr'] . ' ' . $request['third_name_tr'] . ' ' . $request['family_name_tr'];
            } else {
                $personData['full_name_tr'] = null;
            }
            $personData['full_name'] = $request['first_name'] . ' ' . $request['second_name'] . ' ' . $request['third_name'] . ' ' . $request['family_name'];

            /********************************************************/
            $full_name = $personData['full_name_tr']; //الاسم التركي
            $id_number = $personData['id_number']; // رقم الهوية
//


            $falmils_by_name = Family::whereNotIn('id', [$id])->whereNull('parent_id')->whereHas('person'
                , function ($query) use ($full_name) {
                    $query->where('full_name_tr', $full_name);
                })->with('person');
            $falmils_by_id_number = Family::whereNotIn('id', [$id])->whereNull('parent_id')->whereHas('person'
                , function ($query) use ($id_number) {
                    $query->where('id_number', $id_number);
                })->with('person');

            $vists_by_name = array_unique(array_filter(Family::whereNotIn('id', [$id])->whereNotNull('parent_id')->whereHas('person'
                , function ($query) use ($full_name) {
                    $query->where('full_name_tr', $full_name);
                })->pluck('parent_id')->toArray()));
            $vists_by_id_number = array_unique(array_filter(Family::whereNotIn('id', [$id])->whereNotNull('parent_id')->whereHas('person'
                , function ($query) use ($id_number) {
                    $query->where('id_number', $id_number);
                })->pluck('parent_id')->toArray()));


            if (/*(count($vists_by_name) > 1 || count($vists_by_id_number) > 1) ||
                (count($vists_by_name) > 1 && count($vists_by_id_number) == 0) ||
                (count($vists_by_name) == 0 && count($vists_by_id_number) > 1) ||*/
                ($falmils_by_name->count() > 1 || $falmils_by_id_number->count() > 1) ||
                ($falmils_by_name->count() > 1 && !($falmils_by_id_number->first())) ||
                (!($falmils_by_name->first()) && $falmils_by_id_number->count() > 1)) {

                return back()->with('error', " لم تتم الإضافة،يوجد شخص بهذا الاسم أو رقم الهوية ومكرر أيضاً")->withInput(request()->all);

            } else {
                if ($falmils_by_name->count() == 1 /*|| count($vists_by_name) > 1*/
                    || $falmils_by_id_number->count() == 1 /*|| count($vists_by_id_number) > 1*/) {
                    return back()->with('error', "لم تتم الإضافة،يوجد شخص بهذا الاسم أو رقم الهوية")->withInput(request()->all);
                }
            }
            /**************************************************/
            if ($request['code']) {
                $code = $request['code'];


                $falmils_by_code = Family::whereNotIn('id', [$id])->whereNull('parent_id')->whereHas('person')
                    ->where('code', $code)
                    ->with('person');

                $vists_by_code = array_unique(array_filter(Family::whereNotIn('id', [$id])->whereNotNull('parent_id')
                    ->whereHas('person')
                    ->where('code', $code)
                    ->pluck('parent_id')->toArray()));


                if (($falmils_by_code->count() > 1) /*||
                    (count($vists_by_id_number) > 1)*/) {

                    return back()->with('error', " لم تتم الإضافة،يوجد شخص بهذا الكود ومكرر أيضاً")->withInput(request()->all);

                } else {
                    if ($falmils_by_code->count() == 1) {
                        return back()->with('error', "لم تتم الإضافة،يوجد شخص بهذا الكود")->withInput(request()->all);
                    }
                }
            }
            /********************************************************/
            if (!is_null($person)) {

                $person->update($personData);

                // update family
                if (!is_null($id)) {

                    $family = Family::find($id);
                    if (!is_null($family)) {

                        $dateVisit = Carbon::parse($request['visit_date']);

                        $familyData = [
                            'person_id' => $person->id,
                            'family_project_id' => $request['family_project_id'],
                            'mobile_one' => $request['mobile_one'],
                            'mobile_two' => $request['mobile_two'],
                            'telephone' => $request['telephone'],
                            'country_id' => $request['country_id'],
                            'address' => $request['address'],
                            'house_ownership_id' => $request['house_ownership_id'],
                            'house_roof_id' => $request['house_roof_id'],
                            'house_status_id' => $request['house_status_id'],
                            'furniture_status_id' => $request['furniture_status_id'],
                            'room_number' => $request['room_number'],
                            'need' => $request['need'],
                            'city_id' => $request['city_id'],
                            'neighborhood_id' => $request['neighborhood_id'],
                            'family_status_id' => $request['family_status_id'],
                            'note' => $request['note'],
                            'note_turkey' => $request['note_turkey'],
                            'searcher_note' => $request['searcher_note'],
                            'income_value' => $request['income_value'],
                            'data_entry_id' => Auth::user()->id,
                            'family_type_id' => $request['family_type_id'],
                            'wive_count' => $request['wive_count'],
                            'member_count' => $request['member_count'],
                            'total_income_value' => $request['total_income_value'],
                            'visit_date' => $dateVisit->format('Y/m/d'),
                            'year' => $dateVisit->year,
                            'code' => $request['code'],
                            'representative_id' => $request['representative_id'],
                            'immovable_id' => $request['immovable_id'],
                            'home_space' => $request['home_space'],
                            'number_school_students' => $request['number_school_students'],
                            'number_university_students' => $request['number_university_students'],
                            'supplies_card' => $request['supplies_card'],
                            'family_classification_id' => ($request['need'] == 0 && $family->family_classification_id == 1) ? 5 : $family->family_classification_id,
                            'ignore_date' => ($request['need'] == 0 && $family->need == 1) ? Carbon::now()->toDateString() : null,
                            'ignore_reason' => ($request['need'] == 0 && $family->need == 1) ? $request['searcher_note'] : "",
                            'city_id' => $request['city_id'],
                            'country_id' => $request['country_id'],
                            'neighborhood_id' => $request['neighborhood_id'],
                        ];

                        // if other breadwinner
                        if (($request['breadwinner_id'] == 1) && (!is_null($request['breadwinner_other_id_edit']))) {

                            $relationship = Relationship::find($request['breadwinner_other_id_edit']);

                            $relationship->name = $request['breadwinner_other_edit'];
                            $relationship->save();

                        } else if (($request['breadwinner_id'] == 1) && (!is_null($request['breadwinner_other']))) {
                            $data = [
                                'name' => $request['breadwinner_other'],
                                'name_tr' => '',
                                'status' => 0,
                            ];

                            $relationship = Relationship::create($data);

                            $familyData['breadwinner_id'] = $relationship->id;

                        } else {
                            $familyData['breadwinner_id'] = $request['breadwinner_id'];
                        }

                        // if other relation
                        $relationship = "";
                        if (($request['representative_relationship_id'] == 1) && (!is_null($request['representative_relationship_other_id_edit']))) {

                            $relationship = Relationship::find($request['representative_relationship_other_id_edit']);

                            $relationship->name = $request['representative_relationship_other_edit'];
                            $relationship->save();

                        } else if (($request['representative_relationship_id'] == 1) && (!is_null($request['representative_relationship_other']))) {

                            $data = [
                                'name' => $request['representative_relationship_other'],
                                'name_tr' => '',
                                'status' => 0,
                            ];

                            $relationship = Relationship::create($data);

                            $familyData['representative_relationship_id'] = $relationship->id;


                        } else {
                            $familyData['representative_relationship_id'] = $request['representative_relationship_id'];
                        }

                        // if other immovable
                        $immovable = "";
                        if (($request['immovable_id'] == 1) && (!is_null($request['immovable_other_id_edit']))) {

                            $immovable = Immovable::find($request['immovable_other_id_edit']);

                            $immovable->name = $request['immovable_other_edit'];
                            $immovable->save();

                        } else if (($request['immovable_id'] == 1) && (!is_null($request['immovable_other']))) {

                            $data = [
                                'name' => $request['immovable_other'],
                                'name_tr' => '',
                                'status' => 0,
                            ];

                            $immovable = Immovable::create($data);

                            $familyData['immovable_id'] = $immovable->id;


                        } else {
                            $familyData['immovable_id'] = $request['immovable_id'];
                        }

                        // if work
                        if ($request['work'] == 1) {
                            $familyData['job_type_id'] = $request['job_type_id'];
                            $familyData['income_value'] = $request['income_value'];
                        } else {
                            $familyData['job_type_id'] = null;
                            $familyData['income_value'] = null;
                        }

                        // if rent house
                        if ($request['house_ownership_id'] == 2) {
                            $familyData['rent_value'] = $request['rent_value'];
                        } else {
                            $familyData['rent_value'] = null;
                        }

                        // if un
                        if ($request['family_type_id'] == 7) {
                            $familyData['id_university'] = $request['id_university'];
                            $familyData['study_type_id'] = $request['study_type_id'];
                            $familyData['study_part_id'] = $request['study_part_id'];
                            $familyData['study_level_id'] = $request['study_level_id'];
                            $familyData['graduated_date'] = $request['graduated_date'];
                            $familyData['study_hour_price'] = $request['study_hour_price'];
                        } else {
                            $familyData['id_university'] = null;
                            $familyData['study_type_id'] = null;
                            $familyData['study_part_id'] = null;
                            $familyData['study_level_id'] = null;
                            $familyData['graduated_date'] = null;
                            $familyData['study_hour_price'] = null;
                        }

                        // if other educational institution
                        if (($request['educational_institution_id'] == 1) && (!is_null($request['educational_institution_other_id_edit']))) {

                            $educationalInstitution = EducationalInstitution::find($request['educational_institution_other_id_edit']);

                            $educationalInstitution->name = $request['educational_institution_other_edit'];
                            $educationalInstitution->save();

                        } else if (($request['educational_institution_id'] == 1) && (!is_null($request['educational_institution_other']))) {
                            $data = [
                                'name' => $request['educational_institution_other'],
                                'status' => 0,
                            ];

                            $educationalInstitution = EducationalInstitution::create($data);
                            $familyData['educational_institution_id'] = $educationalInstitution->id;

                        } else {

                            $familyData['educational_institution_id'] = $request['educational_institution_id'];
                        }

                        // if other educational institution
                        if (($request['educational_institution_id'] == 1) && (!is_null($request['educational_institution_other_id_edit']))) {

                            $educationalInstitution = EducationalInstitution::find($request['educational_institution_other_id_edit']);

                            $educationalInstitution->name = $request['educational_institution_other_edit'];
                            $educationalInstitution->save();

                        } else if (($request['educational_institution_id'] == 1) && (!is_null($request['educational_institution_other']))) {
                            $data = [
                                'name' => $request['educational_institution_other'],
                                'status' => 0,
                            ];

                            $educationalInstitution = EducationalInstitution::create($data);
                            $familyData['educational_institution_id'] = $educationalInstitution->id;

                        } else {

                            $familyData['educational_institution_id'] = $request['educational_institution_id'];
                        }

                        // if other specialty
                        if (($request['university_specialty_id'] == 1) && (!is_null($request['university_specialty_other_id_edit']))) {

                            $educationalInstitution = UniversitySpecialty::find($request['university_specialty_other_id_edit']);

                            $educationalInstitution->name = $request['university_specialty_other_edit'];
                            $educationalInstitution->save();

                        } else if (($request['university_specialty_id'] == 1) && (!is_null($request['university_specialty_other']))) {
                            $data = [
                                'name' => $request['university_specialty_other'],
                                'status' => 0,
                            ];

                            $educationalInstitution = UniversitySpecialty::create($data);
                            $familyData['university_specialty_id'] = $educationalInstitution->id;

                        } else {

                            $familyData['university_specialty_id'] = $request['university_specialty_id'];
                        }


                        // if other visit type
                        if (($request['visit_reason_id'] == 1) && (!is_null($request['visit_reason_other_id_edit']))) {

                            $visitReason = VisitReason::find($request['visit_reason_other_id_edit']);

                            $visitReason->name = $request['visit_reason_other_edit'];
                            $visitReason->save();
                            $familyData['visit_mission_date'] = null;

                        } else if (($request['visit_reason_id'] == 1) && (!is_null($request['visit_reason_other']))) {
                            $data = [
                                'name' => $request['visit_reason_other'],
                                'status' => 0,
                            ];

                            $visitReason = VisitReason::create($data);
                            $familyData['visit_reason_id'] = $visitReason->id;
                            $familyData['visit_mission_date'] = null;

                        } else if (($request['visit_reason_id'] == 3) && (!is_null($request['visit_mission_date']))) {

                            $familyData['visit_mission_date'] = $request['visit_mission_date'];
                            $familyData['visit_reason_id'] = $request['visit_reason_id'] ?? 4;

                        } else {
                            $familyData['visit_mission_date'] = null;
                            $familyData['visit_reason_id'] = $request['visit_reason_id'] ?? 4;
                        }
                        // if YTM
                        if ($request['family_type_id'] == 5) {
                            $familyData['father_death_reason'] = $request['father_death_reason'];
                            $familyData['father_death_date'] = $request['father_death_date'];
                            $familyData['mother_death_reason'] = $request['mother_death_reason'];
                            $familyData['mother_death_date'] = $request['mother_death_date'];
                        } else {
                            $familyData['father_death_reason'] = null;
                            $familyData['father_death_date'] = null;
                            $familyData['mother_death_reason'] = null;
                            $familyData['mother_death_date'] = null;
                        }

                        // if other funded institution
                        if (($request['funded_institution_id'] == 1) && (!is_null($request['funded_institution_other_id_edit']))) {

                            $fundedInstitution = FundedInstitution::find($request['funded_institution_other_id_edit']);

                            $fundedInstitution->name = $request['funded_institution_other_edit'];
                            $fundedInstitution->save();

                        } else if (($request['funded_institution_id'] == 1) && (!is_null($request['funded_institution_other']))) {
                            $data = [
                                'name' => $request['funded_institution_other'],
                                'code' => null,
                                'logo' => null,
                                'status' => 0,
                            ];

                            $fundedInstitution = FundedInstitution::create($data);
                            $familyData['funded_institution_id'] = $fundedInstitution->id;

                        } else {
                            $familyData['funded_institution_id'] = $request['funded_institution_id'];
                        }


                        $family->update($familyData);

                        //dd($family);
                        if (
                            (!is_null($request['representative_relationship_id'])) || (!is_null($request['representative_id_number'])) ||
                            (!is_null($request['representative_first_name'])) || (!is_null($request['representative_second_name'])) ||
                            (!is_null($request['representative_third_name'])) || (!is_null($request['representative_family_name'])) ||
                            (!is_null($request['representative_full_name'])) || (!is_null($request['representative_job_type_id']))
                        ) {

                            $representativePersonData = [
                                'id_number' => $request['representative_id_number'],
                                'first_name' => $request['representative_first_name'],
                                'second_name' => $request['representative_second_name'],
                                'third_name' => $request['representative_third_name'],
                                'family_name' => $request['representative_family_name'],
                                'full_name' => $request['representative_first_name'] . " " . $request['representative_second_name'] . " "
                                    . $request['representative_third_name'] . " "
                                    . $request['representative_family_name'],

                            ];

                            if ((isset($family->representative)) && (!is_null($family->representative))) {
                                $representativePerson = $family->representative;
                                $representativePerson->update(array_filter($representativePersonData));
                                $representativeData = [
                                    'representative_id' => $representativePerson->id,
                                    'representative_relationship_id' => $relationship ? $relationship->id : $request['representative_relationship_id'],
                                    'representative_job_type_id' => $request['representative_job_type_id'],
                                    'representative_reason' => $request['representative_reason']
                                ];

                                $family->update(array_filter($representativeData));

                            } else {
                                if (
                                    (!is_null($request['representative_relationship_id'])) || (!is_null($request['representative_id_number'])) ||
                                    (!is_null($request['representative_first_name'])) || (!is_null($request['representative_second_name'])) ||
                                    (!is_null($request['representative_third_name'])) || (!is_null($request['representative_family_name'])) ||
                                    (!is_null($request['representative_full_name'])) || (!is_null($request['representative_job_type_id']))) {

                                    $representativePersonData = [
                                        'id_number' => $request['representative_id_number'],
                                        'first_name' => $request['representative_first_name'],
                                        'second_name' => $request['representative_second_name'],
                                        'third_name' => $request['representative_third_name'],
                                        'family_name' => $request['representative_family_name'],
                                        'full_name' => $request['representative_first_name'] . " " . $request['representative_second_name'] . " "
                                            . $request['representative_third_name'] . " "
                                            . $request['representative_family_name'],

                                    ];

                                    $representativePerson = Person::create($representativePersonData);

                                    $representativeData = [
                                        'representative_id' => $representativePerson->id,
                                        'representative_relationship_id' => $relationship ? $relationship->id : $request['representative_relationship_id'],
                                        'representative_job_type_id' => $request['representative_job_type_id'],
                                        'representative_reason' => $request['representative_reason']
                                    ];

                                    $family->update($representativeData);

                                }
                            }
                        }
                        // income type
                        if (!is_null($request['income_type_id'])) {
                            if ((isset($family->incomes)) && (!is_null($family->incomes))) {

                                foreach ($family->incomes as $item) {
                                    $item->delete();
                                }


                                $incomeTypeArray = [];
                                for ($i = 0; $i < count($request['income_type_id']); $i++) {
                                    if ((!is_null($request['income_type_id'][$i])) && (!is_null($request['income_type_value'][$i])) && (!is_null($request['income_note'][$i]))) {
                                        $incomeTypeArray[$i]['income_type_id'] = $request['income_type_id'][$i];
                                        $incomeTypeArray[$i]['value'] = $request['income_type_value'][$i];
                                        $incomeTypeArray[$i]['note'] = $request['income_note'][$i];
                                    }
                                }

                                if (count($incomeTypeArray) > 0) {
                                    foreach ($incomeTypeArray as $item) {
                                        $itemData = [
                                            'income_type_id' => $item['income_type_id'],
                                            'value' => $item['value'],
                                            'note' => $item['note'],
                                            'family_id' => $family->id,
                                        ];
                                        FamilyIncome::create($itemData);
                                    }
                                }
                            }
                        }

                        // remove all searcher
                        if ((isset($family->searcher)) && (!is_null($family->searcher))) {
                            foreach ($family->searcher as $searcherItem) {
                                $searcherItem->delete();
                            }
                        }

                        // only if update searcher
                        if (isset($request['searcher_id'])) {

//                            dd($request['searcher_id']);
                            foreach ($request['searcher_id'] as $searcherItem) {
                                FamilySearcher::create([
                                    'searcher_id' => $searcherItem,
                                    'family_id' => $family->id,
                                ]);
                            }
                        }


                        // remove all diseases
                        if ((isset($family->diseases)) && (!is_null($family->diseases))) {
                            foreach ($family->diseases as $disease) {
                                $disease->delete();
                            }
                        }

                        // only if update diseases
                        if (($request['health_status'] == 1) && (!is_null($request['family_diseases_edit']))) {

                            FamilyMemberDiseases::destroy(FamilyMemberDiseases::where('person_id', '=', $person->id)
                                ->where('family_id', "=", $family->id)->pluck('id')->toArray());
                            foreach ($request['family_diseases_edit'] as $disease) {
                                FamilyMemberDiseases::create([
                                    'person_id' => $person->id,
                                    'disease_id' => $disease,
                                    'family_id' => $family->id,
                                ]);
                            }

                        }

                        // if change health status and back to family diseases
                        if (($person->health_status == 1) && (!is_null($request['family_diseases']))) {

                            FamilyMemberDiseases::destroy(FamilyMemberDiseases::where('person_id', '=', $person->id)
                                ->where('family_id', "=", $family->id)->pluck('id')->toArray());
                            foreach ($request['family_diseases'] as $disease) {
                                FamilyMemberDiseases::create([
                                    'person_id' => $person->id,
                                    'disease_id' => $disease,
                                    'family_id' => $family->id,
                                ]);
                            }

                        }

                        $message = ' تم تحديث استمارة بنجاح';
                        event(new NewLogCreated($message, $request['first_name'], 68, 0, 0, 'admin/families/' . $family->id . '/edit'));

                        $action = Action::create(['title' => $message, 'type' => 'إدارة الاستمارات', 'link' => Permission::findByName('list families')->link . "/" . $family->id . "/edit"]);
                        $users = User::permission('edit families')->get();
                        if ($users->first())
                            Notification::send($users, new NotifyUsers($action));

                        $come_by = $request['come_by'] ?? "";

                        if ($come_by == "season_coupon")
                            return redirect('/admin/season_coupons/create?family_id=' . $family->id);
                        elseif ($come_by == "urgent_coupon")
                            return redirect('/admin/urgent_coupons/create?family_id=' . $family->id);
                        else
                            return redirect('admin/families/' . $family->id . '/edit')->with('success', $message);

                    } else {
                        $message = ' لم يتم العثور  علي البيانات  بنجاح';
                        event(new NewLogCreated($message, null, 68, 0, 0, null));
                        return redirect('admin/families')->with('error', $message);
                    }
                } else {
                    $message = ' لم يتم العثور  علي البيانات  بنجاح';
                    event(new NewLogCreated($message, null, 68, 0, 0, null));
                    return redirect('admin/families')->with('error', $message);
                }
            } else {
                $message = ' لم يتم العثور  علي البيانات  بنجاح';
                event(new NewLogCreated($message, null, 68, 0, 0, null));
                return redirect('admin/families')->with('error', $message);
            }
        } else {
            $message = ' لم يتم العثور  علي البيانات  بنجاح';
            event(new NewLogCreated($message, null, 68, 0, 0, null));
            return redirect('admin/families')->with('error', $message);
        }
    }

    public function addMember($id)
    {

        if (!is_null($id)) {
            $family = Family::where('id', $id)->with(['members'])->first();
            if ($family) {
                $parent_id = $family->parent_id;
                if ($parent_id) {
                    $family = Family::where('id', $parent_id)->with(['members'])->first();
                }
            }

            if (!is_null($family)) {
                $relationships = Relationship::all();
                $qualifications = Qualification::all();
                $socialStatuses = SocialStatus::all();
                $incomeTypes = IncomeType::all();
                $diseases = Disease::all();
                $countries = Country::all();


                return view('admin.family.part.member.add', compact('family', 'countries', 'diseases', 'incomeTypes', 'relationships', 'qualifications', 'socialStatuses'));

            } else {
                event(new NewLogCreated('لم يتم  العثور على افراد المكفول برقم : ', $id, 130, 0, null));
                return back()->with('error', 'لم يتم العثور على  افراد المكفول بنجاح');
            }

        } else {
            event(new NewLogCreated('لم يتم العثور على افراد المكفول بنجاح برقم : ', $id, 130, 0, null));
            return back()->with('error', 'لم يتم العثور على  افراد المكفول بنجاح');
        }
    }

    public function addNewMember(Request $request, $familyId)
    {
        if (!is_null($familyId)) {
            $family = Family::find($familyId);


            $id_nums = Person::whereIn('id', $family->members->pluck('person_id')->toArray())->pluck('id_number')->toArray();

            if (strlen($request['member_id_number']) != 9) {
                return response()->json([
                    'html' => "<tr><td colspan='12'>رقم الهوية غير صحيح</td></tr>"]);
            }
            if (
                in_array($request['member_id_number'], $id_nums)
                || $family->person->id_number == $request['member_id_number']
            ) {
                return response()->json([
                    'html' => "<tr><td colspan='12'>الاسم موجود سابقا</td></tr>"]);
            }


            if (!is_null($family)) {

                $personMemberData = [
                    'first_name' => $request['member_first_name'],
                    'first_name_tr' => $request['member_first_name_tr'],
                    'date_of_birth' => $request['member_date_of_birth'],
                    'date_of_birth_place' => $request['member_date_of_birth_place'],
                    'id_number' => $request['member_id_number'],
                    'qualification_id' => $request['member_qualification_id'],
                    'work' => $request['member_work'],
                    'health_status' => $request['member_health_status'],
                    'social_status_id' => $request['member_social_status_id'],
                ];

                $personMember = Person::create($personMemberData);

                $memberData = [
                    'family_id' => $familyId,
                    'person_id' => $personMember->id,
                ];


                // if other relation
                if (($request['member_relationship_id'] == 1) && (!is_null($request['member_relationship_other']))) {

                    $data = [
                        'name' => $request['member_relationship_other'],
                        'name_tr' => '',
                        'status' => 0,
                    ];

                    $relationship = Relationship::create($data);

                    $memberData['relationship_id'] = $relationship->id;

                } else {
                    $memberData['relationship_id'] = $request['member_relationship_id'];
                }


                $member = Member::create($memberData);


                // member diseases
                if ($member) {
                    if ($personMember->health_status == 1) {
                        if (!is_null($request['member_family_diseases'])) {
                            foreach ($request['member_family_diseases'] as $disease) {
                                FamilyMemberDiseases::create([
                                    'family_id' => $family->id,
                                    'person_id' => $personMember->id,
                                    'disease_id' => $disease,
                                ]);
                            }
                        }
                    }
                }
                event(new NewLogCreated('تم إضافة افراد للمكفول برقم :', $familyId, 130, 0, null));

                $view = view('admin.family.part.member.addNew', compact('member'))->render();
                return response()->json(['html' => $view]);

            } else {
                event(new NewLogCreated('لم يتم  العثور على افراد المكفول برقم : ', $familyId, 130, 0, null));
                return back()->with('error', 'لم يتم العثور على  افراد المكفول بنجاح');
            }

        } else {
            event(new NewLogCreated('لم يتم  العثور على افراد المكفول برقم : ', $familyId, 130, 0, null));
            return back()->with('error', 'لم يتم العثور على  افراد المكفول بنجاح');
        }
    }

    public function editNewMember(Request $request, $id, $familyId)
    {
        if (!is_null($familyId)) {
            $family = Family::find($familyId);


            $id_nums = Person::whereNotIn('id', [$id])->whereIn('id', $family->members->pluck('person_id')->toArray())->pluck('id_number')->toArray();

            if (strlen($request['member_id_number']) != 9) {
                return response()->json([
                    'html' => "<tr><td colspan='12'>رقم الهوية غير صحيح</td></tr>"]);
            }
            if (
                in_array($request['member_id_number'], $id_nums)
                || $family->person->id_number == $request['member_id_number']
            ) {
                return response()->json([
                    'html' => "<tr><td colspan='12'>الاسم موجود سابقا</td></tr>"]);
            }


            if (!is_null($family)) {

                $personMemberData = [
                    'first_name' => $request['member_first_name'],
                    'first_name_tr' => $request['member_first_name_tr'],
                    'date_of_birth' => $request['member_date_of_birth'],
                    'date_of_birth_place' => $request['member_date_of_birth_place'],
                    'id_number' => $request['member_id_number'],
                    'qualification_id' => $request['member_qualification_id'],
                    'work' => $request['member_work'],
                    'health_status' => $request['member_health_status'],
                    'social_status_id' => $request['member_social_status_id'],
                ];

                $personMember = Person::find($id);
                $personMember->update($personMemberData);
                $memberData = [
                    'family_id' => $familyId,
                    'person_id' => $personMember->id,
                ];


                // if other relation
                if (($request['member_relationship_id'] == 1) && (!is_null($request['member_relationship_other']))) {

                    $data = [
                        'name' => $request['member_relationship_other'],
                        'name_tr' => '',
                        'status' => 0,
                    ];

                    $relationship = Relationship::create($data);

                    $memberData['relationship_id'] = $relationship->id;

                } else {
                    $memberData['relationship_id'] = $request['member_relationship_id'];
                }


                $member = Person::find($id)->member;
                $member->update($memberData);

                // member diseases
                if ($member) {
                    if ($personMember->health_status == 1) {
                        if (!is_null($request['member_family_diseases'])) {
                            foreach ($request['member_family_diseases'] as $disease) {
                                FamilyMemberDiseases::create([
                                    'family_id' => $family->id,
                                    'person_id' => $personMember->id,
                                    'disease_id' => $disease,
                                ]);
                            }
                        }
                    }
                }
                event(new NewLogCreated('تم إضافة افراد للمكفول برقم :', $familyId, 130, 0, null));

                $view = view('admin.family.part.member.addNew', compact('member'))->render();
                return response()->json(['html' => $view]);

            } else {
                event(new NewLogCreated('لم يتم  العثور على افراد المكفول برقم : ', $familyId, 130, 0, null));
                return back()->with('error', 'لم يتم العثور على  افراد المكفول بنجاح');
            }

        } else {
            event(new NewLogCreated('لم يتم  العثور على افراد المكفول برقم : ', $familyId, 130, 0, null));
            return back()->with('error', 'لم يتم العثور على  افراد المكفول بنجاح');
        }
    }

    public function addWives(Request $request, $familyId)
    {
        if (!is_null($familyId)) {
            $family = Family::find($familyId);

            if ($family) {
                $parent_id = $family->parent_id;
                if ($parent_id) {
                    $family = Family::find($parent_id);
                }
            }

            $wives = Person::whereIn('id', $family->members->pluck('person_id')->toArray())->pluck('full_name')->toArray();
            $wives_nums = Person::whereIn('id', $family->members->pluck('person_id')->toArray())->pluck('id_number')->toArray();
            if (strlen($request['wive_id_number']) != 9) {
                return response()->json([
                    'html' => "<tr><td colspan='3'>رقم الهوية غير صحيح</td></tr>"]);
            }
            if (in_array($request['wive_first_name'] . " " .
                    $request['wive_second_name'] . " " .
                    $request['wive_third_name'] . " " .
                    $request['wive_family_name'], $wives)
                ||
                in_array($request['wive_id_number'], $wives_nums)
                || $family->person->full_name == $request['wive_first_name'] . " " .
                $request['wive_second_name'] . " " .
                $request['wive_third_name'] . " " .
                $request['wive_family_name']
                || $family->person->id_number == $request['wive_id_number']) {

                return response()->json([
                    'html' => "<tr><td colspan='3'>الاسم موجود سابقا</td></tr>"]);
            }

            if (!is_null($family)) {
                $family->update(['wive_count' => $request['wive_count'], 'member_count' => $request['member_count']]);

                $personMemberData = [
                    'first_name' => $request['wive_first_name'],
                    'second_name' => $request['wive_second_name'],
                    'third_name' => $request['wive_third_name'],
                    'family_name' => $request['wive_family_name'],
                    'id_number' => $request['wive_id_number'],
                    'full_name' => $request['wive_first_name'] . " " .
                        $request['wive_second_name'] . " " .
                        $request['wive_third_name'] . " " .
                        $request['wive_family_name'],
                ];

                $personMember = Person::create($personMemberData);

                // member data
                $memberData = [
                    'family_id' => $familyId,
                    'person_id' => $personMember->id,
                ];


                $memberData['relationship_id'] = $request['wive_relationship_id'];

                $member = Member::create($memberData);

                event(new NewLogCreated('تم إضافة زوجات للمكفول برقم :', $familyId, 140, 0, null));

                $view = view('admin.family.part.member.addWive', compact('member'))->render();


                return response()->json(['html' => $view]);

            } else {
                event(new NewLogCreated('لم يتم  العثور على زوجات المكفول برقم : ', $familyId, 140, 0, null));
                return back()->with('error', 'لم يتم العثور على  زوجات المكفول بنجاح');
            }

        } else {
            event(new NewLogCreated('لم يتم  العثور على زوجات المكفول برقم : ', $familyId, 140, 0, null));
            return back()->with('error', 'لم يتم العثور على  زوجات المكفول بنجاح');
        }
    }

    public function removeMember($memberId)
    {
        if (!is_null($memberId)) {
            $member = Member::find($memberId);

            if (!is_null($member)) {
                $name = $member->first_name;
                if ($member->delete()) {
                    event(new NewLogCreated(' تم حذف فرد بنجاح : ', $name, 131, 0, null));
                    return back()->with('success', 'تم حذف فرد بنجاح');
                } else {
                    event(new NewLogCreated(' لم يتم حذف فرد بنجاح : ', $name, 131, 0, null));
                    return back()->with('error', 'لم يتم حذف فرد بنجاح');
                }
            } else {
                event(new NewLogCreated('لم يتم  العثور على الفرد  برقم : ', $memberId, 131, 0, null));
                return back()->with('error', 'لم يتم العثور على  الفرد بنجاح');
            }
        } else {
            event(new NewLogCreated('لم يتم  العثور على الفرد  برقم : ', $memberId, 131, 0, null));
            return back()->with('error', 'لم يتم العثور على الفرد بنجاح');
        }
    }

    public function removeIncome($id)
    {
        if (!is_null($id)) {
            $income = FamilyIncome::find($id);

            if (!is_null($income)) {
                $name = $income->name;
                if ($income->delete()) {
                    event(new NewLogCreated(' تم حذف مصدر دخل بنجاح : ', $name, 132, 0, null));
                    return back()->with('success', 'تم حذف مصدر دخل بنجاح');
                } else {
                    event(new NewLogCreated(' لم يتم حذف مصدر دخل بنجاح : ', $name, 132, 0, null));
                    return back()->with('error', 'لم يتم حذف مصدر دخل بنجاح');
                }
            } else {
                event(new NewLogCreated('لم يتم  العثور على مصدر الدخل  برقم : ', $id, 132, 0, null));
                return back()->with('error', 'لم يتم العثور على  مصدر الدخل بنجاح');
            }
        } else {
            event(new NewLogCreated('لم يتم  العثور على مصدر الدخل  برقم : ', $id, 132, 0, null));
            return back()->with('error', 'لم يتم العثور على مصدر الدخل بنجاح');
        }
    }

    public function addMedia($familyId)
    {
        if (!is_null($familyId)) {
            $family = Family::where('id', $familyId)->with(['media'])->first();

            if ($family) {
                $parent_id = $family->parent_id;
                if ($parent_id) {
                    $family = Family::where('id', $parent_id)->with(['media'])->first();
                }
            }

            if (!is_null($family)) {
                $files = FileType::where('status', 1)->get();

                return view('admin.family.media.add', compact('family', 'files'));

            } else {
                event(new NewLogCreated('لم يتم العثور على  الاستماره بنجاح برقم : ', $familyId, 71, 0, null));
                return redirect('admin/families')->with('error', 'لم يتم العثور على  الاستماره بنجاح');
            }

        } else {
            event(new NewLogCreated('لم يتم العثور على الاستماره بنجاح برقم : ', $familyId, 71, 0, null));
            return redirect('admin/families')->with('error', 'لم يتم العثور على  الاستماره بنجاح');
        }
    }

    public function removeMedia($id)
    {

        if (!is_null($id)) {
            $media = FamilyMedia::find($id);

            if (!is_null($media)) {
                $familyId = $media->family_id;
                $family = Family::find($familyId);

                if ($media->delete()) {
                    event(new NewLogCreated('تم حذف مرفق خاص باستماره برقم :  ', $family->id, 71, 1, url('admin/families/' . $family->id . '/edit')));
                    return back()->with('success', 'تم حذف مرفق خاص باستماره بنجاح ');
                }
                event(new NewLogCreated('لم يتم حذف مرفق خاص باستماره برقم :  ', $family->id, 71, 1, url('admin/families/' . $family->id . '/edit')));
                return back()->with('error', 'لم يتم حذف مرفق خاص باستماره بنجاح  ');

            } else {
                event(new NewLogCreated('لم يتم العثور على  مرفق خاص باستماره بنجاح برقم : ', $id, 71, 0, null));
                return back()->with('error', 'لم يتم العثور على  مرفق خاص باستماره بنجاح');
            }

        } else {
            event(new NewLogCreated('لم يتم العثور على  مرفق خاص باستماره بنجاح برقم : ', $id, 71, 0, null));
            return back()->with('error', 'لم يتم العثور على  مرفق خاص باستماره بنجاح');
        }
    }

    public function addNewMedia(Request $request, $familyId)
    {
        $type = null;
        $message = null;


        if (!is_null($familyId)) {
            $family = Family::find($familyId);

            if (!is_null($family)) {

                if (count($request['files']) != count(array_filter($request['file_type_id']))) {
                    event(new NewLogCreated(' يرجى ادخال نوع الملف ', $family->person->full_name, 99, 0, 0));
                    return back()->with('error', 'يرجى ادخال نوع الملف ');
                }

                $fileArray = [];
                $linkArray = [];
                for ($i = 0; $i < count($request['links']); $i++) {
                    if ((isset($request['links'][$i])) && (!is_null($request['links'][$i])) && (isset($request['link_file_type_id'][$i])) && (!is_null($request['link_file_type_id'][$i]))) {
                        $linkArray[$i]['links'] = $request['links'][$i];
                        $linkArray[$i]['link_file_type_id'] = $request['link_file_type_id'][$i];
                        $linkArray[$i]['link_file_type_id_other'] = $request['link_file_type_id_other'][$i];
                        $linkArray[$i]['link_type'] = 2;
                    }
                }

                for ($i = 0; $i < count($request['files']); $i++) {
                    if ((isset($request['files'][$i])) && (!is_null($request['files'][$i])) && (isset($request['file_type_id'][$i])) && (!is_null($request['file_type_id'][$i]))) {
                        $fileArray[$i]['files'] = $request['files'][$i];
                        $fileArray[$i]['file_type_id'] = $request['file_type_id'][$i];
                        $fileArray[$i]['other'] = $request['file_type_id_other'][$i];

                    }
                }


                if (count($linkArray) > 0) {
                    foreach ($linkArray as $link) {

                        if (($link['link_file_type_id'] == 1) && (!is_null($link['link_file_type_id_other'])) || ($link['link_file_type_id'] == 6) && (!is_null($link['link_file_type_id_other']))) {

                            $fileType = FileType::create([
                                'name' => $link['link_file_type_id_other'],
                                'status' => 0,
                            ]);

                            $file_type_id = $fileType->id;
                        } else {
                            $file_type_id = $link['link_file_type_id'];
                        }

                        $mediaData = [
                            'path' => $link['links'],
                            'file_type_id' => $file_type_id,
                            'family_id' => $familyId,
                            'type' => $link['link_type']
                        ];

                        FamilyMedia::create($mediaData);

                        $type = 'success';
                        $message = 'تم اضافه  مرفق خاص باستماره بنجاح برقم :';
                        event(new NewLogCreated('ت ', $familyId, 71, 0, null));
                    }

                }
                if (count($fileArray) > 0) {

                    foreach ($fileArray as $file) {
                        $filename = $file['files']->getClientOriginalName();
                        $isImage = $file['files']->getClientOriginalExtension(); // the extension of file .


                        $pathCheck = 'uploads/attachments/' . $familyId;

                        if (!file_exists($pathCheck)) {
                            File::makeDirectory($pathCheck, $mode = 0777, true, true);
                        }


                        $extintion = pathinfo($file['files']->getClientOriginalName(), PATHINFO_EXTENSION);
                        if ($extintion == 'JFIF' || $extintion == 'JPEG' || $extintion == 'GIF' || $extintion == 'BMP' || $extintion == 'PNG' || $extintion == 'SVG' || $extintion == 'JPG' ||
                            $extintion == 'jfif' || $extintion == 'jpeg' || $extintion == 'gif' || $extintion == 'bmp' || $extintion == 'png' || $extintion == 'svg' || $extintion == 'jpg') {
                            Image::make($file['files']->getRealPath())->save($pathCheck . "/" . $filename, 60);
                        } else {
                            $file['files']->move($pathCheck, $filename);
                        }

                        if (($file['file_type_id'] == 1) && (!is_null($file['other'])) || ($file['file_type_id'] == 6) && (!is_null($file['other']))) {

                            $fileType = FileType::create([
                                'name' => $file['other'],
                                'status' => 0,
                            ]);

                            $file_type_id = $fileType->id;
                        } else {
                            $file_type_id = $file['file_type_id'];
                        }

                        $mediaData = [
                            'path' => $familyId . '/' . $filename,
                            'file_type_id' => $file_type_id,
                            'family_id' => $familyId,
                            'type' => (($isImage == 'png') || ($isImage == 'jpeg') || ($isImage == 'jpg')) ? 0 : 1
                        ];

                        FamilyMedia::create($mediaData);

                        $type = 'success';
                        $message = 'تم اضافه  مرفق خاص باستماره بنجاح برقم :';
                        event(new NewLogCreated('ت ', $familyId, 71, 0, null));
                    }

                }
                //dd($fileArray);
                return back()->with($type, $message);

            } else {
                event(new NewLogCreated('لم يتم العثور على  مرفق خاص باستماره بنجاح برقم : ', $familyId, 71, 0, null));
                return back()->with('error', 'لم يتم العثور على  مرفق خاص باستماره بنجاح');
            }

        } else {
            event(new NewLogCreated('لم يتم العثور على  مرفق خاص باستماره بنجاح برقم : ', $familyId, 71, 0, null));
            return back()->with('error', 'لم يتم العثور على  مرفق خاص باستماره بنجاح');
        }
    }

    public function approve($id)
    {
        if (!is_null($id)) {
            $family = Family::find($id);

            if ($family->parent_id != null) {
                $newFamily = Family::Find($family->parent_id);
                $visit_count = $newFamily->visit_count;
                $newPerson = $newFamily->person;

                $person = $family->person;

                $tt = $family->toArray();
                unset($tt['person']);
                unset($tt['id']);

                $newFamily->update($tt);
                $updateData = [
                    'archive' => 0,
                    'approve' => 0,
                    'visit_count' => $visit_count,
                    'expense_id' => null,
                    'parent_id' => null,
                    'person_id' => $newPerson->id,
                ];
                $newFamily->update($updateData);


                $tt2 = $person->toArray();
                unset($tt2['id']);

                $newPerson->update($tt2);


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
                event(new NewLogCreated('تم استعادة الاستماره بنجاح برقم : ', $id, 135, 0, null));
                $action = Action::create(['title' => "تم تحديث استمارة", 'type' => 'إدارة الترجمات', 'link' => '/admin/families/' . $family->id . '/edit']);
                $users = User::permission('edit families')->get();
                if ($users->first())
                    Notification::send($users, new NotifyUsers($action));
                return redirect('admin/families/' . $family->id . '/edit')->with('success', ' تم اعتماد الاستماره بنجاح');

            }


            if (!is_null($family)) {

                // year + year number visit
                $currentDate = Carbon::now();
                $currentYear = $currentDate->year;
                $familiesYearNumber = Family::whereNotNull('parent_id')->where(['year' => $currentYear])
                    ->get()->sortBy('visit_date');

                $numberCount = 1;
                foreach ($familiesYearNumber as $number) {
                    $number->update(['year_number' => $numberCount]);
                    $numberCount++;
                }

                $person = $family->person;

                if (!is_null($person)) {

                    // clone person
                    $newPerson = $person->replicate();
                    $newPerson->save();

                    // clone family
                    $newFamily = $family->replicate();
                    $newFamily->save();

                    // update family clone data
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

                    event(new NewLogCreated('تم اعتماد الاستماره بنجاح برقم : ', $id, 135, 0, null));
                    return redirect('admin/families/' . $family->id . '/edit')->with('success', ' تم اعتماد الاستماره بنجاح');
                }

            } else {
                event(new NewLogCreated('لم يتم العثور على  الاستماره بنجاح برقم : ', $id, 135, 0, null));
                return redirect('admin/families')->with('error', 'لم يتم العثور على  الاستماره بنجاح');
            }

        } else {
            event(new NewLogCreated('لم يتم العثور على الاستماره بنجاح برقم : ', $id, 135, 0, null));
            return redirect('admin/families')->with('error', 'لم يتم العثور على  الاستماره بنجاح');
        }
    }

    public function showArchive($id)
    {
        if (!is_null($id)) {
            $family = Family::where('id', $id)->with(['members', 'incomes', 'media'])->first();


            if (!is_null($family)) {
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


                return view('admin.family.archive.showArchive', compact('furnitureStatuses', 'qualificationLevels', 'governorates', 'neighborhoods', 'countries', 'projects', 'fileTypes', /*'family_diseases',*/
                    'family', 'incomeTypes', 'countries', 'educationalInstitutions', 'universitySpecialties', 'diseases', 'idTypes', 'relationships', 'jobTypes', 'qualifications', 'socialStatuses', 'cities', 'houseOwners', 'houseRoofs', 'houseStatuses', 'types', 'studyLevels', 'studyParts', 'studyTypes', 'fundedInstitutions', 'statuses', 'visitReasons', 'users'));
            } else {
                event(new NewLogCreated('لم يتم العثور على  الاستماره بنجاح برقم : ', $id, 68, 0, null));
                return redirect('admin/families')->with('error', 'لم يتم العثور على  الاستماره بنجاح');
            }

        } else {
            event(new NewLogCreated('لم يتم العثور على الاستماره بنجاح برقم : ', $id, 68, 0, null));
            return redirect('admin/families')->with('error', 'لم يتم العثور على  الاستماره بنجاح');
        }
    }

    public function archive($id)
    {
        if (!is_null($id)) {
            $family = Family::where('id', $id)->first();
            if ($family) {
                $parent_id = $family->parent_id;
                //dd($parent_id);
                if ($parent_id) {
                    $family = Family::where('id', $parent_id)->first();
                    //dd($family);
                }
            }
            if (!is_null($family)) {
                $archives = Family::where('parent_id', $family->id)
                    ->orderByDesc('visit_count')
                    ->get();

                if ((!($archives)->isEmpty())) {
                    return view('admin.family.archive.archive', compact('archives', 'family'));
                } else {
                    event(new NewLogCreated('ليس للأسرة أرشيف زيارات يرجى اعتماد الزيارة أولا برقم : ', $id, 133, 0, null));
                    return redirect('admin/families')->with('error', 'ليس للأسرة أرشيف زيارات يرجى اعتماد الزيارة أولا  ');
                }
            } else {
                event(new NewLogCreated('لم يتم العثور على  سجل  استماره بنجاح برقم : ', $id, 134, 0, null));
                return redirect('admin/families')->with('error', 'لم يتم العثور على  سجل  استماره بنجاح');
            }
        } else {
            event(new NewLogCreated('لم يتم العثور على  أرشيف  استماره بنجاح برقم : ', $id, 133, 0, null));
            return redirect('admin/families')->with('error', 'لم يتم العثور على   أرشيف  استماره بنجاح');
        }
    }

    public function visit($id)
    {
        if (!is_null($id)) {
            $family = Family::find($id);

            if (!is_null($family)) {

                $family = Family::with('visits')->where('id', $id)->first();
                return view('admin.family.visit', compact('family'));
            } else {
                event(new NewLogCreated('لم يتم العثور على  سجل  استماره بنجاح برقم : ', $id, 134, 0, null));
                return back()->with('error', 'لم يتم العثور على  سجل  استماره بنجاح');
            }

        } else {
            event(new NewLogCreated('لم يتم العثور على  سجل  استماره بنجاح برقم : ', $id, 134, 0, null));
            return back()->with('error', 'لم يتم العثور على   سجل  استماره بنجاح');
        }
    }

    public function searchIdNumber(Request $request)
    {
        $idNumber = $request['text'];
        $familyId = $request['family_id'];
        $persons = Person::where('id_number', $idNumber)->groupBy('id_number')->get();

        $view = view('admin.family.part.member.search', compact('persons', 'familyId'))->render();

        return response()->json(['html' => $view]);
    }

    public function addSingleMember($personId, $familyId)
    {
        if (!is_null($familyId)) {
            $family = Family::find($familyId);
            $person = Person::find($personId);


            if (!is_null($family)) {
                $id_nums = Person::whereIn('id', $family->members->pluck('person_id')->toArray())->pluck('id_number')->toArray();


                if (
                    in_array($person->id_number, $id_nums)
                    || $family->person->id_number == $person->id_number
                ) {
                    event(new NewLogCreated('لم يتم  اضافه فرد المكفول برقم : ', $familyId, 130, 0, null));
                    return back()->with('error', 'الفرد مضاف مسبقا');
                }


                $member = Member::create([
                    'family_id' => $familyId,
                    'person_id' => $personId,
                ]);
                if ($member) {
                    event(new NewLogCreated('تم اضافه فرد المكفول برقم : ', $familyId, 130, 0, null));
                    return back()->with('success', 'تم اضافه فرد المكفول برقم بنجاح');
                } else {
                    event(new NewLogCreated('لم يتم  اضافه فرد المكفول برقم : ', $familyId, 130, 0, null));
                    return back()->with('error', 'لم يتم  اضافه فرد المكفول بنجاح');
                }

            } else {
                event(new NewLogCreated('لم يتم  العثور على افراد المكفول برقم : ', $familyId, 130, 0, null));
                return back()->with('error', 'لم يتم العثور على  افراد المكفول بنجاح');
            }

        } else {
            event(new NewLogCreated('لم يتم  العثور على افراد المكفول برقم : ', $familyId, 130, 0, null));
            return back()->with('error', 'لم يتم العثور على  افراد المكفول بنجاح');
        }
    }

    public function getTranslation(Request $request)
    {

        $transName = '';

        if (!is_null($request->name)) {
            $translation = NameTranslation::where('arabic', $request->name)->first();
            if (!is_null($translation)) {
                $transName = $translation->turkey;
            }
        }

        return response()->json($transName);
    }

    public function visitTemplateDownload()
    {
        $this->visitHeaderTemplate();
        $header = $this->visitHeaderTemplate();

        $this->exportExcelVisitTemplate($header, 'نموذج الزيارات');
    }

    public function visitHeaderTemplate()
    {

        return $header = ["تاريخ الزياره", "اسم الباحث",
            "رقم الهوية",
            "الاسم الاول", "اسم الاب", "اسم الجد", "اسم العائلة",
            "الاسم الاول بالتركي", "اسم الاب بالتركي",
            "اسم الجد بالتركي", "اسم العائلة بالتركي", "يحتاج / لا يحتاج", "سبب الكفالة",
            "جوال 1", "	جوال 2", "هاتف", "اسم الزوجة \ الزوج", "هويه الزوجة \ الزوج",
            "الرقم الجامعي",
            "التاريخ المتوقع للتخرج", "المدينة", "الحي\المنطقة", "تفاصيل العنوان",
            "يعمل/لايعمل", "المهنة", "ملكية السكن", "حـالـة السـكن", "وضع العائلة",
            "مصدر دخل 1", "قيمه الدخل 1 ",
            "مصدر دخل 2", "قيمه الدخل 2 ",
            "مصدر دخل 3", "قيمه الدخل 3 ",
            "ملاحظات", "تقيم الباحث",
            "الاسم 1", "العمر 1", "القرابة 1", "الحالة الاجتماعيه 1", "الحالة الوظيفيه 1", "الحالة الصحيه 1", "الحالة التعليمية 1",
            "الاسم 2", "العمر 2", "القرابة 2", "الحالة الاجتماعيه 2", "الحالة الوظيفيه 2", "الحالة الصحيه 2", "الحالة التعليمية 2",
            "الاسم 3", "العمر 3", "القرابة 3", "الحالة الاجتماعيه 3", "الحالة الوظيفيه 3", "الحالة الصحيه 3", "الحالة التعليمية 3",
            "الاسم 4", "العمر 4", "القرابة 4", "الحالة الاجتماعيه 4", "الحالة الوظيفيه 4", "الحالة الصحيه 4", "الحالة التعليمية 4",
            "الاسم 5", "العمر 5", "القرابة 5", "الحالة الاجتماعيه 5", "الحالة الوظيفيه 5", "الحالة الصحيه 5", "الحالة التعليمية 5",
            "الاسم 6", "العمر 6", "القرابة 6", "الحالة الاجتماعيه 6", "الحالة الوظيفيه 6", "الحالة الصحيه 6", "الحالة التعليمية 6",
            "الاسم 7", "العمر 7", "القرابة 7", "الحالة الاجتماعيه 7", "الحالة الوظيفيه 7", "الحالة الصحيه 7", "الحالة التعليمية 7",
            "الاسم 8", "العمر 8", "القرابة 8", "الحالة الاجتماعيه 8", "الحالة الوظيفيه 8", "الحالة الصحيه 8", "الحالة التعليمية 8",
            "الاسم 9", "العمر 9", "القرابة 9", "الحالة الاجتماعيه 9", "الحالة الوظيفيه 9", "الحالة الصحيه 9", "الحالة التعليمية 9",
            "الاسم 10", "العمر 10", "القرابة 10", "الحالة الاجتماعيه 10", "الحالة الوظيفيه 10", "الحالة الصحيه 10", "الحالة التعليمية 10",
            "الاسم 11", "العمر 11", "القرابة 11", "الحالة الاجتماعيه 11", "الحالة الوظيفيه 11", "الحالة الصحيه 11", "الحالة التعليمية 11",
            "الاسم 12", "العمر 12", "القرابة 12", "الحالة الاجتماعيه 12", "الحالة الوظيفيه 12", "الحالة الصحيه 12", "الحالة التعليمية 12",
            "الاسم 13", "العمر 13", "القرابة 13", "الحالة الاجتماعيه 13", "الحالة الوظيفيه 13", "الحالة الصحيه 13", "الحالة التعليمية 13",
            "الاسم 14", "العمر 14", "القرابة 14", "الحالة الاجتماعيه 14", "الحالة الوظيفيه 14", "الحالة الصحيه 14", "الحالة التعليمية 14",
            "الاسم 15", "العمر 15", "القرابة 15", "الحالة الاجتماعيه 15", "الحالة الوظيفيه 15", "الحالة الصحيه 15", "الحالة التعليمية 15",
            "الاسم 16", "العمر 16", "القرابة 16", "الحالة الاجتماعيه 16", "الحالة الوظيفيه 16", "الحالة الصحيه 16", "الحالة التعليمية 16",
            "الاسم 17", "العمر 17", "القرابة 17", "الحالة الاجتماعيه 17", "الحالة الوظيفيه 17", "الحالة الصحيه 17", "الحالة التعليمية 17",
            "الاسم 18", "العمر 18", "القرابة 18", "الحالة الاجتماعيه 18", "الحالة الوظيفيه 18", "الحالة الصحيه 18", "الحالة التعليمية 18",
            "الاسم 19", "العمر 19", "القرابة 19", "الحالة الاجتماعيه 19", "الحالة الوظيفيه 19", "الحالة الصحيه 19", "الحالة التعليمية 19",
            "الاسم 20", "العمر 20", "القرابة 20", "الحالة الاجتماعيه 20", "الحالة الوظيفيه 20", "الحالة الصحيه 20", "الحالة التعليمية 20",
            "سنة الميلاد",
        ];
    }

    public function visitHeader()
    {
        return $header = ["تاريخ الزيارة", "اسم الباحث", "الكود", "الجهة المرشحة",
            "رقم الهوية", "اســـــم الحالة",
            "الاسم الاول", "اسم الاب", "اسم الجد", "اسم العائلة", "اسم الحالة بالتركي",
            "الاسم الاول بالتركي", "اسم الاب بالتركي",
            "اسم الجد بالتركي", "اسم العائلة بالتركي", "يحتاج / لا يحتاج", "سبب الكفالة",
            "جوال 1", "	جوال 2", "هاتف", "اسم الزوجة \ الزوج", "هويه الزوجة \ الزوج",
            "الرقم الجامعي",
            "الوكيل",
            "التاريخ المتوقع للتخرج", "المدينة", "الحي\المنطقة", "تفاصيل العنوان",
            "يعمل/لايعمل", "المهنة", "ملكية السكن", "حـالـة السـكن", "وضع العائلة",
            "ملاحظات", "تقيم الباحث",
            "الاسم 1", "العمر 1", "القرابة 1", "الحالة الاجتماعيه 1", "الحالة الوظيفيه 1", "الحالة الصحيه 1", "الحالة التعليمية 1",
            "الاسم 2", "العمر 2", "القرابة 2", "الحالة الاجتماعيه 2", "الحالة الوظيفيه 2", "الحالة الصحيه 2", "الحالة التعليمية 2",
            "الاسم 3", "العمر 3", "القرابة 3", "الحالة الاجتماعيه 3", "الحالة الوظيفيه 3", "الحالة الصحيه 3", "الحالة التعليمية 3",
            "الاسم 4", "العمر 4", "القرابة 4", "الحالة الاجتماعيه 4", "الحالة الوظيفيه 4", "الحالة الصحيه 4", "الحالة التعليمية 4",
            "الاسم 5", "العمر 5", "القرابة 5", "الحالة الاجتماعيه 5", "الحالة الوظيفيه 5", "الحالة الصحيه 5", "الحالة التعليمية 5",
            "الاسم 6", "العمر 6", "القرابة 6", "الحالة الاجتماعيه 6", "الحالة الوظيفيه 6", "الحالة الصحيه 6", "الحالة التعليمية 6",
            "الاسم 7", "العمر 7", "القرابة 7", "الحالة الاجتماعيه 7", "الحالة الوظيفيه 7", "الحالة الصحيه 7", "الحالة التعليمية 7",
            "الاسم 8", "العمر 8", "القرابة 8", "الحالة الاجتماعيه 8", "الحالة الوظيفيه 8", "الحالة الصحيه 8", "الحالة التعليمية 8",
            "الاسم 9", "العمر 9", "القرابة 9", "الحالة الاجتماعيه 9", "الحالة الوظيفيه 9", "الحالة الصحيه 9", "الحالة التعليمية 9",
            "الاسم 10", "العمر 10", "القرابة 10", "الحالة الاجتماعيه 10", "الحالة الوظيفيه 10", "الحالة الصحيه 10", "الحالة التعليمية 10",
            "الاسم 11", "العمر 11", "القرابة 11", "الحالة الاجتماعيه 11", "الحالة الوظيفيه 11", "الحالة الصحيه 11", "الحالة التعليمية 11",
            "الاسم 12", "العمر 12", "القرابة 12", "الحالة الاجتماعيه 12", "الحالة الوظيفيه 12", "الحالة الصحيه 12", "الحالة التعليمية 12",
            "الاسم 13", "العمر 13", "القرابة 13", "الحالة الاجتماعيه 13", "الحالة الوظيفيه 13", "الحالة الصحيه 13", "الحالة التعليمية 13",
            "الاسم 14", "العمر 14", "القرابة 14", "الحالة الاجتماعيه 14", "الحالة الوظيفيه 14", "الحالة الصحيه 14", "الحالة التعليمية 14",
            "الاسم 15", "العمر 15", "القرابة 15", "الحالة الاجتماعيه 15", "الحالة الوظيفيه 15", "الحالة الصحيه 15", "الحالة التعليمية 15",
            "الاسم 16", "العمر 16", "القرابة 16", "الحالة الاجتماعيه 16", "الحالة الوظيفيه 16", "الحالة الصحيه 16", "الحالة التعليمية 16",
            "الاسم 17", "العمر 17", "القرابة 17", "الحالة الاجتماعيه 17", "الحالة الوظيفيه 17", "الحالة الصحيه 17", "الحالة التعليمية 17",
            "الاسم 18", "العمر 18", "القرابة 18", "الحالة الاجتماعيه 18", "الحالة الوظيفيه 18", "الحالة الصحيه 18", "الحالة التعليمية 18",
            "الاسم 19", "العمر 19", "القرابة 19", "الحالة الاجتماعيه 19", "الحالة الوظيفيه 19", "الحالة الصحيه 19", "الحالة التعليمية 19",
            "الاسم 20", "العمر 20", "القرابة 20", "الحالة الاجتماعيه 20", "الحالة الوظيفيه 20", "الحالة الصحيه 20", "الحالة التعليمية 20",
        ];
    }

    public function exportExcelVisit($families, $header, $name)
    {


        $users = User::where('id', '<>', 1)->get();
        $familyTypes = FamilyType::all();
        $cities = City::all();
        $Neighborhoods = Neighborhood::all();
        $jobTypes = JobType::all();
        $incomeTypes = IncomeType::all();
        $houseOwnerships = HouseOwnership::all();
        $houseStatuses = HouseStatus::all();
        $familyStatuses = FamilyStatus::all();
        $relationShips = Relationship::where('id', '<>', 1)->get();

        $relationFamily = Relationship::find(14);
        $fundedInstitutions = FundedInstitution::all();
        $socialStatuses = SocialStatus::all();
        $qualifications = Qualification::all();
        $health = Health::all();
        $need = Need::all();

        Excel::create($name, function ($excel) use ($families, $header, $need, $health, $qualifications, $socialStatuses, $incomeTypes, $fundedInstitutions, $relationFamily, $users, $familyTypes, $cities, $Neighborhoods, $jobTypes, $houseOwnerships, $houseStatuses, $familyStatuses, $relationShips) {

            $excel->sheet('الزيارات', function ($sheet) use ($families, $need, $health, $qualifications, $socialStatuses, $header, $incomeTypes, $fundedInstitutions, $relationFamily, $users, $familyTypes, $cities, $Neighborhoods, $jobTypes, $houseOwnerships, $houseStatuses, $familyStatuses, $relationShips) {

                $allRows = array();
                if (count($families) == 1) {
                    $person = $families->person;
                    $log = $families->person;
                    $wiveOrHusband = null;

                    if ((isset($families->members)) && (count($families->members) > 0)) {
                        foreach ($families->members as $item) {
                            if (($item->relationShip_id == 25) || ($item->relationShip_id == 27)) {
                                $wiveOrHusband = $item->persone;
                            }
                        }
                    }

                    $mainData = [
                        $families->visit_date,
                        ((isset($item->searcher)) && (!is_null($item->searcher)) && (count($item->searcher) > 1)) ? $item->searcher->first()->searcher_id . '-' . $item->searcher->first()->searcher->full_name : null,
                        $families->code,
                        $families->other_note,
                        $person->id_number,
                        $person->full_name,
                        $person->first_name,
                        $person->second_name,
                        $person->third_name,
                        $person->family_name,
                        $person->full_name_tr,
                        $person->first_name_tr,
                        $person->second_name_tr,
                        $person->third_name_tr,
                        $person->family_name_tr,
                        $person->need == 0 ? 'يحتاج' : 'لا يحتاج',
                        isset($families->type) ? $families->type->name : null,
                        $families->mobile_one,
                        $families->mobile_two,
                        $families->telephone,

                        !is_null($wiveOrHusband) ? $wiveOrHusband->first_name : null,
                        !is_null($wiveOrHusband) ? $wiveOrHusband->id_number : null,
                        $families->id_university,
                        isset($families->representative) ? ($families->representative->full_name) : '-',
                        $families->graduated_date,
                        isset($families->city) ? $families->city->name : null,
                        isset($families->neighborhood) ? $families->neighborhood->name : null,
                        $families->address,
                        $person->work == 0 ? 'يعمل' : 'لا يعمل',
                        isset($families->job_type) ? $families->job_type->name : null,
                        isset($families->house_ownership) ? $families->house_ownership->name : null,
                        isset($families->house_status) ? $families->house_status->name : null,
                        isset($families->status) ? $families->status->name : null,
                        $families->previous_income_coupon,
                        $families->previous_income_value,
                        $families->note,
                        $families->searcher_note,
                    ];

                    if (isset($families->members)) {
                        foreach ($families->members as $member) {
                            $personMember = $member->person;

                            $newMemberData = [
                                $personMember->first_name,
                                $personMember->date_of_birth,
                                isset($member->relationship) ? $member->relationship->name : null,
                                isset($personMember->social_status) ? $personMember->social_status->name : null,
                                !is_null($personMember->work == 0) ? 'لا يعمل' : 'يعمل',
                                !is_null($personMember->health_status == 0) ? 'سليم' : 'مريض',
                            ];

                            array_push($mainData, $newMemberData);

                        }
                    }
                    array_push($allRows, collect($mainData)->flatten());

                } else {
                    foreach ($families as $item) {


                        $wiveOrHusband = null;

                        if ((isset($item->members)) && (count($item->members) > 0)) {
                            foreach ($item->members as $itemData) {
                                if (($itemData->relationShip_id == 25) || ($itemData->relationShip_id == 27)) {
                                    $wiveOrHusband = $itemData->persone;
                                }
                            }
                        }
                        $person = $item->person;
                        $mainData = [
                            $item->visit_date,
                            ((isset($item->searcher)) && (!is_null($item->searcher)) && (count($item->searcher) > 1)) ? $item->searcher->first()->searcher_id . '-' . $item->searcher->first()->searcher->full_name : null,
                            $item->code,
                            $item->other_note,
                            $person->id_number,
                            $person->full_name,
                            $person->first_name,
                            $person->second_name,
                            $person->third_name,
                            $person->family_name,
                            $person->full_name_tr,
                            $person->first_name_tr,
                            $person->second_name_tr,
                            $person->third_name_tr,
                            $person->family_name_tr,
                            $person->need == 0 ? 'يحتاج' : 'لا يحتاج',
                            isset($item->type) ? $item->type->name : null,
                            $item->mobile_one,
                            $item->mobile_two,
                            $item->telephone,
                            !is_null($wiveOrHusband) ? $wiveOrHusband->first_name : null,
                            !is_null($wiveOrHusband) ? $wiveOrHusband->id_number : null,
                            $item->id_university,
                            isset($item->representative) ? ($item->representative->full_name) : '-',
                            $item->graduated_date,
                            isset($item->city) ? $item->city->name : null,
                            isset($item->neighborhood) ? $item->neighborhood->name : null,
                            $item->address,
                            $person->work == 0 ? 'يعمل' : 'لا يعمل',
                            isset($item->job_type) ? $item->job_type->name : null,
                            isset($item->house_ownership) ? $item->house_ownership->name : null,
                            isset($item->house_status) ? $item->house_status->name : null,
                            isset($item->status) ? $item->status->name : null,
                            $item->note,
                            $item->searcher_note,
                        ];


                        if (isset($item->members)) {
                            foreach ($item->members as $member) {
                                $personMember = $member->person;

                                $newMemberData = [
                                    $personMember->first_name,
                                    $personMember->date_of_birth,
                                    isset($member->relationship) ? $member->relationship->name : null,
                                    isset($personMember->social_status) ? $personMember->social_status->name : null,
                                    !is_null($personMember->work == 0) ? 'لا يعمل' : 'يعمل',
                                    !is_null($personMember->health_status == 0) ? 'سليم' : 'مريض',
                                    isset($personMember->qualification) ? $personMember->qualification->name : null,
                                ];

                                array_push($mainData, $newMemberData);
                            }
                        }

                        array_push($allRows, collect($mainData)->flatten());
                    }
                }

                $newArray = collect($allRows)->toArray();

                foreach ($newArray as $key => $item) {
                    $sheet->row($key + 2, $item);
                }

                $sheet->setOrientation('landscape');
                $sheet->fromArray($header, NULL, 'A1');
                $sheet->freezeFirstRow();
            });

        })->download('xlsx');
    }

    public function exportExcelVisitTemplate($header, $name)
    {
        $users = User::where('department_id', '=', 5)->get();
        $familyTypes = FamilyType::all();
        $cities = City::all();
        $Neighborhoods = Neighborhood::all();
        $jobTypes = JobType::all();
        $incomeTypes = IncomeType::all();
        $houseOwnerships = HouseOwnership::all();
        $houseStatuses = HouseStatus::all();
        $familyStatuses = FamilyStatus::all();
        $relationShips = Relationship::where('id', '<>', 1)->get();
        $relationFamily = Relationship::find(14);
        $fundedInstitutions = FundedInstitution::all();
        $socialStatuses = SocialStatus::all();
        $qualifications = Qualification::all();
        $health = Health::all();
        $need = Need::all();
        $work = Work::all();

        Excel::create($name, function ($excel) use ($header, $need, $work, $health, $qualifications, $socialStatuses, $incomeTypes, $fundedInstitutions, $relationFamily, $users, $familyTypes, $cities, $Neighborhoods, $jobTypes, $houseOwnerships, $houseStatuses, $familyStatuses, $relationShips) {

            $excel->sheet('الزيارات', function ($sheet) use ($need, $work, $health, $qualifications, $socialStatuses, $header, $incomeTypes, $fundedInstitutions, $relationFamily, $users, $familyTypes, $cities, $Neighborhoods, $jobTypes, $houseOwnerships, $houseStatuses, $familyStatuses, $relationShips) {

                $sheet->getStyle('C1')->applyFromArray(array(
                    'fill' => array(
                        'type' => \PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => 'FF0000')
                    )
                ));
                $sheet->getStyle('D1')->applyFromArray(array(
                    'fill' => array(
                        'type' => \PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => 'FF0000')
                    )
                ));
                $sheet->getStyle('E1')->applyFromArray(array(
                    'fill' => array(
                        'type' => \PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => 'FF0000')
                    )
                ));
                $sheet->getStyle('F1')->applyFromArray(array(
                    'fill' => array(
                        'type' => \PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => 'FF0000')
                    )
                ));
                $sheet->getStyle('G1')->applyFromArray(array(
                    'fill' => array(
                        'type' => \PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => 'FF0000')
                    )
                ));
                $sheet->getStyle('H1')->applyFromArray(array(
                    'fill' => array(
                        'type' => \PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => 'FF0000')
                    )
                ));
                $sheet->getStyle('I1')->applyFromArray(array(
                    'fill' => array(
                        'type' => \PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => 'FF0000')
                    )
                ));
                $sheet->getStyle('J1')->applyFromArray(array(
                    'fill' => array(
                        'type' => \PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => 'FF0000')
                    )
                ));
                $sheet->getStyle('K1')->applyFromArray(array(
                    'fill' => array(
                        'type' => \PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => 'FF0000')
                    )
                ));
                $this->dropDown($sheet, $users, 'B', 'full_name', 'name', 'AAA', 2);
                $this->dropDown($sheet, $need, 'L', 'name', 'name1', 'AAB', 2);
                $this->dropDown($sheet, $cities, 'U', 'name', 'name2', 'AAC', 2);
                $this->dropDown($sheet, $Neighborhoods, 'V', 'name', 'name3', 'AAD', 2);
                $this->dropDown($sheet, $work, 'X', 'name', 'name4', 'AAE', 2);
                $this->dropDown($sheet, $jobTypes, 'Y', 'name', 'name5', 'AAF', 2);
                $this->dropDown($sheet, $houseOwnerships, 'Z', 'name', 'name6', 'AAG', 2);
                $this->dropDown($sheet, $houseStatuses, 'AA', 'name', 'name7', 'AAH', 2);
                $this->dropDown($sheet, $familyStatuses, 'AB', 'name', 'name8', 'AAI', 2);
                $this->dropDown($sheet, $incomeTypes, 'AC', 'name', 'name9', 'AAJ', 2);
                $this->dropDown($sheet, $incomeTypes, 'AE', 'name', 'name9', 'AAJ', 2);
                $this->dropDown($sheet, $incomeTypes, 'AG', 'name', 'name9', 'AAJ', 2);
                $this->dropDown($sheet, $familyTypes, 'M', 'name', 'name15', 'AAP', 2);

                $this->dropDown($sheet, $relationShips, 'AM', 'name', 'name10', 'AAK', 2);
                $this->dropDown($sheet, $relationShips, 'AT', 'name', 'name10', 'AAK', 2);
                $this->dropDown($sheet, $relationShips, 'BA', 'name', 'name10', 'AAK', 2);
                $this->dropDown($sheet, $relationShips, 'BH', 'name', 'name10', 'AAK', 2);
                $this->dropDown($sheet, $relationShips, 'BO', 'name', 'name10', 'AAK', 2);
                $this->dropDown($sheet, $relationShips, 'BV', 'name', 'name10', 'AAK', 2);
                $this->dropDown($sheet, $relationShips, 'CC', 'name', 'name10', 'AAK', 2);
                $this->dropDown($sheet, $relationShips, 'CJ', 'name', 'name10', 'AAK', 2);
                $this->dropDown($sheet, $relationShips, 'CQ', 'name', 'name10', 'AAK', 2);
                $this->dropDown($sheet, $relationShips, 'CX', 'name', 'name10', 'AAK', 2);
                $this->dropDown($sheet, $relationShips, 'DE', 'name', 'name10', 'AAK', 2);
                $this->dropDown($sheet, $relationShips, 'DL', 'name', 'name10', 'AAK', 2);
                $this->dropDown($sheet, $relationShips, 'DS', 'name', 'name10', 'AAK', 2);
                $this->dropDown($sheet, $relationShips, 'DZ', 'name', 'name10', 'AAK', 2);
                $this->dropDown($sheet, $relationShips, 'EG', 'name', 'name10', 'AAK', 2);
                $this->dropDown($sheet, $relationShips, 'EN', 'name', 'name10', 'AAK', 2);
                $this->dropDown($sheet, $relationShips, 'EU', 'name', 'name10', 'AAK', 2);
                $this->dropDown($sheet, $relationShips, 'FB', 'name', 'name10', 'AAK', 2);
                $this->dropDown($sheet, $relationShips, 'FI', 'name', 'name10', 'AAK', 2);
                $this->dropDown($sheet, $relationShips, 'FP', 'name', 'name10', 'AAK', 2);

                $this->dropDown($sheet, $jobTypes, 'AO', 'name', 'name11', 'AAL', 2);
                $this->dropDown($sheet, $jobTypes, 'AV', 'name', 'name11', 'AAL', 2);
                $this->dropDown($sheet, $jobTypes, 'BC', 'name', 'name11', 'AAL', 2);
                $this->dropDown($sheet, $jobTypes, 'BJ', 'name', 'name11', 'AAL', 2);
                $this->dropDown($sheet, $jobTypes, 'BQ', 'name', 'name11', 'AAL', 2);
                $this->dropDown($sheet, $jobTypes, 'BX', 'name', 'name11', 'AAL', 2);
                $this->dropDown($sheet, $jobTypes, 'CE', 'name', 'name11', 'AAL', 2);
                $this->dropDown($sheet, $jobTypes, 'CL', 'name', 'name11', 'AAL', 2);
                $this->dropDown($sheet, $jobTypes, 'CS', 'name', 'name11', 'AAL', 2);
                $this->dropDown($sheet, $jobTypes, 'CZ', 'name', 'name11', 'AAL', 2);
                $this->dropDown($sheet, $jobTypes, 'DG', 'name', 'name11', 'AAL', 2);
                $this->dropDown($sheet, $jobTypes, 'DN', 'name', 'name11', 'AAL', 2);
                $this->dropDown($sheet, $jobTypes, 'DU', 'name', 'name11', 'AAL', 2);
                $this->dropDown($sheet, $jobTypes, 'EB', 'name', 'name11', 'AAL', 2);
                $this->dropDown($sheet, $jobTypes, 'EI', 'name', 'name11', 'AAL', 2);
                $this->dropDown($sheet, $jobTypes, 'EP', 'name', 'name11', 'AAL', 2);
                $this->dropDown($sheet, $jobTypes, 'EW', 'name', 'name11', 'AAL', 2);
                $this->dropDown($sheet, $jobTypes, 'FD', 'name', 'name11', 'AAL', 2);
                $this->dropDown($sheet, $jobTypes, 'FK', 'name', 'name11', 'AAL', 2);
                $this->dropDown($sheet, $jobTypes, 'FR', 'name', 'name11', 'AAL', 2);

                $this->dropDown($sheet, $socialStatuses, 'AN', 'name', 'name12', 'AAM', 2);
                $this->dropDown($sheet, $socialStatuses, 'AU', 'name', 'name12', 'AAM', 2);
                $this->dropDown($sheet, $socialStatuses, 'BB', 'name', 'name12', 'AAM', 2);
                $this->dropDown($sheet, $socialStatuses, 'BI', 'name', 'name12', 'AAM', 2);
                $this->dropDown($sheet, $socialStatuses, 'BP', 'name', 'name12', 'AAM', 2);
                $this->dropDown($sheet, $socialStatuses, 'BW', 'name', 'name12', 'AAM', 2);
                $this->dropDown($sheet, $socialStatuses, 'CD', 'name', 'name12', 'AAM', 2);
                $this->dropDown($sheet, $socialStatuses, 'CK', 'name', 'name12', 'AAM', 2);
                $this->dropDown($sheet, $socialStatuses, 'CR', 'name', 'name12', 'AAM', 2);
                $this->dropDown($sheet, $socialStatuses, 'CY', 'name', 'name12', 'AAM', 2);
                $this->dropDown($sheet, $socialStatuses, 'DF', 'name', 'name12', 'AAM', 2);
                $this->dropDown($sheet, $socialStatuses, 'DM', 'name', 'name12', 'AAM', 2);
                $this->dropDown($sheet, $socialStatuses, 'DT', 'name', 'name12', 'AAM', 2);
                $this->dropDown($sheet, $socialStatuses, 'EA', 'name', 'name12', 'AAM', 2);
                $this->dropDown($sheet, $socialStatuses, 'EH', 'name', 'name12', 'AAM', 2);
                $this->dropDown($sheet, $socialStatuses, 'EO', 'name', 'name12', 'AAM', 2);
                $this->dropDown($sheet, $socialStatuses, 'EV', 'name', 'name12', 'AAM', 2);
                $this->dropDown($sheet, $socialStatuses, 'FC', 'name', 'name12', 'AAM', 2);
                $this->dropDown($sheet, $socialStatuses, 'FJ', 'name', 'name12', 'AAM', 2);
                $this->dropDown($sheet, $socialStatuses, 'FQ', 'name', 'name12', 'AAM', 2);

                $this->dropDown($sheet, $health, 'AP', 'name', 'name13', 'AAN', 2);
                $this->dropDown($sheet, $health, 'AW', 'name', 'name13', 'AAN', 2);
                $this->dropDown($sheet, $health, 'BD', 'name', 'name13', 'AAN', 2);
                $this->dropDown($sheet, $health, 'BK', 'name', 'name13', 'AAN', 2);
                $this->dropDown($sheet, $health, 'BR', 'name', 'name13', 'AAN', 2);
                $this->dropDown($sheet, $health, 'BY', 'name', 'name13', 'AAN', 2);
                $this->dropDown($sheet, $health, 'CF', 'name', 'name13', 'AAN', 2);
                $this->dropDown($sheet, $health, 'CM', 'name', 'name13', 'AAN', 2);
                $this->dropDown($sheet, $health, 'CT', 'name', 'name13', 'AAN', 2);
                $this->dropDown($sheet, $health, 'DA', 'name', 'name13', 'AAN', 2);
                $this->dropDown($sheet, $health, 'DH', 'name', 'name13', 'AAN', 2);
                $this->dropDown($sheet, $health, 'DO', 'name', 'name13', 'AAN', 2);
                $this->dropDown($sheet, $health, 'DV', 'name', 'name13', 'AAN', 2);
                $this->dropDown($sheet, $health, 'EC', 'name', 'name13', 'AAN', 2);
                $this->dropDown($sheet, $health, 'EJ', 'name', 'name13', 'AAN', 2);
                $this->dropDown($sheet, $health, 'EQ', 'name', 'name13', 'AAN', 2);
                $this->dropDown($sheet, $health, 'EX', 'name', 'name13', 'AAN', 2);
                $this->dropDown($sheet, $health, 'FE', 'name', 'name13', 'AAN', 2);
                $this->dropDown($sheet, $health, 'FL', 'name', 'name13', 'AAN', 2);
                $this->dropDown($sheet, $health, 'FS', 'name', 'name13', 'AAN', 2);

                $this->dropDown($sheet, $qualifications, 'AQ', 'name', 'name14', 'AAO', 2);
                $this->dropDown($sheet, $qualifications, 'AX', 'name', 'name14', 'AAO', 2);
                $this->dropDown($sheet, $qualifications, 'BE', 'name', 'name14', 'AAO', 2);
                $this->dropDown($sheet, $qualifications, 'BL', 'name', 'name14', 'AAO', 2);
                $this->dropDown($sheet, $qualifications, 'BS', 'name', 'name14', 'AAO', 2);
                $this->dropDown($sheet, $qualifications, 'BZ', 'name', 'name14', 'AAO', 2);
                $this->dropDown($sheet, $qualifications, 'CG', 'name', 'name14', 'AAO', 2);
                $this->dropDown($sheet, $qualifications, 'CN', 'name', 'name14', 'AAO', 2);
                $this->dropDown($sheet, $qualifications, 'CU', 'name', 'name14', 'AAO', 2);
                $this->dropDown($sheet, $qualifications, 'DB', 'name', 'name14', 'AAO', 2);
                $this->dropDown($sheet, $qualifications, 'DI', 'name', 'name14', 'AAO', 2);
                $this->dropDown($sheet, $qualifications, 'DP', 'name', 'name14', 'AAO', 2);
                $this->dropDown($sheet, $qualifications, 'DW', 'name', 'name14', 'AAO', 2);
                $this->dropDown($sheet, $qualifications, 'ED', 'name', 'name14', 'AAO', 2);
                $this->dropDown($sheet, $qualifications, 'EK', 'name', 'name14', 'AAO', 2);
                $this->dropDown($sheet, $qualifications, 'ER', 'name', 'name14', 'AAO', 2);
                $this->dropDown($sheet, $qualifications, 'EY', 'name', 'name14', 'AAO', 2);
                $this->dropDown($sheet, $qualifications, 'FF', 'name', 'name14', 'AAO', 2);
                $this->dropDown($sheet, $qualifications, 'FM', 'name', 'name14', 'AAO', 2);
                $this->dropDown($sheet, $qualifications, 'FT', 'name', 'name14', 'AAO', 2);

                $sheet->setOrientation('landscape');
                $sheet->fromArray($header, NULL, 'A1');
                $sheet->freezeFirstRow();
                $sheet->setColumnFormat(array(
                    'A' => 'dd/mm/yyyy',
                    'T' => 'dd-mm-yyyy',
                ));
            });

        })->download('xlsx');
    }

    public function representative(Request $request)
    {

        if ($request->hasFile('file')) {

            $request->validate([
                'file' => 'required|mimes:csv,txt'
            ]);

            $path = $request->file('file')->getRealPath();
            $data = \Excel::load($path)->get();

            if ($data->count()) {

                foreach ($data as $key => $value) {

                    if (
                        (isset($value['alkod'])) && (isset($value['asm_alokyl'])) && (isset($value['rkm_hoy_alokyl'])) &&
                        (isset($value['sbb_alokal']))) {

                        $arr[] = [
                            'code' => $value['alkod'],
                            'first_name' => $value['asm_alokyl'],
                            'id_number' => $value['rkm_hoy_alokyl'],
                            'representative_reason' => $value['sbb_alokal'],
                        ];
                    }
                }
                if (!empty($arr)) {
                    foreach ($arr as $value) {
                        $familyData['code'] = $value['code'];

                        $personData['representative_reason'] = $value['representative_reason'];
                        $personData['first_name'] = $value['first_name'];
                        $personData['id_number'] = $value['id_number'];


                        $family = Family::where(['code' => $familyData['code']])->first();
                        if (!is_null($family)) {
                            $person = Person::create([
                                'first_name' => $personData['first_name'],
                                'id_number' => $personData['id_number'],
                            ]);
                            $family->update(['representative_id' => $person->id, 'representative_reason' => $value['representative_reason']]);

                        }
                    }
                }

                return back();

            } else {
                return redirect('admin/families')->with('error', 'لم يتم تحميل الملف بنجاح');
            }
        }
    }

    public function searcherNoteTurkey(Request $request)
    {

        if ($request->hasFile('file')) {

            $request->validate([
                'file' => 'required|mimes:csv,txt'
            ]);

            $path = $request->file('file')->getRealPath();
            $data = \Excel::load($path)->get();

            if ($data->count()) {

                foreach ($data as $key => $value) {

                    if (
                        (isset($value['alkod'])) && (isset($value['tarykh_alzyarh'])) && (isset($value['altkyym_altrky']))) {

                        $arr[] = [
                            'code' => $value['alkod'],
                            'note_turkey' => $value['altkyym_altrky'],
                            'visit_date' => $value['tarykh_alzyarh'],
                        ];
                    }
                }
                if (!empty($arr)) {
                    foreach ($arr as $value) {
                        $familyData['code'] = $value['code'];
                        $familyData['note_turkey'] = $value['note_turkey'];
                        $familyData['visit_date'] = $value['visit_date'];

                        $family = Family::where(['code' => $familyData['code']])->first();
                        if (!is_null($family)) {
                            $family->update(['note_turkey' => $familyData['note_turkey']]);

                        }
                    }
                }

                return back();

            } else {
                return redirect('admin/families')->with('error', 'لم يتم تحميل الملف بنجاح');
            }
        }
    }


 public function delete_visit($id)
    {
        if (!is_null($id)) {
            $family = Family::whereNotNull('parent_id')->find($id);
            if ($family) {


                if (!is_null($family)) {

                    $parent_id=$family->parent_id;
                    $name = $family->code;
                    
                    
                    FamilySearcher::where('family_id', $id)->delete();
                    FamilyIncome::where('family_id', $id)->delete();
                    FamilyMemberDiseases::where('family_id', $id)->delete();
                    FamilyMedia::where('family_id', $id)->delete();
                    TaskFamily::where('family_id', $id)->delete();
                    Task::where('family_id', $id)->delete();
                    Person::find($family->person_id)->delete();
                    $family->delete();
                    event(new NewLogCreated('تم حذف زيارة بنجاح ', $name, 67, 0, null));
                    return redirect('admin/families/archive/'.$parent_id)->with('success', 'تم حذف زيارة بنجاح');



                    event(new NewLogCreated('لم يتم حذف زيارة بنجاح  ', $name, 67, 0, null));
                    return redirect('admin/families/archive/'.$parent_id)->with('error', 'لم يتم حذف زيارة بنجاح  ');

                } else {
                    event(new NewLogCreated('لم يتم العثور على  مكفول بنجاح برقم : ', $id, 67, 0, null));
                    return redirect('admin/families/archive/'.$parent_id)->with('error', 'لم يتم العثور على  زيارة بنجاح');
                }
            } else {
                event(new NewLogCreated('لم يتم العثور على  زيارة بنجاح برقم : ', $id, 67, 0, null));
                return redirect('admin/families/archive/'.$parent_id)->with('error', 'لم يتم العثور على  زيارة بنجاح');
            }
        } else {
            event(new NewLogCreated('لم يتم العثور على  زيارة بنجاح برقم : ', $id, 67, 0, null));
            return redirect('admin/families/archive/'.$parent_id)->with('error', 'لم يتم العثور على  زيارة بنجاح');
        }
    }

    public function delete($id)
    {
        if (!is_null($id)) {
            $family = Family::find($id);
            if ($family) {
                $parent_id = $family->parent_id;
                if ($parent_id)
                    $family = Family::find($parent_id);


                if (!is_null($family)) {

                    if (($family->season_coupons->first()) || ($family->season_coupon_families->first())
                        || ($family->urgent_coupons->first()) || ($family->expense_details->first())) {
                        event(new NewLogCreated('لم يتم حذف   الأسرة  بنجاح لان لها مساعدات او صرفيات ', $family->person->name, 114, 0, null));
                        return redirect('admin/families')->with('error', 'لم يتم حذف   أسرة بنجاح لأن لها مساعدات أو صرفيات ');

                    }
                    $name = $family->code;


                    $childs = $family->childs()->get();
                    foreach ($childs as $child) {
                        FamilySearcher::where('family_id', $child->id)->delete();
                        FamilyIncome::where('family_id', $child->id)->delete();
                        FamilyMemberDiseases::where('family_id', $child->id)->delete();
                        FamilyMedia::where('family_id', $child->id)->delete();
                        TaskFamily::where('family_id', $child->id)->delete();
                        Task::where('family_id', $child->id)->delete();
                        Person::find($child->person_id)->delete();
                        $child->delete();
                    }

                    FamilySearcher::where('family_id', $id)->delete();
                    FamilyIncome::where('family_id', $id)->delete();
                    FamilyMemberDiseases::where('family_id', $id)->delete();
                    FamilyMedia::where('family_id', $id)->delete();
                    TaskFamily::where('family_id', $id)->delete();
                    Task::where('family_id', $id)->delete();
                    Person::find($family->person_id)->delete();
                    $family->delete();
                    event(new NewLogCreated('تم حذف مكفول بنجاح ', $name, 67, 0, null));
                    return redirect('admin/families')->with('success', 'تم حذف مكفول بنجاح');


                    event(new NewLogCreated('لم يتم حذف مكفول بنجاح  ', $name, 67, 0, null));
                    return redirect('admin/families')->with('error', 'لم يتم حذف مكفول بنجاح  ');

                } else {
                    event(new NewLogCreated('لم يتم العثور على  مكفول بنجاح برقم : ', $id, 67, 0, null));
                    return redirect('admin/families')->with('error', 'لم يتم العثور على  مكفول بنجاح');
                }
            } else {
                event(new NewLogCreated('لم يتم العثور على  مكفول بنجاح برقم : ', $id, 67, 0, null));
                return redirect('admin/families')->with('error', 'لم يتم العثور على  مكفول بنجاح');
            }
        } else {
            event(new NewLogCreated('لم يتم العثور على  مكفول بنجاح برقم : ', $id, 67, 0, null));
            return redirect('admin/families')->with('error', 'لم يتم العثور على  مكفول بنجاح');
        }
    }

    public function exportFamilies(Request $request)
    {
        $request['id'] = array_filter(explode(",", $request['the_ids']));

        if (isset($request['allVisitExcel'])) {
            if (!is_null($request['id'])) {
                $families = Family::whereIn('id', $request['id'])/*->where(['family_type_id' => 7, 'parent_id' => null])*/
                ->get();
            } else {
                $families = Family::/*where(['family_type_id' => 7, 'parent_id' => null])->*/
                where('parent_id', null)
                    ->get();
            }
            $this->exportAllExcelVisit($families);
        } else if (isset($request['allYTMExcel'])) {

            if (!is_null($request['id'])) {
                $families = Family::whereIn('id', $request['id'])
                    ->get();
            } else {
                $families = Family::where('family_type_id', 5)
                    ->where('parent_id', null)
                    ->get();
            }

            $this->exportAllExcelYTM($families);
        }
        if (isset($request['allVisitPDF'])) {
            $families = collect();

            if ($request['id']) {
                $families = Family::whereIn('id', $request['id'])->get();
            }
            return $this->exportAllTurkeyVisit($families);

        } else if (isset($request['allYTMPDF'])) {

            $families = collect();
            if (!is_null($request['id'])) {
                $families = Family::whereIn('id', $request['id'])->get();
            }

            return $this->exportAllYTMPDF($families);

        } else if (isset($request['allVisitWord'])) {

            $families = collect();

            if (!is_null($request['id'])) {
                $families = Family::whereIn('id', $request['id'])->get();
            }


            return $this->exportAllWordVisit($families);

        } else if (isset($request['allYTMWord'])) {

            $families = collect();
            if (!is_null($request['id'])) {
                $families = Family::whereIn('id', $request['id'])->get();
            }
            return $this->exportAllWordYTM($families);
        } else {
            return back();
        }
    }

    public function YTMTemplateDownload()
    {
        $header = $this->YTMHeaderTemplate();
        $this->exportExcelYTMTemplate($header, 'نموذج يتيم');
    }

    public function YTMHeaderTemplate()
    {
        return $header = ["الاسم", "اسم الاب ", "اسم الجد", " اسم العائلة",
            "رقم الهوية", "تاريخ الميلاد", "مكان الميلاد", "الجنس",
            "عدد الافراد", "سبب وفاة الاب", "تاريخ الوفاة", "سبب وفاة الام", "تاريخ الوفاة للام", "المستوى التعليمي",
            "المرحلة التعليمية", "المدينة", "العنوان", "اسم الوكيل", "اسم الاب للوكيل", "اسم الجد للوكيل", "اسم العائلة للوكيل",
            "درجة القرابة للوكيل", "مهنة الوكيل", "رقم هوية الوكيل",
            "رقم جوال 1", "رقم جوال 2", "وضع الاسرة",
            "الاسم 1", "اسم العائلة 1", "تاريخ الميلاد 1",
            "الاسم 2", "اسم العائلة 2", "تاريخ الميلاد 2",
            "الاسم 3", "اسم العائلة 3", "تاريخ الميلاد 3",
            "الاسم 4", "اسم العائلة 4", "تاريخ الميلاد 4",
            "الاسم 5", "اسم العائلة 5", "تاريخ الميلاد 5",
            "الاسم 6", "اسم العائلة 6", "تاريخ الميلاد 6",
            "الاسم 7", "اسم العائلة 7", "تاريخ الميلاد 7",
            "الاسم 8", "اسم العائلة 8", "تاريخ الميلاد 8",
            "الاسم 9", "اسم العائلة 9", "تاريخ الميلاد 9",
            "الاسم 10", "اسم العائلة 10", "تاريخ الميلاد 10",
            "الاسم 11", "اسم العائلة 11", "تاريخ الميلاد 11",
            "الاسم 12", "اسم العائلة 12", "تاريخ الميلاد 12",
        ];
    }

    public function YTMHeader()
    {
        return $header = ["الكود", "الاسم", "اسم الاب ", "اسم الجد", " اسم العائلة",
            "رقم الهوية", "سنه الميلاد", "مكان الميلاد", "الجنس",
            "عدد الافراد", "سبب وفاة الاب", "تاريخ الوفاة", "سبب وفاة الام", "تاريخ الوفاة للام", "المستوى التعليمي",
            "المرحلة التعليمية", "المدينة", "العنوان", "اسم الوكيل", "اسم الاب للوكيل", "اسم الجد للوكيل", "اسم العائلة للوكيل",
            "درجة القرابة للوكيل", "مهنة الوكيل", "رقم هوية الوكيل",
            "رقم جوال 1", "رقم جوال 2", "وضع الاسرة",
            "الاسم 1", "اسم العائلة 1", "تاريخ الميلاد 1",
            "الاسم 2", "اسم العائلة 2", "تاريخ الميلاد 2",
            "الاسم 3", "اسم العائلة 3", "تاريخ الميلاد 3",
            "الاسم 4", "اسم العائلة 4", "تاريخ الميلاد 4",
            "الاسم 5", "اسم العائلة 5", "تاريخ الميلاد 5",
            "الاسم 6", "اسم العائلة 6", "تاريخ الميلاد 6",
            "الاسم 7", "اسم العائلة 7", "تاريخ الميلاد 7",
            "الاسم 8", "اسم العائلة 8", "تاريخ الميلاد 8",
            "الاسم 9", "اسم العائلة 9", "تاريخ الميلاد 9",
            "الاسم 10", "اسم العائلة 10", "تاريخ الميلاد 10",
            "الاسم 11", "اسم العائلة 11", "تاريخ الميلاد 11",
            "الاسم 12", "اسم العائلة 12", "تاريخ الميلاد 12",
        ];
    }

    public function exportExcelYTMTemplate($header, $name)
    {
        $qualifications = Qualification::all();
        $cities = City::all();
        $countries = Country::all();
        $qualificationLevels = QualificationLevels::all();
        $relationships = Relationship::all();
        $jobTypes = JobType::all();
        $governorates = Governorate::all();
        $genders = Gender::all();

        Excel::create($name, function ($excel) use ($header, $genders, $governorates, $qualifications, $cities, $countries, $qualificationLevels, $relationships, $jobTypes) {

            $excel->sheet('الايتام', function ($sheet) use ($header, $genders, $governorates, $qualifications, $cities, $countries, $qualificationLevels, $relationships, $jobTypes) {

                $sheet->getStyle('A1')->applyFromArray(array(
                    'fill' => array(
                        'type' => \PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => 'FF0000')
                    )
                ));
                $sheet->getStyle('B1')->applyFromArray(array(
                    'fill' => array(
                        'type' => \PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => 'FF0000')
                    )
                ));
                $sheet->getStyle('C1')->applyFromArray(array(
                    'fill' => array(
                        'type' => \PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => 'FF0000')
                    )
                ));
                $sheet->getStyle('D1')->applyFromArray(array(
                    'fill' => array(
                        'type' => \PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => 'FF0000')
                    )
                ));
                $sheet->getStyle('E1')->applyFromArray(array(
                    'fill' => array(
                        'type' => \PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => 'FF0000')
                    )
                ));

                $this->dropDown($sheet, $countries, 'G', 'name', 'nameG', 'AAG', 2);
                $this->dropDown($sheet, $genders, 'H', 'name', 'nameH', 'AAH', 2);
                $this->dropDown($sheet, $qualifications, 'N', 'name', 'nameN', 'AAN', 2);
                $this->dropDown($sheet, $qualificationLevels, 'O', 'name', 'nameO', 'AAO', 2);
                $this->dropDown($sheet, $governorates, 'P', 'name', 'nameP', 'AAP', 2);
                $this->dropDown($sheet, $relationships, 'V', 'name', 'nameV', 'AAV', 2);
                $this->dropDown($sheet, $jobTypes, 'W', 'name', 'nameW', 'AAW', 2);

                $sheet->setOrientation('landscape');
                $sheet->fromArray($header, NULL, 'A1');
                $sheet->freezeFirstRowAndColumn();
                $sheet->setColumnFormat(array(
                    'F' => 'dd-mm-yyyy',
                    'K' => 'dd-mm-yyyy',
                    'M' => 'dd-mm-yyyy',
                    'AD' => 'dd-mm-yyyy',
                    'AG' => 'dd-mm-yyyy',
                    'AJ' => 'dd-mm-yyyy',
                    'AM' => 'dd-mm-yyyy',
                    'AP' => 'dd-mm-yyyy',
                    'AS' => 'dd-mm-yyyy',
                    'AV' => 'dd-mm-yyyy',
                    'AY' => 'dd-mm-yyyy',
                    'BB' => 'dd-mm-yyyy',
                    'BE' => 'dd-mm-yyyy',
                    'BH' => 'dd-mm-yyyy',
                    'BK' => 'dd-mm-yyyy',
                ));
            });

        })->download('xlsx');
    }

    public function exportItemExcelYTM($id)
    {
        $families = Family::where('id', $id)->get();
        $header = $this->YTMHeader();
        $this->exportExcelYTM($families, $header, 'الايتام');
    }

    public function exportAllExcelYTM($families)
    {
        $header = $this->YTMHeader();
        $this->exportExcelYTM($families, $header, 'الايتام');
    }

    public function exportExcelYTM($families, $header, $name)
    {

        Excel::create($name, function ($excel) use ($families, $header) {

            $excel->sheet('الايتام', function ($sheet) use ($families, $header) {

                $allRows = array();

                foreach ($families as $item) {
                    $person = $item->person;
                    $mainData = [
                        $item->code,
                        $person->first_name,
                        $person->second_name,
                        $person->third_name,
                        $person->family_name,
                        $person->id_number,
                        $person->date_of_birth,
                        isset($person->birthPlace) ? $person->birthPlace->name : null,
                        $item->gender == 'M' ? 'ذكر' : 'أنثى',
                        $item->member_count,
                        $item->father_death_reason,
                        $item->father_death_date,
                        $item->mother_death_reason,
                        $item->mother_death_date,
                        isset($person->qualificationLevel) ? $person->qualificationLevel->name : null,
                        isset($person->qualification) ? $person->qualification->name : null,
                        isset($item->governorate) ? $item->governorate->name : null,
                        $item->address,
                        isset($item->representative) ? $item->representative->first_name : null,
                        isset($item->representative) ? $item->representative->second_name : null,
                        isset($item->representative) ? $item->representative->third_name : null,
                        isset($item->representative) ? $item->representative->family_name : null,
                        isset($item->representative_relationship) ? $item->representative_relationship->name : null,
                        isset($item->representativeJobType) ? $item->representativeJobType->name : null,
                        isset($item->representative) ? $item->representative->id_number : null,
                        $item->mobile_one,
                        $item->mobile_two,
                        $item->note,
                    ];

                    if (isset($item->members)) {
                        foreach ($item->members as $member) {
                            $personMember = $member->person;

                            $newMemberData = [
                                $personMember->first_name,
                                $personMember->family_name,
                                $personMember->date_of_birth,
                            ];

                            array_push($mainData, $newMemberData);
                        }
                    }
                    array_push($allRows, collect($mainData)->flatten());
                }


                $newArray = collect($allRows)->toArray();

                foreach ($newArray as $key => $item) {
                    $sheet->row($key + 2, $item);
                }

                $sheet->setOrientation('landscape');
                $sheet->fromArray($header, NULL, 'A1');
                $sheet->freezeFirstRowAndColumn();
            });

        })->download('xlsx');
    }

    function getDirContents($dir, &$results = array())
    {
        set_time_limit(0);
        $files = scandir($dir);
        foreach ($files as $key => $value) {
            set_time_limit(0);
            $path = realpath($dir . DIRECTORY_SEPARATOR . $value);

            if (!is_dir($path)) {
                if (($value != '.DS_Store') && ($value != 'Thumbs.db')) {

                    $str_arr = preg_split("/\//", $dir);
                    $codeOrName = basename(collect($str_arr)->last());
                    $count = count($str_arr);
                    $fileTypeId = null;

                    $family = Family::whereNull('parent_id')
                        ->where(function ($q) use ($codeOrName) {
                            $q->where(['code' => $codeOrName])
                                ->orWhereHas('person', function ($q) use ($codeOrName) {
                                    $q->where(['full_name' => $codeOrName])
                                        ->orWhere(['full_name_tr' => $codeOrName])
                                        ->orWhere(['id_number' => $codeOrName]);
                                });
                        })->first();


                    if (!is_null($family)) {

                        if (strpos($value, 'AsLE') === 0) {
                            $fileTypeId = 2;
                        } else if ((strpos($value, 'RAPORU') === 0) || (strpos($value, 'SAaLIK') === 0)) {
                            $fileTypeId = 3;
                        } else if (strpos($value, 'EV') === 0) {
                            $fileTypeId = 4;
                        } else if (strpos($value, 'VEFAT') === 0) {
                            $fileTypeId = 5;
                        } else if (strpos($value, 'KİRA') === 0) {
                            $fileTypeId = 7;
                        } else if ((strpos($value, 'ÖĞRENCİ') === 0)) {
                            $fileTypeId = 8;
                        } else if ((strpos($value, 'KİMLİK') === 0) || (strpos($value, 'KsMLsK') === 0)) {
                            $fileTypeId = 9;
                        } else if (strpos($value, 'YIKIMA') === 0) {
                            $fileTypeId = 10;
                        } else if (strpos($value, 'HASAR') === 0) {
                            $fileTypeId = 11;
                        } else if (strpos($value, 'BOŞANMA') === 0) {
                            $fileTypeId = 12;
                        } else if (strpos($value, 'mektubu') === 0) {
                            $fileTypeId = 13;
                        }


                        $familyId = $family->id;
                        $pathCheck = 'uploads/attachments/' . $familyId;
                        if (!file_exists($pathCheck)) {
                            File::makeDirectory($pathCheck, $mode = 0777, true, true);
                        }
                        $filename = basename($value);
                        $no = 'C:\\xampp\\htdocs\\kafalaty2\\kafalaty2\\public\\';
                        $path2 = str_replace($no, '', $path);
                        $extintion = pathinfo($path2, PATHINFO_EXTENSION);
                        $new_name = rand() . "." . $extintion;
                        try {
                            Storage::disk('real_public')->move($path2, $pathCheck . '/' . $new_name);


                            FamilyMedia::create([
                                'file_type_id' => $fileTypeId,
                                'family_id' => $family->id,
                                'path' => $familyId . '/' . $new_name,//$codeOrName . '/' . $value
                            ]);
                        } catch (\League\Flysystem\FileNotFoundException $e1) {
                            continue;
                        }
                        $family->update(['full_name' => null]);

                    }
                    // $results[] = ['path' => $path, 'size' => filesize($path)];
                }
            } else if (($value != ".") && ($value != "..")) {

                $this->getDirContents($path, $results);
                $results[] = ['path' => $path, 'size' => filesize($path)];
            }
        }
        return $results;
    }

    public function visitMedia()
    {
        $this->getDirContents(public_path('uploads/attachments'));
        return back();
    }


    function getDirContents2($dir, &$results = array())
    {
        set_time_limit(0);
        $files = scandir($dir);
        foreach ($files as $key => $value) {
            set_time_limit(0);
            $path = realpath($dir . DIRECTORY_SEPARATOR . $value);

            if (!is_dir($path)) {

                if (($value != '.DS_Store') && ($value != 'Thumbs.db')) {

                    $old_name = basename($value);
                    $no = 'C:\\xampp\\htdocs\\kafalaty2\\kafalaty2\\public\\';
                    $path2 = str_replace($no, '', $path);
                    $extintion = pathinfo($path2, PATHINFO_EXTENSION);
                    $str_arr = preg_split("/\//", $dir);
                    $familyId = basename(collect($str_arr)->last());


                    if ($extintion != 'docx')
                        continue;

                    $exist = FamilyMedia::where('path', "=", $familyId . '/' . $old_name)->first();
                    if ($exist)
                        continue;

                    $new_name = rand() . "." . $extintion;

                    $str_arr = preg_split("/\//", $dir);
                    $count = count($str_arr);


                    $pathCheck = 'uploads/attachments/' . $familyId;
                    if (!file_exists($pathCheck)) {
                        File::makeDirectory($pathCheck, $mode = 0777, true, true);
                    }
                    try {
                        Storage::disk('real_public')->move($path2, $pathCheck . '/' . $new_name);

                        if (strpos($value, 'AsLE') === 0) {
                            $fileTypeId = 2;
                        } else if ((strpos($value, 'RAPORU') === 0) || (strpos($value, 'SAaLIK') === 0)) {
                            $fileTypeId = 3;
                        } else if (strpos($value, 'EV') === 0) {
                            $fileTypeId = 4;
                        } else if (strpos($value, 'VEFAT') === 0) {
                            $fileTypeId = 5;
                        } else if (strpos($value, 'KİRA') === 0) {
                            $fileTypeId = 7;
                        } else if ((strpos($value, 'ÖĞRENCİ') === 0)) {
                            $fileTypeId = 8;
                        } else if ((strpos($value, 'KİMLİK') === 0) || (strpos($value, 'KsMLsK') === 0)) {
                            $fileTypeId = 9;
                        } else if (strpos($value, 'YIKIMA') === 0) {
                            $fileTypeId = 10;
                        } else if (strpos($value, 'HASAR') === 0) {
                            $fileTypeId = 11;
                        } else if (strpos($value, 'BOŞANMA') === 0) {
                            $fileTypeId = 12;
                        } else if (strpos($value, 'mektubu') === 0) {
                            $fileTypeId = 13;
                        } else {
                            $fileTypeId = null;
                        }


                        FamilyMedia::create([
                            'file_type_id' => $fileTypeId,
                            'family_id' => $familyId,
                            'path' => $familyId . '/' . $new_name,//$codeOrName . '/' . $value
                        ]);
                    } catch (\League\Flysystem\FileNotFoundException $e1) {
                        continue;
                    }


                }
                // $results[] = ['path' => $path, 'size' => filesize($path)];
            } else if (($value != ".") && ($value != "..")) {

                $this->getDirContents2($path, $results);
                $results[] = ['path' => $path, 'size' => filesize($path)];
            }

        }
        return $results;
    }

    public function visitMedia2()
    {
        $this->getDirContents2(public_path('uploads/attachments'));
        return back();
    }

    function str2int($string)
    {
        $length = strlen($string);
        for ($i = 0, $int = ''; $i < $length; $i++) {
            if (is_numeric($string[$i]))
                $int .= $string[$i];
            else break;
        }
        return (int)$int;
    }

    function startsWithNumber($string)
    {
        return strlen($string) > 0 && ctype_digit(substr($string, 0, 1));
    }

    public function exportAllWordYTM($families)
    {
        $path = public_path('word_templates_results/ytm');
        if (!file_exists($path)) {
            Storage::disk('real_public')->makeDirectory('word_templates_results/ytm/');
        }
        // delete old files
        $oldFiles = \Illuminate\Support\Facades\File::allfiles($path);

        foreach ($oldFiles as $file) {
            \Illuminate\Support\Facades\File::delete(public_path('word_templates_results/ytm/' . $file->getRelativePathname()));
        }

        if (!($families)->isEmpty()) {

            foreach ($families as $item) {

                $family = $item;
                $parent = Family::find($family->id);
                $settings = Setting::whereIn('key', ['sessionEnd', 'footer', 'name', 'number_one', 'number_two', 'logo', 'address', 'fax', 'phone', 'email', 'facebook', 'twitter', 'youtube', 'welcomeBackground', 'welcomeMainText', 'welcomeSubText', 'welcomeReadMoreLink', 'welcomeReadMoreText'])->get();

                $name = $settings->where('key', 'name')->first();
                $address = $settings->where('key', 'address')->first();
                $phone = $settings->where('key', 'phone')->first();
                $email = $settings->where('key', 'email')->first();

                $parent->update(['is_sent' => 1]);

                $person = isset($family->person) ? $family->person : null;
                $representative = isset($family->representative) ? $family->representative : null;
                $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor(public_path('word_templates/ytm.docx'));

                // family table
                $templateProcessor->setValue('group_number', $family->group_number);
                $templateProcessor->setValue('id_number', !is_null($person) ? $person->id_number : '-');
                $templateProcessor->setValue('first_name', !is_null($person) ? $person->first_name_tr : '-');
                $templateProcessor->setValue('father_name', !is_null($person) ? $person->second_name_tr : '-');
                $templateProcessor->setValue('birth_of_date', !is_null($person) ? $person->date_of_birth : '-');
                $templateProcessor->setValue('place_of_birth', !is_null($person) ? isset($person->birthPlace) ? $person->birthPlace->name_tr : '-' : '-');
                $templateProcessor->setValue('gender', !is_null($person) ? ($person->gander == 'M' ? 'erkek' : 'kadın') : '-');
                $templateProcessor->setValue('mobile_one', $family->mobile_one);
                $templateProcessor->setValue('mobile_two', $family->mobile_two);
                $templateProcessor->setValue('father_death_reason', $family->father_death_reason);
                $templateProcessor->setValue('father_death_date', (!is_null($family->father_death_date_old)) ? $family->father_death_date_old : $family->father_death_date);
                $templateProcessor->setValue('mother_death_reason', $family->mother_death_reason);
                $templateProcessor->setValue('mother_death_date', (!is_null($family->mother_death_date_old)) ? $family->mother_death_date_old : $family->mother_death_date);
                $templateProcessor->setValue('address', $family->address);
                $templateProcessor->setValue('qualification', ((!is_null($person)) && (isset($person->qualification)) && (!is_null($person->qualification))) ? $person->qualification->name_tr : '-');
                $templateProcessor->setValue('qualification_level', ((!is_null($person)) && (isset($person->qualificationLevel)) && (!is_null($person->qualificationLevel))) ? $person->qualificationLevel->name_tr : '-');
                $templateProcessor->setValue('note_turkey', $family->note_turkey);

                $templateProcessor->setValue('representative_first_name', (!is_null($representative)) ? $representative->first_name : '-');
                $templateProcessor->setValue('representative_family_name', (!is_null($representative)) ? $representative->family_name : '-');
                $templateProcessor->setValue('representative_relationship', (isset($family->representative_relationship)) ? $family->representative_relationship->name_tr : '-');
                $templateProcessor->setValue('representative_status', (!is_null($representative)) ? ((!is_null($representative->work)) ? ($representative->work == 0 ? 'çalışmıyor' : 'eserler') : '-') : '-');
                $templateProcessor->setValue('email', (!is_null($person)) ? $person->email : "-");

                // yardim info
                $templateProcessor->setValue('yardim_name', $name->value);
                $templateProcessor->setValue('yardim_mail', $email->value);
                $templateProcessor->setValue('yardim_phone', $phone->value);
                $templateProcessor->setValue('yardim_address', $address->value);

                // members table
                $templateProcessor->cloneRow('id', count($family->members));
                $membersCollection = isset($family->members) ? $family->members : collect();

                $i = 1;
                foreach ($membersCollection->sortBy('date_of_birth') as $item) {
                    $personMember = isset($item->person) ? $item->person : null;
                    $templateProcessor->setValue('id#' . $i, $i);
                    $templateProcessor->setValue('member_first_name#' . $i, !is_null($personMember) ? $personMember->first_name_tr : '-');
                    $templateProcessor->setValue('member_family_name#' . $i, !is_null($personMember) ? $personMember->family_name_tr : '-');
                    $templateProcessor->setValue('member_age#' . $i, !is_null($personMember) ? $personMember->date_of_birth : '-');
                    $i++;
                }

                // save doc to public results path
                $templateProcessor->saveAs(public_path('word_templates_results/ytm/' . $family->id . '.docx'));
            }


            $files = \Illuminate\Support\Facades\File::allfiles($path);

            return view('admin.family.export.word.ytm', compact('files'));

        } else {
            return redirect('admin/families')->with('error', 'لم يتم العثور على  مكفول بنجاح');
        }
    }

    public function exportItemWordTurkeyYTM($id)
    {
        if (!is_null($id)) {
            $parent = Family::find($id);


            $parent_id = $parent->parent_id;
            if ($parent_id) {
                $parent = Family::where('id', $parent_id)->first();
            }


            if (!is_null($parent)) {
                $family = $parent;
                if (!is_null($family)) {

                    $settings = Setting::whereIn('key', ['sessionEnd', 'footer', 'name', 'number_one', 'number_two', 'logo', 'address', 'fax', 'phone', 'email', 'facebook', 'twitter', 'youtube', 'welcomeBackground', 'welcomeMainText', 'welcomeSubText', 'welcomeReadMoreLink', 'welcomeReadMoreText'])->get();

                    $name = $settings->where('key', 'name')->first();
                    $address = $settings->where('key', 'address')->first();
                    $phone = $settings->where('key', 'phone')->first();
                    $email = $settings->where('key', 'email')->first();

                    $parent->update(['is_sent' => 1]);

                    $person = isset($family->person) ? $family->person : null;
                    $representative = isset($family->representative) ? $family->representative : null;
                    $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor(public_path('word_templates/ytm.docx'));

                    // family table
                    $templateProcessor->setValue('group_number', $family->group_number);
                    $templateProcessor->setValue('id_number', !is_null($person) ? $person->id_number : '-');
                    $templateProcessor->setValue('first_name', !is_null($person) ? $person->first_name_tr : '-');
                    $templateProcessor->setValue('father_name', !is_null($person) ? $person->second_name_tr : '-');
                    $templateProcessor->setValue('birth_of_date', !is_null($person) ? $person->date_of_birth : '-');
                    $templateProcessor->setValue('place_of_birth', !is_null($person) ? isset($person->birthPlace) ? $person->birthPlace->name_tr : '-' : '-');
                    $templateProcessor->setValue('gender', !is_null($person) ? ($person->gander == 'M' ? 'erkek' : 'kadın') : '-');
                    $templateProcessor->setValue('mobile_one', $family->mobile_one);
                    $templateProcessor->setValue('mobile_two', $family->mobile_one);
                    $templateProcessor->setValue('father_death_reason', $family->father_death_reason);
                    $templateProcessor->setValue('father_death_date', (!is_null($family->father_death_date_old)) ? $family->father_death_date_old : $family->father_death_date);
                    $templateProcessor->setValue('mother_death_reason', $family->mother_death_reason);
                    $templateProcessor->setValue('mother_death_date', (!is_null($family->mother_death_date_old)) ? $family->mother_death_date_old : $family->mother_death_date);
                    $templateProcessor->setValue('address', $family->address);
                    $templateProcessor->setValue('qualification', ((!is_null($person)) && (isset($person->qualification)) && (!is_null($person->qualification))) ? $person->qualification->name_tr : '-');
                    $templateProcessor->setValue('qualification_level', ((!is_null($person)) && (isset($person->qualificationLevel)) && (!is_null($person->qualificationLevel))) ? $person->qualificationLevel->name_tr : '-');
                    $templateProcessor->setValue('note_turkey', $family->note_turkey);

                    $templateProcessor->setValue('representative_first_name', (!is_null($representative)) ? $representative->first_name : '-');
                    $templateProcessor->setValue('representative_family_name', (!is_null($representative)) ? $representative->family_name : '-');
                    $templateProcessor->setValue('representative_relationship', (isset($family->representative_relationship)) ? $family->representative_relationship->name_tr : '-');
                    $templateProcessor->setValue('representative_status', (!is_null($representative)) ? ((!is_null($representative->work)) ? ($representative->work == 0 ? 'çalışmıyor' : 'eserler') : '-') : '-');
                    $templateProcessor->setValue('email', (!is_null($person)) ? $person->email : "-");

                    // yardim info
                    $templateProcessor->setValue('yardim_name', $name->value);
                    $templateProcessor->setValue('yardim_mail', $email->value);
                    $templateProcessor->setValue('yardim_phone', $phone->value);
                    $templateProcessor->setValue('yardim_address', $address->value);

                    // members table
                    $templateProcessor->cloneRow('id', count($family->members));
                    $membersCollection = isset($family->members) ? $family->members : collect();

                    $i = 1;
                    foreach ($membersCollection->sortBy('date_of_birth') as $item) {
                        $personMember = isset($item->person) ? $item->person : null;
                        $templateProcessor->setValue('id#' . $i, $i);
                        $templateProcessor->setValue('member_first_name#' . $i, !is_null($personMember) ? $personMember->first_name_tr : '-');
                        $templateProcessor->setValue('member_family_name#' . $i, !is_null($personMember) ? $personMember->family_name_tr : '-');
                        $templateProcessor->setValue('member_age#' . $i, !is_null($personMember) ? $personMember->date_of_birth : '-');
                        $i++;
                    }

                    $path = public_path('word_templates_results/ytm/');
                    if (!file_exists($path)) {
                        Storage::disk('real_public')->makeDirectory('word_templates_results/ytm/');
                    }
                    // delete old files
                    $oldFiles = \Illuminate\Support\Facades\File::allfiles($path);

                    foreach ($oldFiles as $file) {
                        \Illuminate\Support\Facades\File::delete(public_path('word_templates_results/ytm/' . $file->getRelativePathname()));
                    }

                    // save doc to public results path
                    $templateProcessor->saveAs(public_path('word_templates_results/ytm/' . $family->id . '.docx'));

                    $files = \Illuminate\Support\Facades\File::allfiles($path);

                    return view('admin.family.export.word.ytm', compact('files', 'family'));

                } else {
                    return redirect('admin/families')->with('error', 'لم يتم العثور على  مكفول بنجاح');
                }
            } else {
                return redirect('admin/families')->with('error', 'لم يتم العثور على  مكفول بنجاح');
            }
        } else {
            return redirect('admin/families')->with('error', 'لم يتم العثور على  مكفول بنجاح');
        }
    }

    public function exportItemWordTurkeyVisit($id)
    {
        if (!is_null($id)) {
            $parent = Family::find($id);

            $parent_id = $parent->parent_id;
            if ($parent_id) {
                $parent = Family::where('id', $parent_id)->first();
            }


            if (!is_null($parent)) {
                $family = $parent;
                if (!is_null($family)) {

                    $parent->update(['is_sent' => 1]);
                    $relationShip = Relationship::find(14);

                    $person = isset($family->person) ? $family->person : null;


                    $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor(public_path('word_templates/visit.docx'));

                    // family table
                    $templateProcessor->setValue('code', $family->code);
                    $templateProcessor->setValue('family_name_tr', !is_null($person) ? $person->full_name_tr : '-');
                    $templateProcessor->setValue('family_status', isset($family->status) ? !is_null($family->status->name_tr) ? $family->status->name_tr : '-' : '-');
                    $templateProcessor->setValue('city', isset($family->city) ? $family->city->name_tr : '-');
                    $templateProcessor->setValue('neighborhood', isset($family->neighborhood) ? $family->neighborhood->name_tr : '-');
                    $templateProcessor->setValue('id_number', !is_null($person) ? $person->id_number : '-');
                    $templateProcessor->setValue('mobile_one', $family->mobile_one);
                    $templateProcessor->setValue('mobile_two', $family->mobile_two);
                    $templateProcessor->setValue('telphone', $family->telephone);
                    $templateProcessor->setValue('job_type', isset($family->person->work) ? isset($family->job_type) ? $family->job_type->name_tr : '-' : '-');
                    $templateProcessor->setValue('visit_date', $family->visit_date);
                    $templateProcessor->setValue('student_id', $family->id_university);
                    $templateProcessor->setValue('main_first_name', !is_null($person) ? $person->first_name_tr : '-');
                    $templateProcessor->setValue('main_age', !is_null($person) ? $person->date_of_birth : '-');
                    $templateProcessor->setValue('main_relationship', !is_null($relationShip) ? $relationShip->name_tr : '-');
                    $templateProcessor->setValue('main_health', (!is_null($person) && (!is_null($person->health))) ? $person->health == 0 ? 'SAĞLAM' : 'HASTA' : '-');
                    $templateProcessor->setValue('main_qualification', ((!is_null($person)) && (isset($person->qualification)) && (!is_null($person->qualification))) ? $person->qualification->name_tr : '-');
                    $templateProcessor->setValue('note_turkey', $family->note_turkey);

                    // members table
                    $templateProcessor->cloneRow('id', count($family->members));
                    $membersCollection = isset($family->members) ? $family->members : collect();

                    $i = 1;
                    foreach ($membersCollection->sortBy('date_of_birth') as $item) {
                        $personMember = isset($item->person) ? $item->person : null;
                        $templateProcessor->setValue('id#' . $i, $i);
                        $templateProcessor->setValue('first_name#' . $i, !is_null($personMember) ? $personMember->first_name_tr : '-');
                        $templateProcessor->setValue('age#' . $i, !is_null($personMember) ? $personMember->date_of_birth : '-');
                        $templateProcessor->setValue('relationship#' . $i, isset($item->relationship) ? $item->relationship->name_tr : null);
                        $templateProcessor->setValue('health#' . $i, (!is_null($personMember) && (!is_null($personMember->health))) ? $personMember->health == 0 ? 'SAĞLAM' : 'HASTA' : '-');
                        $templateProcessor->setValue('qualification#' . $i, ((!is_null($personMember)) && (isset($personMember->qualification)) && (!is_null($personMember->qualification))) ? $personMember->qualification->name_tr : '-');
                        $i++;
                    }

                    $path = public_path('word_templates_results/visit/');
                    if (!file_exists($path)) {
                        Storage::disk('real_public')->makeDirectory('word_templates_results/visit/');
                    }

                    // delete old files
                    $oldFiles = \Illuminate\Support\Facades\File::allfiles($path);

                    foreach ($oldFiles as $file) {
                        \Illuminate\Support\Facades\File::delete(public_path('word_templates_results/visit/' . $file->getRelativePathname()));
                    }

                    // save doc to public results path
                    $templateProcessor->saveAs(public_path('word_templates_results/visit/' . $family->id . '.docx'));

                    $files = \Illuminate\Support\Facades\File::allfiles($path);

                    return view('admin.family.export.word.visit', compact('files', 'family'));

                } else {
                    return redirect('admin/families')->with('error', 'لم يتم العثور على  مكفول بنجاح');
                }
            } else {
                return redirect('admin/families')->with('error', 'لم يتم العثور على  مكفول بنجاح');
            }
        } else {
            return redirect('admin/families')->with('error', 'لم يتم العثور على  مكفول بنجاح');
        }
    }

    public function exportAllWordVisit($families)
    {
        $path = public_path('word_templates_results/visit/');
        if (!file_exists($path)) {
            Storage::disk('real_public')->makeDirectory('word_templates_results/visit/');
        }
        // delete old files
        $oldFiles = \Illuminate\Support\Facades\File::allfiles($path);

        foreach ($oldFiles as $file) {
            \Illuminate\Support\Facades\File::delete(public_path('word_templates_results/visit/' . $file->getRelativePathname()));
        }

        $relationShip = Relationship::find(14);

        if (!($families)->isEmpty()) {

            foreach ($families as $item) {
                $family = $item;
                $parent = Family::find($family->id);
                $parent->update(['is_sent' => 1]);

                $person = isset($family->person) ? $family->person : null;
                $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor(public_path('word_templates/visit.docx'));

                // family table
                $templateProcessor->setValue('code', $family->code);
                $templateProcessor->setValue('family_name_tr', !is_null($person) ? $person->full_name_tr : '-');
                $templateProcessor->setValue('family_status', isset($family->status) ? !is_null($family->status->name_tr) ? $family->status->name_tr : '-' : '-');
                $templateProcessor->setValue('city', isset($family->city) ? $family->city->name_tr : '-');
                $templateProcessor->setValue('neighborhood', isset($family->neighborhood) ? $family->neighborhood->name_tr : '-');
                $templateProcessor->setValue('id_number', !is_null($person) ? $person->id_number : '-');
                $templateProcessor->setValue('mobile_one', $family->mobile_one);
                $templateProcessor->setValue('mobile_two', $family->mobile_one);
                $templateProcessor->setValue('telphone', $family->telephone);
                $templateProcessor->setValue('job_type', isset($family->job_type) ? $family->job_type->name_tr : '-');
                $templateProcessor->setValue('visit_date', $family->visit_date);
                $templateProcessor->setValue('student_id', $family->id_university);
                $templateProcessor->setValue('main_first_name', !is_null($person) ? $person->first_name_tr : '-');
                $templateProcessor->setValue('main_age', !is_null($person) ? $person->date_of_birth : '-');
                $templateProcessor->setValue('main_relationship', !is_null($relationShip) ? $relationShip->name_tr : '-');
                $templateProcessor->setValue('main_health', (!is_null($person) && (!is_null($person->health))) ? $person->health == 0 ? 'SAĞLAM' : 'HASTA' : '-');
                $templateProcessor->setValue('main_qualification', ((!is_null($person)) && (isset($person->qualification)) && (!is_null($person->qualification))) ? $person->qualification->name_tr : '-');
                $templateProcessor->setValue('note_turkey', $family->note_turkey);

                // members table
                $templateProcessor->cloneRow('id', count($family->members));
                $membersCollection = isset($family->members) ? $family->members : collect();

                $i = 1;
                foreach ($membersCollection->sortBy('date_of_birth') as $item) {
                    $personMember = isset($item->person) ? $item->person : null;
                    $templateProcessor->setValue('id#' . $i, $i);
                    $templateProcessor->setValue('first_name#' . $i, !is_null($personMember) ? $personMember->first_name_tr : '-');
                    $templateProcessor->setValue('age#' . $i, !is_null($personMember) ? $personMember->date_of_birth : '-');
                    $templateProcessor->setValue('relationship#' . $i, isset($item->relationship) ? $item->relationship->name_tr : null);
                    $templateProcessor->setValue('health#' . $i, (!is_null($personMember) && (!is_null($personMember->health))) ? $personMember->health == 0 ? 'SAĞLAM' : 'HASTA' : '-');
                    $templateProcessor->setValue('qualification#' . $i, ((!is_null($personMember)) && (isset($personMember->qualification)) && (!is_null($personMember->qualification))) ? $personMember->qualification->name_tr : '-');
                    $i++;
                }

                // save doc to public results path
                $templateProcessor->saveAs(public_path('word_templates_results/visit/' . $family->id . '.docx'));
            }


            $files = \Illuminate\Support\Facades\File::allfiles($path);

            return view('admin.family.export.word.visit', compact('files'));

        } else {
            return redirect('admin/families')->with('error', 'لم يتم العثور على  مكفول بنجاح');
        }
    }

    public function exportAllTurkeyVisit($families)
    {
        if (!($families)->isEmpty()) {
            $relationShip = Relationship::find(14);

            $pdf = PDF::loadView('admin.family.export.pdf.visit.visitAll', compact('families', 'relationShip'));
            return $pdf->download('VISIT' . '.pdf');

        } else {
            return redirect('admin/families')->with('error', 'لم يتم العثور على  مكفول بنجاح');
        }
    }

    public function exportItemTurkeyYTM($id)
    {
        if (!is_null($id)) {
            $parent = Family::find($id);

            $parent_id = $parent->parent_id;
            if ($parent_id) {
                $parent = Family::where('id', $parent_id)->first();
            }

            if (!is_null($parent)) {
                $family = $parent;
                if (!is_null($family)) {

                    $parent->update(['is_sent' => 1]);

                    $pdf = PDF::loadView('admin.family.export.pdf.ytm.ytm', compact('family'));
                    return $pdf->download('YTM' . '.pdf');
                }
            }
        }
    }

    public function exportAllYTMPDF($families)
    {
        $pdf = PDF::loadView('admin.family.export.pdf.ytm.ytmAll', compact('families'));
        return $pdf->download('YTM' . '.pdf');
    }

    public function exportItemTurkeyVisit($id)
    {
        if (!is_null($id)) {
            $parent = Family::find($id);

            $parent_id = $parent->parent_id;
            if ($parent_id) {
                $parent = Family::where('id', $parent_id)->first();
            }

            if (!is_null($parent)) {
                $family = $parent;
                if (!is_null($family)) {

                    $parent->update(['is_sent' => 1]);
                    $relationShip = Relationship::find(14);

                    $person = isset($family->person) ? $family->person : null;

                    $pdf = PDF::loadView('admin.family.export.pdf.visit.visit', compact('family', 'relationShip', 'person'));
                    return $pdf->download('VISIT' . '.pdf');
                } else {
                    return redirect('admin/families')->with('error', 'لم يتم العثور على  مكفول بنجاح');
                }
            } else {
                return redirect('admin/families')->with('error', 'لم يتم العثور على  مكفول بنجاح');
            }
        }
    }

    public function exportAllPDF()
    {

        $family = Family::all();

        if (!is_null($family)) {
//            if($family->family_type_id == 2){
            $pdf = PDF::loadView('admin.family.exportYTM', compact('family'));
//            }
//            $pdf = PDF::loadView('admin.family.exportTurkey', compact('family'));
            return $pdf->download('all' . '.pdf');
        }
    }

    public function exportItemExcelVisit($id)
    {
        $families = Family::find($id);
        $header = $this->visitHeader();
        $this->exportExcelVisit($families, $header, 'VISIT');
    }

    public function exportAllExcelVisit($families)
    {
        $header = $this->visitHeader();
        $this->exportExcelVisit($families, $header, 'الزيارات');
    }

    public static function dropDown($sheet, $table, $callValue, $name, $nameRange, $col, $i)
    {
        foreach ($table as $value) {
            $sheet->SetCellValue($col . $i, $value->id . '-' . $value->$name);
            $i++;
        }

        $sheet->_parent->addNamedRange(
            new \PHPExcel_NamedRange(
                $nameRange, $sheet, $col . '2:' . $col . '10000'
            )
        );

        for ($c = 2; $c <= 50; $c++) {
            $objValidation = $sheet->getCell($callValue . $c)->getDataValidation();
            $objValidation->setType(\PHPExcel_Cell_DataValidation::TYPE_LIST);
            $objValidation->setErrorStyle(\PHPExcel_Cell_DataValidation::STYLE_INFORMATION);
            $objValidation->setAllowBlank(false);
            $objValidation->setShowInputMessage(true);
            $objValidation->setShowErrorMessage(true);
            $objValidation->setShowDropDown(true);
            $objValidation->setErrorTitle('المدخل غير صحيح');
            $objValidation->setError('القيمه غير موجودة في القائمة المنسدلة');
            $objValidation->setPromptTitle('القائمة المنسدلة');
            $objValidation->setPrompt('اختر العنصر من القائمة المنسدلة');
            $objValidation->setFormula1($nameRange);
        }
    }

    public function getBirthDay($year, $age)
    {
        if (($year != '') && ($age != '')) {
            if ((is_numeric($year)) && (is_numeric($age))) {
                return $year - $age;
            }
        }
        return null;
    }

    public function checkTranslation($first_name, $first_name_tr, $second_name, $second_name_tr, $third_name, $third_name_tr, $family_name, $family_name_tr)
    {
        $allTranslations = NameTranslation::all();

        if (($first_name != null) && ($first_name_tr != null)) {
            $the_name = NameTranslation::where(['arabic' => $first_name])->first();

            //dd($first_name_tr != $the_name->turkey);
            if (!($the_name)) {
                $name_id = NameTranslation::create([
                    'arabic' => $first_name,
                    'turkey' => $first_name_tr,
                ])->id;
                $action = Action::create(['title' => 'ترجمة جديدة تحتاج مراجعة', 'type' => 'إدارة الترجمات', 'link' => Permission::findByName('list nameTranslations')->link . "/" . $name_id . "/edit"]);
                $users = User::permission('create nameTranslations')->get();
                if ($users->first())
                    Notification::send($users, new NotifyUsers($action));

            } elseif ($the_name && $first_name_tr != $the_name->turkey) {

                $name = NameTranslation::where(['arabic' => $first_name])->first();
                $name->update([
                    'arabic' => $first_name,
                    'turkey' => $first_name_tr,
                ]);
                $name_id = $name->id;
                $action = Action::create(['title' => 'ترجمة جديدة تحتاج مراجعة', 'type' => 'إدارة الترجمات', 'link' => Permission::findByName('list nameTranslations')->link . "/" . $name_id . "/edit"]);
                $users = User::permission('create nameTranslations')->get();
                if ($users->first())
                    Notification::send($users, new NotifyUsers($action));
            }
        }

        if (($second_name != null) && ($second_name_tr != null)) {

            $the_name = NameTranslation::where(['arabic' => $second_name])->first();
            if (!($the_name)) {
                $name_id = NameTranslation::create([
                    'arabic' => $second_name,
                    'turkey' => $second_name_tr,
                ])->id;
                $action = Action::create(['title' => 'ترجمة جديدة تحتاج مراجعة', 'type' => 'إدارة الترجمات', 'link' => Permission::findByName('list nameTranslations')->link . "/" . $name_id . "/edit"]);
                $users = User::permission('create nameTranslations')->get();
                if ($users->first())
                    Notification::send($users, new NotifyUsers($action));
            } elseif ($the_name && $second_name_tr != $the_name->turkey) {
                $name = NameTranslation::where(['arabic' => $second_name])->first();
                $name->update([
                    'arabic' => $second_name,
                    'turkey' => $second_name_tr,
                ]);
                $name_id = $name->id;
                $action = Action::create(['title' => 'ترجمة جديدة تحتاج مراجعة', 'type' => 'إدارة الترجمات', 'link' => Permission::findByName('list nameTranslations')->link . "/" . $name_id . "/edit"]);
                $users = User::permission('create nameTranslations')->get();
                if ($users->first())
                    Notification::send($users, new NotifyUsers($action));
            }
        }

        if (($third_name != null) && ($third_name_tr != null)) {
            $the_name = NameTranslation::where(['arabic' => $third_name])->first();

            if (!($the_name)) {
                $name_id = NameTranslation::create([
                    'arabic' => $third_name,
                    'turkey' => $third_name_tr,
                ])->id;
                $action = Action::create(['title' => 'ترجمة جديدة تحتاج مراجعة', 'type' => 'إدارة الترجمات', 'link' => Permission::findByName('list nameTranslations')->link . "/" . $name_id . "/edit"]);
                $users = User::permission('create nameTranslations')->get();
                if ($users->first())
                    Notification::send($users, new NotifyUsers($action));
            } elseif ($the_name && $third_name_tr != $the_name->turkey) {
                $name = NameTranslation::where(['arabic' => $third_name])->first();
                $name->update([
                    'arabic' => $third_name,
                    'turkey' => $third_name_tr,
                ]);
                $name_id = $name->id;
                $action = Action::create(['title' => 'ترجمة جديدة تحتاج مراجعة', 'type' => 'إدارة الترجمات', 'link' => Permission::findByName('list nameTranslations')->link . "/" . $name_id . "/edit"]);
                $users = User::permission('create nameTranslations')->get();
                if ($users->first())
                    Notification::send($users, new NotifyUsers($action));
            }
        }

        if (($family_name != null) && ($family_name_tr != null)) {
            $the_name = NameTranslation::where(['arabic' => $family_name])->first();
            if (!($the_name)) {
                $name_id = NameTranslation::create([
                    'arabic' => $family_name,
                    'turkey' => $family_name_tr,
                ])->id;
                $action = Action::create(['title' => 'ترجمة جديدة تحتاج مراجعة', 'type' => 'إدارة الترجمات', 'link' => Permission::findByName('list nameTranslations')->link . "/" . $name_id . "/edit"]);
                $users = User::permission('create nameTranslations')->get();
                if ($users->first())
                    Notification::send($users, new NotifyUsers($action));
            } elseif ($the_name && $family_name_tr != $the_name->turkey) {
                $name = NameTranslation::where(['arabic' => $family_name])->first();
                $name->update([
                    'arabic' => $family_name,
                    'turkey' => $family_name_tr,
                ]);
                $name_id = $name->id;
                $action = Action::create(['title' => 'ترجمة جديدة تحتاج مراجعة', 'type' => 'إدارة الترجمات', 'link' => Permission::findByName('list nameTranslations')->link . "/" . $name_id . "/edit"]);
                $users = User::permission('create nameTranslations')->get();
                if ($users->first())
                    Notification::send($users, new NotifyUsers($action));
            }
        }

    }

    public function archiveVisitCountIssue()
    {
        // 1 // ytm
        $allFamilies = Family::with(['person'])->where(['family_project_id' => 2])->get();
        foreach ($allFamilies as $person) {
            $full_name = $person->person->full_name;
            $person->update(['full_name' => $full_name]);

        }

        // 2
        $allFamilies = Family::whereNotNull('full_name')->where('hidden', 0)->get()->groupBy('full_name');
        foreach ($allFamilies as $group) {

            $lastYear = $group->first();

            $parentId = !is_null($lastYear) ? $lastYear->id : null;

            $i = 1;
            foreach ($group->sortBy('year') as $familyItem) {

                if (!is_null($parentId)) {
                    $familyItem->update(['visit_count' => $i++,
                        'parent_id' => $parentId,
                        'archive' => 1,
                        'approve' => 1,
                        'full_name' => null
                    ]);
                } else {
                    $familyItem->update(['visit_count' => $i++,
                        'archive' => 1,
                        'approve' => 1,
                        'full_name' => null
                    ]);
                }

            }
            $i++;

            if (!is_null($lastYear->person_id)) {
                $personOLd = Person::find($lastYear->person_id);

                $newPerson = $personOLd->replicate();
                $newPerson->save();

                $newItem = $lastYear->replicate();
                $newItem->save();
                $newItem->update(['parent_id' => null,
                    'person_id' => $newPerson->id,
                    'archive' => 0,
                    'approve' => 0,
                    'visit_count' => $newItem->visit_count + 1,
                ]);

                $childFamily = Family::where('parent_id', $parentId)->get();

                foreach ($childFamily as $value) {
                    $value->update(['parent_id' => $newItem->id]);
                }
            }

        }

        // 3 //visit
        $allFamilies = Family::where(['hidden' => 0, 'family_project_id' => 1, 'visit_count' => 1, 'parent_id' => null])->get();
        foreach ($allFamilies as $person) {
            $full_name = $person->person->full_name;
            $person->update(['full_name' => $full_name]);

        }

        // 4
        $allFamilies = Family::whereNotNull('full_name')->where('hidden', 0)->get()->groupBy('full_name');
        foreach ($allFamilies as $group) {

            if (count($group) == 1) {
                $lastYear = $group->first();

                $parentId = !is_null($lastYear) ? $lastYear->id : null;

                $i = 1;

                if (!is_null($parentId)) {
                    $lastYear->update(['visit_count' => $i++,
                        'parent_id' => $parentId,
                        'archive' => 1,
                        'approve' => 1,
                        'full_name' => null,
                    ]);
                } else {
                    $lastYear->update(['visit_count' => $i++,
                        'archive' => 1,
                        'approve' => 1,
                        'full_name' => null,
                    ]);
                }


                $i++;


                if (!is_null($lastYear->person_id)) {
                    $personOLd = Person::find($lastYear->person_id);

                    $newPerson = $personOLd->replicate();
                    $newPerson->save();

                    $newItem = $lastYear->replicate();
                    $newItem->save();
                    $newItem->update(['parent_id' => null,
                        'person_id' => $newPerson->id,
                        'archive' => 0,
                        'approve' => 0,
                        'visit_count' => $newItem->visit_count + 1,
                    ]);

                    $childFamily = Family::where('parent_id', $parentId)->get();

                    foreach ($childFamily as $value) {
                        $value->update(['parent_id' => $newItem->id]);
                    }
                }

            } else {
                $lastYear = $group->sortBy('year')->last();

                $parentId = !is_null($lastYear) ? $lastYear->id : null;

                $i = 1;
                foreach ($group->sortBy('year') as $familyItem) {

                    if (!is_null($parentId)) {
                        $familyItem->update(['visit_count' => $i++,
                            'parent_id' => $parentId,
                            'archive' => 1,
                            'approve' => 1,
                            'full_name' => null

                        ]);
                    } else {
                        $familyItem->update(['visit_count' => $i++,
                            'archive' => 1,
                            'approve' => 1,
                            'full_name' => null

                        ]);
                    }

                }
                $i++;

                if (!is_null($lastYear->person_id)) {
                    $personOLd = Person::find($lastYear->person_id);

                    $newPerson = $personOLd->replicate();
                    $newPerson->save();

                    $newItem = $lastYear->replicate();
                    $newItem->save();
                    $newItem->update(['parent_id' => null,
                        'person_id' => $newPerson->id,
                        'archive' => 0,
                        'approve' => 0,
                        'visit_count' => $newItem->visit_count + 1,
                    ]);

                    $childFamily = Family::where('parent_id', $parentId)->get();

                    foreach ($childFamily as $value) {
                        $value->update(['parent_id' => $newItem->id]);
                    }
                }

            }
        }
    }

    public function families_ajax(Request $request)
    {
        $q = $request['q'];
        $families = Family::query()
            ->whereNull('parent_id')
            ->join('persons', 'families.person_id', '=', 'persons.id')
            ->whereHas('person'
                , function ($query) use ($q) {
                    $query->where('full_name', 'like', '%' . $q . '%')
                        ->orWhere('id_number', 'like', '%' . $q . '%');
                })
            ->orWhere('code', 'like', '%' . $q . '%')
            ->whereNull('families.parent_id')
            ->select([
                'families.id',
                DB::raw("CONCAT(COALESCE(`persons`.`full_name`,''), ' - ',COALESCE(`families`.`code`,''), ' - ', COALESCE(`persons`.`id_number` ,'')) as text")
            ])
            ->distinct();

        //dd($families->take(10)->get());
        // dd($families->take(10)->get());

        if ($families->first()) {
            return json_encode($families->take(10)->get());
        } else {
            return ['q' => $q];
        }
    }

    public function families_ajax_id(Request $request)
    {
        $q = $request['q'];
        $families = Family::whereHas('person')->whereNull('parent_id')->where('id', $q);
        if ($families->first())
            return $families->with('person')->first();
        else {
            return ['q' => $q];
        }
    }

    public function person_ajax_id(Request $request)
    {
        $q = $request['q'];
        $persons = Person::where('id', $q);
        if ($persons->first())
            return $persons->with('diseases', 'member')->first();
        else {
            return ['q' => $q];
        }
    }

    public function getImportVisit()
    {
        return view('admin.family.import.importVisit');
    }

    public function getImportYTM()
    {
        return view('admin.family.import.importYTM');
    }

    public function importHiddenVisit(Request $request)
    {

        if ($request->hasFile('file')) {

            $request->validate([
                'file' => 'required|mimes:csv,txt'
            ]);

            $path = $request->file('file')->getRealPath();
            $data = \Excel::load($path)->get();

            if ($data->count()) {

                foreach ($data as $key => $value) {

                    if (
                        (isset($value['alkod'])) && (isset($value['rkm_alhoy'])) && (isset($value['asm_alhal'])) &&
                        (isset($value['asm_alhal_baltrky']))) {

                        $arr[] = [
                            'code' => $value['alkod'],
                            'full_name' => $value['asm_alhal'],
                            'full_name_tr' => $value['asm_alhal_baltrky'],
                            'id_number' => $value['rkm_alhoy'],
                        ];
                    }
                }
                if (!empty($arr)) {
                    foreach ($arr as $value) {
                        $personData['full_name'] = $value['full_name'];
                        $personData['full_name_tr'] = $value['full_name_tr'];
                        $personData['id_number'] = $value['id_number'];

                        $familyData['code'] = $value['code'];
                        $familyData['hidden'] = 1;
                        $familyData['visit_reason_id'] = 1;
                        $familyData['is_imported'] = 1;
                        $familyData['family_project_id'] = 1;
                        $familyData['family_classification_id'] = 1;

                        $personData['full_name_tr'] = $request['first_name_tr'] . ' ' . $request['second_name_tr'] . ' ' . $request['third_name_tr'] . ' ' . $request['family_name_tr'];
                        $checkFound = $this->checkFound($personData['id_number'], $personData['full_name_tr']);

                        if ($checkFound === false)
                            continue;

                        if ($checkFound > 0 && $checkFound !== true) {
                            $oldFamily = Family::find($checkFound);
                            $existPerson = $oldFamily->person;

                            $oldFamily->update($familyData);
                            $existPerson->update($personData);

                        } elseif ($checkFound === true) {
                            $person = Person::create($personData);

                            if ($person) {
                                $familyData['person_id'] = $person->id;
                                $familyData['visit_count'] = 1;
                                Family::create($familyData);

                            }
                        } else {
                            continue;
                        }
                    }
                }

                return back();

            } else {
                return redirect('admin/families')->with('error', 'لم يتم تحميل الملف بنجاح');
            }
        }
    }

    public function importOldYTM(Request $request)
    {

        $message = '';
        $type = '';

        if ($request->hasFile('file')) {

            $request->validate([
                'file' => 'required|mimes:csv,txt'
            ]);

            $path = $request->file('file')->getRealPath();
            $data = \Excel::load($path)->get();
            if ($data->count()) {

                foreach ($data as $key => $value) {
                    $arr[] = [
                        // person
                        'first_name' => $value['alasm'],
                        'second_name' => $value['asm_alab'],
                        'third_name' => $value['asm_aljd'],
                        'family_name' => $value['asm_alaaael'],
                        'full_name' => $value['alasm_kaml'],
                        'id_number' => $value['hoy_alytym'],
                        'date_of_birth' => $value['tarykh_almylad_alytym'],
                        'gender' => $value['aljns'],
                        'qualification_id' => $value['almrhl_altaalymy'],
                        'qualification_level_id' => $value['almstoy_altaalymy_llytym'],

                        // family
                        'code' => $value['alkod'],
                        'father_death_reason' => $value['sbb_ofa_alab'],
                        'father_death_date_old' => $value['tarykh_alofa'],
                        'mother_death_reason' => $value['sbb_ofa_alam'],
                        'mother_death_date_old' => $value['tarykh_alofa_llam'],
                        'address' => $value['alaanoan'],
                        'note' => $value['odaa_alasr'],
                        'governorate_id' => $value['almdyn'],
                        'mobile_two' => $value['rkm_joal_1'],
                        'mobile_one' => $value['rkm_joal_2'],

                        // representative
                        'representative_first_name' => $value['alasm_alokyl'],
                        'representative_family_name' => $value['asm_alaaael_llokyl'],
                        'representative_relationship_id' => $value['drj_alkrab_llokyl'],
                        'representative_job_type_id' => $value['almhn_alokyl'],
                        'representative_full_name' => $value['asm_oly_alamr_rbaaay'],
                        'representative_id_number' => $value['rkm_hoy_oly_alamr'],

                        // members
                        'member_first_name_1' => $value['alasm_1'],
                        'member_family_name_1' => $value['asm_alaaael_1'],
                        'member_date_of_birth_1' => $value['tarykh_almylad_1'],

                        'member_first_name_2' => $value['alasm_2'],
                        'member_family_name_2' => $value['asm_alaaael_2'],
                        'member_date_of_birth_2' => $value['tarykh_almylad_2'],

                        'member_first_name_3' => $value['alasm_3'],
                        'member_family_name_3' => $value['asm_alaaael_3'],
                        'member_date_of_birth_3' => $value['tarykh_almylad_3'],

                        'member_first_name_4' => $value['alasm_4'],
                        'member_family_name_4' => $value['asm_alaaael_4'],
                        'member_date_of_birth_4' => $value['tarykh_almylad_4'],

                        'member_first_name_5' => $value['alasm_5'],
                        'member_family_name_5' => $value['asm_alaaael_5'],
                        'member_date_of_birth_5' => $value['tarykh_almylad_5'],

                        'member_first_name_6' => $value['alasm_6'],
                        'member_family_name_6' => $value['asm_alaaael_6'],
                        'member_date_of_birth_6' => $value['tarykh_almylad_6'],

                        'member_first_name_7' => $value['alasm_7'],
                        'member_family_name_7' => $value['asm_alaaael_7'],
                        'member_date_of_birth_7' => $value['tarykh_almylad_7'],

                        'member_first_name_8' => $value['alasm_8'],
                        'member_family_name_8' => $value['asm_alaaael_8'],
                        'member_date_of_birth_8' => $value['tarykh_almylad_8'],

                        'member_first_name_9' => $value['alasm_9'],
                        'member_family_name_9' => $value['asm_alaaael_9'],
                        'member_date_of_birth_9' => $value['tarykh_almylad_9'],

                        'member_first_name_10' => $value['alasm_10'],
                        'member_family_name_10' => $value['asm_alaaael_10'],
                        'member_date_of_birth_10' => $value['tarykh_almylad_10'],

                        'member_first_name_11' => $value['alasm_11'],
                        'member_family_name_11' => $value['asm_alaaael_11'],
                        'member_date_of_birth_11' => $value['tarykh_almylad_11'],

                        'member_first_name_12' => $value['alasm_12'],
                        'member_family_name_12' => $value['asm_alaaael_12'],
                        'member_date_of_birth_12' => $value['tarykh_almylad_12'],

                    ];
                }

                if (!empty($arr)) {
                    foreach ($arr as $value) {

                        // person data
                        $personData['first_name'] = $value['first_name'];
                        $personData['second_name'] = $value['second_name'];
                        $personData['third_name'] = $value['third_name'];
                        $personData['family_name'] = $value['family_name'];
                        $personData['full_name'] = $value['full_name'];
                        $personData['id_number'] = $value['id_number'];
                        $personData['date_of_birth'] = !is_null($value['date_of_birth']) ? substr($value['date_of_birth'], -4) : null;
                        $personData['date_of_birth_place'] = 1;
                        $personData['gender'] = $value['gender'];
                        $personData['qualification_id'] = $value['qualification_id'];
                        $personData['qualification_level_id'] = $value['qualification_level_id'];

                        // family data
                        $familyData['code'] = $value['code'];
                        $familyData['father_death_reason'] = $value['father_death_reason'];
                        $familyData['father_death_date_old'] = $value['father_death_date_old'];
                        $familyData['mother_death_reason'] = $value['mother_death_reason'];
                        $familyData['mother_death_date_old'] = $value['mother_death_date_old'];
                        $familyData['address'] = $value['address'];
                        $familyData['note'] = $value['note'];
                        $familyData['mobile_one'] = $value['mobile_one'];
                        $familyData['mobile_two'] = $value['mobile_two'];
                        $familyData['governorate_id'] = $value['governorate_id'];
                        $familyData['visit_reason_id'] = 6; // visit
                        $familyData['family_project_id'] = 2; // ytm
                        $familyData['family_type_id'] = 5; // ytm
                        $familyData['visit_count'] = 1;
                        $familyData['data_entry_id'] = 1;
                        $familyData['family_classification_id'] = 1;
                        // representative family data
                        $familyData['representative_relationship_id'] = $value['representative_relationship_id'];
                        $familyData['representative_job_type_id'] = $value['representative_job_type_id'];

                        // representative data
                        $representativeData['full_name'] = $value['representative_full_name'];
                        $representativeData['first_name'] = $value['representative_first_name'];
                        $representativeData['family_name'] = $value['representative_family_name'];
                        $representativeData['id_number'] = $value['representative_id_number'];

                        $personData['full_name_tr'] = $request['first_name_tr'] . ' ' . $request['second_name_tr'] . ' ' . $request['third_name_tr'] . ' ' . $request['family_name_tr'];
                        $checkFound = $this->checkFound($personData['id_number'], $personData['full_name_tr']);

                        if ($checkFound === false)
                            continue;

                        if ($checkFound > 0 && $checkFound !== true) {
                            $oldFamily = Family::find($checkFound);
                            $existPerson = $oldFamily->person;

                            if ((!is_null($oldFamily))) {
                                $existPerson->update($personData);

                                $representative = Person::where('id_number', '<>', '')
                                    ->where('id_number', '=', $representativeData['id_number'])->first();

                                if (!is_null($representative)) {
                                    $representative->update($representativeData);
                                    $familyData['representative_id'] = $representative->id;
                                } else {
                                    $representative = Person::create($representativeData);
                                    $familyData['representative_id'] = $representative->id;
                                }

                                $familyData['visit_count'] = $oldFamily->visit_count + 1;
                                $oldFamily->update($familyData);


                                if ((isset($oldFamily->member)) && (!($oldFamily->member)->isEmpty())) {

                                    foreach ($oldFamily->member as $member) {
                                        $person = isset($member->person) ? $member->person : null;
                                        if (!is_null($person)) {
                                            $member->delete();
                                            $person->delete();
                                        }
                                    }
                                }

                                for ($i = 1; $i <= 12; $i++) {
                                    $allMemberData['first_name'] = $value['member_first_name_' . $i];
                                    $allMemberData['family_name'] = $value['member_family_name_' . $i];
                                    $allMemberData['date_of_birth'] = !is_null($value['member_date_of_birth_' . $i]) ? substr($value['member_date_of_birth_' . $i], -4) : null;

                                    if (($allMemberData['first_name'] != '') || ($allMemberData['family_name'] != '') || (($allMemberData['date_of_birth'] != ''))) {
                                        $memberPerson = Person::create($allMemberData);

                                        Member::create([
                                            'family_id' => $oldFamily->id,
                                            'person_id' => $memberPerson->id,
                                        ]);

                                    }
                                }
                            }

                        } elseif ($checkFound === true) {
                            $person = Person::create($personData);

                            if ($person) {
                                $familyData['person_id'] = $person->id;

                                $existRepresentative = Person::where('id_number', '<>', '')->where('id_number', '=', $representativeData['id_number'])->first();

                                if (!is_null($existRepresentative)) {
                                    $existRepresentative->update($representativeData);
                                    $familyData['representative_id'] = $existRepresentative->id;
                                } else {
                                    $representative = Person::create($representativeData);
                                    $familyData['representative_id'] = $representative->id;
                                }

                                $familyData['is_imported'] = 1;
                                $family = Family::create($familyData);

                                if ($family) {

                                    for ($i = 1; $i <= 12; $i++) {
                                        $allMemberData['first_name'] = $value['member_first_name_' . $i];
                                        $allMemberData['family_name'] = $value['member_family_name_' . $i];
                                        $allMemberData['date_of_birth'] = !is_null($value['member_date_of_birth_' . $i]) ? substr($value['member_date_of_birth_' . $i], -4) : null;

                                        if (($allMemberData['first_name'] != '') || ($allMemberData['family_name'] != '') || (($allMemberData['date_of_birth'] != ''))) {
                                            $memberPerson = Person::create($allMemberData);

                                            Member::create([
                                                'family_id' => $family->id,
                                                'person_id' => $memberPerson->id,
                                            ]);

                                        }
                                    }
                                }
                            }
                        } else {
                            continue;
                        }
                        $message = 'تم إضافة زيارات ايتام عن طريق ملف اكسل بنجاح';
                        $type = 'success';
                        event(new NewLogCreated($message, $personData['first_name'], 102, 0, null));
                    }
                }

                return redirect('admin/families')->with($type, $message);

            } else {
                $message = 'لم يتم إضافة زيارات ايتام عن طريق ملف اكسل بنجاح';

                event(new NewLogCreated($message, $request['first_name'], 102, 0, null));
                return redirect('admin/families')->with('error', $message);
            }

        } else {
            event(new NewLogCreated($message, null, 102, 0, null));
            return redirect('admin/families')->with('error', 'لم يتم إضافة زيارات ايتام عن طريق ملف اكسل بنجاح لعدم وجود بيانات');
        }
    }

    public function importOldVisit(Request $request)
    {
        $message = '';
        $type = '';
        $relations = Relationship::all();

        if ($request->hasFile('file')) {

            $path = $request->file('file')->getRealPath();
            $data = \Excel::load($path)->get();

            if ($data->count()) {

                foreach ($data as $key => $value) {
                    if (
                        (isset($value['alaaam'])) && (isset($value['rkm_alzyarh'])) &&
                        (isset($value['asm_albahth'])) && (isset($value['asm_albahth_2'])) && (isset($value['alkod'])) &&
                        (isset($value['rkm_alhoy'])) && (isset($value['tarykh_alzyar'])) && (isset($value['aljh_almrshh'])) &&
                        (isset($value['aadd_alzyarat'])) && (isset($value['asm_alhal'])) && (isset($value['alasm_alaol'])) &&
                        (isset($value['asm_alab'])) && (isset($value['asm_aljd'])) && (isset($value['asm_alaaael'])) &&
                        (isset($value['asm_alhal_baltrky'])) && (isset($value['alasm_alaol_baltrky'])) && (isset($value['asm_alab_baltrky'])) &&
                        (isset($value['asm_aljd_baltrky'])) && (isset($value['asm_alaaael_baltrky'])) && (isset($value['joal_1'])) && (isset($value['yhtaj_la_yhtaj'])) && (isset($value['sbb_alkfal'])) &&
                        (isset($value['joal_2'])) && (isset($value['hatf'])) && (isset($value['asm_alzoj_alzoj'])) && (isset($value['rkm_hoy_alzoj_alzoj'])) &&
                        (isset($value['alrkm_aljamaay'])) && (isset($value['altarykh_almtokaa_lltkhrj'])) && (isset($value['alhy_mntkh'])) && (isset($value['almdyn'])) &&
                        (isset($value['tfasyl_alaanoan'])) && (isset($value['yaamllayaaml'])) && (isset($value['almhn'])) &&
                        (isset($value['mlky_alskn'])) && (isset($value['hal_alskn'])) && (isset($value['odaa_alaaaelh'])) &&
                        (isset($value['msaaadat_akhry'])) && (isset($value['aldkhl_alshhry'])) && (isset($value['mlahthat'])) &&
                        (isset($value['tkym_albahth'])) && (isset($value['mrfkat'])) && (isset($value['aadd_afrad_alasr'])) &&
                        (isset($value['alasm_1'])) && (isset($value['alaamr_1'])) && (isset($value['alaamr_1'])) && (isset($value['alkrab_1'])) && (isset($value['alhal_1'])) &&
                        (isset($value['alasm_2'])) && (isset($value['alaamr_2'])) && (isset($value['alaamr_2'])) && (isset($value['alkrab_2'])) && (isset($value['alhal_2'])) &&
                        (isset($value['alasm_3'])) && (isset($value['alaamr_3'])) && (isset($value['alaamr_3'])) && (isset($value['alkrab_3'])) && (isset($value['alhal_3'])) &&
                        (isset($value['alasm_4'])) && (isset($value['alaamr_4'])) && (isset($value['alaamr_4'])) && (isset($value['alkrab_4'])) && (isset($value['alhal_4'])) &&
                        (isset($value['alasm_5'])) && (isset($value['alaamr_5'])) && (isset($value['alaamr_5'])) && (isset($value['alkrab_5'])) && (isset($value['alhal_5'])) &&
                        (isset($value['alasm_6'])) && (isset($value['alaamr_6'])) && (isset($value['alaamr_6'])) && (isset($value['alkrab_6'])) && (isset($value['alhal_6'])) &&
                        (isset($value['alasm_7'])) && (isset($value['alaamr_7'])) && (isset($value['alaamr_7'])) && (isset($value['alkrab_7'])) && (isset($value['alhal_7'])) &&
                        (isset($value['alasm_8'])) && (isset($value['alaamr_8'])) && (isset($value['alaamr_8'])) && (isset($value['alkrab_8'])) && (isset($value['alhal_8'])) &&
                        (isset($value['alasm_9'])) && (isset($value['alaamr_9'])) && (isset($value['alaamr_9'])) && (isset($value['alkrab_9'])) && (isset($value['alhal_9'])) &&
                        (isset($value['alasm_10'])) && (isset($value['alaamr_10'])) && (isset($value['alaamr_10'])) && (isset($value['alkrab_10'])) && (isset($value['alhal_10'])) &&
                        (isset($value['alasm_11'])) && (isset($value['alaamr_11'])) && (isset($value['alaamr_11'])) && (isset($value['alkrab_11'])) && (isset($value['alhal_11'])) &&
                        (isset($value['alasm_12'])) && (isset($value['alaamr_12'])) && (isset($value['alaamr_12'])) && (isset($value['alkrab_12'])) && (isset($value['alhal_12'])) &&
                        (isset($value['alasm_13'])) && (isset($value['alaamr_13'])) && (isset($value['alaamr_13'])) && (isset($value['alkrab_13'])) && (isset($value['alhal_13'])) &&
                        (isset($value['alasm_14'])) && (isset($value['alaamr_14'])) && (isset($value['alaamr_14'])) && (isset($value['alkrab_14'])) && (isset($value['alhal_14'])) &&
                        (isset($value['alasm_15'])) && (isset($value['alaamr_15'])) && (isset($value['alaamr_15'])) && (isset($value['alkrab_15'])) && (isset($value['alhal_15'])) &&
                        (isset($value['alasm_16'])) && (isset($value['alaamr_16'])) && (isset($value['alaamr_16'])) && (isset($value['alkrab_16'])) && (isset($value['alhal_16'])) &&
                        (isset($value['alasm_17'])) && (isset($value['alaamr_17'])) && (isset($value['alaamr_17'])) && (isset($value['alkrab_17'])) && (isset($value['alhal_17'])) &&
                        (isset($value['alasm_18'])) && (isset($value['alaamr_18'])) && (isset($value['alaamr_18'])) && (isset($value['alkrab_18'])) && (isset($value['alhal_18'])) &&
                        (isset($value['alasm_19'])) && (isset($value['alaamr_19'])) && (isset($value['alaamr_19'])) && (isset($value['alkrab_19'])) && (isset($value['alhal_19'])) &&
                        (isset($value['alasm_20'])) && (isset($value['alaamr_20'])) && (isset($value['alaamr_20'])) && (isset($value['alkrab_20'])) && (isset($value['alhal_20'])) &&
                        (isset($value['alasm_21'])) && (isset($value['alaamr_21'])) && (isset($value['alaamr_21'])) && (isset($value['alkrab_21'])) && (isset($value['alhal_21'])) &&
                        (isset($value['alasm_22'])) && (isset($value['alaamr_22'])) && (isset($value['alaamr_22'])) && (isset($value['alkrab_22'])) && (isset($value['alhal_23'])) &&
                        (isset($value['alasm_23'])) && (isset($value['alaamr_23'])) && (isset($value['alaamr_23'])) && (isset($value['alkrab_23'])) && (isset($value['alhal_23']))
                    ) {
                        $arr[] = [
                            'year' => $value['alaaam'],
                            'year_number' => $value['rkm_alzyarh'],
                            'searcher_id' => $value['asm_albahth'],
                            'searcher_id_2' => $value['asm_albahth_2'],
                            'code' => $value['alkod'] == '-' ? null : $value['alkod'],
                            'id_number' => $value['rkm_alhoy'],
                            'visit_date' => $value['tarykh_alzyar'],
                            'funded_institution_id' => $value['aljh_almrshh'],
                            'visit_count' => $value['aadd_alzyarat'],
                            'full_name' => $value['asm_alhal'],
                            'first_name' => $value['alasm_alaol'],
                            'second_name' => $value['asm_alab'],
                            'third_name' => $value['asm_aljd'],
                            'family_name' => $value['asm_alaaael'],
                            'full_name_tr' => $value['asm_alhal_baltrky'],
                            'first_name_tr' => $value['alasm_alaol_baltrky'],
                            'second_name_tr' => $value['asm_alab_baltrky'],
                            'third_name_tr' => $value['asm_aljd_baltrky'],
                            'family_name_tr' => $value['asm_alaaael_baltrky'],
                            'need' => $value['yhtaj_la_yhtaj'],
                            'family_type_id' => $value['sbb_alkfal'],
                            'mobile_one' => $value['joal_1'],
                            'mobile_two' => $value['joal_2'],
                            'phone' => $value['hatf'],
                            'wive_name' => $value['asm_alzoj_alzoj'],
                            'wive_id_number' => $value['rkm_hoy_alzoj_alzoj'],
                            'id_university' => $value['alrkm_aljamaay'],
                            'graduated_date' => $value['altarykh_almtokaa_lltkhrj'],
                            'city_id' => $value['almdyn'],
                            'neighborhood_id' => $value['alhy_mntkh'],
                            'address' => $value['tfasyl_alaanoan'],
                            'work' => $value['yaamllayaaml'] != '-' ? $value['yaamllayaaml'] : null,
                            'job_type_id' => $value['almhn'],
                            'house_ownership_id' => $value['mlky_alskn'],
                            'house_status_id' => $value['hal_alskn'],
                            'family_status_id' => $value['odaa_alaaaelh'],
                            'previous_income_coupon' => $value['msaaadat_akhry'],
                            'previous_income_value' => $value['aldkhl_alshhry'],
                            'note' => $value['mlahthat'],
                            'searcher_note' => $value['tkym_albahth'],
                            'old_attachment' => $value['mrfkat'],

                            'member_first_name_1' => $value['alasm_1'],
                            'date_of_birth_1' => ($value['alaamr_1'] != '') ? strlen($value['alaamr_1']) == 4 ? $value['alaamr_1'] : $this->getBirthDay($value['alaaam'], $value['alaamr_1']) : null,
                            'member_relationship_1' => $value['alkrab_1'],
                            'member_status_1' => $value['alhal_1'],

                            'member_first_name_2' => $value['alasm_2'],
                            'date_of_birth_2' => ($value['alaamr_2'] != '') ? strlen($value['alaamr_2']) == 4 ? $value['alaamr_2'] : $this->getBirthDay($value['alaaam'], $value['alaamr_2']) : null,
                            'member_relationship_2' => $value['alkrab_2'],
                            'member_status_2' => $value['alhal_2'],

                            'member_first_name_3' => $value['alasm_3'],
                            'date_of_birth_3' => ($value['alaamr_3'] != '') ? strlen($value['alaamr_3']) == 4 ? $value['alaamr_3'] : $this->getBirthDay($value['alaaam'], $value['alaamr_3']) : null,
                            'member_relationship_3' => $value['alkrab_3'],
                            'member_status_3' => $value['alhal_3'],

                            'member_first_name_4' => $value['alasm_4'],
                            'date_of_birth_4' => ($value['alaamr_4'] != '') ? strlen($value['alaamr_4']) == 4 ? $value['alaamr_4'] : $this->getBirthDay($value['alaaam'], $value['alaamr_4']) : null,
                            'member_relationship_4' => $value['alkrab_4'],
                            'member_status_4' => $value['alhal_4'],

                            'member_first_name_5' => $value['alasm_5'],
                            'date_of_birth_5' => ($value['alaamr_5'] != '') ? strlen($value['alaamr_5']) == 4 ? $value['alaamr_5'] : $this->getBirthDay($value['alaaam'], $value['alaamr_5']) : null,
                            'member_relationship_5' => $value['alkrab_5'],
                            'member_status_5' => $value['alhal_6'],

                            'member_first_name_6' => $value['alasm_6'],
                            'date_of_birth_6' => ($value['alaamr_6'] != '') ? strlen($value['alaamr_6']) == 4 ? $value['alaamr_6'] : $this->getBirthDay($value['alaaam'], $value['alaamr_6']) : null,
                            'member_relationship_6' => $value['alkrab_6'],
                            'member_status_6' => $value['alhal_6'],

                            'member_first_name_7' => $value['alasm_7'],
                            'date_of_birth_7' => ($value['alaamr_7'] != '') ? strlen($value['alaamr_7']) == 4 ? $value['alaamr_7'] : $this->getBirthDay($value['alaaam'], $value['alaamr_7']) : null,
                            'member_relationship_7' => $value['alkrab_7'],
                            'member_status_7' => $value['alhal_8'],

                            'member_first_name_8' => $value['alasm_8'],
                            'date_of_birth_8' => ($value['alaamr_8'] != '') ? strlen($value['alaamr_8']) == 4 ? $value['alaamr_8'] : $this->getBirthDay($value['alaaam'], $value['alaamr_8']) : null,
                            'member_relationship_8' => $value['alkrab_8'],
                            'member_status_8' => $value['alhal_8'],

                            'member_first_name_9' => $value['alasm_9'],
                            'date_of_birth_9' => ($value['alaamr_9'] != '') ? strlen($value['alaamr_9']) == 4 ? $value['alaamr_9'] : $this->getBirthDay($value['alaaam'], $value['alaamr_9']) : null,
                            'member_relationship_9' => $value['alkrab_9'],
                            'member_status_9' => $value['alhal_9'],

                            'member_first_name_10' => $value['alasm_10'],
                            'date_of_birth_10' => ($value['alaamr_10'] != '') ? strlen($value['alaamr_10']) == 4 ? $value['alaamr_10'] : $this->getBirthDay($value['alaaam'], $value['alaamr_10']) : null,
                            'member_relationship_10' => $value['alkrab_10'],
                            'member_status_10' => $value['alhal_10'],

                            'member_first_name_11' => $value['alasm_11'],
                            'date_of_birth_11' => ($value['alaamr_11'] != '') ? strlen($value['alaamr_11']) == 4 ? $value['alaamr_11'] : $this->getBirthDay($value['alaaam'], $value['alaamr_11']) : null,
                            'member_relationship_11' => $value['alkrab_11'],
                            'member_status_11' => $value['alhal_11'],

                            'member_first_name_12' => $value['alasm_12'],
                            'date_of_birth_12' => ($value['alaamr_12'] != '') ? strlen($value['alaamr_12']) == 4 ? $value['alaamr_12'] : $this->getBirthDay($value['alaaam'], $value['alaamr_12']) : null,
                            'member_relationship_12' => $value['alkrab_12'],
                            'member_status_12' => $value['alhal_12'],

                            'member_first_name_13' => $value['alasm_13'],
                            'date_of_birth_13' => ($value['alaamr_13'] != '') ? strlen($value['alaamr_13']) == 4 ? $value['alaamr_13'] : $this->getBirthDay($value['alaaam'], $value['alaamr_13']) : null,
                            'member_relationship_13' => $value['alkrab_13'],
                            'member_status_13' => $value['alhal_13'],

                            'member_first_name_14' => $value['alasm_14'],
                            'date_of_birth_14' => ($value['alaamr_14'] != '') ? strlen($value['alaamr_14']) == 4 ? $value['alaamr_14'] : $this->getBirthDay($value['alaaam'], $value['alaamr_14']) : null,
                            'member_relationship_14' => $value['alkrab_14'],
                            'member_status_14' => $value['alhal_14'],

                            'member_first_name_15' => $value['alasm_15'],
                            'date_of_birth_15' => ($value['alaamr_15'] != '') ? strlen($value['alaamr_15']) == 4 ? $value['alaamr_15'] : $this->getBirthDay($value['alaaam'], $value['alaamr_15']) : null,
                            'member_relationship_15' => $value['alkrab_15'],
                            'member_status_15' => $value['alhal_15'],

                            'member_first_name_16' => $value['alasm_16'],
                            'date_of_birth_16' => ($value['alaamr_16'] != '') ? strlen($value['alaamr_16']) == 4 ? $value['alaamr_16'] : $this->getBirthDay($value['alaaam'], $value['alaamr_16']) : null,
                            'member_relationship_16' => $value['alkrab_16'],
                            'member_status_16' => $value['alhal_16'],

                            'member_first_name_17' => $value['alasm_17'],
                            'date_of_birth_17' => ($value['alaamr_17'] != '') ? strlen($value['alaamr_17']) == 4 ? $value['alaamr_17'] : $this->getBirthDay($value['alaaam'], $value['alaamr_17']) : null,
                            'member_relationship_17' => $value['alkrab_17'],
                            'member_status_17' => $value['alhal_18'],

                            'member_first_name_18' => $value['alasm_18'],
                            'date_of_birth_18' => ($value['alaamr_18'] != '') ? strlen($value['alaamr_18']) == 4 ? $value['alaamr_18'] : $this->getBirthDay($value['alaaam'], $value['alaamr_18']) : null,
                            'member_relationship_18' => $value['alkrab_18'],
                            'member_status_18' => $value['alhal_18'],

                            'member_first_name_19' => $value['alasm_19'],
                            'date_of_birth_19' => ($value['alaamr_19'] != '') ? strlen($value['alaamr_19']) == 4 ? $value['alaamr_19'] : $this->getBirthDay($value['alaaam'], $value['alaamr_19']) : null,
                            'member_relationship_19' => $value['alkrab_19'],
                            'member_status_19' => $value['alhal_19'],

                            'member_first_name_20' => $value['alasm_20'],
                            'date_of_birth_20' => ($value['alaamr_20'] != '') ? strlen($value['alaamr_20']) == 4 ? $value['alaamr_20'] : $this->getBirthDay($value['alaaam'], $value['alaamr_20']) : null,
                            'member_relationship_20' => $value['alkrab_20'],
                            'member_status_20' => $value['alhal_20'],
                        ];

                    } else {
                        event(new NewLogCreated($message, null, 98, 0, null));
                        return redirect('admin/families')->with('error', 'لم يتم إضافة زيارات اسر عن طريق ملف اكسل بنجاح لعدم وجود الاعمده المطلوبه');
                    }
                }
                if (!empty($arr)) {
                    foreach ($arr as $value) {

                        // person data
                        $personData['first_name'] = $value['first_name'];
                        $personData['second_name'] = $value['second_name'];
                        $personData['third_name'] = $value['third_name'];
                        $personData['family_name'] = $value['family_name'];
                        $personData['full_name'] = $value['full_name'];
                        $personData['full_name_tr'] = $value['full_name_tr'];
                        $personData['first_name_tr'] = $value['first_name_tr'];
                        $personData['second_name_tr'] = $value['second_name_tr'];
                        $personData['third_name_tr'] = $value['third_name_tr'];
                        $personData['family_name_tr'] = $value['family_name_tr'];
                        $personData['id_number'] = $value['id_number'];
                        $personData['id_type_id'] = 1;
                        $personData['work'] = $value['work'];

                        // searcher data
                        $searcherData1['searcher_id'] = $value['searcher_id'];
                        $searcherData2['searcher_id_2'] = $value['searcher_id_2'];

                        // family data
                        $familyData['mobile_one'] = $value['mobile_one'];
                        $familyData['mobile_two'] = $value['mobile_two'];
                        $familyData['telephone'] = ($value['phone'] == '-') ? null : $value['phone'];
                        $familyData['code'] = $value['code'];
                        $familyData['funded_institution_id'] = $value['funded_institution_id'];
                        $familyData['need'] = $value['need'] == 1 ?? 0;
                        $familyData['id_university'] = $value['id_university'];
                        $familyData['graduated_date'] = $value['graduated_date'];
                        $familyData['neighborhood_id'] = $value['neighborhood_id'];
                        $familyData['city_id'] = $value['city_id'];
                        $familyData['address'] = $value['address'];
                        $familyData['job_type_id'] = $value['job_type_id'];
                        $familyData['house_ownership_id'] = $value['house_ownership_id'];
                        $familyData['house_status_id'] = $value['house_status_id'];
                        $familyData['family_status_id'] = $value['family_status_id'];
                        $familyData['previous_income_coupon'] = $value['previous_income_coupon'];
                        $familyData['previous_income_value'] = $value['previous_income_value'];
                        $familyData['note'] = $value['note'];
                        $familyData['searcher_note'] = $value['searcher_note'];
                        $familyData['old_attachment'] = $value['old_attachment'];
                        $familyData['visit_reason_id'] = 6; // visit
                        $familyData['family_type_id'] = $value['family_type_id'];
                        $familyData['family_project_id'] = 1; // تعليم اخوه
                        $familyData['year'] = $value['year'];
                        $familyData['year_number'] = $value['year_number'];
                        $familyData['visit_reason_id'] = 6;
                        $familyData['visit_date'] = $value['visit_date'];
                        $familyData['is_imported'] = 1;
                        $familyData['visit_count'] = $value['visit_count'];

                        $personData['full_name_tr'] = $request['first_name_tr'] . ' ' . $request['second_name_tr'] . ' ' . $request['third_name_tr'] . ' ' . $request['family_name_tr'];
                        $checkFound = $this->checkFound($personData['id_number'], $personData['full_name_tr']);

                        if ($checkFound === false)
                            continue;

                        if ($checkFound > 0 && $checkFound !== true) {
                            $oldFamily = Family::find($checkFound);
                            $existPerson = $oldFamily->person;

                            $familyData['family_classification_id'] = ($familyData['need'] == 0 && $oldFamily->family_classification_id == 1) ? 5 : $oldFamily->family_classification_id;
                            $familyData['ignore_date'] = ($familyData['need'] == 0 && $oldFamily->need == 1) ? Carbon::now()->toDateString() : null;
                            $familyData['ignore_reason'] = ($familyData['need'] == 0 && $oldFamily->need == 1) ? $familyData['searcher_note'] : "";

                            if ((!is_null($oldFamily))) {
                                $existPerson->update($personData);

                                $oldFamily->update($familyData);

                                if ((isset($oldFamily->searcher)) && (!($oldFamily->searcher)->isEmpty())) {

                                    foreach ($oldFamily->searcher as $itemSearcher) {
                                        if (!is_null($itemSearcher)) {
                                            $itemSearcher->delete();
                                        }
                                    }
                                }

                                //searcher
                                if ($value['searcher_id'] != '') {
                                    FamilySearcher::create([
                                        'searcher_id' => $value['searcher_id'],
                                        'family_id' => $oldFamily->id,
                                    ]);
                                }

                                // members

                                if ((isset($oldFamily->members)) && (!($oldFamily->members)->isEmpty())) {

                                    foreach ($oldFamily->members as $member) {
                                        $person = isset($member->person) ? $member->person : null;
                                        if (!is_null($person)) {
                                            $member->delete();
                                        }
                                    }
                                }

                                for ($i = 1; $i <= 20; $i++) {
                                    $allMemberData['first_name'] = $value['member_first_name_' . $i];
                                    $allMemberData['date_of_birth'] = $value['date_of_birth_' . $i];
                                    $allMemberData['old_status'] = $value['member_status_' . $i];

                                    if (($allMemberData['first_name'] != '')) {

                                        if (($value['member_relationship_' . $i] == 27) || ($value['member_relationship_' . $i] == 44) ||
                                            ($value['member_relationship_' . $i] == 45) || ($value['member_relationship_' . $i] == 32) ||
                                            ($value['member_relationship_' . $i] == 33) || ($value['member_relationship_' . $i] == 34)) {

                                            $id = $value['wive_id_number'];
                                            $existPerson = Person::where('id_number', '<>', '')->where('id_number', '=', $id)->first();

                                            if (!is_null($existPerson)) {
                                                $existPerson->update(['id_number' => $id]);
                                                Member::create([
                                                    'family_id' => $oldFamily->id,
                                                    'person_id' => $existPerson->id,
                                                    'relationship_id' => $value['member_relationship_' . $i],
                                                ]);

                                            } else {
                                                $memberPerson = Person::create($allMemberData);
                                                $memberPerson->update(['id_number' => $id]);
                                                Member::create([
                                                    'family_id' => $oldFamily->id,
                                                    'person_id' => $memberPerson->id,
                                                    'relationship_id' => $value['member_relationship_' . $i],
                                                ]);
                                            }

                                        } else {
                                            $memberPerson = Person::create($allMemberData);

                                            Member::create([
                                                'family_id' => $oldFamily->id,
                                                'person_id' => $memberPerson->id,
                                                'relationship_id' => $value['member_relationship_' . $i],
                                            ]);
                                        }
                                    }
                                }
                            }

                        } elseif ($checkFound === true) {
                            $familyData['family_classification_id'] = $familyData['need'] == 0 ? 5 : 1;// new
                            $familyData['ignore_date'] = ($familyData['need'] == 0) ? Carbon::now()->toDateString() : null;
                            $familyData['ignore_reason'] = ($familyData['need'] == 0) ? $familyData['searcher_note'] : "";

//                         create person
                            $person = Person::create($personData);
                            if ($person) {
                                $familyData['person_id'] = $person->id;

                                $family = Family::create($familyData);


                                // create family
                                if ($family) {

                                    // create searcher
                                    if ($searcherData1['searcher_id'] != '') {
                                        FamilySearcher::create([
                                            'searcher_id' => $searcherData1['searcher_id'],
                                            'family_id' => $family->id,
                                        ]);
                                    }

                                    if ($searcherData2['searcher_id_2'] != '') {
                                        FamilySearcher::create([
                                            'searcher_id' => $searcherData2['searcher_id_2'],
                                            'family_id' => $family->id,
                                        ]);
                                    }


                                    $wiveNameArr = explode(' ', trim($value['wive_name']));
                                    $familyNameArr = explode(' ', trim($value['first_name']));

                                    for ($i = 1; $i <= 20; $i++) {

                                        if ($value['member_first_name_' . $i] != '') {

                                            $status = $value['member_status_' . $i] == 24 ? 'رب الاسرة' : $value['member_status_' . $i];

                                            if ($value['member_first_name_' . $i] == $familyNameArr[0]) {
                                                $person->date_of_birth = $value['date_of_birth_' . $i];
                                                $person->old_status = $status;


                                            } elseif ($value['member_first_name_' . $i] == $wiveNameArr[0]) {

                                                $memberPerson = Person::create([
                                                    'first_name' => $value['member_first_name_' . $i],
                                                    'full_name' => $value['wive_name'],
                                                    'id_number' => $value['wive_id_number'],
                                                    'date_of_birth' => $value['date_of_birth_' . $i],
                                                    'old_status' => $status
                                                ]);

                                                if ($memberPerson) {
                                                    Member::create([
                                                        'family_id' => $family->id,
                                                        'person_id' => $memberPerson->id,
                                                        'relationship_id' => $value['member_relationship_' . $i],
                                                    ]);
                                                }

                                            } else {
                                                $memberPerson = Person::create([
                                                    'first_name' => $value['member_first_name_' . $i],
                                                    'date_of_birth' => $value['date_of_birth_' . $i],
                                                    'old_status' => $status
                                                ]);

                                                if ($memberPerson) {
                                                    Member::create([
                                                        'family_id' => $family->id,
                                                        'person_id' => $memberPerson->id,
                                                        'relationship_id' => $value['member_relationship_' . $i],
                                                    ]);
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        } else {
                            continue;
                        }
                        $message = 'تم إضافه زيارات عن طريق ملف اكسل بنجاح';
                        $type = 'success';
                        event(new NewLogCreated($message, $personData['first_name'], 98, 0, null));
                    }
                } else {
                    $message = 'لم يتم إضافة زياره بنجاح';

                    event(new NewLogCreated($message, $value['first_name'], 98, 0, null));
                    return redirect('admin/families')->with('error', $message);

                }
            }
            return redirect('admin/families')->with('success', $message);

        } else {
            event(new NewLogCreated($message, null, 98, 0, null));
            return redirect('admin/families')->with('error', 'لم يتم تحميل الملف بنجاح');
        }
    }

    public function importYTMFile(Request $request)
    {
        $message = '';
        $type = '';
        $arr = array();
        if ($request->hasFile('file')) {

            $extensions = array("xlsx");

            $result = array($request->file('file')->getClientOriginalExtension());

            if (in_array($result[0], $extensions)) {

                $path = $request->file('file')->getRealPath();
                $data = \Excel::load($path, 'UTF-8')->get();


                if (gettype($data->first()->first() == "double") || gettype($data->first()->first() == "string") || gettype($data->first()->first() == "integer"))
                    $headerRow = $data->first()->keys()->toArray();
                else
                    $headerRow = $data->first()->first()->keys()->toArray();

                $headerRow = array_filter($headerRow, "is_string");

                $values = [];

                $value = array_fill_keys($headerRow, $values);


                if (!(
                    (isset($value['alasm'])) && (isset($value['asm_alab'])) &&
                    (isset($value['asm_aljd'])) && (isset($value['asm_alaaael'])) &&
                    (isset($value['rkm_alhoy'])) && (isset($value['tarykh_almylad'])) && (isset($value['mkan_almylad'])) &&
                    (isset($value['aljns'])) && (isset($value['aadd_alafrad'])) && (isset($value['sbb_ofa_alab'])) && (isset($value['tarykh_alofa'])) &&
                    (isset($value['sbb_ofa_alam'])) && (isset($value['tarykh_alofa_llam'])) && (isset($value['almrhl_altaalymy'])) &&
                    (isset($value['almsto_altaalymy'])) && (isset($value['almdyn'])) && (isset($value['alaanoan'])) &&
                    (isset($value['asm_alokyl'])) && (isset($value['asm_alaaael_llokyl'])) && (isset($value['drj_alkrab_llokyl'])) &&
                    (isset($value['mhn_alokyl'])) && (isset($value['asm_alab_llokyl'])) &&
                    (isset($value['asm_aljd_llokyl'])) && (isset($value['asm_alaaael_llokyl'])) &&
                    (isset($value['drj_alkrab_llokyl'])) && (isset($value['mhn_alokyl'])) && (isset($value['rkm_hoy_alokyl'])) &&
                    (isset($value['rkm_joal_1'])) && (isset($value['rkm_joal_2'])) && (isset($value['odaa_alasr'])) &&
                    (isset($value['asm_alaaael_1'])) && (isset($value['tarykh_almylad_1'])) && (isset($value['alasm_1'])) &&
                    (isset($value['asm_alaaael_2'])) && (isset($value['tarykh_almylad_2'])) && (isset($value['alasm_2'])) &&
                    (isset($value['asm_alaaael_3'])) && (isset($value['tarykh_almylad_3'])) && (isset($value['alasm_3'])) &&
                    (isset($value['asm_alaaael_4'])) && (isset($value['tarykh_almylad_4'])) && (isset($value['alasm_4'])) &&
                    (isset($value['asm_alaaael_5'])) && (isset($value['tarykh_almylad_5'])) && (isset($value['alasm_5'])) &&
                    (isset($value['asm_alaaael_6'])) && (isset($value['tarykh_almylad_6'])) && (isset($value['alasm_6'])) &&
                    (isset($value['asm_alaaael_7'])) && (isset($value['tarykh_almylad_7'])) && (isset($value['alasm_7'])) &&
                    (isset($value['asm_alaaael_8'])) && (isset($value['tarykh_almylad_8'])) && (isset($value['alasm_8'])) &&
                    (isset($value['asm_alaaael_9'])) && (isset($value['tarykh_almylad_9'])) && (isset($value['alasm_9'])) &&
                    (isset($value['asm_alaaael_10'])) && (isset($value['tarykh_almylad_10'])) && (isset($value['alasm_10'])) &&
                    (isset($value['asm_alaaael_11'])) && (isset($value['tarykh_almylad_11'])) && (isset($value['alasm_11'])) &&
                    (isset($value['asm_alaaael_12'])) && (isset($value['tarykh_almylad_12'])) && (isset($value['alasm_12']))
                )) {
                    event(new NewLogCreated($message, null, 102, 0, null));
                    return redirect('admin/families/import/ytm')->with('error', 'لم يتم إضافة زيارات ايتام عن طريق ملف اكسل بنجاح لعدم وجود الاعمده المطلوبه');
                }

                if ($data->count() > 100) {
                    return back()->with('error', 'لا يمكن رفع ملف أكثر من 100 صف دفعة واحدة');
                }
                if ($data->count()) {

                    $i = 0;
                    $errors = [];

                    foreach ($data as $key => $value) {
                        $i++;


                        if (
                            (!is_null($value['alasm'])) && (!is_null($value['asm_alab'])) &&
                            (!is_null($value['asm_aljd'])) && (!is_null($value['asm_alaaael'])) &&
                            (!is_null($value['rkm_alhoy']) && (is_numeric($value['rkm_alhoy'])) && (strlen($value['rkm_alhoy']) == 9))
                            /* ||(!is_null($value['tarykh_almylad'])) ||
                             (!is_null($value['mkan_almylad'])) ||
                             (!is_null($value['aadd_alafrad'])) || (!is_null($value['sbb_ofa_alab'])) || (!is_null($value['tarykh_alofa'])) ||
                             (!is_null($value['sbb_ofa_alam'])) || (!is_null($value['tarykh_alofa_llam'])) || (!is_null($value['almrhl_altaalymy'])) ||
                             (!is_null($value['almsto_altaalymy'])) || (!is_null($value['almdyn'])) || (!is_null($value['alaanoan'])) ||
                             (!is_null($value['asm_alokyl'])) || (!is_null($value['asm_alaaael_llokyl'])) || (!is_null($value['drj_alkrab_llokyl'])) ||
                             (!is_null($value['mhn_alokyl'])) || (!is_null($value['asm_alab_llokyl'])) ||
                             (!is_null($value['asm_aljd_llokyl'])) || (!is_null($value['asm_alaaael_llokyl'])) ||
                             (!is_null($value['drj_alkrab_llokyl'])) || (!is_null($value['mhn_alokyl'])) || (!is_null($value['rkm_hoy_alokyl'])) ||
                             (!is_null($value['rkm_joal_1'])) || (!is_null($value['rkm_joal_2'])) || (!is_null($value['odaa_alasr'])) ||
                             (!is_null($value['asm_alaaael_1'])) || (!is_null($value['tarykh_almylad_1'])) || (!is_null($value['alasm_1'])) ||
                             (!is_null($value['asm_alaaael_2'])) || (!is_null($value['tarykh_almylad_2'])) || (!is_null($value['alasm_2'])) ||
                             (!is_null($value['asm_alaaael_3'])) || (!is_null($value['tarykh_almylad_3'])) || (!is_null($value['alasm_3'])) ||
                             (!is_null($value['asm_alaaael_4'])) || (!is_null($value['tarykh_almylad_4'])) || (!is_null($value['alasm_4'])) ||
                             (!is_null($value['asm_alaaael_5'])) || (!is_null($value['tarykh_almylad_5'])) || (!is_null($value['alasm_5'])) ||
                             (!is_null($value['asm_alaaael_6'])) || (!is_null($value['tarykh_almylad_6'])) || (!is_null($value['alasm_6'])) ||
                             (!is_null($value['asm_alaaael_7'])) || (!is_null($value['tarykh_almylad_7'])) || (!is_null($value['alasm_7'])) ||
                             (!is_null($value['asm_alaaael_8'])) || (!is_null($value['tarykh_almylad_8'])) || (!is_null($value['alasm_8'])) ||
                             (!is_null($value['asm_alaaael_9'])) || (!is_null($value['tarykh_almylad_9'])) || (!is_null($value['alasm_9'])) ||
                             (!is_null($value['asm_alaaael_10'])) || (!is_null($value['tarykh_almylad_10'])) || (!is_null($value['alasm_10'])) ||
                             (!is_null($value['asm_alaaael_11'])) || (!is_null($value['tarykh_almylad_11'])) || (!is_null($value['alasm_11'])) ||
                             (!is_null($value['asm_alaaael_12'])) || (!is_null($value['tarykh_almylad_12'])) || (!is_null($value['alasm_12']))*/
                        ) {
                            $arr[] = [
                                // person
                                'first_name' => $value['alasm'],
                                'second_name' => $value['asm_alab'],
                                'third_name' => $value['asm_aljd'],
                                'family_name' => $value['asm_alaaael'],
                                'id_number' => $value['rkm_alhoy'],
                                'date_of_birth' => $value['tarykh_almylad'],
                                'date_of_birth_place' => !is_null($value['mkan_almylad']) ? substr($value['mkan_almylad'], 0, strpos($value['mkan_almylad'], '-')) : null,
                                'gender' => $value['aljns'] == 'أنثى' ? 'F' : 'M',
                                'qualification_id' => !is_null($value['almsto_altaalymy']) ? substr($value['almsto_altaalymy'], 0, strpos($value['almsto_altaalymy'], '-')) : null,
                                'qualification_level_id' => !is_null($value['almrhl_altaalymy']) ? substr($value['almrhl_altaalymy'], 0, strpos($value['almrhl_altaalymy'], '-')) : null,

                                // family
                                'member_count' => $value['aadd_alafrad'],
                                'father_death_reason' => $value['sbb_ofa_alab'],
                                'father_death_date' => $value['tarykh_alofa'],
                                'mother_death_reason' => $value['sbb_ofa_alam'],
                                'mother_death_date' => $value['tarykh_alofa_llam'],
                                'address' => $value['alaanoan'],
                                'note' => $value['odaa_alasr'],
                                'mobile_one' => $value['rkm_joal_1'],
                                'mobile_two' => $value['rkm_joal_2'],
                                'governorate_id' => !is_null($value['almdyn']) ? substr($value['almdyn'], 0, strpos($value['almdyn'], '-')) : null,

                                // representative
                                'representative_first_name' => $value['asm_alokyl'],
                                'representative_second_name' => $value['asm_alab_llokyl'],
                                'representative_third_name' => $value['asm_aljd_llokyl'],
                                'representative_family_name' => $value['asm_alaaael_llokyl'],
                                'representative_relationship_id' => !is_null($value['drj_alkrab_llokyl']) ? substr($value['drj_alkrab_llokyl'], 0, strpos($value['drj_alkrab_llokyl'], '-')) : null,
                                'representative_job_type_id' => !is_null($value['mhn_alokyl']) ? substr($value['mhn_alokyl'], 0, strpos($value['mhn_alokyl'], '-')) : null,
                                'representative_id_number' => $value['rkm_hoy_alokyl'],

                                // members
                                'member_first_name_1' => $value['alasm_1'],
                                'member_family_name_1' => $value['asm_alaaael_1'],
                                'member_date_of_birth_1' => $value['tarykh_almylad_1'],

                                'member_first_name_2' => $value['alasm_2'],
                                'member_family_name_2' => $value['asm_alaaael_2'],
                                'member_date_of_birth_2' => $value['tarykh_almylad_2'],

                                'member_first_name_3' => $value['alasm_3'],
                                'member_family_name_3' => $value['asm_alaaael_3'],
                                'member_date_of_birth_3' => $value['tarykh_almylad_3'],

                                'member_first_name_4' => $value['alasm_4'],
                                'member_family_name_4' => $value['asm_alaaael_4'],
                                'member_date_of_birth_4' => $value['tarykh_almylad_4'],

                                'member_first_name_5' => $value['alasm_5'],
                                'member_family_name_5' => $value['asm_alaaael_5'],
                                'member_date_of_birth_5' => $value['tarykh_almylad_5'],

                                'member_first_name_6' => $value['alasm_6'],
                                'member_family_name_6' => $value['asm_alaaael_6'],
                                'member_date_of_birth_6' => $value['tarykh_almylad_6'],

                                'member_first_name_7' => $value['alasm_7'],
                                'member_family_name_7' => $value['asm_alaaael_7'],
                                'member_date_of_birth_7' => $value['tarykh_almylad_7'],

                                'member_first_name_8' => $value['alasm_8'],
                                'member_family_name_8' => $value['asm_alaaael_8'],
                                'member_date_of_birth_8' => $value['tarykh_almylad_8'],

                                'member_first_name_9' => $value['alasm_9'],
                                'member_family_name_9' => $value['asm_alaaael_9'],
                                'member_date_of_birth_9' => $value['tarykh_almylad_9'],

                                'member_first_name_10' => $value['alasm_10'],
                                'member_family_name_10' => $value['asm_alaaael_10'],
                                'member_date_of_birth_10' => $value['tarykh_almylad_10'],

                                'member_first_name_11' => $value['alasm_11'],
                                'member_family_name_11' => $value['asm_alaaael_11'],
                                'member_date_of_birth_11' => $value['tarykh_almylad_11'],

                                'member_first_name_12' => $value['alasm_12'],
                                'member_family_name_12' => $value['asm_alaaael_12'],
                                'member_date_of_birth_12' => $value['tarykh_almylad_12'],

                            ];

                        } else {
                            array_push($errors, $i + 1);
                            continue;
                        }


                    }

                    if (!empty($arr)) {

                        foreach ($arr as $value) {


                            // person data
                            $personData['first_name'] = trim($value['first_name']);
                            $personData['second_name'] = trim($value['second_name']);
                            $personData['third_name'] = trim($value['third_name']);
                            $personData['family_name'] = trim($value['family_name']);
                            $personData['full_name'] = $personData['first_name'] . " " . $personData['second_name'] . " " . $personData['third_name'] . " " . $personData['family_name'];
                            $personData['first_name_tr'] = NameTranslation::where('arabic', $personData['first_name'])->first() ? NameTranslation::where('arabic', $personData['first_name'])->first()->turkey : "";
                            $personData['second_name_tr'] = NameTranslation::where('arabic', $personData['second_name'])->first() ? NameTranslation::where('arabic', $personData['second_name'])->first()->turkey : "";
                            $personData['third_name_tr'] = NameTranslation::where('arabic', $personData['third_name'])->first() ? NameTranslation::where('arabic', $personData['third_name'])->first()->turkey : "";
                            $personData['family_name_tr'] = NameTranslation::where('arabic', $personData['family_name'])->first() ? NameTranslation::where('arabic', $personData['family_name'])->first()->turkey : "";
                            $personData['full_name_tr'] = $personData['first_name_tr'] . " " . $personData['second_name_tr'] . " " . $personData['third_name_tr'] . " " . $personData['family_name_tr'];
                            $personData['id_number'] = $value['id_number'];
                            $personData['date_of_birth'] = !is_null($value['date_of_birth']) ? date('Y', strtotime(trim($value['date_of_birth']))) : null;
                            $personData['date_of_birth_place'] = 1;
                            $personData['gender'] = $value['gender'];
                            $personData['qualification_id'] = $value['qualification_id'];
                            $personData['qualification_level_id'] = $value['qualification_level_id'];
                            $personData['id_type_id'] = 1;

                            // family data
                            $familyData['member_count'] = $value['member_count'];
                            $familyData['father_death_reason'] = $value['father_death_reason'];
                            $familyData['father_death_date'] = $value['father_death_date'];
                            $familyData['mother_death_reason'] = $value['mother_death_reason'];
                            $familyData['mother_death_date'] = $value['mother_death_date'];
                            $familyData['address'] = $value['address'];
                            $familyData['note'] = $value['note'];
                            $familyData['mobile_one'] = $value['mobile_one'];
                            $familyData['mobile_two'] = $value['mobile_two'];
                            $familyData['governorate_id'] = $value['governorate_id'];
                            $familyData['visit_reason_id'] = 6; // visit
                            $familyData['family_project_id'] = 2; // ytm
                            $familyData['family_type_id'] = 5; // ytm
                            $familyData['data_entry_id'] = 1;
                            $familyData['family_classification_id'] = 1;
                            $familyData['visit_count'] = 1;
                            // representative family data
                            $familyData['representative_relationship_id'] = $value['representative_relationship_id'];
                            $familyData['representative_job_type_id'] = $value['representative_job_type_id'];

                            // representative data
                            $representativeData['first_name'] = $value['representative_first_name'];
                            $representativeData['second_name'] = $value['representative_second_name'];
                            $representativeData['third_name'] = $value['representative_third_name'];
                            $representativeData['family_name'] = $value['representative_family_name'];
                            $representativeData['id_number'] = $value['representative_id_number'];


                            $falmils_by_id_number = Family::whereNull('parent_id')->whereHas('person'
                                , function ($query) use ($personData) {
                                    $query->where('id_number', $personData['id_number']);
                                })->with('person');
                            $vists_by_id_number = array_unique(array_filter(Family::whereNotNull('parent_id')->whereHas('person'
                                , function ($query) use ($personData) {
                                    $query->where('id_number', $personData['id_number']);
                                })->pluck('parent_id')->toArray()));

                            $existPerson = null;
                            if ($falmils_by_id_number->count() == 1) {
                                $family_id = $falmils_by_id_number->first()->id;
                                $oldFamily = Family::find($family_id);
                                $existPerson = $oldFamily->person;
                            } elseif (count($vists_by_id_number) == 1) {
                                $family_id = Family::find($vists_by_id_number[0])->id;
                                $oldFamily = Family::find($family_id);
                                $existPerson = $oldFamily->person;
                            }

                            // dd($existPerson);

                            if (!is_null($existPerson)) {
                                $oldFamily = Family::where('person_id', $existPerson->id)
                                    ->where('approve', 0)
                                    ->first();

                                if ((!is_null($oldFamily))) {


                                    $visit_count = $oldFamily->visit_count;
                                    $existPerson->update($personData);

                                    $oldFamily->update($familyData);

                                    $newPerson = $existPerson->replicate();
                                    $newPerson->save();

                                    // clone family
                                    $newFamily = $oldFamily->replicate();
                                    $newFamily->save();


                                    $newFamily->update(
                                        [
                                            'visit_count' => $visit_count,
                                            'approve' => 1,
                                            'archive' => 1,
                                            'parent_id' => $oldFamily->id,
                                            'person_id' => $newPerson->id,
                                        ]);

                                    $updateData = [
                                        'archive' => 0,
                                        'approve' => 0,
                                        'visit_count' => $visit_count + 1,
                                        'expense_id' => null,
                                    ];
                                    $oldFamily->update($updateData);


                                    // clone income
                                    if ((isset($oldFamily->incomes)) && (!is_null($oldFamily->incomes))) {
                                        foreach ($oldFamily->incomes as $item) {
                                            $newIncome = $item->replicate();
                                            $newIncome->family_id = $newFamily->id;
                                            $newIncome->save();
                                        }
                                    }

                                    // clone members
                                    if ((isset($oldFamily->members)) && (!is_null($oldFamily->members))) {
                                        foreach ($oldFamily->members as $item) {
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
                                    if ((isset($oldFamily->searcher)) && (!is_null($oldFamily->searcher))) {
                                        foreach ($oldFamily->searcher as $item) {
                                            $newSearcher = $item->replicate();
                                            $newSearcher->family_id = $newFamily->id;
                                            $newSearcher->save();
                                        }
                                    }

                                    // clone member diseases
                                    if ((isset($oldFamily->familyMemberDiseases)) && (!is_null($oldFamily->familyMemberDiseases))) {
                                        foreach ($oldFamily->familyMemberDiseases as $item) {
                                            $newIncome = $item->replicate();
                                            $newIncome->family_id = $newFamily->id;
                                            $newIncome->save();
                                        }
                                    }

                                    $representative = Person::where('id_number', '<>', '')
                                        ->where('id_number', '=', $representativeData['id_number'])->first();

                                    if (!is_null($representative)) {
                                        $representative->update($representativeData);
                                        $familyData['representative_id'] = $representative->id;
                                    } else {
                                        $representative = Person::create($representativeData);
                                        $familyData['representative_id'] = $representative->id;
                                    }
                                    $familyData['is_imported'] = 1;
                                    $oldFamily->update($familyData);


                                    if ((isset($oldFamily->members)) && (!($oldFamily->members)->isEmpty())) {

                                        foreach ($oldFamily->members as $member) {
                                            $person = isset($member->person) ? $member->person : null;
                                            if (!is_null($person)) {
                                                $member->delete();
                                                $person->delete();
                                            }
                                        }
                                    }

                                    for ($i = 1; $i <= 12; $i++) {
                                        $allMemberData['first_name'] = trim($value['member_first_name_' . $i]);
                                        $allMemberData['family_name'] = trim($value['member_family_name_' . $i]);
                                        //
                                        $allMemberData['first_name_tr'] =
                                            NameTranslation::where('arabic', $allMemberData['first_name'])->first() ?
                                                NameTranslation::where('arabic', $allMemberData['first_name'])->first()->turkey : null;
                                        $allMemberData['family_name_tr'] = NameTranslation::where('arabic', $allMemberData['family_name'])->first() ? NameTranslation::where('arabic', $allMemberData['family_name'])->first()->turkey : "";
                                        $allMemberData['date_of_birth'] = !is_null($value['member_date_of_birth_' . $i]) ? date('Y', strtotime(trim($value['member_date_of_birth_' . $i]))) : null;

                                        if (($allMemberData['first_name'] != '') || ($allMemberData['family_name'] != '') || (($allMemberData['date_of_birth'] != ''))) {
                                            $memberPerson = Person::create($allMemberData);

                                            Member::create([
                                                'family_id' => $oldFamily->id,
                                                'person_id' => $memberPerson->id,
                                            ]);

                                        }
                                    }
                                }

                            } else {
                                $person = Person::create($personData);

                                if ($person) {
                                    $familyData['person_id'] = $person->id;

                                    $existRepresentative = Person::where('id_number', '<>', '')->where('id_number', '=', $representativeData['id_number'])->first();

                                    if (!is_null($existRepresentative)) {
                                        $existRepresentative->update($representativeData);
                                        $familyData['representative_id'] = $existRepresentative->id;
                                    } else {
                                        $representative = Person::create($representativeData);
                                        $familyData['representative_id'] = $representative->id;
                                    }

                                    $family = Family::create($familyData);


                                    if ($family) {

                                        for ($i = 1; $i <= 12; $i++) {
                                            $allMemberData['first_name'] = trim($value['member_first_name_' . $i]);
                                            $allMemberData['first_name_tr'] = NameTranslation::where('arabic', $allMemberData['first_name'])->first() ? NameTranslation::where('arabic', $allMemberData['first_name'])->first()->turkey : null;
                                            $allMemberData['family_name'] = $value['member_family_name_' . $i];
                                            $allMemberData['family_name_tr'] = NameTranslation::where('arabic', $allMemberData['family_name'])->first() ? NameTranslation::where('arabic', $allMemberData['family_name'])->first()->turkey : "";


                                            $allMemberData['date_of_birth'] = !is_null($value['member_date_of_birth_' . $i]) ? date('Y', strtotime(trim($value['member_date_of_birth_' . $i]))) : null;

                                            if (($allMemberData['first_name'] != '') || ($allMemberData['family_name'] != '') || (($allMemberData['date_of_birth'] != ''))) {
                                                $memberPerson = Person::create($allMemberData);

                                                Member::create([
                                                    'family_id' => $family->id,
                                                    'person_id' => $memberPerson->id,
                                                ]);

                                            }
                                        }
                                    }

                                }
                            }
                            $errors_msg = $errors ? " وفشل في استيراد الصفوف " . implode(",", $errors) : "";
                            $message = 'تم إضافة زيارات ايتام عن طريق ملف اكسل بنجاح ' . $errors_msg;
                            $type = 'success';
                            event(new NewLogCreated($message, $personData['first_name'], 102, 0, null));
                        }

                    }
                    return redirect('admin/families/import/ytm')->with($type, $message);

                } else {

                    $message = 'لم يتم إضافة زيارات ايتام عن طريق ملف اكسل بنجاح لعدم وجود بيانات';

                    event(new NewLogCreated($message, $request['first_name'], 102, 0, null));
                    return redirect('admin/families/import/ytm')->with('error', $message);
                }

            } else {
                event(new NewLogCreated($message, null, 102, 0, null));
                return redirect('admin/families/import/ytm')->with('error', 'لم يتم تحميل الملف بنجاح يجب ان يكون نوع الملف xlsx');
            }
        } else {
            event(new NewLogCreated($message, null, 102, 0, null));
            return redirect('admin/families/import/ytm')->with('error', 'لم يتم تحميل الملف');
        }
    }

    public function importVisit(Request $request)
    {
        //dd('test');
        $message = '';
        $type = '';
        $relations = Relationship::all();

        if ($request->hasFile('file')) {

            $extensions = array("xlsx");

            $result = array($request->file('file')->getClientOriginalExtension());

            if (in_array($result[0], $extensions)) {

                $path = $request->file('file')->getRealPath();
                $data = \Excel::load($path, 'UTF-8')->get();

                if ($data->count() > 100) {
                    return back()->with('error', 'لا يمكن رفع ملف أكثر من 100 صف دفعة واحدة');
                }

                if ($data->count()) {

                    if (gettype($data->first()->first() == "double") || gettype($data->first()->first() == "string") || gettype($data->first()->first() == "integer"))
                        $headerRow = $data->first()->keys()->toArray();
                    else
                        $headerRow = $data->first()->first()->keys()->toArray();

                    $headerRow = array_filter($headerRow, "is_string");

                    $values = [];

                    $value = array_fill_keys($headerRow, $values);


                    if (
                        (isset($value['tarykh_alzyarh'])) && (isset($value['asm_albahth'])) && (isset($value['rkm_alhoy'])) &&
                        (isset($value['alasm_alaol'])) && (isset($value['asm_alab'])) && (isset($value['asm_aljd'])) &&
                        (isset($value['asm_alaaael'])) && (isset($value['alasm_alaol_baltrky'])) && (isset($value['asm_alab_baltrky'])) &&
                        (isset($value['asm_aljd_baltrky'])) && (isset($value['sn_almylad'])) && (isset($value['asm_alaaael_baltrky'])) && (isset($value['yhtaj_la_yhtaj'])) &&
                        (isset($value['sbb_alkfal'])) && (isset($value['joal_1'])) && (isset($value['joal_2'])) &&
                        (isset($value['hatf'])) && (isset($value['asm_alzoj_alzoj'])) && (isset($value['hoyh_alzoj_alzoj'])) &&
                        (isset($value['alrkm_aljamaay'])) && (isset($value['altarykh_almtokaa_lltkhrj'])) && (isset($value['almdyn'])) &&
                        (isset($value['alhyalmntk'])) && (isset($value['tfasyl_alaanoan'])) && (isset($value['yaamllayaaml'])) &&
                        (isset($value['almhn'])) && (isset($value['mlky_alskn'])) && (isset($value['hal_alskn'])) &&
                        (isset($value['odaa_alaaael'])) && (isset($value['msdr_dkhl_1'])) && (isset($value['kymh_aldkhl_1'])) &&
                        (isset($value['msdr_dkhl_2'])) && (isset($value['kymh_aldkhl_2'])) && (isset($value['msdr_dkhl_3'])) &&
                        (isset($value['kymh_aldkhl_3'])) && (isset($value['mlahthat'])) && (isset($value['tkym_albahth'])) &&
                        (isset($value['alasm_1'])) && (isset($value['alaamr_1'])) && (isset($value['alkrab_1'])) && (isset($value['alhal_alajtmaaayh_1'])) && (isset($value['alhal_alothyfyh_1'])) && (isset($value['alhal_alshyh_1'])) && (isset($value['alhal_altaalymy_1'])) &&
                        (isset($value['alasm_2'])) && (isset($value['alaamr_2'])) && (isset($value['alkrab_2'])) && (isset($value['alhal_alajtmaaayh_2'])) && (isset($value['alhal_alothyfyh_2'])) && (isset($value['alhal_alshyh_2'])) && (isset($value['alhal_altaalymy_2'])) &&
                        (isset($value['alasm_3'])) && (isset($value['alaamr_3'])) && (isset($value['alkrab_3'])) && (isset($value['alhal_alajtmaaayh_3'])) && (isset($value['alhal_alothyfyh_3'])) && (isset($value['alhal_alshyh_3'])) && (isset($value['alhal_altaalymy_3'])) &&
                        (isset($value['alasm_4'])) && (isset($value['alaamr_4'])) && (isset($value['alkrab_4'])) && (isset($value['alhal_alajtmaaayh_4'])) && (isset($value['alhal_alothyfyh_4'])) && (isset($value['alhal_alshyh_4'])) && (isset($value['alhal_altaalymy_4'])) &&
                        (isset($value['alasm_5'])) && (isset($value['alaamr_5'])) && (isset($value['alkrab_5'])) && (isset($value['alhal_alajtmaaayh_5'])) && (isset($value['alhal_alothyfyh_5'])) && (isset($value['alhal_alshyh_5'])) && (isset($value['alhal_altaalymy_5'])) &&
                        (isset($value['alasm_6'])) && (isset($value['alaamr_6'])) && (isset($value['alkrab_6'])) && (isset($value['alhal_alajtmaaayh_6'])) && (isset($value['alhal_alothyfyh_6'])) && (isset($value['alhal_alshyh_6'])) && (isset($value['alhal_altaalymy_6'])) &&
                        (isset($value['alasm_7'])) && (isset($value['alaamr_7'])) && (isset($value['alkrab_7'])) && (isset($value['alhal_alajtmaaayh_7'])) && (isset($value['alhal_alothyfyh_7'])) && (isset($value['alhal_alshyh_7'])) && (isset($value['alhal_altaalymy_7'])) &&
                        (isset($value['alasm_8'])) && (isset($value['alaamr_8'])) && (isset($value['alkrab_8'])) && (isset($value['alhal_alajtmaaayh_8'])) && (isset($value['alhal_alothyfyh_8'])) && (isset($value['alhal_alshyh_8'])) && (isset($value['alhal_altaalymy_8'])) &&
                        (isset($value['alasm_9'])) && (isset($value['alaamr_9'])) && (isset($value['alkrab_9'])) && (isset($value['alhal_alajtmaaayh_9'])) && (isset($value['alhal_alothyfyh_9'])) && (isset($value['alhal_alshyh_9'])) && (isset($value['alhal_altaalymy_9'])) &&
                        (isset($value['alasm_10'])) && (isset($value['alaamr_10'])) && (isset($value['alkrab_10'])) && (isset($value['alhal_alajtmaaayh_10'])) && (isset($value['alhal_alothyfyh_10'])) && (isset($value['alhal_alshyh_10'])) && (isset($value['alhal_altaalymy_10'])) &&
                        (isset($value['alasm_11'])) && (isset($value['alaamr_11'])) && (isset($value['alkrab_11'])) && (isset($value['alhal_alajtmaaayh_11'])) && (isset($value['alhal_alothyfyh_11'])) && (isset($value['alhal_alshyh_11'])) && (isset($value['alhal_altaalymy_11'])) &&
                        (isset($value['alasm_12'])) && (isset($value['alaamr_12'])) && (isset($value['alkrab_12'])) && (isset($value['alhal_alajtmaaayh_12'])) && (isset($value['alhal_alothyfyh_12'])) && (isset($value['alhal_alshyh_12'])) && (isset($value['alhal_altaalymy_12'])) &&
                        (isset($value['alasm_13'])) && (isset($value['alaamr_13'])) && (isset($value['alkrab_13'])) && (isset($value['alhal_alajtmaaayh_13'])) && (isset($value['alhal_alothyfyh_13'])) && (isset($value['alhal_alshyh_13'])) && (isset($value['alhal_altaalymy_13'])) &&
                        (isset($value['alasm_14'])) && (isset($value['alaamr_14'])) && (isset($value['alkrab_14'])) && (isset($value['alhal_alajtmaaayh_14'])) && (isset($value['alhal_alothyfyh_14'])) && (isset($value['alhal_alshyh_14'])) && (isset($value['alhal_altaalymy_14'])) &&
                        (isset($value['alasm_15'])) && (isset($value['alaamr_15'])) && (isset($value['alkrab_15'])) && (isset($value['alhal_alajtmaaayh_15'])) && (isset($value['alhal_alothyfyh_15'])) && (isset($value['alhal_alshyh_15'])) && (isset($value['alhal_altaalymy_15'])) &&
                        (isset($value['alasm_16'])) && (isset($value['alaamr_16'])) && (isset($value['alkrab_16'])) && (isset($value['alhal_alajtmaaayh_16'])) && (isset($value['alhal_alothyfyh_16'])) && (isset($value['alhal_alshyh_16'])) && (isset($value['alhal_altaalymy_16'])) &&
                        (isset($value['alasm_17'])) && (isset($value['alaamr_17'])) && (isset($value['alkrab_17'])) && (isset($value['alhal_alajtmaaayh_17'])) && (isset($value['alhal_alothyfyh_17'])) && (isset($value['alhal_alshyh_17'])) && (isset($value['alhal_altaalymy_17'])) &&
                        (isset($value['alasm_18'])) && (isset($value['alaamr_18'])) && (isset($value['alkrab_18'])) && (isset($value['alhal_alajtmaaayh_18'])) && (isset($value['alhal_alothyfyh_18'])) && (isset($value['alhal_alshyh_18'])) && (isset($value['alhal_altaalymy_18'])) &&
                        (isset($value['alasm_19'])) && (isset($value['alaamr_19'])) && (isset($value['alkrab_19'])) && (isset($value['alhal_alajtmaaayh_19'])) && (isset($value['alhal_alothyfyh_19'])) && (isset($value['alhal_alshyh_19'])) && (isset($value['alhal_altaalymy_19'])) &&
                        (isset($value['alasm_20'])) && (isset($value['alaamr_20'])) && (isset($value['alkrab_20'])) && (isset($value['alhal_alajtmaaayh_20'])) && (isset($value['alhal_alothyfyh_20'])) && (isset($value['alhal_alshyh_20'])) && (isset($value['alhal_altaalymy_20']))

                    ) {

                        $i = 0;
                        $errors = [];

                        foreach ($data as $key => $value) {
                            $i++;

                            if (
                                // (!is_null($value['tarykh_alzyarh'])) || (!is_null($value['asm_albahth'])) ||
                                (!is_null($value['rkm_alhoy'])) && (is_numeric($value['rkm_alhoy'])) && (strlen($value['rkm_alhoy']) == 9) &&
                                (!is_null($value['alasm_alaol'])) && (!is_null($value['asm_alab'])) && (!is_null($value['asm_aljd'])) &&
                                (!is_null($value['asm_alaaael'])) && (!is_null($value['alasm_alaol_baltrky'])) && (!is_null($value['asm_alab_baltrky'])) &&
                                (!is_null($value['asm_aljd_baltrky'])) && (!is_null($value['asm_alaaael_baltrky']))
                                /*|| (!is_null($value['yhtaj_la_yhtaj'])) ||
                                (!is_null($value['sbb_alkfal'])) || (!is_null($value['joal_1'])) || (!is_null($value['joal_2'])) ||
                                (!is_null($value['hatf'])) || (!is_null($value['asm_alzoj_alzoj'])) || (!is_null($value['hoyh_alzoj_alzoj'])) ||
                                (!is_null($value['alrkm_aljamaay'])) || (!is_null($value['altarykh_almtokaa_lltkhrj'])) ||
                                (!is_null($value['almdyn'])) ||
                                (!is_null($value['alhyalmntk'])) || (!is_null($value['tfasyl_alaanoan'])) || (!is_null($value['yaamllayaaml'])) ||
                                (!is_null($value['almhn'])) || (!is_null($value['mlky_alskn'])) || (!is_null($value['hal_alskn'])) ||
                                (!is_null($value['odaa_alaaael'])) ||
                                (!is_null($value['msdr_dkhl_1'])) || (!is_null($value['kymh_aldkhl_1'])) ||
                                (!is_null($value['msdr_dkhl_2'])) || (!is_null($value['kymh_aldkhl_2'])) ||
                                (!is_null($value['msdr_dkhl_3'])) || (!is_null($value['kymh_aldkhl_3'])) ||
                                (!is_null($value['mlahthat'])) || (!is_null($value['tkym_albahth']) )*/

                            ) {
                                $arr[] = [
                                    'visit_date' => $value['tarykh_alzyarh'],
                                    'searcher_id' => !is_null($value['asm_albahth']) ? substr($value['asm_albahth'], 0, strpos($value['asm_albahth'], '-')) : null,
                                    'id_number' => $value['rkm_alhoy'],
                                    'first_name' => $value['alasm_alaol'],
                                    'second_name' => $value['asm_alab'],
                                    'third_name' => $value['asm_aljd'],
                                    'family_name' => $value['asm_alaaael'],
                                    'first_name_tr' => $value['alasm_alaol_baltrky'],
                                    'second_name_tr' => $value['asm_alab_baltrky'],
                                    'third_name_tr' => $value['asm_aljd_baltrky'],
                                    'family_name_tr' => $value['asm_alaaael_baltrky'],
                                    'need' => !is_null($value['yhtaj_la_yhtaj']) ? substr($value['yhtaj_la_yhtaj'], 0, strpos($value['yhtaj_la_yhtaj'], '-')) : null,
                                    'family_type_id' => !is_null($value['sbb_alkfal']) ? substr($value['sbb_alkfal'], 0, strpos($value['sbb_alkfal'], '-')) : null,
                                    'mobile_one' => $value['joal_1'],
                                    'mobile_two' => $value['joal_2'],
                                    'phone' => $value['hatf'],

                                    // wive
                                    'wive_id_number' => $value['hoyh_alzoj_alzoj'],
                                    'date_of_birth' => $value['sn_almylad'] ?? null,
                                    'id_university' => $value['alrkm_aljamaay'],
                                    'graduated_date' => $value['altarykh_almtokaa_lltkhrj'],
                                    'neighborhood_id' => !is_null($value['alhyalmntk']) ? substr($value['alhyalmntk'], 0, strpos($value['alhyalmntk'], '-')) : null,
                                    'city_id' => !is_null($value['almdyn']) ? substr($value['almdyn'], 0, strpos($value['almdyn'], '-')) : null,
                                    'address' => $value['tfasyl_alaanoan'],
                                    'work' => !is_null($value['yaamllayaaml']) ? substr($value['yaamllayaaml'], 0, strpos($value['yaamllayaaml'], '-')) : null,
                                    'job_type_id' => !is_null($value['almhn']) ? substr($value['almhn'], 0, strpos($value['almhn'], '-')) : null,
                                    'house_ownership_id' => !is_null($value['mlky_alskn']) ? substr($value['mlky_alskn'], 0, strpos($value['mlky_alskn'], '-')) : null,
                                    'house_status_id' => !is_null($value['hal_alskn']) ? substr($value['hal_alskn'], 0, strpos($value['hal_alskn'], '-')) : null,
                                    'family_status_id' => !is_null($value['odaa_alaaael']) ? substr($value['odaa_alaaael'], 0, strpos($value['odaa_alaaael'], '-')) : null,

                                    'income_type_id_1' => !is_null($value['msdr_dkhl_1']) ? substr($value['msdr_dkhl_1'], 0, strpos($value['msdr_dkhl_1'], '-')) : null,
                                    'income_type_id_2' => !is_null($value['msdr_dkhl_2']) ? substr($value['msdr_dkhl_2'], 0, strpos($value['msdr_dkhl_2'], '-')) : null,
                                    'income_type_id_3' => !is_null($value['msdr_dkhl_3']) ? substr($value['msdr_dkhl_3'], 0, strpos($value['msdr_dkhl_3'], '-')) : null,
                                    'income_value_1' => $value['kymh_aldkhl_1'],
                                    'income_value_2' => $value['kymh_aldkhl_2'],
                                    'income_value_3' => $value['kymh_aldkhl_3'],
                                    'note' => $value['mlahthat'],
                                    'searcher_note' => $value['tkym_albahth'],

                                    //member
                                    'member_first_name_1' => $value['alasm_1'],
                                    'date_of_birth_1' => $value['alaamr_1'],
                                    'member_relationship_1' => !is_null($value['alkrab_1']) ? substr($value['alkrab_1'], 0, strpos($value['alkrab_1'], '-')) : null,
                                    'member_social_status_1' => !is_null($value['alhal_alajtmaaayh_1']) ? substr($value['alhal_alajtmaaayh_1'], 0, strpos($value['alhal_alajtmaaayh_1'], '-')) : null,
                                    'member_work_1' => !is_null($value['alhal_alothyfyh_1']) ? substr($value['alhal_alothyfyh_1'], 0, strpos($value['alhal_alothyfyh_1'], '-')) : null,
                                    'member_health_status_1' => !is_null($value['alhal_alshyh_1']) ? substr($value['alhal_alshyh_1'], 0, strpos($value['alhal_alshyh_1'], '-')) : null,
                                    'member_qualification_1' => !is_null($value['alhal_altaalymy_1']) ? substr($value['alhal_altaalymy_1'], 0, strpos($value['alhal_altaalymy_1'], '-')) : null,

                                    'member_first_name_2' => $value['alasm_2'],
                                    'date_of_birth_2' => $value['alaamr_2'],
                                    'member_relationship_2' => !is_null($value['alkrab_2']) ? substr($value['alkrab_2'], 0, strpos($value['alkrab_2'], '-')) : null,
                                    'member_social_status_2' => !is_null($value['alhal_alajtmaaayh_2']) ? substr($value['alhal_alajtmaaayh_2'], 0, strpos($value['alhal_alajtmaaayh_2'], '-')) : null,
                                    'member_work_2' => !is_null($value['alhal_alothyfyh_2']) ? substr($value['alhal_alothyfyh_2'], 0, strpos($value['alhal_alothyfyh_2'], '-')) : null,
                                    'member_health_status_2' => !is_null($value['alhal_alshyh_2']) ? substr($value['alhal_alshyh_2'], 0, strpos($value['alhal_alshyh_2'], '-')) : null,
                                    'member_qualification_2' => !is_null($value['alhal_altaalymy_2']) ? substr($value['alhal_altaalymy_2'], 0, strpos($value['alhal_altaalymy_2'], '-')) : null,

                                    'member_first_name_3' => $value['alasm_3'],
                                    'date_of_birth_3' => $value['alaamr_3'],
                                    'member_relationship_3' => !is_null($value['alkrab_3']) ? substr($value['alkrab_3'], 0, strpos($value['alkrab_3'], '-')) : null,
                                    'member_social_status_3' => !is_null($value['alhal_alajtmaaayh_3']) ? substr($value['alhal_alajtmaaayh_3'], 0, strpos($value['alhal_alajtmaaayh_3'], '-')) : null,
                                    'member_work_3' => !is_null($value['alhal_alothyfyh_3']) ? substr($value['alhal_alothyfyh_3'], 0, strpos($value['alhal_alothyfyh_3'], '-')) : null,
                                    'member_health_status_3' => !is_null($value['alhal_alshyh_3']) ? substr($value['alhal_alshyh_3'], 0, strpos($value['alhal_alshyh_3'], '-')) : null,
                                    'member_qualification_3' => !is_null($value['alhal_altaalymy_3']) ? substr($value['alhal_altaalymy_3'], 0, strpos($value['alhal_altaalymy_3'], '-')) : null,

                                    'member_first_name_4' => $value['alasm_4'],
                                    'date_of_birth_4' => $value['alaamr_4'],
                                    'member_relationship_4' => !is_null($value['alkrab_4']) ? substr($value['alkrab_4'], 0, strpos($value['alkrab_4'], '-')) : null,
                                    'member_social_status_4' => !is_null($value['alhal_alajtmaaayh_4']) ? substr($value['alhal_alajtmaaayh_4'], 0, strpos($value['alhal_alajtmaaayh_4'], '-')) : null,
                                    'member_work_4' => !is_null($value['alhal_alothyfyh_4']) ? substr($value['alhal_alothyfyh_4'], 0, strpos($value['alhal_alothyfyh_4'], '-')) : null,
                                    'member_health_status_4' => !is_null($value['alhal_alshyh_4']) ? substr($value['alhal_alshyh_4'], 0, strpos($value['alhal_alshyh_4'], '-')) : null,
                                    'member_qualification_4' => !is_null($value['alhal_altaalymy_4']) ? substr($value['alhal_altaalymy_4'], 0, strpos($value['alhal_altaalymy_4'], '-')) : null,

                                    'member_first_name_5' => $value['alasm_5'],
                                    'date_of_birth_5' => $value['alaamr_5'],
                                    'member_relationship_5' => !is_null($value['alkrab_5']) ? substr($value['alkrab_5'], 0, strpos($value['alkrab_5'], '-')) : null,
                                    'member_social_status_5' => !is_null($value['alhal_alajtmaaayh_5']) ? substr($value['alhal_alajtmaaayh_5'], 0, strpos($value['alhal_alajtmaaayh_5'], '-')) : null,
                                    'member_work_5' => !is_null($value['alhal_alothyfyh_5']) ? substr($value['alhal_alothyfyh_5'], 0, strpos($value['alhal_alothyfyh_5'], '-')) : null,
                                    'member_health_status_5' => !is_null($value['alhal_alshyh_5']) ? substr($value['alhal_alshyh_5'], 0, strpos($value['alhal_alshyh_5'], '-')) : null,
                                    'member_qualification_5' => !is_null($value['alhal_altaalymy_5']) ? substr($value['alhal_altaalymy_5'], 0, strpos($value['alhal_altaalymy_5'], '-')) : null,

                                    'member_first_name_6' => $value['alasm_6'],
                                    'date_of_birth_6' => $value['alaamr_6'],
                                    'member_relationship_6' => !is_null($value['alkrab_6']) ? substr($value['alkrab_6'], 0, strpos($value['alkrab_6'], '-')) : null,
                                    'member_social_status_6' => !is_null($value['alhal_alajtmaaayh_6']) ? substr($value['alhal_alajtmaaayh_6'], 0, strpos($value['alhal_alajtmaaayh_6'], '-')) : null,
                                    'member_work_6' => !is_null($value['alhal_alothyfyh_6']) ? substr($value['alhal_alothyfyh_6'], 0, strpos($value['alhal_alothyfyh_6'], '-')) : null,
                                    'member_health_status_6' => !is_null($value['alhal_alshyh_6']) ? substr($value['alhal_alshyh_6'], 0, strpos($value['alhal_alshyh_6'], '-')) : null,
                                    'member_qualification_6' => !is_null($value['alhal_altaalymy_6']) ? substr($value['alhal_altaalymy_6'], 0, strpos($value['alhal_altaalymy_6'], '-')) : null,

                                    'member_first_name_7' => $value['alasm_7'],
                                    'date_of_birth_7' => $value['alaamr_7'],
                                    'member_relationship_7' => !is_null($value['alkrab_7']) ? substr($value['alkrab_7'], 0, strpos($value['alkrab_7'], '-')) : null,
                                    'member_social_status_7' => !is_null($value['alhal_alajtmaaayh_7']) ? substr($value['alhal_alajtmaaayh_7'], 0, strpos($value['alhal_alajtmaaayh_7'], '-')) : null,
                                    'member_work_7' => !is_null($value['alhal_alothyfyh_7']) ? substr($value['alhal_alothyfyh_7'], 0, strpos($value['alhal_alothyfyh_7'], '-')) : null,
                                    'member_health_status_7' => !is_null($value['alhal_alshyh_7']) ? substr($value['alhal_alshyh_7'], 0, strpos($value['alhal_alshyh_7'], '-')) : null,
                                    'member_qualification_7' => !is_null($value['alhal_altaalymy_7']) ? substr($value['alhal_altaalymy_7'], 0, strpos($value['alhal_altaalymy_7'], '-')) : null,

                                    'member_first_name_8' => $value['alasm_8'],
                                    'date_of_birth_8' => $value['alaamr_8'],
                                    'member_relationship_8' => !is_null($value['alkrab_8']) ? substr($value['alkrab_8'], 0, strpos($value['alkrab_8'], '-')) : null,
                                    'member_social_status_8' => !is_null($value['alhal_alajtmaaayh_8']) ? substr($value['alhal_alajtmaaayh_8'], 0, strpos($value['alhal_alajtmaaayh_8'], '-')) : null,
                                    'member_work_8' => !is_null($value['alhal_alothyfyh_8']) ? substr($value['alhal_alothyfyh_8'], 0, strpos($value['alhal_alothyfyh_8'], '-')) : null,
                                    'member_health_status_8' => !is_null($value['alhal_alshyh_8']) ? substr($value['alhal_alshyh_8'], 0, strpos($value['alhal_alshyh_8'], '-')) : null,
                                    'member_qualification_8' => !is_null($value['alhal_altaalymy_8']) ? substr($value['alhal_altaalymy_8'], 0, strpos($value['alhal_altaalymy_8'], '-')) : null,

                                    'member_first_name_9' => $value['alasm_9'],
                                    'date_of_birth_9' => $value['alaamr_9'],
                                    'member_relationship_9' => !is_null($value['alkrab_9']) ? substr($value['alkrab_9'], 0, strpos($value['alkrab_9'], '-')) : null,
                                    'member_social_status_9' => !is_null($value['alhal_alajtmaaayh_9']) ? substr($value['alhal_alajtmaaayh_9'], 0, strpos($value['alhal_alajtmaaayh_9'], '-')) : null,
                                    'member_work_9' => !is_null($value['alhal_alothyfyh_9']) ? substr($value['alhal_alothyfyh_9'], 0, strpos($value['alhal_alothyfyh_9'], '-')) : null,
                                    'member_health_status_9' => !is_null($value['alhal_alshyh_9']) ? substr($value['alhal_alshyh_9'], 0, strpos($value['alhal_alshyh_9'], '-')) : null,
                                    'member_qualification_9' => !is_null($value['alhal_altaalymy_9']) ? substr($value['alhal_altaalymy_9'], 0, strpos($value['alhal_altaalymy_9'], '-')) : null,

                                    'member_first_name_10' => $value['alasm_10'],
                                    'date_of_birth_10' => $value['alaamr_10'],
                                    'member_relationship_10' => !is_null($value['alkrab_10']) ? substr($value['alkrab_10'], 0, strpos($value['alkrab_10'], '-')) : null,
                                    'member_social_status_10' => !is_null($value['alhal_alajtmaaayh_10']) ? substr($value['alhal_alajtmaaayh_10'], 0, strpos($value['alhal_alajtmaaayh_10'], '-')) : null,
                                    'member_work_10' => !is_null($value['alhal_alothyfyh_10']) ? substr($value['alhal_alothyfyh_10'], 0, strpos($value['alhal_alothyfyh_10'], '-')) : null,
                                    'member_health_status_10' => !is_null($value['alhal_alshyh_10']) ? substr($value['alhal_alshyh_10'], 0, strpos($value['alhal_alshyh_10'], '-')) : null,
                                    'member_qualification_10' => !is_null($value['alhal_altaalymy_10']) ? substr($value['alhal_altaalymy_10'], 0, strpos($value['alhal_altaalymy_10'], '-')) : null,

                                    'member_first_name_11' => $value['alasm_11'],
                                    'date_of_birth_11' => $value['alaamr_11'],
                                    'member_relationship_11' => !is_null($value['alkrab_11']) ? substr($value['alkrab_11'], 0, strpos($value['alkrab_11'], '-')) : null,
                                    'member_social_status_11' => !is_null($value['alhal_alajtmaaayh_11']) ? substr($value['alhal_alajtmaaayh_11'], 0, strpos($value['alhal_alajtmaaayh_11'], '-')) : null,
                                    'member_work_11' => !is_null($value['alhal_alothyfyh_11']) ? substr($value['alhal_alothyfyh_11'], 0, strpos($value['alhal_alothyfyh_11'], '-')) : null,
                                    'member_health_status_11' => !is_null($value['alhal_alshyh_11']) ? substr($value['alhal_alshyh_11'], 0, strpos($value['alhal_alshyh_11'], '-')) : null,
                                    'member_qualification_11' => !is_null($value['alhal_altaalymy_11']) ? substr($value['alhal_altaalymy_11'], 0, strpos($value['alhal_altaalymy_11'], '-')) : null,

                                    'member_first_name_12' => $value['alasm_12'],
                                    'date_of_birth_12' => $value['alaamr_12'],
                                    'member_relationship_12' => !is_null($value['alkrab_12']) ? substr($value['alkrab_12'], 0, strpos($value['alkrab_12'], '-')) : null,
                                    'member_social_status_12' => !is_null($value['alhal_alajtmaaayh_12']) ? substr($value['alhal_alajtmaaayh_12'], 0, strpos($value['alhal_alajtmaaayh_12'], '-')) : null,
                                    'member_work_12' => !is_null($value['alhal_alothyfyh_12']) ? substr($value['alhal_alothyfyh_12'], 0, strpos($value['alhal_alothyfyh_12'], '-')) : null,
                                    'member_health_status_12' => !is_null($value['alhal_alshyh_12']) ? substr($value['alhal_alshyh_12'], 0, strpos($value['alhal_alshyh_12'], '-')) : null,
                                    'member_qualification_12' => !is_null($value['alhal_altaalymy_12']) ? substr($value['alhal_altaalymy_12'], 0, strpos($value['alhal_altaalymy_12'], '-')) : null,

                                    'member_first_name_13' => $value['alasm_13'],
                                    'date_of_birth_13' => $value['alaamr_13'],
                                    'member_relationship_13' => !is_null($value['alkrab_13']) ? substr($value['alkrab_13'], 0, strpos($value['alkrab_13'], '-')) : null,
                                    'member_social_status_13' => !is_null($value['alhal_alajtmaaayh_13']) ? substr($value['alhal_alajtmaaayh_13'], 0, strpos($value['alhal_alajtmaaayh_13'], '-')) : null,
                                    'member_work_13' => !is_null($value['alhal_alothyfyh_13']) ? substr($value['alhal_alothyfyh_13'], 0, strpos($value['alhal_alothyfyh_13'], '-')) : null,
                                    'member_health_status_13' => !is_null($value['alhal_alshyh_13']) ? substr($value['alhal_alshyh_13'], 0, strpos($value['alhal_alshyh_13'], '-')) : null,
                                    'member_qualification_13' => !is_null($value['alhal_altaalymy_13']) ? substr($value['alhal_altaalymy_13'], 0, strpos($value['alhal_altaalymy_13'], '-')) : null,

                                    'member_first_name_14' => $value['alasm_14'],
                                    'date_of_birth_14' => $value['alaamr_14'],
                                    'member_relationship_14' => !is_null($value['alkrab_14']) ? substr($value['alkrab_14'], 0, strpos($value['alkrab_14'], '-')) : null,
                                    'member_social_status_14' => !is_null($value['alhal_alajtmaaayh_14']) ? substr($value['alhal_alajtmaaayh_14'], 0, strpos($value['alhal_alajtmaaayh_14'], '-')) : null,
                                    'member_work_14' => !is_null($value['alhal_alothyfyh_14']) ? substr($value['alhal_alothyfyh_14'], 0, strpos($value['alhal_alothyfyh_14'], '-')) : null,
                                    'member_health_status_14' => !is_null($value['alhal_alshyh_14']) ? substr($value['alhal_alshyh_14'], 0, strpos($value['alhal_alshyh_14'], '-')) : null,
                                    'member_qualification_14' => !is_null($value['alhal_altaalymy_14']) ? substr($value['alhal_altaalymy_14'], 0, strpos($value['alhal_altaalymy_14'], '-')) : null,

                                    'member_first_name_15' => $value['alasm_15'],
                                    'date_of_birth_15' => $value['alaamr_15'],
                                    'member_relationship_15' => !is_null($value['alkrab_15']) ? substr($value['alkrab_15'], 0, strpos($value['alkrab_15'], '-')) : null,
                                    'member_social_status_15' => !is_null($value['alhal_alajtmaaayh_15']) ? substr($value['alhal_alajtmaaayh_15'], 0, strpos($value['alhal_alajtmaaayh_15'], '-')) : null,
                                    'member_work_15' => !is_null($value['alhal_alothyfyh_15']) ? substr($value['alhal_alothyfyh_15'], 0, strpos($value['alhal_alothyfyh_15'], '-')) : null,
                                    'member_health_status_15' => !is_null($value['alhal_alshyh_15']) ? substr($value['alhal_alshyh_15'], 0, strpos($value['alhal_alshyh_15'], '-')) : null,
                                    'member_qualification_15' => !is_null($value['alhal_altaalymy_15']) ? substr($value['alhal_altaalymy_15'], 0, strpos($value['alhal_altaalymy_15'], '-')) : null,

                                    'member_first_name_16' => $value['alasm_16'],
                                    'date_of_birth_16' => $value['alaamr_16'],
                                    'member_relationship_16' => !is_null($value['alkrab_16']) ? substr($value['alkrab_16'], 0, strpos($value['alkrab_16'], '-')) : null,
                                    'member_social_status_16' => !is_null($value['alhal_alajtmaaayh_16']) ? substr($value['alhal_alajtmaaayh_16'], 0, strpos($value['alhal_alajtmaaayh_16'], '-')) : null,
                                    'member_work_16' => !is_null($value['alhal_alothyfyh_16']) ? substr($value['alhal_alothyfyh_16'], 0, strpos($value['alhal_alothyfyh_16'], '-')) : null,
                                    'member_health_status_16' => !is_null($value['alhal_alshyh_16']) ? substr($value['alhal_alshyh_16'], 0, strpos($value['alhal_alshyh_16'], '-')) : null,
                                    'member_qualification_16' => !is_null($value['alhal_altaalymy_16']) ? substr($value['alhal_altaalymy_16'], 0, strpos($value['alhal_altaalymy_16'], '-')) : null,

                                    'member_first_name_17' => $value['alasm_17'],
                                    'date_of_birth_17' => $value['alaamr_17'],
                                    'member_relationship_17' => !is_null($value['alkrab_17']) ? substr($value['alkrab_17'], 0, strpos($value['alkrab_17'], '-')) : null,
                                    'member_social_status_17' => !is_null($value['alhal_alajtmaaayh_17']) ? substr($value['alhal_alajtmaaayh_17'], 0, strpos($value['alhal_alajtmaaayh_17'], '-')) : null,
                                    'member_work_17' => !is_null($value['alhal_alothyfyh_17']) ? substr($value['alhal_alothyfyh_17'], 0, strpos($value['alhal_alothyfyh_17'], '-')) : null,
                                    'member_health_status_17' => !is_null($value['alhal_alshyh_17']) ? substr($value['alhal_alshyh_17'], 0, strpos($value['alhal_alshyh_17'], '-')) : null,
                                    'member_qualification_17' => !is_null($value['alhal_altaalymy_17']) ? substr($value['alhal_altaalymy_17'], 0, strpos($value['alhal_altaalymy_17'], '-')) : null,

                                    'member_first_name_18' => $value['alasm_18'],
                                    'date_of_birth_18' => $value['alaamr_18'],
                                    'member_relationship_18' => !is_null($value['alkrab_18']) ? substr($value['alkrab_18'], 0, strpos($value['alkrab_18'], '-')) : null,
                                    'member_social_status_18' => !is_null($value['alhal_alajtmaaayh_18']) ? substr($value['alhal_alajtmaaayh_18'], 0, strpos($value['alhal_alajtmaaayh_18'], '-')) : null,
                                    'member_work_18' => !is_null($value['alhal_alothyfyh_18']) ? substr($value['alhal_alothyfyh_18'], 0, strpos($value['alhal_alothyfyh_18'], '-')) : null,
                                    'member_health_status_18' => !is_null($value['alhal_alshyh_18']) ? substr($value['alhal_alshyh_18'], 0, strpos($value['alhal_alshyh_18'], '-')) : null,
                                    'member_qualification_18' => !is_null($value['alhal_altaalymy_18']) ? substr($value['alhal_altaalymy_18'], 0, strpos($value['alhal_altaalymy_18'], '-')) : null,

                                    'member_first_name_19' => $value['alasm_19'],
                                    'date_of_birth_19' => $value['alaamr_19'],
                                    'member_relationship_19' => !is_null($value['alkrab_19']) ? substr($value['alkrab_19'], 0, strpos($value['alkrab_19'], '-')) : null,
                                    'member_social_status_19' => !is_null($value['alhal_alajtmaaayh_19']) ? substr($value['alhal_alajtmaaayh_19'], 0, strpos($value['alhal_alajtmaaayh_19'], '-')) : null,
                                    'member_work_19' => !is_null($value['alhal_alothyfyh_19']) ? substr($value['alhal_alothyfyh_19'], 0, strpos($value['alhal_alothyfyh_19'], '-')) : null,
                                    'member_health_status_19' => !is_null($value['alhal_alshyh_19']) ? substr($value['alhal_alshyh_19'], 0, strpos($value['alhal_alshyh_19'], '-')) : null,
                                    'member_qualification_19' => !is_null($value['alhal_altaalymy_19']) ? substr($value['alhal_altaalymy_19'], 0, strpos($value['alhal_altaalymy_19'], '-')) : null,

                                    'member_first_name_20' => $value['alasm_20'],
                                    'date_of_birth_20' => $value['alaamr_20'],
                                    'member_relationship_20' => !is_null($value['alkrab_20']) ? substr($value['alkrab_20'], 0, strpos($value['alkrab_20'], '-')) : null,
                                    'member_social_status_20' => !is_null($value['alhal_alajtmaaayh_20']) ? substr($value['alhal_alajtmaaayh_20'], 0, strpos($value['alhal_alajtmaaayh_20'], '-')) : null,
                                    'member_work_20' => !is_null($value['alhal_alothyfyh_20']) ? substr($value['alhal_alothyfyh_20'], 0, strpos($value['alhal_alothyfyh_20'], '-')) : null,
                                    'member_health_status_20' => !is_null($value['alhal_alshyh_20']) ? substr($value['alhal_alshyh_20'], 0, strpos($value['alhal_alshyh_20'], '-')) : null,
                                    'member_qualification_20' => !is_null($value['alhal_altaalymy_20']) ? substr($value['alhal_altaalymy_20'], 0, strpos($value['alhal_altaalymy_20'], '-')) : null,
                                ];


                            } else {
                                array_push($errors, $i + 1);
                                continue;
                            }

                        }
                    } else {

                        event(new NewLogCreated($message, null, 98, 0, null));
                        return back()->with('error', 'لم يتم إضافة زيارات اسر عن طريق ملف اكسل بنجاح لعدم وجود الاعمده المطلوبه');
                    }


                    if (!empty($arr)) {
                        foreach ($arr as $value) {


                            $personData['first_name'] = trim($value['first_name']);
                            $personData['second_name'] = trim($value['second_name']);
                            $personData['third_name'] = trim($value['third_name']);
                            $personData['family_name'] = trim($value['family_name']);
                            $personData['first_name_tr'] = trim($value['first_name_tr']);
                            $personData['third_name_tr'] = trim($value['third_name_tr']);
                            $personData['family_name_tr'] = trim($value['family_name_tr']);
                            $personData['second_name_tr'] = trim($value['second_name_tr']);
                            $personData['id_number'] = $value['id_number'];
                            $personData['id_type_id'] = 1;
                            $personData['work'] = $value['work'];
                            $personData['date_of_birth'] = $value['date_of_birth'];

                            $familyData['year'] = Carbon::now()->year;
                            $familyData['visit_date'] = $value['visit_date'] ? $value['visit_date']->format('Y/m/d') : null;

                            $familyData['mobile_one'] = $value['mobile_one'];
                            $familyData['mobile_two'] = $value['mobile_two'];
                            $familyData['telephone'] = ($value['phone'] == '-') ? null : $value['phone'];
                            $familyData['need'] = $value['need'] == 1 ?? 0;
                            $familyData['id_university'] = $value['id_university'];
                            $familyData['graduated_date'] = $value['graduated_date'];
                            $familyData['neighborhood_id'] = $value['neighborhood_id'];
                            //$familyData['city_id'] = $value['city_id'];
                            $familyData['address'] = $value['address'];
                            $familyData['job_type_id'] = $value['job_type_id'];
                            $familyData['house_ownership_id'] = $value['house_ownership_id'];
                            $familyData['house_status_id'] = $value['house_status_id'];
                            $familyData['note'] = $value['note'];
                            $familyData['searcher_note'] = $value['searcher_note'];
                            $familyData['visit_reason_id'] = 6; // visit
                            $familyData['family_type_id'] = $value['family_type_id'];
                            $familyData['family_project_id'] = 1; // تعلىم اخوه
                            $familyData['data_entry_id'] = Auth::user()->id;
                            $familyData['family_status_id'] = $value['family_status_id'];
                            $familyData['is_imported'] = 1;

                            $personData['full_name'] = $personData['first_name'] . ' ' . $personData['second_name'] . ' ' . $personData['third_name'] . ' ' . $personData['family_name'];

                            $personData['full_name_tr'] = $personData['first_name_tr'] . ' ' . $personData['second_name_tr'] . ' ' . $personData['third_name_tr'] . ' ' . $personData['family_name_tr'];
                            $checkFound = $this->checkFound($personData['id_number'], $personData['full_name_tr']);


                            if ($checkFound === false)
                                continue;

                            if ($checkFound > 0 && $checkFound !== true) {
                                $oldFamily = Family::find($checkFound);
                                $existPerson = $oldFamily->person;


                                $familyData['family_classification_id'] = ($familyData['need'] == 0 && $oldFamily->family_classification_id == 1) ? 5 : $oldFamily->family_classification_id;
                                $familyData['ignore_date'] = ($familyData['need'] == 0 && $oldFamily->need == 1) ? Carbon::now()->toDateString() : null;
                                $familyData['ignore_reason'] = ($familyData['need'] == 0 && $oldFamily->need == 1) ? $familyData['searcher_note'] : "";

                                if ((!is_null($oldFamily))) {

                                    $visit_count = $oldFamily->visit_count;
                                    $existPerson->update($personData);

                                    $oldFamily->update($familyData);

                                    //dd(1);
                                    $newPerson = $existPerson->replicate();
                                    $newPerson->save();

                                    // clone family
                                    $newFamily = $oldFamily->replicate();
                                    $newFamily->save();


                                    $newFamily->update(
                                        [
                                            'visit_count' => $visit_count,
                                            'approve' => 1,
                                            'archive' => 1,
                                            'parent_id' => $oldFamily->id,
                                            'person_id' => $newPerson->id,
                                        ]);

                                    $updateData = [
                                        'archive' => 0,
                                        'approve' => 0,
                                        'visit_count' => $visit_count + 1,
                                        'expense_id' => null,
                                    ];
                                    $oldFamily->update($updateData);


                                    // clone income
                                    if ((isset($oldFamily->incomes)) && (!is_null($oldFamily->incomes))) {
                                        foreach ($oldFamily->incomes as $item) {
                                            $newIncome = $item->replicate();
                                            $newIncome->family_id = $newFamily->id;
                                            $newIncome->save();
                                        }
                                    }

                                    // clone members
                                    if ((isset($oldFamily->members)) && (!is_null($oldFamily->members))) {
                                        foreach ($oldFamily->members as $item) {
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
                                    if ((isset($oldFamily->searcher)) && (!is_null($oldFamily->searcher))) {
                                        foreach ($oldFamily->searcher as $item) {
                                            $newSearcher = $item->replicate();
                                            $newSearcher->family_id = $newFamily->id;
                                            $newSearcher->save();
                                        }
                                    }

                                    // clone member diseases
                                    if ((isset($oldFamily->familyMemberDiseases)) && (!is_null($oldFamily->familyMemberDiseases))) {
                                        foreach ($oldFamily->familyMemberDiseases as $item) {
                                            $newIncome = $item->replicate();
                                            $newIncome->family_id = $newFamily->id;
                                            $newIncome->save();
                                        }
                                    }


                                    if ((isset($oldFamily->searcher)) && (!($oldFamily->searcher)->isEmpty())) {

                                        foreach ($oldFamily->searcher as $itemSearcher) {
                                            if (!is_null($itemSearcher)) {
                                                $itemSearcher->delete();
                                            }
                                        }
                                    }

                                    //searcher
                                    if ($value['searcher_id'] != '') {
                                        FamilySearcher::create([
                                            'searcher_id' => $value['searcher_id'],
                                            'family_id' => $oldFamily->id,
                                        ]);
                                    }

                                    // income
                                    if ((isset($oldFamily->incomes)) && (!($oldFamily->incomes)->isEmpty())) {

                                        foreach ($oldFamily->incomes as $income) {
                                            if (!is_null($income)) {
                                                $income->delete();
                                            }
                                        }
                                    }

                                    for ($i = 1; $i <= 3; $i++) {
                                        $allIncomeData['income_type_id'] = $value['income_type_id_' . $i];
                                        $allIncomeData['income_value'] = $value['income_value_' . $i];

                                        if (($allIncomeData['income_type_id'] != '')) {
                                            FamilyIncome::create([
                                                'family_id' => $oldFamily->id,
                                                'income_type_id' => $allIncomeData['income_type_id'],
                                                'value' => $allIncomeData['income_value']
                                            ]);
                                        }
                                    }

                                    // members

                                    if ((isset($oldFamily->members)) && (!($oldFamily->members)->isEmpty())) {

                                        foreach ($oldFamily->members as $member) {
                                            $person = isset($member->person) ? $member->person : null;
                                            if (!is_null($person)) {
                                                $member->delete();
                                            }
                                        }
                                    }

                                    for ($i = 1; $i <= 20; $i++) {
                                        $allMemberData['first_name'] = trim($value['member_first_name_' . $i]);
                                        $allMemberData['first_name_tr'] = NameTranslation::where('arabic', $allMemberData['first_name'])->first() ? NameTranslation::where('arabic', $allMemberData['first_name'])->first()->turkey : null;
                                        $allMemberData['date_of_birth'] = $value['date_of_birth_' . $i];
                                        $allMemberData['social_status_id'] = $value['member_social_status_' . $i];
                                        $allMemberData['work'] = $value['member_work_' . $i];
                                        $allMemberData['health_status'] = $value['member_health_status_' . $i];
                                        $allMemberData['qualification_id'] = $value['member_qualification_' . $i];

                                        if (($allMemberData['first_name'] != '')) {

                                            if (($value['member_relationship_' . $i] == 27) || ($value['member_relationship_' . $i] == 44) ||
                                                ($value['member_relationship_' . $i] == 45) || ($value['member_relationship_' . $i] == 32) ||
                                                ($value['member_relationship_' . $i] == 33) || ($value['member_relationship_' . $i] == 34)) {

                                                $id = $value['wive_id_number'];
                                                $existPerson = Person::where('id_number', '<>', '')->where('id_number', '=', $id)->first();

                                                if (!is_null($existPerson)) {
                                                    $existPerson->update(['id_number' => $id]);
                                                    Member::create([
                                                        'family_id' => $oldFamily->id,
                                                        'person_id' => $existPerson->id,
                                                        'relationship_id' => $value['member_relationship_' . $i],
                                                    ]);

                                                } else {
                                                    $memberPerson = Person::create($allMemberData);
                                                    $memberPerson->update(['id_number' => $id]);
                                                    Member::create([
                                                        'family_id' => $oldFamily->id,
                                                        'person_id' => $memberPerson->id,
                                                        'relationship_id' => $value['member_relationship_' . $i],
                                                    ]);
                                                }

                                            } else {
                                                $memberPerson = Person::create($allMemberData);

                                                Member::create([
                                                    'family_id' => $oldFamily->id,
                                                    'person_id' => $memberPerson->id,
                                                    'relationship_id' => $value['member_relationship_' . $i],
                                                ]);
                                            }
                                        }
                                    }
                                }

                            } elseif ($checkFound === true) {
                                $familyData['family_classification_id'] = $familyData['need'] == 0 ? 5 : 1;// new
                                $familyData['ignore_date'] = ($familyData['need'] == 0) ? Carbon::now()->toDateString() : null;
                                $familyData['ignore_reason'] = ($familyData['need'] == 0) ? $familyData['searcher_note'] : "";
                                $familyData['visit_count'] = 1;


                                $person = Person::create($personData);
                                if ($person) {
                                    $familyData['person_id'] = $person->id;

                                    $family = Family::create($familyData);

                                    $familyDataLog['visit_date'] = Carbon::now()->format('Y/m/d');

                                    if ($family) {
                                        //searcher
                                        if ($value['searcher_id'] != '') {
                                            FamilySearcher::create([
                                                'searcher_id' => $value['searcher_id'],
                                                'family_id' => $family->id,
                                            ]);
                                        }

                                        // income
                                        for ($i = 1; $i <= 3; $i++) {
                                            $allIncomeData['income_type_id'] = $value['income_type_id_' . $i];
                                            $allIncomeData['income_value'] = $value['income_value_' . $i];

                                            if (($allIncomeData['income_type_id'] != '')) {
                                                FamilyIncome::create([
                                                    'family_id' => $family->id,
                                                    'income_type_id' => $allIncomeData['income_type_id'],
                                                    'value' => $allIncomeData['income_value']
                                                ]);
                                            }
                                        }

                                        // member
                                        for ($i = 1; $i <= 20; $i++) {
                                            $allMemberData['first_name'] = trim($value['member_first_name_' . $i]);
                                            $allMemberData['first_name_tr'] = NameTranslation::where('arabic', $allMemberData['first_name'])->first() ? NameTranslation::where('arabic', $allMemberData['first_name'])->first()->turkey : null;

                                            $allMemberData['date_of_birth'] = $value['date_of_birth_' . $i];
                                            $allMemberData['social_status_id'] = $value['member_social_status_' . $i];
                                            $allMemberData['work'] = $value['member_work_' . $i];
                                            $allMemberData['health_status'] = $value['member_health_status_' . $i];
                                            $allMemberData['qualification_id'] = $value['member_qualification_' . $i];

                                            if (($allMemberData['first_name'] != '')) {


                                                if (
                                                    ($value['member_relationship_' . $i] == 27) || ($value['member_relationship_' . $i] == 44) ||
                                                    ($value['member_relationship_' . $i] == 45) || ($value['member_relationship_' . $i] == 32) ||
                                                    ($value['member_relationship_' . $i] == 33) || ($value['member_relationship_' . $i] == 34)
                                                ) {

                                                    $id = $value['wive_id_number'];
                                                    $existPerson = Person::where('id_number', '<>', '')->where('id_number', '=', $id)->first();

                                                    if (!is_null($existPerson)) {
                                                        $memberPerson = $existPerson->update(['id_number' => $id]);
                                                        Member::create([
                                                            'family_id' => $family->id,
                                                            'person_id' => $memberPerson->id,
                                                            'relationship_id' => $value['member_relationship_' . $i],

                                                        ]);

                                                    } else {
                                                        $memberPerson = Person::create($allMemberData);
                                                        $memberPerson->update(['id_number' => $id]);
                                                        Member::create([
                                                            'family_id' => $family->id,
                                                            'person_id' => $memberPerson->id,
                                                            'relationship_id' => $value['member_relationship_' . $i],

                                                        ]);
                                                    }
                                                } else {
                                                    $memberPerson = Person::create($allMemberData);

                                                    Member::create([
                                                        'family_id' => $family->id,
                                                        'person_id' => $memberPerson->id,
                                                        'relationship_id' => $value['member_relationship_' . $i],
                                                    ]);
                                                }

                                            }

                                        }

                                    }
                                }
                            } else {
                                continue;
                            }

                            $errors_msg = $errors ? " وفشل في استيراد الصفوف " . implode(",", $errors) : "";
                            $message = ' تم إضافه زيارات عن طريق ملف اكسل بنجاح ' . $errors_msg;
                            $type = 'success';
                            event(new NewLogCreated($message, $personData['first_name'], 98, 0, null));
                        }
                    } else {
                        $message = 'لم يتم إضافة زياره بنجاح';

                        event(new NewLogCreated($message, $value['first_name'], 98, 0, null));
                        return back()->with('error', $message);

                    }
                }
                return back()->with('success', $message);

            } else {
                event(new NewLogCreated($message, null, 98, 0, null));
                return back()->with('error', 'لم يتم تحميل الملف بنجاح يجب ان يكون نوع الملف xlsx');
            }

        } else {
            event(new NewLogCreated($message, null, 98, 0, null));
            return redirect('admin/families')->with('error', 'لم يتم تحميل الملف بنجاح');
        }
    }

    function checkFound($id_number, $full_name_tr)
    {
        $falmils_by_name = Family::whereNull('parent_id')->whereHas('person'
            , function ($query) use ($full_name_tr) {
                $query->where('full_name_tr', $full_name_tr);
            })->with('person');
        $falmils_by_id_number = Family::whereNull('parent_id')->whereHas('person'
            , function ($query) use ($id_number) {
                $query->where('id_number', $id_number);
            })->with('person');
        $vists_by_name = array_unique(array_filter(Family::whereNotNull('parent_id')->whereHas('person'
            , function ($query) use ($full_name_tr) {
                $query->where('full_name_tr', $full_name_tr);
            })->pluck('parent_id')->toArray()));
        $vists_by_id_number = array_unique(array_filter(Family::whereNotNull('parent_id')->whereHas('person'
            , function ($query) use ($id_number) {
                $query->where('id_number', $id_number);
            })->pluck('parent_id')->toArray()));

        if (/*(count($vists_by_name) > 1 || count($vists_by_id_number) > 1) ||
            (count($vists_by_name) > 1 && count($vists_by_id_number) == 0) ||
            (count($vists_by_name) == 0 && count($vists_by_id_number) > 1) ||
            (count($vists_by_name) == 0 && count($vists_by_id_number) > 1) ||*/
            ($falmils_by_name->count() > 1 || $falmils_by_id_number->count() > 1) ||
            ($falmils_by_name->count() > 1 && !($falmils_by_id_number->first())) ||
            (!($falmils_by_name->first()) && $falmils_by_id_number->count() > 1)) {

            return false;
        } else {
            if ($falmils_by_name->count() == 1) {
                $family_id = $falmils_by_name->first()->id;
                return $family_id;
            } elseif (count($vists_by_name) == 1) {
                $family_id = Family::find($vists_by_name[0])->id;
                return $family_id;
            } elseif ($falmils_by_id_number->count() == 1) {
                $family_id = $falmils_by_id_number->first()->id;
                return $family_id;
            } elseif (count($vists_by_id_number) == 1) {
                $family_id = Family::find($vists_by_id_number[0])->id;
                return $family_id;
            } else {
                return true;
            }
        }

    }

//    public function orderd()
//    {
//
//
//        Person::whereIn('id', Family::whereHas('person'
//            , function ($query) {
//                $query->where('id_number', "=", "")
//                    ->orWhere('id_number', "=", "-");
//            })->pluck('person_id')->toArray())
//            ->update(["id_number" => null]);
//
//        Person::whereIn('id', Family::whereHas('person'
//            , function ($query) {
//                $query->where('full_name_tr', "=", "")
//                    ->orWhere('full_name_tr', "=", "-");
//            })->pluck('person_id')->toArray())
//            ->update(["full_name_tr" => null]);
//
//
//        Family::whereHas('person')
//            ->where('code', "=", "")
//            ->orWhere('code', "=", "-")
//            ->update(["code" => null]);
//
////اعلى لتوحيد الفاضي والفراغات بنال
//
//
//        Family::destroy(Family::whereHas('person'
//            , function ($query) {
//                $query->WhereNull('id_number')
//                    ->WhereNull('full_name_tr');
//            })->WhereNull('code')
//            ->pluck('id')->toArray());
//
//
//        $allfamileis = Family::whereHas('person', function ($query) {
//            $query->whereNotNull('full_name_tr')
//                ->where('full_name_tr', "!=", "")
//                ->whereNotNull('id_number')
//                ->where('id_number', "!=", "")
//                ->where('id_number', "!=", "-")
//                ->where('full_name_tr', "!=", "-");
//        })->orderBy('updated_at')
//            ->get();
//        foreach ($allfamileis->chunk(50) as $families) {
//            set_time_limit(0);
//            foreach ($families as $family) {
//                set_time_limit(0);
//
//                if (strpos($family->updated_at, Carbon::today()->toDateString()) !== false
//                ) {
//                    continue;
//
//                }
//                $full_name_tr = $family->person->full_name_tr;
//                $id_number = $family->person->id_number;
//
//                $falmils_by_name = Family::whereHas('person'
//                    , function ($query) use ($full_name_tr) {
//                        $query->where('full_name_tr', $full_name_tr);
//                    })->with('person');
//                $falmils_by_id_number = Family::whereHas('person'
//                    , function ($query) use ($id_number) {
//                        $query->where('id_number', $id_number);
//                    })->with('person');
//
//                if ($falmils_by_id_number->count() > 1) {
//                    $thefamilies = $falmils_by_id_number->get()->sortByDesc('id');
//                } elseif ($falmils_by_name->count() > 1) {
//                    $thefamilies = $falmils_by_name->get()->sortByDesc('id');
//                } else {
//                    $family->update(['visit_count' => 1]);
//                    continue;
//                }
//                $i = $thefamilies->count();
//                $parent_id = $thefamilies->first()->id;
//                foreach ($thefamilies as $thefamily) {
//                    if ($i == $thefamilies->count()) {
//                        $thefamily->update(['parent_id' => null, 'visit_count' => $i]);
//                    } else {
//                        $thefamily->update(['parent_id' => $parent_id, 'visit_count' => $i]);
//
//                    }
//                    $i--;
//                }
//                $i = 1;
//            }
//            //sleep(5);
//
//        }
//
//
//        $scound_stop_familis = Family::whereHas('person', function ($query) {
//            $query->whereNull('full_name_tr')
//                ->whereNotNull('id_number');
//        })->orderBy('updated_at', 'desc')
//            ->get();
//        foreach ($scound_stop_familis->chunk(50) as $families) {
//            set_time_limit(0);
//            foreach ($families as $family) {
//                set_time_limit(0);
//
//                if (strpos($family->updated_at, Carbon::today()->toDateString()) !== false
//                ) {
//
//                    continue;
//                }
//                $id_number = $family->person->id_number;
//
//                $falmils_by_id_number = Family::whereHas('person'
//                    , function ($query) use ($id_number) {
//                        $query->where('id_number', $id_number);
//                    })->with('person');
//
//
//                if ($falmils_by_id_number->count() > 1) {
//                    $thefamilies = $falmils_by_id_number->get()->sortByDesc('id');
//                } else {
//                    $family->update(['visit_count' => 1]);
//                    continue;
//                }
//                $i = $thefamilies->count();
//                $parent_id = $thefamilies->first()->id;
//                foreach ($thefamilies as $thefamily) {
//                    if ($i == $thefamilies->count()) {
//                        $thefamily->update(['parent_id' => null, 'visit_count' => $i]);
//                    } else {
//                        $thefamily->update(['parent_id' => $parent_id, 'visit_count' => $i]);
//
//                    }
//                    $i--;
//                }
//                $i = 1;
//            }
//            //sleep(5);
//        }
//
//
//        $first_stop_familis = Family::whereHas('person', function ($query) {
//            $query->WhereNull('id_number')
//                ->whereNotNull('full_name_tr');
//        }) ->orderBy('updated_at', 'desc')
//            ->get();
//        foreach ($first_stop_familis->chunk(50) as $families) {
//            set_time_limit(0);
//            foreach ($families as $family) {
//                set_time_limit(0);
//
//                if (strpos($family->updated_at, Carbon::today()->toDateString()) !== false
//                ) {
//
//                    continue;
//                }
//                $full_name_tr = $family->person->full_name_tr;
//
//                $falmils_by_name = Family::whereHas('person'
//                    , function ($query) use ($full_name_tr) {
//                        $query->where('full_name_tr', $full_name_tr);
//                    })->with('person');
//
//                if ($falmils_by_name->count() > 1) {
//                    $thefamilies = $falmils_by_name->get()->sortByDesc('id');
//                } else {
//                    $family->update(['visit_count' => 1]);
//                    continue;
//                }
//                $i = $thefamilies->count();
//                $parent_id = $thefamilies->first()->id;
//                foreach ($thefamilies as $thefamily) {
//                    if ($i == $thefamilies->count()) {
//                        $thefamily->update(['parent_id' => null, 'visit_count' => $i]);
//                    } else {
//                        $thefamily->update(['parent_id' => $parent_id, 'visit_count' => $i]);
//
//                    }
//                    $i--;
//                }
//                $i = 1;
//            }
//            // sleep(5);
//        }
//
//
//        $thersit_stop_familis = Family::whereHas('person', function ($query) {
//            $query->WhereNull('id_number')
//                ->WhereNull('full_name_tr');
//        })->whereNotNull('code')
//            ->orderBy('updated_at', 'desc')
//            ->get();
//        foreach ($thersit_stop_familis->chunk(50) as $families) {
//            set_time_limit(0);
//            foreach ($families as $family) {
//                set_time_limit(0);
//
//                if (strpos($family->updated_at, Carbon::today()->toDateString()) !== false
//                ) {
//
//                    continue;
//                }
//                $code = $family->code;
//                $search_code = str_replace(".M", "", $code);
//                $falmils_by_code = Family::with('person')
//                    ->where(function ($query) use ($code, $search_code) {
//                        $query->where('code', $code)
//                            ->orWhere('code', $search_code);
//                    });
//                if ($falmils_by_code->count() > 1) {
//                    $thefamilies = $falmils_by_code->get()->sortByDesc('id');
//                } else {
//                    $family->update(['visit_count' => 1]);
//                    continue;
//                }
//                $i = $thefamilies->count();
//                $parent_id = $thefamilies->first()->id;
//                foreach ($thefamilies as $thefamily) {
//                    if ($i == $thefamilies->count()) {
//                        $thefamily->update(['parent_id' => null, 'visit_count' => $i]);
//                    } else {
//                        $thefamily->update(['parent_id' => $parent_id, 'visit_count' => $i]);
//
//                    }
//                    $i--;
//                }
//                $i = 1;
//            }
//            //sleep(5);
//        }
////يتم حذفه
//        //select families.id,parent_id,id_number , code, persons.full_name , persons.full_name_tr from `families`,persons where `families`.`person_id` = `persons`.`id` and exists (select * from `persons` where `families`.`person_id` = `persons`.`id` and `id_number` is null and `full_name_tr` is null) and `code` is null and `families`.`deleted_at` is null
//
//
//        dd('done');
//
//        //فحص الكفائة
//        //SELECT families.id,visit_count,parent_id,person_id,code,persons.full_name,persons.full_name_tr,persons.id_number,families.updated_at FROM `families`,persons where families.person_id = persons.id ORDER BY `families`.`updated_at` DESC
//
//        //SELECT families.id,visit_count,parent_id,person_id,code,persons.full_name,persons.full_name_tr,persons.id_number,families.updated_at FROM `families`,persons where families.person_id = persons.id and `families`.`updated_at` like '%2020-03-08%'and `families`.`updated_at` like '%2020-03-08%' ORDER BY `families`.`updated_at` DESC
//    }

//    public function orderd2()
//    {
//
//        $scound_stop_familis = Family::whereHas('person', function ($query) {
//            $query->whereNotNull('full_name')
//                ->whereNull('full_name_tr')
//                ->whereNotNull('id_number');
//        })->whereNull('code')
//            ->where('created_at', 'like', '%2020-03-16 12:%')
//            ->orderBy('created_at', 'desc')
//            ->get();
//
//
//        foreach ($scound_stop_familis->chunk(50) as $families) {
//            set_time_limit(0);
//            foreach ($families as $family) {
//                set_time_limit(0);
//
//                /*if (strpos($family->updated_at, Carbon::today()->toDateString()) !== false
//                ) {
//
//                    continue;
//                }*/
//                $id_number = $family->person->id_number;
//
//                $falmils_by_id_number = Family::whereHas('person'
//                    , function ($query) use ($id_number) {
//                        $query->where('id_number', $id_number);
//                    })->with('person');
//
//
//                if ($falmils_by_id_number->count() > 1) {
//                    $thefamilies = $falmils_by_id_number->get()->sortByDesc('id');
//                } else {
//                    $family->update(['visit_count' => 1]);
//                    continue;
//                }
//                $i = $thefamilies->count();
//                $parent_id = $thefamilies->first()->id;
//                foreach ($thefamilies as $thefamily) {
//                    if ($i == $thefamilies->count()) {
//                        $thefamily->update(['parent_id' => null, 'visit_count' => $i]);
//                    } else {
//                        $thefamily->update(['parent_id' => $parent_id, 'visit_count' => $i]);
//
//                    }
//                    $i--;
//                }
//                $i = 1;
//            }
//            //sleep(5);
//        }
//
//
//        dd('done');
//
//    }
//
//
//    public function orderd3()
//    {
//
//        $scound_stop_familis = Family::whereNull('parent_id')->whereHas('childs')
//            ->get();
//
//
//        foreach ($scound_stop_familis->chunk(50) as $families) {
//            set_time_limit(0);
//            foreach ($families as $newFamily) {
//                set_time_limit(0);
//                $newPerson = $newFamily->person;
//
//                $family = $newFamily->childs()->orderBy('visit_count', 'desc')->first();
//                $person = $family->person;
//
//                $tt = $family->toArray();
//                unset($tt['person']);
//                unset($tt['id']);
//
//                $newFamily->update($tt);
//                $updateData = [
//                    'archive' => 0,
//                    'approve' => 0,
//                    'visit_count' => $family->visit_count + 1,
//                    'expense_id' => null,
//                    'parent_id' => null,
//                    'person_id' => $newPerson->id,
//                ];
//                $newFamily->update($updateData);
//
//
//                $tt2 = $person->toArray();
//                unset($tt2['id']);
//
//                $newPerson->update($tt2);
//
//
//                // clone income
//                if ((isset($family->incomes)) && (!is_null($family->incomes))) {
//                    foreach ($family->incomes as $item) {
//                        $newIncome = $item->replicate();
//                        $newIncome->family_id = $newFamily->id;
//                        $newIncome->save();
//                    }
//                }
//
//                // clone members
//                if ((isset($family->members)) && (!is_null($family->members))) {
//                    foreach ($family->members as $item) {
//                        $itemPerson = $item->person;
//                        $newMember = $item->replicate();
//                        $newPerson = $itemPerson->replicate();
//                        $newPerson->save();
//                        $newMember->family_id = $newFamily->id;
//                        $newMember->person_id = $newPerson->id;
//                        $newMember->save();
//                    }
//                }
//
//                // clone searcher
//                if ((isset($family->searcher)) && (!is_null($family->searcher))) {
//                    foreach ($family->searcher as $item) {
//                        $newSearcher = $item->replicate();
//                        $newSearcher->family_id = $newFamily->id;
//                        $newSearcher->save();
//                    }
//                }
//
//                // clone member diseases
//                if ((isset($family->familyMemberDiseases)) && (!is_null($family->familyMemberDiseases))) {
//                    foreach ($family->familyMemberDiseases as $item) {
//                        $newIncome = $item->replicate();
//                        $newIncome->family_id = $newFamily->id;
//                        $newIncome->save();
//                    }
//                }
//
//                //dd('done1');
//
//
//            }
//
//        }
//
//
//        dd('done');
////الفحص
//        //http://127.0.0.1:8000/admin/families/14552/edit
//        //http://127.0.0.1:8000/admin/families/2375/showArchive
//    }

//    public function orderd2()
//    {
//
//        $scound_stop_familis = Family::whereHas('person', function ($query) {
//            $query->whereNotNull('full_name')
//                ->whereNull('full_name_tr')
//                ->whereNotNull('id_number');
//        })->whereNull('code')
//            ->where('created_at', 'like', '%2020-03-16 12:%')
//            ->orderBy('created_at', 'desc')
//            ->get();
//
//
//        foreach ($scound_stop_familis->chunk(50) as $families) {
//            set_time_limit(0);
//            foreach ($families as $family) {
//                set_time_limit(0);
//
//                /*if (strpos($family->updated_at, Carbon::today()->toDateString()) !== false
//                ) {
//
//                    continue;
//                }*/
//                $id_number = $family->person->id_number;
//
//                $falmils_by_id_number = Family::whereHas('person'
//                    , function ($query) use ($id_number) {
//                        $query->where('id_number', $id_number);
//                    })->with('person');
//
//
//                if ($falmils_by_id_number->count() > 1) {
//                    $thefamilies = $falmils_by_id_number->get()->sortByDesc('id');
//                } else {
//                    $family->update(['visit_count' => 1]);
//                    continue;
//                }
//                $i = $thefamilies->count();
//                $parent_id = $thefamilies->first()->id;
//                foreach ($thefamilies as $thefamily) {
//                    if ($i == $thefamilies->count()) {
//                        $thefamily->update(['parent_id' => null, 'visit_count' => $i]);
//                    } else {
//                        $thefamily->update(['parent_id' => $parent_id, 'visit_count' => $i]);
//
//                    }
//                    $i--;
//                }
//                $i = 1;
//            }
//            //sleep(5);
//        }
//
//
//        dd('done');
//
//    }
//
//
//    public function orderd3()
//    {
//
//        $scound_stop_familis = Family::whereNull('parent_id')->whereHas('childs')
//            ->get();
//
//
//        foreach ($scound_stop_familis->chunk(50) as $families) {
//            set_time_limit(0);
//            foreach ($families as $newFamily) {
//                set_time_limit(0);
//                $newPerson = $newFamily->person;
//
//                $family = $newFamily->childs()->orderBy('visit_count', 'desc')->first();
//                $person = $family->person;
//
//                $tt = $family->toArray();
//                unset($tt['person']);
//                unset($tt['id']);
//
//                $newFamily->update($tt);
//                $updateData = [
//                    'archive' => 0,
//                    'approve' => 0,
//                    'visit_count' => $family->visit_count + 1,
//                    'expense_id' => null,
//                    'parent_id' => null,
//                    'person_id' => $newPerson->id,
//                ];
//                $newFamily->update($updateData);
//
//
//                $tt2 = $person->toArray();
//                unset($tt2['id']);
//
//                $newPerson->update($tt2);
//
//
//                // clone income
//                if ((isset($family->incomes)) && (!is_null($family->incomes))) {
//                    foreach ($family->incomes as $item) {
//                        $newIncome = $item->replicate();
//                        $newIncome->family_id = $newFamily->id;
//                        $newIncome->save();
//                    }
//                }
//
//                // clone members
//                if ((isset($family->members)) && (!is_null($family->members))) {
//                    foreach ($family->members as $item) {
//                        $itemPerson = $item->person;
//                        $newMember = $item->replicate();
//                        $newPerson = $itemPerson->replicate();
//                        $newPerson->save();
//                        $newMember->family_id = $newFamily->id;
//                        $newMember->person_id = $newPerson->id;
//                        $newMember->save();
//                    }
//                }
//
//                // clone searcher
//                if ((isset($family->searcher)) && (!is_null($family->searcher))) {
//                    foreach ($family->searcher as $item) {
//                        $newSearcher = $item->replicate();
//                        $newSearcher->family_id = $newFamily->id;
//                        $newSearcher->save();
//                    }
//                }
//
//                // clone member diseases
//                if ((isset($family->familyMemberDiseases)) && (!is_null($family->familyMemberDiseases))) {
//                    foreach ($family->familyMemberDiseases as $item) {
//                        $newIncome = $item->replicate();
//                        $newIncome->family_id = $newFamily->id;
//                        $newIncome->save();
//                    }
//                }
//
//                //dd('done1');
//
//
//            }
//
//        }
//
//
//        dd('done');
////الفحص
//        //http://127.0.0.1:8000/admin/families/14552/edit
//        //http://127.0.0.1:8000/admin/families/2375/showArchive
//    }

//    public function orderd4()
//    {
//
//        $scound_stop_familis = Family::whereNull('parent_id')
//            ->whereHas('person', function ($q) {
//                $q->whereNull('first_name');
//            })->whereHas('childs', function ($q) {
//                $q->whereHas('person'
//                    , function ($q) {
//                        $q->whereNotNull('first_name');
//                    });
//            })->get();
//
//
//        foreach ($scound_stop_familis->chunk(50) as $families) {
//            set_time_limit(0);
//            foreach ($families as $newFamily) {
//                set_time_limit(0);
//                $newPerson = $newFamily->person;
//
//                $family = $newFamily->childs()->whereHas('person'
//                    , function ($q) {
//                        $q->whereNotNull('first_name');
//                    })->orderBy('visit_count', 'desc')->first();
//
//                $person = $family->person;
//
//                $tt = $family->toArray();
//                unset($tt['person']);
//                unset($tt['id']);
//
//                $newFamily->update($tt);
//                $updateData = [
//                    'archive' => 0,
//                    'approve' => 0,
//                    'visit_count' => $family->visit_count + 1,
//                    'expense_id' => null,
//                    'parent_id' => null,
//                    'person_id' => $newPerson->id,
//                ];
//                $newFamily->update($updateData);
//
//
//                $tt2 = $person->toArray();
//                unset($tt2['id']);
//
//                $newPerson->update($tt2);
//
//
//                // clone income
//                if ((isset($family->incomes)) && (!is_null($family->incomes))) {
//                    foreach ($family->incomes as $item) {
//                        $newIncome = $item->replicate();
//                        $newIncome->family_id = $newFamily->id;
//                        $newIncome->save();
//                    }
//                }
//
//                // clone members
//                if ((isset($family->members)) && (!is_null($family->members))) {
//                    foreach ($family->members as $item) {
//                        $itemPerson = $item->person;
//                        $newMember = $item->replicate();
//                        $newPerson = $itemPerson->replicate();
//                        $newPerson->save();
//                        $newMember->family_id = $newFamily->id;
//                        $newMember->person_id = $newPerson->id;
//                        $newMember->save();
//                    }
//                }
//
//                // clone searcher
//                if ((isset($family->searcher)) && (!is_null($family->searcher))) {
//                    foreach ($family->searcher as $item) {
//                        $newSearcher = $item->replicate();
//                        $newSearcher->family_id = $newFamily->id;
//                        $newSearcher->save();
//                    }
//                }
//
//                // clone member diseases
//                if ((isset($family->familyMemberDiseases)) && (!is_null($family->familyMemberDiseases))) {
//                    foreach ($family->familyMemberDiseases as $item) {
//                        $newIncome = $item->replicate();
//                        $newIncome->family_id = $newFamily->id;
//                        $newIncome->save();
//                    }
//                }
//
//                //dd('done1');
//
//
//            }
//
//        }
//
//
//        dd('done');
////الفحص
//        //http://127.0.0.1:8000/admin/families/14552/edit
//        //http://127.0.0.1:8000/admin/families/2375/showArchive
//    }


//    public function orderd5()
//    {
//
//        $the_persons = Person::whereNotNull('first_name')
//            ->whereNull('first_name_tr')->get();
//
//
//       // dd($the_persons->count());
//
//        foreach ($the_persons->chunk(50) as $persons) {
//            set_time_limit(0);
//            foreach ($persons as $person) {
//                set_time_limit(0);
//                $first_name = $person->first_name;
//                $NameTranslation = NameTranslation::where('arabic', $first_name)->first();
//
//                if ($NameTranslation) {
//                    $first_name_tr = $NameTranslation->turkey;
//                    $person->update(['first_name_tr' => $first_name_tr]);
//                } else {
//                    continue;
//                }
//
//
//            }
//
//        }
//
//
//        dd('done');
////الفحص
//        //http://127.0.0.1:8000/admin/families/14552/edit
//        //http://127.0.0.1:8000/admin/families/2375/showArchive
//    }

//    public function orderd6()
//    {
//
//        $the_persons = Person::whereNotNull('family_name')
//            ->whereNull('family_name_tr')->get();
//
//
//        //dd($the_persons->count());
//
//        foreach ($the_persons->chunk(50) as $persons) {
//            set_time_limit(0);
//            foreach ($persons as $person) {
//                set_time_limit(0);
//                $family_name = $person->family_name;
//                $NameTranslation = NameTranslation::where('arabic', $family_name)->first();
//
//                if ($NameTranslation) {
//                    $family_name_tr = $NameTranslation->turkey;
//                    $person->update(['family_name_tr' => $family_name_tr]);
//                } else {
//                    continue;
//                }
//
//
//            }
//
//        }
//
//
//        dd('done');
////الفحص
//        //http://127.0.0.1:8000/admin/families/14552/edit
//        //http://127.0.0.1:8000/admin/families/2375/showArchive
//    }
//    public function orderd7()
//    {
//
//        $the_families = Family::whereNull('note_turkey')
//            ->whereHas('childs'
//                , function ($q) {
//                    $q->whereNotNull('note_turkey');
//                })->get();
//        // dd($the_families);
//
//
//        //dd($the_persons->count());
//
//        foreach ($the_families->chunk(50) as $families) {
//            set_time_limit(0);
//            foreach ($families as $family) {
//                set_time_limit(0);
//                $best_child = Family::where('parent_id', $family->id)->whereNotNull('note_turkey')
//                    ->orderBy('visit_count', 'desc')->first();
//
//                $family->update(['note_turkey' => $best_child->note_turkey]);
//            }
//
//        }
//
//
//        dd('done');
//    }
//    public function orderd8()
//    {
//
//        //dd(Family::doesntHave('members')->get());
//
//
//        $the_visits = Family::whereHas('members')->whereNotNull('parent_id')
//            ->orderBy('visit_count', 'desc')->groupBy('parent_id')->get();
//
//
//        //dd($the_persons->count());
//
//        foreach ($the_visits->chunk(50) as $visits) {
//            set_time_limit(0);
//            foreach ($visits as $visit) {
//                set_time_limit(0);
//                $parent = $visit->parent;
//
//
//                if (!($parent->members->first())) {
//
//                    if ((isset($visit->members)) && (!is_null($visit->members))) {
//                        foreach ($visit->members as $item) {
//                            $itemPerson = $item->person;
//                            $newMember = $item->replicate();
//                            $newPerson = $itemPerson->replicate();
//                            $newPerson->save();
//                            $newMember->family_id = $parent->id;
//                            $newMember->person_id = $newPerson->id;
//                            $newMember->save();
//                        }
//                    }
//                }
//            }
//
//        }
//
//
//        dd('done');
//    }

//    public function orderd9()
//    {
//
//        $the_families = Family::where('visit_reason_id',5)
//            ->update(['visit_reason_id'=>10]);
//
//
//        dd('done');
//    }
    public function sendSMS(Request $request)
    {


        $ids = explode(",", $request['the_ids']);
        $families = Family::find($ids);

        if ($families && $families->first()) {
            foreach ($families as $family) {
                if (!($family->mobile_one) && !($family->mobile_two)) {
                    if (count($ids) == 1)
                        return response()->json([
                            'message' => 'المكفول ليس له رقم تواصل',
                        ], 200);
                    else
                        continue;
                } else {
                    $mobile = ($family->mobile_one) && $family->mobile_one > 0 ? $family->mobile_one : $family->mobile_two;
                    if (!(strpos($mobile, '+970') !== false)) {
                        $mobile = '+970' . $mobile;
                    }

                    if (strlen($mobile) != 13) {
                        if (count($ids) == 1)
                            return response()->json([
                                'message' => 'رقم المكفول غير صحيح',
                            ], 200);
                        else
                            continue;
                    } else {
                        event(new SmsEvent($request['massage'], $mobile));

                    }
                }
            }
            event(new NewLogCreated('تم ابلاغ مكفول بنجاح', $family->code, 86, 0, null));
            if (request()['the_type']) {
                return response()->json([
                    'message' => 'تم ابلاغ مكفول بنجاح',
                ], 200);
            } else
                return redirect('admin/expenseDetails')->with('success', 'تم ابلاغ مكفول بنجاح');

        } else {
            event(new NewLogCreated('المحاوله للوصول لمكفول غير موجودة برقم : ', '', 86, 0, null));
            if (request()['the_type']) {
                return response()->json([
                    'message' => 'الرجاء التاكد من الرابط المطلوب'
                ], 401);
            } else
                return redirect("/admin/expenseDetails")->with('error', 'الصرفية غير موجود');
        }
    }

    /*public function orderd10()
       {
           $allfamileis_ids = Family::join('persons', 'persons.id', '=', 'families.person_id')
               ->whereNull('parent_id')
               ->where('code', "!=", "")
               ->where('code', "!=", "-")
               ->whereHas('person', function ($query) {
                   $query->whereNotNull('full_name_tr')
                       ->where('full_name_tr', "!=", "")
                       ->where('full_name_tr', "!=", "-")
                       ->whereNotNull('id_number')
                       ->where('id_number', "!=", "")
                       ->where('id_number', "!=", "-");
               })
               ->groupBy('persons.full_name_tr')->havingRaw('count(*) > 1')
               ->select('persons.*','families.*')
               ->get();
           $allfamileis = Family::find($allfamileis_ids->pluck('id')->toArray());

           foreach ($allfamileis->chunk(50) as $families) {
               set_time_limit(0);
               foreach ($families as $family) {
                   set_time_limit(0);

                   if (strpos($family->updated_at, Carbon::today()->toDateString()) !== false
                   ) {
                       continue;

                   }
                   $full_name_tr = $family->person->full_name_tr;

                   $falmils_by_name = Family::whereHas('person'
                       , function ($query) use ($full_name_tr) {
                           $query->where('full_name_tr', $full_name_tr);
                       })->with('person');


                   if ($falmils_by_name->count() > 1 && count(array_unique($falmils_by_name->pluck('code')->toArray())) == 1) {
                       $thefamilies = $falmils_by_name->get()->sortByDesc('updated_at');

                   } else {
                       continue;
                   }
                   $i = $thefamilies->count();
                   $parent_id = $thefamilies->first()->id;
                   foreach ($thefamilies as $thefamily) {
                       if ($i == $thefamilies->count()) {
                           $thefamily->update(['parent_id' => null, 'visit_count' => $i]);
                       } else {
                           $thefamily->update(['parent_id' => $parent_id, 'visit_count' => $i]);

                       }
                       $i--;
                   }
                   $i = 1;
               }
               //sleep(5);

           }
           dd('done');

       }*/


    public function marge($id)
    {
        if (auth()->user()->hasPermissionTo('create families') && auth()->user()->hasPermissionTo('edit families')) {
            $family = Family::find($id);
            if ($family) {
                $parent_id = $family->parent_id;
                if ($parent_id)
                    $family = Family::find($parent_id);
                if (!is_null($family)) {

                    return view('admin.family.marge', compact("family"));

                } else {
                    event(new NewLogCreated('لم يتم العثور على  مكفول بنجاح برقم : ', $id, 67, 0, null));
                    return redirect('admin/families')->with('error', 'لم يتم العثور على  مكفول بنجاح');
                }
            } else {
                event(new NewLogCreated('لم يتم العثور على  مكفول بنجاح برقم : ', $id, 67, 0, null));
                return redirect('admin/families')->with('error', 'لم يتم العثور على  مكفول بنجاح');
            }

        } else {
            return redirect('admin/families')->with('error', 'ليس لديك صلاحية تعديل وانشاء استمارات');
        }
    }

    public function marge_post(Request $request)
    {
        if (auth()->user()->hasPermissionTo('create families') && auth()->user()->hasPermissionTo('edit families')) {

            $families_yes = $request["families_yes"] ? array_filter($request["families_yes"]) : [];

            $id = $request["id"] ?? "";


            $family = Family::find($id);
            if ($family) {
                $parent_id = $family->parent_id;
                if ($parent_id)
                    $family = Family::find($parent_id);
                if (!is_null($family)) {

                    $falmils_ids = array_merge([$family->id], $families_yes);
                    $falmils_by_name = Family::whereHas('person')->whereIn('id', $falmils_ids)->orWhereIn('parent_id', $falmils_ids);


                    if ($falmils_by_name->count() > 1) {
                        $thefamilies = $falmils_by_name->get()->sortByDesc('updated_at');


                        $i = $thefamilies->count();
                        $parent_id = $thefamilies->first()->id;
                        foreach ($thefamilies as $thefamily) {
                            if ($i == $thefamilies->count()) {
                                $thefamily->update(['parent_id' => null, 'visit_count' => $i]);
                            } else {
                                $thefamily->update(['parent_id' => $parent_id, 'visit_count' => $i]);

                            }
                            $i--;
                        }
                        $i = 1;


                        return redirect('admin/families/archive/' . $parent_id)->with('success', 'تم توحيد هذه الزيارات لاسرة واحدة');

                    } else {

                        return redirect('admin/families')->with('error', 'لا يمكن دمج الأسرة مع نفسها');

                    }

                } else {
                    event(new NewLogCreated('لم يتم العثور على  مكفول بنجاح برقم : ', $id, 67, 0, null));
                    return redirect('admin/families')->with('error', 'لم يتم العثور على  مكفول بنجاح');
                }
            } else {
                event(new NewLogCreated('لم يتم العثور على  مكفول بنجاح برقم : ', $id, 67, 0, null));
                return redirect('admin/families')->with('error', 'لم يتم العثور على  مكفول بنجاح');
            }
        } else {
            return redirect('admin/families')->with('error', 'ليس لديك صلاحية تعديل وانشاء استمارات');
        }
    }

    public function orderd11()
    {

        //1
        $the_families = Family::whereNull('representative_id')
            ->whereHas('childs'
                , function ($q) {
                    $q->whereNotNull('representative_id');
                })->get();
        echo $the_families->count();
        foreach ($the_families->chunk(50) as $families) {
            set_time_limit(0);
            foreach ($families as $family) {
                set_time_limit(0);
                $best_child = Family::where('parent_id', $family->id)->whereNotNull('representative_id')
                    ->orderBy('visit_count', 'desc')->first();
                $family->update(['representative_id' => $best_child->representative_id]);
            }

        }
        echo "1 <br>";
        //2
        $the_families = Family::whereNull('representative_job_type_id')
            ->whereHas('childs'
                , function ($q) {
                    $q->whereNotNull('representative_job_type_id');
                })->get();
        echo $the_families->count();
        foreach ($the_families->chunk(50) as $families) {
            set_time_limit(0);
            foreach ($families as $family) {
                set_time_limit(0);
                $best_child = Family::where('parent_id', $family->id)->whereNotNull('representative_job_type_id')
                    ->orderBy('visit_count', 'desc')->first();
                $family->update(['representative_job_type_id' => $best_child->representative_job_type_id]);
            }

        }
        echo "2 <br>";

        //3
        $the_families = Family::whereNull('representative_relationship_id')
            ->whereHas('childs'
                , function ($q) {
                    $q->whereNotNull('representative_relationship_id');
                })->get();
        echo $the_families->count();
        foreach ($the_families->chunk(50) as $families) {
            set_time_limit(0);
            foreach ($families as $family) {
                set_time_limit(0);
                $best_child = Family::where('parent_id', $family->id)->whereNotNull('representative_relationship_id')
                    ->orderBy('visit_count', 'desc')->first();
                $family->update(['representative_relationship_id' => $best_child->representative_relationship_id]);
            }

        }
        echo "3 <br>";
        //4
        $the_families = Family::whereNull('representative_reason')
            ->whereHas('childs'
                , function ($q) {
                    $q->whereNotNull('representative_reason');
                })->get();
        echo $the_families->count();
        foreach ($the_families->chunk(50) as $families) {
            set_time_limit(0);
            foreach ($families as $family) {
                set_time_limit(0);
                $best_child = Family::where('parent_id', $family->id)->whereNotNull('representative_reason')
                    ->orderBy('visit_count', 'desc')->first();
                $family->update(['representative_reason' => $best_child->representative_reason]);
            }

        }
        echo "<br> 4";
        dd('done');
    }

    public function orderd12()
    {
        //فحص
        //SELECT first_name_tr,second_name_tr,third_name_tr,family_name_tr,full_name_tr,updated_at FROM `persons` where updated_at like '%2020-04-23%' ORDER BY `persons`.`updated_at` DESC

        $the_families = Person::where(function ($q) {
            $q->whereNull('full_name')
                ->orWhere('full_name', '-');
        })->where(function ($q) {
            $q->whereNotNull('first_name')
                ->orWhereNotNull('second_name')
                ->orWhereNotNull('third_name')
                ->orWhereNotNull('family_name');
        })->get();
        echo $the_families->count() . "<br>";
        foreach ($the_families->chunk(50) as $families) {
            set_time_limit(0);
            foreach ($families as $family) {
                set_time_limit(0);
                $person = $family;
                $person->update(['full_name' => $person->first_name . " " .
                    $person->second_name . " " .
                    $person->third_name . " " .
                    $person->family_name]);
            }

        }

        $the_families = Person::where(function ($q) {
            $q->whereNull('full_name_tr')
                ->orWhere('full_name_tr', '-');
        })->where(function ($q) {
            $q->whereNotNull('first_name_tr')
                ->orWhereNotNull('second_name_tr')
                ->orWhereNotNull('third_name_tr')
                ->orWhereNotNull('family_name_tr');
        })->get();
        echo $the_families->count() . "<br>";
        foreach ($the_families->chunk(50) as $families) {
            set_time_limit(0);
            foreach ($families as $family) {
                set_time_limit(0);
                $person = $family;
                $person->update(['full_name_tr' => $person->first_name_tr . " " .
                    $person->second_name_tr . " " .
                    $person->third_name_tr . " " .
                    $person->family_name_tr]);
            }

        }


//1
        $the_families = Family::whereHas('person', function ($q) {
            $q->where(function ($q) {
                $q->whereNull('full_name')
                    ->orWhere('full_name', '-');
            })
                ->where(function ($q) {
                    $q->whereNotNull('first_name')
                        ->orWhereNotNull('second_name')
                        ->orWhereNotNull('third_name')
                        ->orWhereNotNull('family_name');
                });
        })->get();

        echo $the_families->count() . "<br>";
        foreach ($the_families->chunk(50) as $families) {
            set_time_limit(0);
            foreach ($families as $family) {
                set_time_limit(0);
                $person = $family->person;
                $person->update(['full_name' => $person->first_name . " " .
                    $person->second_name . " " .
                    $person->third_name . " " .
                    $person->family_name]);

            }

        }
//2
        $the_families = Family::whereHas('person', function ($q) {
            $q->where(function ($q) {
                $q->whereNull('full_name_tr')
                    ->orWhere('full_name_tr', '-');
            })
                ->where(function ($q) {
                    $q->whereNotNull('first_name_tr')
                        ->orWhereNotNull('second_name_tr')
                        ->orWhereNotNull('third_name_tr')
                        ->orWhereNotNull('family_name_tr');
                });
        })->get();
        echo $the_families->count() . "<br>";
        foreach ($the_families->chunk(50) as $families) {
            set_time_limit(0);
            foreach ($families as $family) {
                set_time_limit(0);
                $person = $family->person;
                $person->update(['full_name_tr' => $person->first_name_tr . " " .
                    $person->second_name_tr . " " .
                    $person->third_name_tr . " " .
                    $person->family_name_tr]);
            }

        }

//3
//2
        dd('dosn');
    }

}


