<?php

namespace App\Http\Controllers\admin;

use App\Events\NewLogCreated;
use App\Http\Requests\QualificationLevelRequest;
use App\Http\Requests\QualificationRequest;
use App\QualificationLevels;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class QualificationLevelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $qualificationLevels = QualificationLevels::all();
        return view('admin.qualificationLevel.list', compact('qualificationLevels'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.qualificationLevel.create');
    }

    /**
     * @param QualificationLevelRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(QualificationLevelRequest $request)
    {
        $message = null;

        $item = QualificationLevels::where('name', '=', $request['name'])->first();

        if(is_null($item)) {
            $request['created_by'] = Auth::user()->id;

            if ($qualificationLevel = QualificationLevels::create($request->all())) {
                $message = 'تم إضافة المستوى التعليمي بنجاح';

                event(new NewLogCreated($message, $request['name'], 109, 1, url('admin/qualificationLevels/' . $qualificationLevel->id . '/edit')));
                return back()->with('success', $message);

            } else {

                $message = 'لم يتم إضافة المستوى التعليمي بنجاح';

                event(new NewLogCreated($message, $request['name'], 109, 0, null));
                return back()->with('error', $message);
            }   } else {

            $message = 'لم يتم إضافة المستوى التعليمي بنجاح لتكرار البيانات ';

            event(new NewLogCreated($message, $request['name'], 109, 0, null));
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
            $qualificationLevel = QualificationLevels::find($id);

            if (!is_null($qualificationLevel)) {

                return view('admin.qualificationLevel.edit', compact('qualificationLevel'));
            } else {
                event(new NewLogCreated('لم يتم العثور على  المستوى التعليمي بنجاح برقم : ', $id, 110, 0, null));
                return redirect('admin/qualificationLevels')->with('error', 'لم يتم العثور على  المستوى التعليمي بنجاح');
            }

        } else {
            event(new NewLogCreated('لم يتم العثور على  المستوى التعليمي بنجاح برقم : ', $id, 110, 0, null));
            return redirect('admin/qualificationLevels')->with('error', 'لم يتم العثور على  المستوى التعليمي بنجاح');
        }
    }

    /**
     * @param QualificationLevelRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(QualificationLevelRequest $request, $id)
    {
        $message = null;

        if (!is_null($id)) {
            $qualificationLevel = QualificationLevels::find($id);

            if (!is_null($qualificationLevel)) {

                $request['updated_by'] = Auth::user()->id;
                if ($qualificationLevel->update($request->all())) {
                    $message = 'تم تحديث المستوى التعليمي بنجاح';

                    event(new NewLogCreated($message, $request['name'], 110, 1, url('admin/qualificationLevels/' . $qualificationLevel->id . '/edit')));
                    return redirect('admin/qualificationLevels')->with('success', $message);

                } else {
                    $message = 'لم يتم تحديث المستوى التعليمي بنجاح';

                    event(new NewLogCreated($message, $request['name'], 110, 0, null));
                    return redirect('admin/qualificationLevels')->with('error', $message);
                }
            } else {
                event(new NewLogCreated('لم يتم العثور على  المستوى التعليمي بنجاح برقم : ', $id, 110, 0, null));
                return redirect('admin/qualificationLevels')->with('error', 'لم يتم العثور على  المستوى التعليمي بنجاح');
            }

        } else {
            event(new NewLogCreated('لم يتم العثور على  المستوى التعليمي بنجاح برقم : ', $id, 110, 0, null));
            return redirect('admin/qualificationLevels')->with('error', 'لم يتم العثور على  المستوى التعليمي بنجاح');
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function delete($id)
    {
        if (!is_null($id)) {
            $qualificationLevel = QualificationLevels::find($id);

            if (!is_null($qualificationLevel)) {
                $name = $qualificationLevel->name;

                if ((($qualificationLevel->person)->isEmpty())) {
                    if ($qualificationLevel->delete()) {
                        event(new NewLogCreated('تم حذف  المستوى التعليمي بنجاح ', $name, 111, 0, null));
                        return redirect('admin/qualificationLevels')->with('success', 'تم حذف  المستوى التعليمي بنجاح');
                    }
                    event(new NewLogCreated('لم يتم حذف  المستوى التعليمي بنجاح  ', $name, 111, 0, null));
                    return redirect('admin/qualificationLevels')->with('error', 'لم يتم حذف  المستوى التعليمي بنجاح  ');
                } else {
                    event(new NewLogCreated('لم يتم حذف  المستوى التعليمي بنجاح لوجود عناصر مرتبطة بها ', $name, 111, 0, null));
                    return redirect('admin/qualificationLevels')->with('error', 'لم يتم حذف  المستوى التعليمي بنجاح لوجود عناصر مرتبطة بها ');
                }
            } else {
                event(new NewLogCreated('لم يتم العثور على المستوى التعليمي بنجاح برقم : ', $id, 111, 0, null));
                return redirect('admin/qualificationLevels')->with('error', 'لم يتم العثور على   المستوى التعليمي بنجاح');
            }

        } else {
            event(new NewLogCreated('لم يتم العثور على المستوى التعليمي بنجاح برقم : ', $id, 111, 0, null));
            return redirect('admin/qualificationLevels')->with('error', 'لم يتم العثور على   المستوى التعليمي بنجاح');
        }
    }
}
