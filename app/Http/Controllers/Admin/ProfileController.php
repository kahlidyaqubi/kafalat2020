<?php

namespace App\Http\Controllers\Admin;

use App\City;
use App\Events\NewLogCreated;
use App\FileType;
use App\Http\Requests\AddMediaRequest;
use App\Http\Requests\PasswordRequest;
use App\Http\Requests\ProfileRequest;
use App\Http\Controllers\Controller;
use App\Institution;
use App\Project;
use App\SocialStatus;
use App\Task;
use App\User;
use App\UserMedia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Log;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

/**
 * Class ProfileController
 * @package App\Http\Controllers\Admin
 */
class ProfileController extends Controller
{

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    function show()
    {
        $user = User::find(Auth::user()->id);
        return view('admin.profile.show', compact('user'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    function edit()
    {
        $user = User::find(Auth::user()->id);
        $social_statuses = SocialStatus::orderBy('name')->get();
        $cities = City::orderBy('name')->get();

        return view('admin.profile.edit', compact('user', 'cities', 'social_statuses'));
    }

    /**
     * @param ProfileRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    function update(ProfileRequest $request)
    {
        $user = User::find(Auth::user()->id);

        if (!is_null($user)) {

            if ($user->update($request->except(['governorate_id', 'city_id']))) {

                if ($request->hasFile('image')) {

                    $request->validate([
                        'image' => 'required|image|mimes:jpeg,png,jpg|max:2048'
                    ]);

                    $filename = time() . '.' . $request['image']->getClientOriginalExtension();
                    $path = 'uploads/users/';
                    Image::make($request['image']->getRealPath())->resize(500, 500)->save($path . $filename);
                    $user->image = $path . $filename;
                    $user->save();

                }

                event(new NewLogCreated('تعديل البيانات الشخصية بنجاح', $user->user_name, 4, 0, 0));
                return back()->with('success', 'تم تعديل البيانات الشخصية بنجاح');
            } else {
                event(new NewLogCreated('لم يتم تعديل البيانات الشخصية بنجاح', $user->user_name, 4, 0, 0));
                return rback()->with('error', 'لم يتم تعديل البيانات الشخصية بنجاح');
            }

        } else {
            event(new NewLogCreated('المحاولة للوصول لمستخدم غير موجود برقم : ', Auth::user()->id, 4, 1, 0));
            return back()->with('error', 'المستخدم غير موجود');
        }
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    function editPassword()
    {
        $user = User::find(Auth::user()->id);
        return view('admin.profile.editPassword', compact('user'));
    }

    /**
     * @param PasswordRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    function updatePassword(PasswordRequest $request)
    {
        $user = User::find(Auth::id());

        if (!Hash::check($request->current_password, $user->password)) {
            event(new NewLogCreated(' لم يتم تغيير كلمة المرور بنجاح', $user->user_name, 4, 0, 0));
            return back()->with('error', 'لم يتم تغيير كلمة المرور بنجاح');
        }

        $newPassword = Hash::make($request->password);


        if ($user->update(['password' => $newPassword])) {
            event(new NewLogCreated(' تم تغيير كلمة المرور بنجاح', $user->user_name, 4, 0, 0));
            return back()->with('success', 'تم تغيير كلمة المرور بنجاح');
        } else {
            event(new NewLogCreated(' لم يتم تغيير كلمة المرور بنجاح', $user->user_name, 4, 0, 0));
            return back()->with('error', 'لم يتم تغيير كلمة المرور بنجاح');
        }
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    function log()
    {
        $user = User::find(Auth::id());

        return view('admin.profile.log', compact('user'));
    }

    /**
     * @return mixed
     */
    function getLog()
    {
        $logs = Log::where('user_id', Auth::user()->id)->get();
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
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addMedia(AddMediaRequest $request)
    {

        $user = User::find(Auth::user()->id);


        $fileArray = [];
        if (count($request['files']) != count($request['file_type_id'])) {
            event(new NewLogCreated(' يرجى ادخال نوع الملف ', $user->user_name, 99, 0, 0));
            return back()->with('error', 'يرجى ادخال نوع الملف ');
        }
        for ($i = 0; $i < count($request['files']); $i++) {
            if ((isset($request['files'][$i])) && (!is_null($request['files'][$i])) && (isset($request['file_type_id'][$i])) && (!is_null($request['file_type_id'][$i]))) {
                $fileArray[$i]['files'] = $request['files'][$i];
                if ($request['file_type_id'][$i] == 1 && ($request['file_type_id_other'][$i])) {
                    $file_type_id = FileType::create(['name' => $request['file_type_id_other'][$i], 'status' => 0])->id;
                    $fileArray[$i]['file_type_id'] = $file_type_id;
                } else {
                    $fileArray[$i]['file_type_id'] = $request['file_type_id'][$i];
                }
            }
        }

        if (count($fileArray) > 0) {
            foreach ($fileArray as $file) {

//                $request->validate([
//                    'files' => 'mimes:jpeg,png,jpg,pdf|max:2048'
//                ]);

                $fileName = time() . '.' . $file['files']->getClientOriginalExtension();

                $path = 'uploads/users/';
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

                
                //$upload = $file['files']->move($path, $fileName);

                $file_type_id = $file['file_type_id'];

                $mediaData = [
                    'path' => $path . $fileName,
                    'file_type_id' => $file_type_id,
                    'user_id' => $user->id
                ];

                UserMedia::create($mediaData);
            }

            event(new NewLogCreated(' تم إضافة مرفقات بنجاح', $user->user_name, 99, 0, 0));
            return back()->with('success', 'تم إضافة مرفقات بنجاح');

        } else {

            event(new NewLogCreated(' لم يتم إضافة مرفقات ', $user->user_name, 99, 0, 0));
            return back()->with('error', 'لم  يتم إضافة اضافه مرفقات ');

        }

    }

    public function removeMedia($id)
    {

        if (!is_null($id)) {
            $media = UserMedia::find($id);

            if (!is_null($media)) {
                $userId = $media->user_id;
                $user = User::find($userId);

                $mypath = public_path() . "/" . $media->path; // مكان التخزين في البابليك ثم مجلد ابلودز
                if (file_exists($mypath) && $mypath != null) {//اذا يوجد ملف قديم مخزن
                    unlink($mypath);//يقوم بحذف القديم
                }

                if ($media->delete()) {
                    event(new NewLogCreated('تم حذف مرفق  شخصي برقم :  ', $user->id, 100, 1, url('admin/profile/edit')));
                    return back()->with('success', 'تم حذف مرفق  شخصي بنجاح  ');
                }
                event(new NewLogCreated('لم يتم حذف مرفق  شخصي برقم :  ', $user->id, 100, 1, url('admin/profile/edit')));
                return back()->with('error', 'لم يتم حذف مرفق  بنجاح  ');

            } else {
                event(new NewLogCreated('لم يتم العثور على  مرفق شخصي بنجاح برقم : ', $id, 100, 0, null));
                return back()->with('error', 'لم يتم العثور على  مرفق شخصي بنجاح');
            }

        } else {
            event(new NewLogCreated('لم يتم العثور على  مرفق شخصي بنجاح برقم : ', $id, 100, 0, null));
            return back()->with('error', 'لم يتم العثور على  مرفق شخصي بنجاح');
        }
    }

    public function tasks(Request $request)
    {
        $user = User::find(auth()->user()->id);

        if (!is_null($user)) {

            $tasks = Task::where('user_id', $user->id);

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

            return view('admin.profile.tasks', compact('items',
                "admin_ids", "user_ids", "family_ids",
                "project_ids", "institution_ids", "title",
                "done", "from_id", "to_id",
                "from_to_date", "to_to_date",
                "from_from_date", "to_from_date", "families_yes",
                "coulmn", 'min_id', 'max_id', 'type', 'full_done', 'institutions', 'projects', 'user'));


        } else {
            event(new NewLogCreated('المحاولة للوصول لمستخدم غير موجود برقم : ', $user->id, 4, 1, null));
            return redirect("/admin/users")->with('error', 'المستخدم غير موجود');
        }
    }

}
