<?php

namespace App\Http\Controllers\admin;

use App\Events\NewLogCreated;
use App\Http\Requests\StudyPartRequest;
use App\StudyPart;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class StudyPartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $studyParts = StudyPart::all();
        return view('admin.studyPart.list', compact('studyParts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.studyPart.create');
    }

    /**
     * @param StudyPartRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(StudyPartRequest $request)
    {
        $message = null;

        $item = StudyPart::where('name', '=', $request['name'])->first();

        if(is_null($item)) {
            $request['created_by'] = Auth::user()->id;

            if ($studyPart = StudyPart::create($request->all())) {
                $message = 'تم إضافة  جهة الدراسة بنجاح';

                event(new NewLogCreated($message, $request['name'], 115, 1, url('admin/studyParts/' . $studyPart->id . '/edit')));
                return back()->with('success', $message);

            } else {

                $message = 'لم يتم إضافة  جهة الدراسة بنجاح';

                event(new NewLogCreated($message, $request['name'], 115, 0, null));
                return back()->with('error', $message);
            }   } else {

            $message = 'لم يتم إضافة  جهة الدراسة بنجاح لتكرار البيانات ';

            event(new NewLogCreated($message, $request['name'], 115, 0, null));
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
            $studyPart = StudyPart::find($id);

            if (!is_null($studyPart)) {

                return view('admin.studyPart.edit', compact('studyPart'));
            } else {
                event(new NewLogCreated('لم يتم العثور على   جهة الدراسة بنجاح برقم : ', $id, 116, 0, null));
                return redirect('admin/studyParts')->with('error', 'لم يتم العثور على   جهة الدراسة بنجاح');
            }

        } else {
            event(new NewLogCreated('لم يتم العثور على   جهة الدراسة بنجاح برقم : ', $id, 116, 0, null));
            return redirect('admin/studyParts')->with('error', 'لم يتم العثور على   جهة الدراسة بنجاح');
        }
    }

    /**
     * @param StudyPartRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(StudyPartRequest $request, $id)
    {
        $message = null;

        if (!is_null($id)) {
            $studyPart = StudyPart::find($id);

            if (!is_null($studyPart)) {

                $request['updated_by'] = Auth::user()->id;
                if ($studyPart->update($request->all())) {
                    $message = 'تم تحديث  جهة الدراسة بنجاح';

                    event(new NewLogCreated($message, $request['name'], 116, 1, url('admin/studyParts/' . $studyPart->id . '/edit')));
                    return redirect('admin/studyParts')->with('success', $message);

                } else {
                    $message = 'لم يتم تحديث  جهة الدراسة بنجاح';

                    event(new NewLogCreated($message, $request['name'], 116, 0, null));
                    return redirect('admin/studyParts')->with('error', $message);
                }
            } else {
                event(new NewLogCreated('لم يتم العثور على   جهة الدراسة بنجاح برقم : ', $id, 116, 0, null));
                return redirect('admin/studyParts')->with('error', 'لم يتم العثور على   جهة الدراسة بنجاح');
            }

        } else {
            event(new NewLogCreated('لم يتم العثور على   جهة الدراسة بنجاح برقم : ', $id, 116, 0, null));
            return redirect('admin/studyParts')->with('error', 'لم يتم العثور على   جهة الدراسة بنجاح');
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function delete($id)
    {
        if (!is_null($id)) {
            $studyPart = StudyPart::find($id);

            if (!is_null($studyPart)) {
                $name = $studyPart->name;

                if ( (($studyPart->family)->isEmpty())) {
                    if ($studyPart->delete()) {
                        event(new NewLogCreated('تم حذف   جهة الدراسة بنجاح ', $name, 117, 0, null));
                        return redirect('admin/studyParts')->with('success', 'تم حذف   جهة الدراسة بنجاح');
                    }
                    event(new NewLogCreated('لم يتم حذف   جهة الدراسة بنجاح  ', $name, 117, 0, null));
                    return redirect('admin/studyParts')->with('error', 'لم يتم حذف   جهة الدراسة بنجاح  ');
                } else {
                    event(new NewLogCreated('لم يتم حذف   جهة الدراسة بنجاح لوجود عناصر مرتبطة بها ', $name, 117, 0, null));
                    return redirect('admin/studyParts')->with('error', 'لم يتم حذف   جهة الدراسة بنجاح لوجود عناصر مرتبطة بها ');
                }
            } else {
                event(new NewLogCreated('لم يتم العثور على  جهة الدراسة بنجاح برقم : ', $id, 117, 0, null));
                return redirect('admin/studyParts')->with('error', 'لم يتم العثور على    جهة الدراسة بنجاح');
            }

        } else {
            event(new NewLogCreated('لم يتم العثور على  جهة الدراسة بنجاح برقم : ', $id, 117, 0, null));
            return redirect('admin/studyParts')->with('error', 'لم يتم العثور على    جهة الدراسة بنجاح');
        }
    }
}
