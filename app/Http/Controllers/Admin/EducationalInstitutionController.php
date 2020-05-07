<?php

namespace App\Http\Controllers\Admin;

use App\EducationalInstitution;
use App\Events\NewLogCreated;
use App\Http\Requests\EducationalInstitutionRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

/**
 * Class EducationalInstitutionController
 * @package App\Http\Controllers\Admin
 */
class EducationalInstitutionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $educationalInstitutions = EducationalInstitution::all();
        return view('admin.educationalInstitution.list', compact('educationalInstitutions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.educationalInstitution.create');
    }

    /**
     * @param EducationalInstitutionRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(EducationalInstitutionRequest $request)
    {
        $message = null;

        $item = EducationalInstitution::where('name', '=', $request['name'])->first();

        if(is_null($item)) {
        $request['created_by'] = Auth::user()->id;
        $request['status'] = 1;

        if ($educationalInstitution = EducationalInstitution::create($request->all())) {
            $message = 'تم إضافة المؤسسة التعلىمية بنجاح';

            event(new NewLogCreated($message, $request['name'], 22, 1, url('admin/educationalInstitutions/' . $educationalInstitution->id . '/edit')));
            return back()->with('success', $message);

        } else {

            $message = 'لم يتم إضافة المؤسسة التعلىمية بنجاح';

            event(new NewLogCreated($message, $request['name'], 22, 0, null));
            return back()->with('error', $message);
        }  } else {

            $message = 'لم يتم إضافة المؤسسة التعلىمية بنجاح لتكرار البيانات ';

            event(new NewLogCreated($message, $request['name'], 22, 0, null));
            return redirect('admin/educationalInstitutions')->with('error', $message);
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
            $educationalInstitution = EducationalInstitution::find($id);

            if (!is_null($educationalInstitution)) {

                return view('admin.educationalInstitution.edit', compact('educationalInstitution'));
            } else {
                event(new NewLogCreated('لم يتم العثور على  المؤسسة التعلىمية بنجاح برقم : ', $id, 23, 0, null));
                return redirect('admin/educationalInstitutions')->with('error', 'لم يتم العثور على  المؤسسة التعلىمية بنجاح');
            }

        } else {
            event(new NewLogCreated('لم يتم العثور على  المؤسسة التعلىمية بنجاح برقم : ', $id, 23, 0, null));
            return redirect('admin/educationalInstitutions')->with('error', 'لم يتم العثور على  المؤسسة التعلىمية بنجاح');
        }
    }

    /**
     * @param EducationalInstitutionRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(EducationalInstitutionRequest $request, $id)
    {
        $message = null;

        if (!is_null($id)) {
            $educationalInstitution = EducationalInstitution::find($id);

            if (!is_null($educationalInstitution)) {

                $request['updated_by'] = Auth::user()->id;
                if ($educationalInstitution->update($request->all())) {
                    $message = 'تم تحديث المؤسسة التعلىمية بنجاح';

                    event(new NewLogCreated($message, $request['name'], 23, 1, url('admin/educationalInstitutions/' . $educationalInstitution->id . '/edit')));
                    return redirect('admin/educationalInstitutions')->with('success', $message);

                } else {
                    $message = 'لم يتم تحديث المؤسسة التعلىمية بنجاح';

                    event(new NewLogCreated($message, $request['name'], 23, 0, null));
                    return redirect('admin/educationalInstitutions')->with('error', $message);
                }
            } else {
                event(new NewLogCreated('لم يتم العثور على  المؤسسة التعلىمية بنجاح برقم : ', $id, 23, 0, null));
                return redirect('admin/educationalInstitutions')->with('error', 'لم يتم العثور على  المؤسسة التعلىمية بنجاح');
            }

        } else {
            event(new NewLogCreated('لم يتم العثور على  المؤسسة التعلىمية بنجاح برقم : ', $id, 23, 0, null));
            return redirect('admin/educationalInstitutions')->with('error', 'لم يتم العثور على  المؤسسة التعلىمية بنجاح');
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function delete($id)
    {
        if (!is_null($id)) {
            $educationalInstitution = EducationalInstitution::find($id);

            if (!is_null($educationalInstitution)) {
                $name = $educationalInstitution->name;

                if ((($educationalInstitution->family)->isEmpty())) {
                    if ($educationalInstitution->delete()) {
                        event(new NewLogCreated('تم حذف المؤسسة التعلىمية بنجاح ', $name, 24, 0, null));
                        return redirect('admin/educationalInstitutions')->with('success', 'تم حذف المؤسسة التعلىمية بنجاح');
                    }
                    event(new NewLogCreated('لم يتم حذف المؤسسة التعلىمية بنجاح  ', $name, 24, 0, null));
                    return redirect('admin/educationalInstitutions')->with('error', 'لم يتم حذف المؤسسة التعلىمية بنجاح  ');
                } else {
                    event(new NewLogCreated('لم يتم حذف المؤسسة التعلىمية بنجاح لوجود عناصر مرتبطة بها ', $name, 24, 0, null));
                    return redirect('admin/educationalInstitutions')->with('error', 'لم يتم حذف المؤسسة التعلىمية بنجاح لوجود عناصر مرتبطة بها ');
                }
            } else {
                event(new NewLogCreated('لم يتم العثور على  المؤسسة التعلىمية بنجاح برقم : ', $id, 24, 0, null));
                return redirect('admin/educationalInstitutions')->with('error', 'لم يتم العثور على  المؤسسة التعلىمية بنجاح');
            }

        } else {
            event(new NewLogCreated('لم يتم العثور على  المؤسسة التعلىمية بنجاح برقم : ', $id, 24, 0, null));
            return redirect('admin/educationalInstitutions')->with('error', 'لم يتم العثور على  المؤسسة التعلىمية بنجاح');
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function approve($id)
    {
        if (!is_null($id)) {
            $educationalInstitution = EducationalInstitution::find($id);

            if (!is_null($educationalInstitution)) {
                if ($educationalInstitution->update(['status'=> 1])) {
                    $message = 'تم قبول المؤسسة التعلىمية بنجاح';

                    event(new NewLogCreated($message, $educationalInstitution->name, 25, 1, url('admin/educationalInstitutions/' . $educationalInstitution->id . '/edit')));
                    return redirect('admin/educationalInstitutions')->with('success', $message);

                } else {
                    $message = 'لم يتم قبول المؤسسة التعلىمية بنجاح';

                    event(new NewLogCreated($message, $educationalInstitution->name, 25, 1, url('admin/educationalInstitutions/' . $educationalInstitution->id . '/edit')));
                    return redirect('admin/educationalInstitutions')->with('error', $message);
                }

            } else {
                event(new NewLogCreated('لم يتم العثور على المؤسسة التعلىمية بنجاح برقم : ', $id, 25, 0, null));
                return redirect('admin/educationalInstitutions')->with('error', 'لم يتم العثور على  المؤسسة التعلىمية بنجاح');
            }
        } else {
            event(new NewLogCreated('لم يتم العثور على  المؤسسة التعلىمية بنجاح برقم : ', $id, 25, 0, null));
            return redirect('admin/educationalInstitutions')->with('error', 'لم يتم العثور على  المؤسسة التعلىمية بنجاح');
        }
    }
}
