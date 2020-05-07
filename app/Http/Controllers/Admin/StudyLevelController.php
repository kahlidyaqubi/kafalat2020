<?php

namespace App\Http\Controllers\admin;

use App\Events\NewLogCreated;
use App\Http\Requests\StudyLevelRequest;
use App\StudyLevel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class StudyLevelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $studyLevels = StudyLevel::all();
        return view('admin.studyLevel.list', compact('studyLevels'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.studyLevel.create');
    }

    /**
     * @param StudyLevelRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(StudyLevelRequest $request)
    {
        $message = null;

        $item = StudyLevel::where('name', '=', $request['name'])->first();

        if(is_null($item)) {
            $request['created_by'] = Auth::user()->id;

            if ($studyLevels = StudyLevel::create($request->all())) {
                $message = 'تم إضافة  المستوى الجامعي بنجاح';

                event(new NewLogCreated($message, $request['name'], 112, 1, url('admin/studyLevels/' . $studyLevels->id . '/edit')));
                return back()->with('success', $message);

            } else {

                $message = 'لم يتم إضافة  المستوى الجامعي بنجاح';

                event(new NewLogCreated($message, $request['name'], 112, 0, null));
                return back()->with('error', $message);
            }   } else {

            $message = 'لم يتم إضافة  المستوى الجامعي بنجاح لتكرار البيانات ';

            event(new NewLogCreated($message, $request['name'], 112, 0, null));
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
            $studyLevel = StudyLevel::find($id);

            if (!is_null($studyLevel)) {

                return view('admin.studyLevel.edit', compact('studyLevel'));
            } else {
                event(new NewLogCreated('لم يتم العثور على المستوى الجامعي بنجاح برقم : ', $id, 113, 0, null));
                return redirect('admin/studyLevels')->with('error', 'لم يتم العثور على   المستوى الجامعي بنجاح');
            }

        } else {
            event(new NewLogCreated('لم يتم العثور على   المستوى الجامعي بنجاح برقم : ', $id, 113, 0, null));
            return redirect('admin/studyLevels')->with('error', 'لم يتم العثور على   المستوى الجامعي بنجاح');
        }
    }

    /**
     * @param StudyLevelRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(StudyLevelRequest $request, $id)
    {
        $message = null;

        if (!is_null($id)) {
            $studyLevel = StudyLevel::find($id);

            if (!is_null($studyLevel)) {

                $request['updated_by'] = Auth::user()->id;
                if ($studyLevel->update($request->all())) {
                    $message = 'تم تحديث  المستوى الجامعي بنجاح';

                    event(new NewLogCreated($message, $request['name'], 113, 1, url('admin/studyLevels/' . $studyLevel->id . '/edit')));
                    return redirect('admin/studyLevels')->with('success', $message);

                } else {
                    $message = 'لم يتم تحديث  المستوى الجامعي بنجاح';

                    event(new NewLogCreated($message, $request['name'], 113, 0, null));
                    return redirect('admin/studyLevels')->with('error', $message);
                }
            } else {
                event(new NewLogCreated('لم يتم العثور على   المستوى الجامعي بنجاح برقم : ', $id, 113, 0, null));
                return redirect('admin/studyLevels')->with('error', 'لم يتم العثور على   المستوى الجامعي بنجاح');
            }

        } else {
            event(new NewLogCreated('لم يتم العثور على   المستوى الجامعي بنجاح برقم : ', $id, 113, 0, null));
            return redirect('admin/studyLevels')->with('error', 'لم يتم العثور على   المستوى الجامعي بنجاح');
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function delete($id)
    {
        if (!is_null($id)) {
            $studyLevel = StudyLevel::find($id);

            if (!is_null($studyLevel)) {
                $name = $studyLevel->name;

                if ((($studyLevel->family)->isEmpty())) {
                    if ($studyLevel->delete()) {
                        event(new NewLogCreated('تم حذف   المستوى الجامعي بنجاح ', $name, 114, 0, null));
                        return redirect('admin/studyLevels')->with('success', 'تم حذف   المستوى الجامعي بنجاح');
                    }
                    event(new NewLogCreated('لم يتم حذف   المستوى الجامعي بنجاح  ', $name, 114, 0, null));
                    return redirect('admin/studyLevels')->with('error', 'لم يتم حذف   المستوى الجامعي بنجاح  ');
                } else {
                    event(new NewLogCreated('لم يتم حذف   المستوى الجامعي بنجاح لوجود عناصر مرتبطة بها ', $name, 114, 0, null));
                    return redirect('admin/studyLevels')->with('error', 'لم يتم حذف   المستوى الجامعي بنجاح لوجود عناصر مرتبطة بها ');
                }
            } else {
                event(new NewLogCreated('لم يتم العثور على  المستوى الجامعي بنجاح برقم : ', $id, 114, 0, null));
                return redirect('admin/studyLevels')->with('error', 'لم يتم العثور على    المستوى الجامعي بنجاح');
            }

        } else {
            event(new NewLogCreated('لم يتم العثور على  المستوى الجامعي بنجاح برقم : ', $id, 114, 0, null));
            return redirect('admin/studyLevels')->with('error', 'لم يتم العثور على    المستوى الجامعي بنجاح');
        }
    }
}
