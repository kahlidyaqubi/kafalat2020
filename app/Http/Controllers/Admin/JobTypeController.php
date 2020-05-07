<?php

namespace App\Http\Controllers\Admin;

use App\Events\NewLogCreated;
use App\Http\Requests\JobTypeRequest;
use App\JobType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

/**
 * Class JobTypeController
 * @package App\Http\Controllers\Admin
 */
class JobTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jobTypes = JobType::all();
        return view('admin.jobType.list', compact('jobTypes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.jobType.create');
    }

    /**
     * @param JobTypeRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(JobTypeRequest $request)
    {
        $message = null;

        $item = JobType::where('name', '=', $request['name'])->first();

        if(is_null($item)) {
        $request['created_by'] = Auth::user()->id;
        $request['status'] = 1;

        if ($jobType = JobType::create($request->all())) {
            $message = 'تم إضافة أنواع العمل بنجاح';

            event(new NewLogCreated($message, $request['name'], 46, 1, url('admin/jobTypes/' . $jobType->id . '/edit')));
            return back()->with('success', $message);

        } else {

            $message = 'لم يتم إضافة أنواع العمل بنجاح';

            event(new NewLogCreated($message, $request['name'], 46, 0, null));
            return back()->with('error', $message);
        }  } else {

            $message = 'لم يتم إضافة أنواع العمل بنجاح لتكرار البيانات';

            event(new NewLogCreated($message, $request['name'], 46, 0, null));
            return back()->with('error', $message);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!is_null($id)) {
            $jobType = JobType::find($id);

            if (!is_null($jobType)) {

                return view('admin.jobType.edit', compact('jobType'));
            } else {
                event(new NewLogCreated('لم يتم العثور على نوع العمل بنجاح برقم : ', $id, 47, 0, null));
                return redirect('admin/jobTypes')->with('error', 'لم يتم العثور على نوع العمل بنجاح');
            }

        } else {
            event(new NewLogCreated('لم يتم العثور على نوع العمل بنجاح برقم : ', $id, 47, 0, null));
            return redirect('admin/jobTypes')->with('error', 'لم يتم العثور على نوع العمل بنجاح');
        }
    }

    /**
     * @param JobTypeRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(JobTypeRequest $request, $id)
    {
        $message = null;

        if (!is_null($id)) {
            $jobType = JobType::find($id);

            if (!is_null($jobType)) {

                $request['updated_by'] = Auth::user()->id;
                if ($jobType->update($request->all())) {
                    $message = 'تم تحديث أنواع العمل بنجاح';

                    event(new NewLogCreated($message, $request['name'], 47, 1, url('admin/jobTypes/' . $jobType->id . '/edit')));
                    return redirect('admin/jobTypes')->with('success', $message);

                } else {
                    $message = 'لم يتم تحديث أنواع العمل بنجاح';

                    event(new NewLogCreated($message, $request['name'], 47, 0, null));
                    return redirect('admin/jobTypes')->with('error', $message);
                }
            } else {
                event(new NewLogCreated('لم يتم العثور على نوع العمل بنجاح برقم : ', $id, 47, 0, null));
                return redirect('admin/jobTypes')->with('error', 'لم يتم العثور على نوع العمل بنجاح');
            }

        } else {
            event(new NewLogCreated('لم يتم العثور على نوع العمل بنجاح برقم : ', $id, 47, 0, null));
            return redirect('admin/jobTypes')->with('error', 'لم يتم العثور على نوع العمل بنجاح');
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function delete($id)
    {
        if (!is_null($id)) {
            $jobType = JobType::find($id);

            if (!is_null($jobType)) {
                $name = $jobType->name;

                if ((($jobType->family)->isEmpty())) {
                    if ($jobType->delete()) {
                        event(new NewLogCreated('تم حذف نوع العمل بنجاح ', $name, 48, 0, null));
                        return redirect('admin/jobTypes')->with('success', 'تم حذف نوع العمل بنجاح');
                    }
                    event(new NewLogCreated('لم يتم حذف نوع العمل بنجاح  ', $name, 48, 0, null));
                    return redirect('admin/jobTypes')->with('error', 'لم يتم حذف نوع العمل بنجاح  ');
                } else {
                    event(new NewLogCreated('لم يتم حذف نوع العمل بنجاح لوجود عناصر مرتبطة بها ', $name, 48, 0, null));
                    return redirect('admin/jobTypes')->with('error', 'لم يتم حذف نوع العمل بنجاح لوجود عناصر مرتبطة بها ');
                }
            } else {
                event(new NewLogCreated('لم يتم العثور على  نوع العمل بنجاح برقم : ', $id, 48, 0, null));
                return redirect('admin/jobTypes')->with('error', 'لم يتم العثور على  نوع العمل بنجاح');
            }

        } else {
            event(new NewLogCreated('لم يتم العثور على  نوع العمل بنجاح برقم : ', $id, 48, 0, null));
            return redirect('admin/jobTypes')->with('error', 'لم يتم العثور على  نوع العمل بنجاح');
        }
    }

}
