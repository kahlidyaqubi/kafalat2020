<?php

namespace App\Http\Controllers\Admin;

use App\Events\NewLogCreated;
use App\Http\Requests\QualificationRequest;
use App\Qualification;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

/**
 * Class QualificationController
 * @package App\Http\Controllers\Admin
 */
class QualificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $qualifications = Qualification::all();
        return view('admin.qualification.list', compact('qualifications'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.qualification.create');
    }

    /**
     * @param QualificationRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(QualificationRequest $request)
    {
        $message = null;

        $item = Qualification::where('name', '=', $request['name'])->first();

        if(is_null($item)) {
        $request['created_by'] = Auth::user()->id;
        if ($qualification = Qualification::create($request->all())) {
            $message = 'تم إضافة مؤهل علمي بنجاح';

            event(new NewLogCreated($message, $request['name'], 49, 1, url('admin/qualifications/' . $qualification->id . '/edit')));
            return back()->with('success', $message);

        } else {

            $message = 'لم يتم إضافة مؤهل علمي بنجاح';

            event(new NewLogCreated($message, $request['name'], 49, 0, null));
            return back()->with('error', $message);
        }   } else {

            $message = 'لم يتم إضافة مؤهل علمي بنجاح لتكرار البيانات';

            event(new NewLogCreated($message, $request['name'], 49, 0, null));
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
            $qualification = Qualification::find($id);

            if (!is_null($qualification)) {

                return view('admin.qualification.edit', compact('qualification'));
            } else {
                event(new NewLogCreated('لم يتم العثور على  مؤهل علمي بنجاح برقم : ', $id, 50, 0, null));
                return redirect('admin/qualifications')->with('error', 'لم يتم العثور على  مؤهل علمي بنجاح');
            }

        } else {
            event(new NewLogCreated('لم يتم العثور على  مؤهل علمي بنجاح برقم : ', $id, 50, 0, null));
            return redirect('admin/qualifications')->with('error', 'لم يتم العثور على  مؤهل علمي بنجاح');
        }
    }

    /**
     * @param QualificationRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(QualificationRequest $request, $id)
    {
        $message = null;

        if (!is_null($id)) {
            $qualification = Qualification::find($id);

            if (!is_null($qualification)) {

                $request['updated_by'] = Auth::user()->id;
                if ($qualification->update($request->all())) {
                    $message = 'تم تحديث مؤهل علمي بنجاح';

                    event(new NewLogCreated($message, $request['name'], 50, 1, url('admin/qualifications/' . $qualification->id . '/edit')));
                    return redirect('admin/qualifications')->with('success', $message);

                } else {
                    $message = 'لم يتم تحديث مؤهل علمي بنجاح';

                    event(new NewLogCreated($message, $request['name'], 50, 0, null));
                    return redirect('admin/qualifications')->with('error', $message);
                }
            } else {
                event(new NewLogCreated('لم يتم العثور على  مؤهل علمي بنجاح برقم : ', $id, 50, 0, null));
                return redirect('admin/qualifications')->with('error', 'لم يتم العثور على  مؤهل علمي بنجاح');
            }

        } else {
            event(new NewLogCreated('لم يتم العثور على  مؤهل علمي بنجاح برقم : ', $id, 50, 0, null));
            return redirect('admin/qualifications')->with('error', 'لم يتم العثور على  مؤهل علمي بنجاح');
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function delete($id)
    {
        if (!is_null($id)) {
            $qualification = Qualification::find($id);

            if (!is_null($qualification)) {
                $name = $qualification->name;

                if ((($qualification->person)->isEmpty())) {
                    if ($qualification->delete()) {
                        event(new NewLogCreated('تم حذف مؤهل علمي بنجاح ', $name, 51, 0, null));
                        return redirect('admin/qualifications')->with('success', 'تم حذف مؤهل علمي بنجاح');
                    }
                    event(new NewLogCreated('لم يتم حذف مؤهل علمي بنجاح  ', $name, 51, 0, null));
                    return redirect('admin/qualifications')->with('error', 'لم يتم حذف مؤهل علمي بنجاح  ');
                } else {
                    event(new NewLogCreated('لم يتم حذف مؤهل علمي بنجاح لوجود عناصر مرتبطة بها ', $name, 51, 0, null));
                    return redirect('admin/qualifications')->with('error', 'لم يتم حذف مؤهل علمي بنجاح لوجود عناصر مرتبطة بها ');
                }
            } else {
                event(new NewLogCreated('لم يتم العثور على  مؤهل علمي بنجاح برقم : ', $id, 51, 0, null));
                return redirect('admin/qualifications')->with('error', 'لم يتم العثور على  مؤهل علمي بنجاح');
            }

        } else {
            event(new NewLogCreated('لم يتم العثور على  مؤهل علمي بنجاح برقم : ', $id, 51, 0, null));
            return redirect('admin/qualifications')->with('error', 'لم يتم العثور على  مؤهل علمي بنجاح');
        }
    }
}
