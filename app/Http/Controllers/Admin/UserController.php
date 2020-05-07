<?php

namespace App\Http\Controllers\Admin;

use App\City;
use File;
use App\Department;
use App\Events\NewLogCreated;
use App\FamilySearcher;
use App\FileType;
use App\Governorate;
use App\Http\Requests\UserRequest;
use App\Institution;
use App\LogCategory;
use App\Neighborhood;
use App\Project;
use App\SocialStatus;
use App\Task;
use App\UniversitySpecialty;
use App\User;
use App\UserMedia;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Maatwebsite\Excel\Facades\Excel;
use niklasravnsborg\LaravelPdf\Facades\Pdf;
use Spatie\Permission\Models\Permission;
use App\Action;
use Notification;
use App\Notifications\NotifyUsers;
use App\Log;
use DataTables;
use Intervention\Image\Facades\Image;

/**
 * Class UserController
 * @package App\Http\Controllers\Admin
 */
class UserController extends Controller
{
    public function index(Request $request)
    {
        $full_name = $request["full_name"] ?? "";
        $email = $request["email"] ?? "";
        $id_number = $request["id_number"] ?? "";
        $the_mobile = $request["the_mobile"] ?? "";
        $the_address = $request["the_address"] ?? "";
        $coulmn = $request["coulmn"] ?? "";
        $social_status_ids = $request["social_status_ids"] ? array_filter($request["social_status_ids"]) : [];
        $university_specialties_ids = $request["university_specialties_ids"] ? array_filter($request["university_specialties_ids"]) : [];
        $department_ids = $request["department_ids"] ? array_filter($request["department_ids"]) : [];
        $city_id = $request["city_id"] ?? "";
        $neighborhood_ids = $request["neighborhood_ids"] ? array_filter($request["neighborhood_ids"]) : [];
        $governorate_id = $request["governorate_id"] ?? "";
        $min_id = User::first()->id ?? 1;
        $max_id = User::orderByDesc('id')->first()->id ?? 1;
        $from_id = $request["from_id"] ?? $min_id;
        $to_id = $request["to_id"] ?? $max_id;
        $from_work_start_date = $request["from_work_start_date"] ?? "";
        $to_work_start_date = $request["to_work_start_date"] ?? "";
        $from_date_of_birth = $request["from_date_of_birth"] ?? "";
        $to_date_of_birth = $request["to_date_of_birth"] ?? "";

        $items = User::when($full_name, function ($query) use ($full_name) {
            return $query->where('full_name', 'like', '%' . $full_name . '%');
        })->when($email, function ($query) use ($email) {
            $query->where('email', 'like', '%' . $email . '%');
        })->when($id_number, function ($query) use ($id_number) {
            $query->where('id_number', 'like', '%' . $id_number . '%');
        })->when($from_work_start_date && $to_work_start_date, function ($query) use ($from_work_start_date, $to_work_start_date) {
            return $query->whereBetween('work_start_date', [$from_work_start_date, $to_work_start_date]);
        })->when($from_date_of_birth && $to_date_of_birth, function ($query) use ($from_date_of_birth, $to_date_of_birth) {
            return $query->whereBetween('date_of_birth', [$from_date_of_birth, $to_date_of_birth]);
        })->when($the_mobile, function ($query) use ($the_mobile) {
            $query->where('mobile_one', 'like', '%' . $the_mobile . '%')
                ->orWhere('mobile', 'like', '%' . $the_mobile . '%')
                ->orWhere('mobile_two', 'like', '%' . $the_mobile . '%');
        })->when($the_address, function ($query) use ($the_address) {
            $query->whereHas('neighborhood'
                , function ($q) use ($the_address) {
                    $q->where('name', 'like', '%' . $the_address . '%');
                })->orWhere('address', 'like', '%' . $the_address . '%');
        })->when($social_status_ids, function ($query) use ($social_status_ids) {
            return $query->whereIn('social_status_id', $social_status_ids);
        })->when($university_specialties_ids, function ($query) use ($university_specialties_ids) {
            return $query->whereIn('university_specialty_id', $university_specialties_ids);
        })->when($department_ids, function ($query) use ($department_ids) {
            return $query->whereIn('department_id', $department_ids);
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
        });


        $departments = Department::orderBy('name')->get();
        $social_statuses = SocialStatus::orderBy('name')->get();
        $cities = City::orderBy('name')->get();
        $governorates = Governorate::orderBy('name')->get();
        $university_specialties = UniversitySpecialty::orderBy('name')->get();

        if ($request["coulmn"] == []) {
            $coulmn = ['id', 'full_name', 'suspend', 'departmen', 'email', 'the_address', 'mobile_one', 'work_start_date', 'operations'];
        }

        if ($request['theaction'] == 'excel') {
            $the_date = Carbon::now();
            $items = $items->orderBy("users.full_name")->get();
            //DB::setFetchMode(\PDO::FETCH_ASSOC);
            //dd(HtmlFacade::style('css/table_execl.css'));
            return
                Excel::create("أسماء المستخدمين $the_date", function ($excel) use ($items, $coulmn) {

                    $excel->sheet('New sheet', function ($sheet) use ($items, $coulmn) {


                        $sheet->loadView('admin.users.printall', [
                            'items' => $items,
                            'coulmn' => $coulmn,
                        ]);


                    });

                })->export('xlsx');
            //Excel::download(new UsersExport($coulmn, $items), "أسماء المستخدمين $the_date.xlsx");

        } elseif ($request['theaction'] == 'print') {
            $the_date = Carbon::now();
            $print = 1;
            $items = $items->orderBy("users.full_name")->get();
            $pdf = Pdf::loadView('admin.users.printall', compact('items', 'print', 'coulmn'));
            return $pdf->stream("أسماء المستخدمين $the_date.pdf");
        } else {
            $items = $items->orderBy("users.full_name")->paginate(20)
                ->appends([
                    "the_address" => $the_address, "full_name" => $full_name, "email" => $email, "id_number" => $id_number,
                    "the_mobile" => $the_mobile,
                    "from_work_start_date" => $from_work_start_date, "to_work_start_date" => $to_work_start_date,
                    "from_date_of_birth" => $from_date_of_birth, "to_date_of_birth" => $to_date_of_birth,
                    "social_status_ids" => $social_status_ids, "department_ids" => $department_ids, "city_id" => $city_id,
                    "neighborhood_id" => $neighborhood_ids, "governorate_id" => $governorate_id,
                    'university_specialties_ids' => $university_specialties_ids, "coulmn" => $coulmn]);
            return view('admin.users.index', compact('items', 'departments', 'social_statuses', 'cities'
                , "the_address", "full_name", "email", "id_number", "the_mobile", 'city_id', 'coulmn', 'department_ids', 'social_status_ids'
                , 'from_id', 'to_id', 'university_specialties', "university_specialties_ids", "neighborhood_ids", "governorate_id", 'max_id', 'min_id', 'governorates',
                "from_work_start_date", "to_work_start_date", "from_date_of_birth", "to_date_of_birth"
            ));

        }

    }

