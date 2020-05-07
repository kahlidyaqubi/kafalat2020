<?php

namespace App\Http\Controllers\Admin;

use App\Events\NewLogCreated;
use App\Http\Requests\UniversitySpecialtyRequest;
use App\UniversitySpecialty;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

/**
 * Class UniversitySpecialtyController
 * @package App\Http\Controllers\Admin
 */
class UniversitySpecialtyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $universitySpecialties = UniversitySpecialty::all();
        return view('admin.universitySpecialty.list', compact('universitySpecialties'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.universitySpecialty.create');
    }


    /**
     * @param UniversitySpecialtyRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(UniversitySpecialtyRequest $request)
    {
        $message = null;

        $item = UniversitySpecialty::where('name', '=', $request['name'])->first();

        if(is_null($item)) {
        $request['created_by'] = Auth::user()->id;
        $request['status'] = 1;

        if ($universitySpecialty = UniversitySpecialty::create($request->all())) {
            $message = 'تم إضافة التخصص الجامعي بنجاح';

            event(new NewLogCreated($message, $request['name'], 56, 1, url('admin/universitySpecialties/' . $universitySpecialty->id . '/edit')));
            return back()->with('success', $message);

        } else {

            $message = 'لم يتم إضافة التخصص الجامعي بنجاح';

            event(new NewLogCreated($message, $request['name'], 56, 0, null));
            return back()->with('error', $message);
        }  } else {

            $message = 'لم يتم إضافة التخصص الجامعي بنجاح لتكرار البيانات';

            event(new NewLogCreated($message, $request['name'], 56, 0, null));
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
            $universitySpecialty = UniversitySpecialty::find($id);

            if (!is_null($universitySpecialty)) {

                return view('admin.universitySpecialty.edit', compact('universitySpecialty'));
            } else {
                event(new NewLogCreated('لم يتم العثور على  التخصص الجامعي بنجاح برقم : ', $id, 57, 0, null));
                return redirect('admin/universitySpecialties')->with('error', 'لم يتم العثور على  التخصص الجامعي بنجاح');
            }

        } else {
            event(new NewLogCreated('لم يتم العثور على  التخصص الجامعي بنجاح برقم : ', $id, 57, 0, null));
            return redirect('admin/universitySpecialties')->with('error', 'لم يتم العثور على  التخصص الجامعي بنجاح');
        }
    }

    /**
     * @param UniversitySpecialtyRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(UniversitySpecialtyRequest $request, $id)
    {
        $message = null;

        if (!is_null($id)) {
            $universitySpecialty = UniversitySpecialty::find($id);

            if (!is_null($universitySpecialty)) {

                $request['updated_by'] = Auth::user()->id;
                if ($universitySpecialty->update($request->all())) {
                    $message = 'تم تحديث التخصص الجامعي بنجاح';

                    event(new NewLogCreated($message, $request['name'], 57, 1, url('admin/universitySpecialties/' . $universitySpecialty->id . '/edit')));
                    return redirect('admin/universitySpecialties')->with('success', $message);

                } else {
                    $message = 'لم يتم تحديث التخصص الجامعي بنجاح';

                    event(new NewLogCreated($message, $request['name'], 57, 0, null));
                    return redirect('admin/universitySpecialties')->with('error', $message);
                }
            } else {
                event(new NewLogCreated('لم يتم العثور على  التخصص الجامعي بنجاح برقم : ', $id, 57, 0, null));
                return redirect('admin/universitySpecialties')->with('error', 'لم يتم العثور على  التخصص الجامعي بنجاح');
            }

        } else {
            event(new NewLogCreated('لم يتم العثور على  التخصص الجامعي بنجاح برقم : ', $id, 57, 0, null));
            return redirect('admin/universitySpecialties')->with('error', 'لم يتم العثور على  التخصص الجامعي بنجاح');
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function delete($id)
    {
        if (!is_null($id)) {
            $universitySpecialty = UniversitySpecialty::find($id);

            if (!is_null($universitySpecialty)) {
                $name = $universitySpecialty->name;

                if ((($universitySpecialty->family)->isEmpty()) && (($universitySpecialty->users)->isEmpty())) {
                    if ($universitySpecialty->delete()) {
                        event(new NewLogCreated('تم حذف التخصص الجامعي بنجاح ', $name, 58, 0, null));
                        return redirect('admin/universitySpecialties')->with('success', 'تم حذف التخصص الجامعي بنجاح');
                    }
                    event(new NewLogCreated('لم يتم حذف التخصص الجامعي بنجاح  ', $name, 58, 0, null));
                    return redirect('admin/universitySpecialties')->with('error', 'لم يتم حذف التخصص الجامعي بنجاح  ');
                } else {
                    event(new NewLogCreated('لم يتم حذف التخصص الجامعي بنجاح لوجود عناصر مرتبطة بها ', $name, 58, 0, null));
                    return redirect('admin/universitySpecialties')->with('error', 'لم يتم حذف التخصص الجامعي بنجاح لوجود عناصر مرتبطة بها ');
                }
            } else {
                event(new NewLogCreated('لم يتم العثور على  التخصص الجامعي بنجاح برقم : ', $id, 58, 0, null));
                return redirect('admin/universitySpecialties')->with('error', 'لم يتم العثور على  التخصص الجامعي بنجاح');
            }

        } else {
            event(new NewLogCreated('لم يتم العثور على  التخصص الجامعي بنجاح برقم : ', $id, 58, 0, null));
            return redirect('admin/universitySpecialties')->with('error', 'لم يتم العثور على  التخصص الجامعي بنجاح');
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function approve($id)
    {

        if (!is_null($id)) {
            $universitySpecialty = UniversitySpecialty::find($id);

            if (!is_null($universitySpecialty)) {
                if ($universitySpecialty->update(['status'=> 1])) {
                    $message = 'تم قبول التخصص الجامعي بنجاح';

                    event(new NewLogCreated($message, $universitySpecialty->name, 59, 1, url('admin/universitySpecialties/' . $universitySpecialty->id . '/edit')));
                    return redirect('admin/universitySpecialties')->with('success', $message);

                } else {
                    $message = 'لم يتم قبول التخصص الجامعي بنجاح';

                    event(new NewLogCreated($message, $universitySpecialty->name, 59, 1, url('admin/universitySpecialties/' . $universitySpecialty->id . '/edit')));
                    return redirect('admin/universitySpecialties')->with('error', $message);
                }

            } else {
                event(new NewLogCreated('لم يتم العثور على التخصص الجامعي بنجاح برقم : ', $id, 59, 0, null));
                return redirect('admin/universitySpecialties')->with('error', 'لم يتم العثور على  التخصص الجامعي بنجاح');
            }
        } else {
            event(new NewLogCreated('لم يتم العثور على  التخصص الجامعي بنجاح برقم : ', $id, 59, 0, null));
            return redirect('admin/universitySpecialties')->with('error', 'لم يتم العثور على  التخصص الجامعي بنجاح');
        }
    }

}
