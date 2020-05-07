<?php

namespace App\Http\Controllers\admin;

use App\Events\NewLogCreated;
use App\Http\Requests\StudyTypeRequest;
use App\StudyType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class StudyTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $studyTypes = StudyType::all();
        return view('admin.studyType.list', compact('studyTypes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.studyType.create');
    }

    /**
     * @param StudyTypeRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(StudyTypeRequest $request)
    {
        $message = null;

        $item = StudyType::where('name', '=', $request['name'])->first();

        if(is_null($item)) {
            $request['created_by'] = Auth::user()->id;

            if ($studyType = StudyType::create($request->all())) {
                $message = 'تم إضافة  نوع الدراسة بنجاح';

                event(new NewLogCreated($message, $request['name'], 118, 1, url('admin/studyTypes/' . $studyType->id . '/edit')));
                return back()->with('success', $message);

            } else {

                $message = 'لم يتم إضافة  نوع الدراسة بنجاح';

                event(new NewLogCreated($message, $request['name'], 118, 0, null));
                return back()->with('error', $message);
            }   } else {

            $message = 'لم يتم إضافة  نوع الدراسة بنجاح لتكرار البيانات ';

            event(new NewLogCreated($message, $request['name'], 118, 0, null));
            return back()->with('error', $message);
        }
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!is_null($id)) {
            $studyType = StudyType::find($id);

            if (!is_null($studyType)) {

                return view('admin.studyType.edit', compact('studyType'));
            } else {
                event(new NewLogCreated('لم يتم العثور على   نوع الدراسة بنجاح برقم : ', $id, 119, 0, null));
                return redirect('admin/studyTypes')->with('error', 'لم يتم العثور على   نوع الدراسة بنجاح');
            }

        } else {
            event(new NewLogCreated('لم يتم العثور على   نوع الدراسة بنجاح برقم : ', $id, 119, 0, null));
            return redirect('admin/studyTypes')->with('error', 'لم يتم العثور على   نوع الدراسة بنجاح');
        }
    }

    /**
     * @param StudyTypeRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(StudyTypeRequest $request, $id)
    {
        $message = null;

        if (!is_null($id)) {
            $studyType = StudyType::find($id);

            if (!is_null($studyType)) {

                $request['updated_by'] = Auth::user()->id;
                if ($studyType->update($request->all())) {
                    $message = 'تم تحديث  نوع الدراسة بنجاح';

                    event(new NewLogCreated($message, $request['name'], 119, 1, url('admin/studyTypes/' . $studyType->id . '/edit')));
                    return redirect('admin/studyTypes')->with('success', $message);

                } else {
                    $message = 'لم يتم تحديث  نوع الدراسة بنجاح';

                    event(new NewLogCreated($message, $request['name'], 119, 0, null));
                    return redirect('admin/studyTypes')->with('error', $message);
                }
            } else {
                event(new NewLogCreated('لم يتم العثور على   نوع الدراسة بنجاح برقم : ', $id, 119, 0, null));
                return redirect('admin/studyTypes')->with('error', 'لم يتم العثور على   نوع الدراسة بنجاح');
            }

        } else {
            event(new NewLogCreated('لم يتم العثور على   نوع الدراسة بنجاح برقم : ', $id, 119, 0, null));
            return redirect('admin/studyTypes')->with('error', 'لم يتم العثور على   نوع الدراسة بنجاح');
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function delete($id)
    {
        if (!is_null($id)) {
            $studyType = StudyType::find($id);

            if (!is_null($studyType)) {
                $name = $studyType->name;

                if ( (($studyType->family)->isEmpty())) {
                    if ($studyType->delete()) {
                        event(new NewLogCreated('تم حذف   نوع الدراسة بنجاح ', $name, 120, 0, null));
                        return redirect('admin/studyTypes')->with('success', 'تم حذف   نوع الدراسة بنجاح');
                    }
                    event(new NewLogCreated('لم يتم حذف   نوع الدراسة بنجاح  ', $name, 120, 0, null));
                    return redirect('admin/studyTypes')->with('error', 'لم يتم حذف   نوع الدراسة بنجاح  ');
                } else {
                    event(new NewLogCreated('لم يتم حذف   نوع الدراسة بنجاح لوجود عناصر مرتبطة بها ', $name, 120, 0, null));
                    return redirect('admin/studyTypes')->with('error', 'لم يتم حذف   نوع الدراسة بنجاح لوجود عناصر مرتبطة بها ');
                }
            } else {
                event(new NewLogCreated('لم يتم العثور على  نوع الدراسة بنجاح برقم : ', $id, 120, 0, null));
                return redirect('admin/studyTypes')->with('error', 'لم يتم العثور على    نوع الدراسة بنجاح');
            }

        } else {
            event(new NewLogCreated('لم يتم العثور على  نوع الدراسة بنجاح برقم : ', $id, 120, 0, null));
            return redirect('admin/studyTypes')->with('error', 'لم يتم العثور على    نوع الدراسة بنجاح');
        }
    }
}