    public function create()
    {
        $departments = Department::orderBy('name')->where('status', 1)->get();
        $social_statuses = SocialStatus::orderBy('name')->get();
        $neighborhoods = Neighborhood::orderBy('name')->get();
        $cities = City::orderBy('name')->get();
        $governorates = Governorate::orderBy('name')->get();
        $university_specialties = UniversitySpecialty::orderBy('name')->where('status', 1)->get();
        return view('admin.users.create', compact('departments', 'university_specialties', 'governorates', 'neighborhoods', 'social_statuses', 'cities'));
    }

    public function store(UserRequest $request)
    {

        request()['password'] = bcrypt(request()->password);
        request()['created_by'] = auth()->user()->id;

        if ($request['neighborhood_id'] == 1 && ($request['neighborhood_id_other']) && ($request['city_id'])) {
            $neighborhood = Neighborhood::where('name', $request['neighborhood_id_other'])->first();
            if ($neighborhood)
                $neighborhood_id = $neighborhood->id;
            else
                $neighborhood_id = Neighborhood::create(['name' => $request['neighborhood_id_other'], 'status' => 0, 'city_id' => $request['city_id']])->id;
            $request['neighborhood_id'] = $neighborhood_id;
            request()['neighborhood_id'] = $neighborhood_id;
        }
        if ($request['department_id'] == 1 && ($request['department_id_other'])) {
            $department = Department::where('name', $request['department_id_other'])->first();
            if ($department)
                $department_id = $department->id;
            else
                $department_id = Department::create(['name' => $request['department_id_other'], 'status' => 0])->id;
            $request['department_id'] = $department_id;
            request()['department_id'] = $department_id;
        }
        if ($request['university_specialty_id'] == 1 && ($request['university_specialty_id_other'])) {
            $university_specialty = UniversitySpecialty::where('name', $request['university_specialty_id_other'])->first();
            if ($university_specialty)
                $university_specialty_id = $university_specialty->id;
            else
                $university_specialty_id = UniversitySpecialty::create(['name' => $request['university_specialty_id_other'], 'status' => 0])->id;
            $request['university_specialty_id'] = $university_specialty_id;
            request()['university_specialty_id'] = $university_specialty_id;
        }
        $user = User::create(request()->except(
            ['university_specialty_id_other', 'department_id_other', 'neighborhood_id_other', 'city_id', 'governorate_id']));
        if ($user) {
            event(new NewLogCreated('تم انشاء حساب بنجاح', $user->user_name, 3, 0, null));


            /**************start Notification*******************/

            $action = Action::create(['title' => 'تم إضافة حساب مستخدم جديد', 'type' => 'إدارة حسابات', 'link' => "/admin/users"]);
            $users = User::permission('users')->whereNotIn('id', [auth()->user()->id])->get();
            if ($users->first())
                Notification::send($users, new NotifyUsers($action));
            /**************end Notification*******************/

            return back()->with('success', 'تم انشاء حساب بنجاح');
        } else {
            event(new NewLogCreated('لم يتم انشاء حساب بنجاح', null, 3, 0, null));
            return back()->with('error', 'لم يتم انشاء حساب بنجاح');
        }

    }

