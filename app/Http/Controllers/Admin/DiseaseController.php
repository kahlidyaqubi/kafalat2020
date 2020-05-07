<?php

namespace App\Http\Controllers\Admin;

use App\Disease;
use App\Events\NewLogCreated;
use App\Http\Requests\DiseaseRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

/**
 * Class DiseaseController
 * @package App\Http\Controllers\Admin
 */
class DiseaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $diseases = Disease::all();
        return view('admin.disease.list', compact('diseases'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.disease.create');
    }

    /**
     * @param DiseaseRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(DiseaseRequest $request)
    {
        $message = null;
        $item = Disease::where('name', '=', $request['name'])->first();

        if(is_null($item)) {
        $request['created_by'] = Auth::user()->id;

        if ($disease = Disease::create($request->all())) {
            $message = 'تم إضافة مرض بنجاح';

            event(new NewLogCreated($message, $request['name'], 19, 1, url('admin/diseases/' . $disease->id . '/edit')));
            return back()->with('success', $message);

        } else {

            $message = 'لم يتم إضافة مرض بنجاح';

            event(new NewLogCreated($message, $request['name'], 19, 0, null));
            return back()->with('error', $message);
        } } else {

            $message = ' لم يتم إضافة مرض بنجاح لتكرار البيانات ';

            event(new NewLogCreated($message, $request['name'], 19, 0, null));
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
            $disease = Disease::find($id);

            if (!is_null($disease)) {

                return view('admin.disease.edit', compact('disease'));
            } else {
                event(new NewLogCreated('لم يتم العثور على  المرض بنجاح برقم : ', $id, 20, 0, null));
                return redirect('admin/diseases')->with('error', 'لم يتم العثور على  المرض بنجاح');
            }

        } else {
            event(new NewLogCreated('لم يتم العثور على  المرض بنجاح برقم : ', $id, 20, 0, null));
            return redirect('admin/diseases')->with('error', 'لم يتم العثور على  المرض بنجاح');
        }
    }


    /**
     * @param DiseaseRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(DiseaseRequest $request, $id)
    {
        $message = null;

        if (!is_null($id)) {
            $disease = Disease::find($id);

            if (!is_null($disease)) {

                $request['updated_by'] = Auth::user()->id;
                if ($disease->update($request->all())) {
                    $message = 'تم تحديث المرض بنجاح';

                    event(new NewLogCreated($message, $request['name'], 20, 1, url('admin/diseases/' . $disease->id . '/edit')));
                    return redirect('admin/diseases')->with('success', $message);

                } else {
                    $message = 'لم يتم تحديث المرض بنجاح';

                    event(new NewLogCreated($message, $request['name'], 20, 0, null));
                    return redirect('admin/diseases')->with('error', $message);
                }
            } else {
                event(new NewLogCreated('لم يتم العثور على المرض بنجاح برقم : ', $id, 20, 0, null));
                return redirect('admin/diseases')->with('error', 'لم يتم العثور على المرض بنجاح');
            }

        } else {
            event(new NewLogCreated('لم يتم العثور على المرض بنجاح برقم : ', $id, 20, 0, null));
            return redirect('admin/diseases')->with('error', 'لم يتم العثور على المرض بنجاح');
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function delete($id)
    {
        if (!is_null($id)) {
            $disease = Disease::find($id);

            if (!is_null($disease)) {
                $name = $disease->name;

                if ((($disease->family_disease)->isEmpty())) {
                    if ($disease->delete()) {
                        event(new NewLogCreated('تم حذف المرض بنجاح ', $name, 21, 0, null));
                        return redirect('admin/diseases')->with('success', 'تم حذف المرض بنجاح');
                    }
                    event(new NewLogCreated('لم يتم حذف المرض بنجاح  ', $name, 21, 0, null));
                    return redirect('admin/diseases')->with('error', 'لم يتم حذف المرض بنجاح  ');
                } else {
                    event(new NewLogCreated('لم يتم حذف المرض بنجاح لوجود عناصر مرتبطة بها ', $name, 21, 0, null));
                    return redirect('admin/diseases')->with('error', 'لم يتم حذف المرض بنجاح لوجود عناصر مرتبطة بها ');
                }
            } else {
                event(new NewLogCreated('لم يتم العثور على  المرض بنجاح برقم : ', $id, 21, 0, null));
                return redirect('admin/diseases')->with('error', 'لم يتم العثور على  المرض بنجاح');
            }
        } else {
            event(new NewLogCreated('لم يتم العثور على المرض بنجاح برقم : ', $id, 21, 0, null));
            return redirect('admin/diseases')->with('error', 'لم يتم العثور على  المرض بنجاح');
        }
    }
}