    public function show($id)
    {

    }

    public function his_tasks($id, Request $request)
    {
        $user = User::find($id);

        if (!is_null($user)) {

            $tasks = Task::where('admin_id', $id);

            $done = $request["done"] ?? "";
            $full_done = $request["full_done"] ?? "";
            $type = $request["type"] ?? "";
            $admin_ids = $request["admin_ids"] ? array_filter($request["admin_ids"]) : [];
            $user_ids = $request["user_ids"] ? array_filter($request["user_ids"]) : [];
            $family_ids = $request["family_ids"] ? array_filter($request["family_ids"]) : [];
            $project_ids = $request["project_ids"] ?? [];
            $institution_ids = $request["institution_ids"] ?? [];
            $title = $request["title"] ?? "";
            $min_id = $tasks->first()->id ?? 1;
            $max_id = $tasks->orderByDesc('id')->first()->id ?? 1;
            $from_id = $request["from_id"] ?? $min_id;
            $to_id = $request["to_id"] ?? $max_id;
            $from_from_date = $request["from_from_date"] ?? "";
            $to_from_date = $request["to_from_date"] ?? "";
            $from_to_date = $request["from_to_date"] ?? "";
            $to_to_date = $request["to_to_date"] ?? "";
            $families_yes = $request['families_yes'] ? array_filter($request["family_ids"]) : [];  // علاقة
            $coulmn = $request["coulmn"] ?? "";

            $items = $tasks->when($admin_ids, function ($query) use ($admin_ids) {
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
            })->when($done, function ($query) use ($done) {
                return $query->where('done', '!=', "");
            })->when($full_done, function ($query) use ($full_done) {
                return $query->where('full_done', '!=', "");
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

            return view('admin.users.his_tasks', compact('items',
                "admin_ids", "user_ids", "family_ids",
                "project_ids", "institution_ids", "title",
                "done", "from_id", "to_id",
                "from_to_date", "to_to_date",
                "from_from_date", "to_from_date", "families_yes",
                "coulmn", 'min_id', 'max_id', 'type', 'full_done', 'institutions', 'projects', 'user'));


        } else {
            event(new NewLogCreated('المحاولة للوصول لمستخدم غير موجود برقم : ', $id, 4, 1, null));
            return redirect("/admin/users")->with('error', 'المستخدم غير موجود');
        }
    }

    public function tasks($id, Request $request)
    {
        $user = User::find($id);

        if (!is_null($user)) {

            $tasks = Task::where('user_id', $id);

            $done = $request["done"] ?? "";
            $full_done = $request["full_done"] ?? "";
            $type = $request["type"] ?? "";
            $admin_ids = $request["admin_ids"] ? array_filter($request["admin_ids"]) : [];
            $user_ids = $request["user_ids"] ? array_filter($request["user_ids"]) : [];
            $family_ids = $request["family_ids"] ? array_filter($request["family_ids"]) : [];
            $project_ids = $request["project_ids"] ?? [];
            $institution_ids = $request["institution_ids"] ?? [];
            $title = $request["title"] ?? "";
            $min_id = $tasks->first()->id ?? 1;
            $max_id = $tasks->orderByDesc('id')->first()->id ?? 1;
            $from_id = $request["from_id"] ?? $min_id;
            $to_id = $request["to_id"] ?? $max_id;
            $from_from_date = $request["from_from_date"] ?? "";
            $to_from_date = $request["to_from_date"] ?? "";
            $from_to_date = $request["from_to_date"] ?? "";
            $to_to_date = $request["to_to_date"] ?? "";
            $families_yes = $request['families_yes'] ? array_filter($request["family_ids"]) : [];  // علاقة
            $coulmn = $request["coulmn"] ?? "";

            $items = $tasks->when($admin_ids, function ($query) use ($admin_ids) {
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
            })->when($done, function ($query) use ($done) {
                return $query->where('done', '!=', "");
            })->when($full_done, function ($query) use ($full_done) {
                return $query->where('full_done', '!=', "");
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

            return view('admin.users.tasks', compact('items',
                "admin_ids", "user_ids", "family_ids",
                "project_ids", "institution_ids", "title",
                "done", "from_id", "to_id",
                "from_to_date", "to_to_date",
                "from_from_date", "to_from_date", "families_yes",
                "coulmn", 'min_id', 'max_id', 'type', 'full_done', 'institutions', 'projects', 'user'));


        } else {
            event(new NewLogCreated('المحاولة للوصول لمستخدم غير موجود برقم : ', $id, 4, 1, null));
            return redirect("/admin/users")->with('error', 'المستخدم غير موجود');
        }
    }

    public function edit($id)
    {
        $user = User::find($id);

        if (!is_null($user)) {
            $departments = Department::orderBy('name')->where('status', 1)->get();
            $social_statuses = SocialStatus::orderBy('name')->get();
            $neighborhoods = Neighborhood::orderBy('name')->get();
            $cities = City::orderBy('name')->get();
            $governorates = Governorate::orderBy('name')->get();
            $university_specialties = UniversitySpecialty::orderBy('name')->where('status', 1)->get();

            return view('admin.users.edit', compact('user', 'departments', 'university_specialties', 'governorates', 'neighborhoods', 'social_statuses', 'cities'));

        } else {
            event(new NewLogCreated('المحاولة للوصول لمستخدم غير موجود برقم : ', $id, 4, 1, null));
            return redirect("/admin/users")->with('error', 'المستخدم غير موجود');
        }

    }

    public function update(UserRequest $request, $id)
    {
        $user = User::find($id);

        if (!is_null($user)) {


            if (request()['password'] != '') {

                request()["password"] = bcrypt(request()["password"]);
            } else {
                unset(request()['password']);
            }

            request()['updated_by'] = auth()->user()->id;

            if ($request['files']) {

                if (count($request['files']) != count($request['file_type_id'])) {
                    event(new NewLogCreated(' يرجى ادخال نوع الملف ', $user->user_name, 99, 0, 0));
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
                        $path = 'uploads/users/';
                        //$upload = $file['files']->move($path, $fileName);

                        if (!file_exists($path)) {
                            File::makeDirectory($path, $mode = 0777, true, true);
                        }


                        $extintion = pathinfo($file['files']->getClientOriginalName(), PATHINFO_EXTENSION);
                        if ($extintion == 'JFIF' || $extintion == 'JPEG' || $extintion == 'GIF' || $extintion == 'BMP' || $extintion == 'PNG' || $extintion == 'SVG' || $extintion == 'JPG' ||
                            $extintion == 'jfif' || $extintion == 'jpeg' || $extintion == 'gif' || $extintion == 'bmp' || $extintion == 'png' || $extintion == 'svg' || $extintion == 'jpg') {
                            Image::make($file['files']->getRealPath())->save($path . $fileName, 60);

                        } else {
                            $upload = $file['files']->move($path, $fileName);
                        }


                        $file_type_id = $file['file_type_id'];

                        $mediaData = [
                            'path' => $path . $fileName,
                            'file_type_id' => $file_type_id,
                            'user_id' => $user->id
                        ];
                        UserMedia::create($mediaData);
                    }

                } else {
                    event(new NewLogCreated(' لم يتم إضافة مرفقات ', $user->user_name, 99, 0, 0));
                    return back()->with('error', 'لم  يتم إضافة  مرفقات ');

                }
            }
            if ($request['neighborhood_id'] == 1 && ($request['neighborhood_id_other']) && ($request['city_id'])) {
                $neighborhood = Neighborhood::where('name', $request['neighborhood_id_other'])->first();
                if ($neighborhood)
                    $neighborhood_id = $neighborhood->id;
                else
                    $neighborhood_id = Neighborhood::create(['name' => $request['neighborhood_id_other'], 'status' => 0, 'city_id' => $request['city_id']])->id;
                $request['neighborhood_id'] = $neighborhood_id;
                request()['neighborhood_id'] = $neighborhood_id;
            }
            if ($request['department_id'] == 1 && ($request['department_id_other'])) {
                $department = Department::where('name', $request['department_id_other'])->first();
                if ($department)
                    $department_id = $department->id;
                else
                    $department_id = Department::create(['name' => $request['department_id_other'], 'status' => 0])->id;
                $request['department_id'] = $department_id;
                request()['department_id'] = $department_id;
            }
            if ($request['university_specialty_id'] == 1 && ($request['university_specialty_id_other'])) {
                $university_specialty = UniversitySpecialty::where('name', $request['university_specialty_id_other'])->first();
                if ($university_specialty)
                    $university_specialty_id = $university_specialty->id;
                else
                    $university_specialty_id = UniversitySpecialty::create(['name' => $request['university_specialty_id_other'], 'status' => 0])->id;
                $request['university_specialty_id'] = $university_specialty_id;
                request()['university_specialty_id'] = $university_specialty_id;
            }
            if ($user->update($request->except(['file_type_id', 'files', 'file_type_id_other', 'university_specialty_id_other', 'department_id_other', 'neighborhood_id_other', 'city_id', 'governorate_id']))) {
                $user->save();
                event(new NewLogCreated('تعديل البيانات بنجاح', $user->user_name, 4, 1, null));

                /**************start Notification*******************/
                $action = Action::create(['title' => 'تم تعديل المستخدم ' . $user->user_name, 'type' => 'إدارة حسابات', 'link' => "/admin/users/" . $user->id . "/edit"]);
                $users = User::permission('users')->whereNotIn('id', [auth()->user()->id])->get();;

                if ($users->first())
                    Notification::send($users, new NotifyUsers($action));
                /**************end Notification*******************/
                return redirect("/admin/users/" . $user->id . "/edit")->with('success', 'تم تعديل البيانات بنجاح');
            } else {
                event(new NewLogCreated('لم يتم تعديل البيانات بنجاح', $user->user_name, 4, 1, null));
                return redirect("/admin/users")->with('error', 'لم يتم تعديل البيانات بنجاح');
            }

        } else {
            event(new NewLogCreated('المحاولة للوصول لمستخدم غير موجود برقم : ', $id, 4, 1, null));
            return redirect("/admin/users")->with('error', 'المستخدم غير موجود');
        }

    }

    public function delete($id)
    {
        $user = User::find($id);

        if (!is_null($user)) {


            if (/*$user->families_data_entries->first() ||*/
            $user->families_searchers->first()) {
                event(new NewLogCreated('محاولة لحذف مستخدم لة استمارات :', $user->user_name, 5, 0, 0, null));
                return redirect("/admin/users")->with('error', 'لا يمكن حذف مستخدم لة كفالات');

            }
            if (auth()->user()->id == $user->id) {
                event(new NewLogCreated('محاولة لحذف مستخدم نفسة :', $user->user_name, 5, 0, 0, null));
                return redirect("/admin/users")->with('error', 'لا يمكن حذف المستخدم لنفسة');
            }

            Task::where('user_id', $id)->delete();
            Task::where('admin_id', $id)->delete();
            UserMedia::where('user_id', $id)->delete();
            $user->syncPermissions();
            $userName = $user->user_name;

            // todo -- المفروض تتاكد ماالةا توابع قبل الحذف
            $user->deleted_by = auth()->user()->id;
            $user->save();
            $user->delete();
            event(new NewLogCreated('تم حذف الحساب بنجاح ', $userName, 5, 0, null));

            $action = Action::create(['title' => LogCategory::find(5)->name, 'type' => 'إدارة حسابات', 'link' => Permission::findByName('list users')->link]);
            $users = User::permission('users')->whereNotIn('id', [auth()->user()->id])->get();;
            if ($users->first())
                Notification::send($users, new NotifyUsers($action));

            return redirect("/admin/users")->with('success', 'تم حذف الحساب بنجاح');

        } else {
            event(new NewLogCreated('المحاولة للوصول لمستخدم غير موجود برقم :', $id, 5, 0, null));
            return redirect("/admin/users")->with('error', 'المستخدم غير موجود');
        }
    }

    public function delete_group(Request $request)
    {
        $ids = explode(",", $request['the_ids']);
        $users = User::find($ids);
        if ($users && $users->first()) {
            foreach ($users as $user) {
                $id = $user->id;
                if (/*$user->families_data_entries->first() ||*/
                $user->families_searchers->first()) {
                    event(new NewLogCreated('محاولة لحذف مستخدم لة استمارات :', $user->user_name, 5, 0, 0, null));
                    continue;

                }
                if (auth()->user()->id == $user->id) {
                    event(new NewLogCreated('محاولة لحذف مستخدم نفسة :', $user->user_name, 5, 0, 0, null));
                    continue;
                }

                Task::where('user_id', $id)->delete();
                Task::where('admin_id', $id)->delete();
                UserMedia::where('user_id', $id)->delete();
                $user->syncPermissions();
                $userName = $user->user_name;

                // todo -- المفروض تتاكد ماالةا توابع قبل الحذف
                $user->deleted_by = auth()->user()->id;
                $user->save();
                $user->delete();


            }
            event(new NewLogCreated('تم حذف عدة حسابات بنجاح ', $userName, 5, 0, null));
            $action = Action::create(['title' => LogCategory::find(5)->name, 'type' => 'إدارة حسابات', 'link' => Permission::findByName('list users')->link]);
            $users = User::permission('users')->whereNotIn('id', [auth()->user()->id])->get();;
            if ($users->first())
                Notification::send($users, new NotifyUsers($action));
            return redirect("/admin/users")->with('error', 'تم حذف المستخدمين بنجاح');
        } else {
            return redirect("/admin/users")->with('error', 'لم يتم تحديد أي عنصر لحذفه')->withInput();
        }
    }

    public function permission($id)
    {
        $user = User::find($id);

        if (!is_null($user)) {
            $links = Permission::where('in_setting', '=', 0)->where("parent_id", 0)->get();

            $lists_links = Permission::where('in_setting', '=', 1)->where("parent_id", 0)->get();

            $coupon_links = Permission::where('in_setting', '=', 2)->where("parent_id", 0)->get();
            $sitting_links = Permission::where('in_setting', '=', 3)->where("parent_id", 0)->get();

            return view('admin.users.permission', compact('links', 'lists_links', 'coupon_links', 'user', 'sitting_links'));

        } else {
            event(new NewLogCreated('المحاولة للوصول لمستخدم غير موجود برقم : ', $id, 6, 0, null));
            return redirect("/admin/users")->with('warning', 'يرجى التأكد من الرابط');
        }

    }

    public function updatePermission(Request $request, $id)
    {
        $user = User::find($id);
        if (!is_null($user)) {
            $user->syncPermissions(request()["permissions"]);
            event(new NewLogCreated('تعديل صلاحيات بنجاح', $user->user_name, 6, 1, null));

            /**************start Notification*******************/
            $action = Action::create(['title' => 'تم تعديل صلاحية المستخدم ' . $user->user_name, 'type' => 'إدارة حسابات', 'link' => "/admin/users?from_id=".$id."&to_id=".$id]);
            $users = User::permission('users')->whereNotIn('id', [auth()->user()->id])->get();;

            if ($users->first())
                Notification::send($users, new NotifyUsers($action));
            /**************end Notification*******************/

            return redirect("/admin/users")->with('success', 'تم حفظ الصلاحيات بنجاح');
        } else {
            return redirect("/admin/users")->with('warning', 'يرجى التأكد من الرابط');
        }
    }

    public function getLog($id)
    {
        $user = User::find($id);

        if (!is_null($user)) {

            return view('admin.users.logs', compact('user'));

        } else {
            event(new NewLogCreated('المحاولة للوصول لمستخدم غير موجود برقم : ', $id, 4, 1, null));
            return redirect("/admin/users")->with('error', 'المستخدم غير موجود');
        }

    }

    public function getLogs($id)
    {

        $user = User::find($id);
        if (!is_null($user)) {
            $logs = Log::where('user_id', $user->id)->get();
            return DataTables::of($logs)
                ->editColumn('message', function ($value) {
                    $event = !is_null($value->message) ? $value->message : null;
                    $name = !is_null($value->name) ? $value->name : null;

                    if ($value->path_status == 0) {
                        return "<span > $event </span>&nbsp;
                    <strong class='text-red'> $name  </strong>";
                    } else {
                        return "<span > $event </span>&nbsp;
                    <strong class='text-red'><a href='$value->path'> $name  </a></strong>";
                    }
                })->addColumn('category', function ($value) {
                    return isset($value->log_category) ? $value->log_category->name : null;
                })
                ->addColumn('ip_address', function ($value) {
                    return isset($value->ip_address) ? $value->ip_address : null;
                })
                ->addColumn('date', function ($value) {
                    return isset($value->created_at) ? date_format($value->created_at, 'Y-m-d') : null;
                })->addColumn('time', function ($value) {
                    return isset($value->created_at) ? date_format($value->created_at, 'H:i') : null;
                })
                ->addColumn('user', function ($value) {
                    return isset($value->user_id) ? User::find($value->user_id)->user_name : null;
                })
                ->addColumn('agent', function ($value) {
                    $agentName = isset($value->agent) ? $value->agent : null;
                    return $agentName;
                })
                ->addColumn('device', function ($value) {
                    $theDevice = isset($value->device) ? $value->device : null;
                    $theDevicePlatform = isset($value->device_platform) ? $value->device_platform : null;
                    return $theDevice . ' - ' . $theDevicePlatform;
                })
                ->rawColumns(['message'])->make(true);
        } else {
            return redirect("/admin/users")->with('warning', 'يرجى التأكد من الرابط');
        }

    }

    public function suspend($id)
    {


        $user = User::find($id);

        if (!is_null($user)) {


            if (!(auth()->user()->hasPermissionTo(6))) {
                return response()->json([
                    'message' => 'ليس لك صلاحية تعديل الصلاحيات',
                ], 401);
            }

            if (auth()->user()->id == $user->id) {
                event(new NewLogCreated('محاولة إيقاف مستخدم نفسة :', $user->user_name, 5, 0, null));
                return response()->json([
                    'message' => 'لا يمكن للمستخدم إيقاف نفسة',
                ], 401);
            }

            if ($user->getAllPermissions()->first()) {
                $user->syncPermissions();
                event(new NewLogCreated('ايقاف حساب بنجاح', $user->user_name, 6, 1, null));
                return response()->json([
                    'message' => 'تم إيقاف حساب بنجاح',
                ], 200);
            } else {
                return response()->json([
                    'message' => 'الحساب موقوف',
                ], 401);
            }
        } else {
            event(new NewLogCreated('محاولة ايقاف حساب برقم:', $id, 6, 1, null));
            return response()->json([
                'message' => 'الرجاء التاكد من الرابط المطلوب'
            ], 401);
        }
    }

    public function print_group(Request $request)
    {

        ini_set("pcre.backtrack_limit", "1000000");
        $ids = explode(",", $request['the_ids']);
        $all_users = User::find($ids);
        $links = [];
        $sitting_links = [];
        $users = [];
        $i = 0;
        if ($all_users && $all_users->first()) {

            foreach ($all_users as $user) {
                //if ($i == 5) break;
                $users[$i] = $user;
                $links[$i] = Permission::where('in_setting', '=', 0)->where("parent_id", 0)->get();

                $sitting_links[$i] = Permission::where('in_setting', '=', 1)->where("parent_id", 0)->get();
                $i++;
            }

            $pdf = Pdf::loadView('admin.users.printpermissions', compact('links', 'users', 'sitting_links'));
            return $pdf->stream("صلاحيات المستخدمين .pdf");
            //return view('admin.users.printpermissions', compact('links', 'users', 'sitting_links'));

        } else {
            return redirect("/admin/users")->with('error', 'لم يتم تحديد أي عنصر لطباعة صلاحياته')->withInput();
        }


    }

    public function familyLog($id)
    {
        $user = User::find($id);
        if (!is_null($user)) {
            return view('admin.user.familyLog', compact('id'));
        } else {
            return redirect("/admin/users")->with('warning', 'يرجى التأكد من الرابط');
        }


    }

    public function familyLogData($id)
    {
        $user = User::find($id);
        if (!is_null($user)) {
            $families = Family::whereIn('id', FamilySearcher::where('searcher_id', $id)->pluck('family_id')->toArray())
                ->with(['person', 'house_ownership', 'person.qualification', 'breadwinner', 'person.social_status', 'job_type', 'educational_institution', 'status', 'searcher', 'fundedInstitution', 'project', 'classification'])
                ->where(['parent_id' => null])
                ->where(['hidden' => 0])
                //->whereIn('year', ['2019'])
                ->get();

            return DataTables::of($families)
                ->addColumn('id', function ($value) {
                    return $value->id;
                })->addColumn('name', function ($value) {

                    $person = $value->person;
                    return !is_null($person->first_name && $person->second_name && $person->third_name && $person->family_name) ? $person->first_name . ' ' . $person->second_name . ' ' . $person->third_name . ' ' . $person->family_name : '-';
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
                    $deleteUrl = url('admin/families/delete/' . $value->id);

                    return "<ul id='dropdown-$value->id' class='dropdown-content'>
                         <li><a  href='$archiveUrl'>الأرشيف</a></li>
                    <li><a href='$deleteUrl'>حذف</a></li>
                    <li><a href='#'>الاتصالات</a></li>
                    <li><a href='#'>المساعدات</a></li>
                    <li><a  href='$addMemberUrl'>إضافة افراد</a></li>
                    <li><a  href='$exportTurkeyUrl'>تصدير استماره تركيه </a></li>
                    <li><a href='$exportExcelUrl'>تصدير اكسل </a></li>
                    <li><a  href='$updateUrl'>تحديث</a></li>
                    <li><a  href='$mediaUrl'>المرفقات</a></li>
                        </ul>
                        <a class='dropdown-trigger btn grey darken-3' data-target='dropdown-$value->id'>
                          <i class='material-icons dp48'>settings</i>
                        </a>";
                })->rawColumns(['actions', 'image'])->make(true);


        } else {
            return redirect("/admin/users")->with('warning', 'يرجى التأكد من الرابط');
        }
    }

    public function users_ajax(Request $request)
    {
        $q = $request['q'];
        $users = User::where('full_name', 'like', '%' . $q . '%')
            ->select([
                'id', 'full_name as text']);
        if ($users->first())
            return json_encode($users->take(10)->get());
        else {
            return 0;
        }
    }
}
