<?php

namespace App\Http\Controllers\admin;

use App\Events\NewLogCreated;
use App\FamilyType;
use App\Http\Requests\FamilyTypeRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class FamilyTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $familyTypes = FamilyType::all();
        return view('admin.familyType.list', compact('familyTypes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.familyType.create');
    }

    /**
     * @param FamilyTypeRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(FamilyTypeRequest $request)
    {
        $message = null;

        $item = FamilyType::where('name', '=', $request['name'])->first();

        if (is_null($item)) {
            $request['created_by'] = Auth::user()->id;
            if ($familyType = FamilyType::create($request->all())) {
                $message = 'تم إضافةتصنيف الحالة بنجاح';

                event(new NewLogCreated($message, $request['name'], 92, 1, url('admin/familyTypes/' . $familyType->id . '/edit')));
                return back()->with('success', $message);

            } else {

                $message = 'لم يتم إضافةتصنيف الحالة بنجاح';

                event(new NewLogCreated($message, $request['name'], 92, 0, null));
                return back()->with('error', $message);
            }
        } else {

            $message = 'لم يتم إضافةتصنيف الحالة بنجاح لتكرار البيانات';

            event(new NewLogCreated($message, $request['name'], 92, 0, null));
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
            $familyType = FamilyType::find($id);

            if (!is_null($familyType)) {

                return view('admin.familyType.edit', compact('familyType'));
            } else {
                event(new NewLogCreated('لم يتم العثور على تصنيف الحالة بنجاح برقم : ', $id, 93, 0, null));
                return redirect('admin/familyTypes')->with('error', 'لم يتم العثور على تصنيف الحالة بنجاح');
            }

        } else {
            event(new NewLogCreated('لم يتم العثور على تصنيف الحالة بنجاح برقم : ', $id, 93, 0, null));
            return redirect('admin/familyTypes')->with('error', 'لم يتم العثور على تصنيف الحالة بنجاح');
        }
    }

    /**
     * @param FamilyTypeRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(FamilyTypeRequest $request, $id)
    {
        $message = null;

        if (!is_null($id)) {
            $familyType = FamilyType::find($id);

            if (!is_null($familyType)) {

                $request['updated_by'] = Auth::user()->id;
                if ($familyType->update($request->all())) {
                    $message = 'تم تحديث تصنيف الحالة بنجاح';

                    event(new NewLogCreated($message, $request['name'], 93, 1, url('admin/familyTypes/' . $familyType->id . '/edit')));
                    return redirect('admin/familyTypes')->with('success', $message);

                } else {
                    $message = 'لم يتم تحديث تصنيف الحالة بنجاح';

                    event(new NewLogCreated($message, $request['name'], 93, 0, null));
                    return redirect('admin/familyTypes')->with('error', $message);
                }
            } else {
                event(new NewLogCreated('لم يتم العثور على تصنيف الحالة بنجاح برقم : ', $id, 93, 0, null));
                return redirect('admin/familyTypes')->with('error', 'لم يتم العثور على تصنيف الحالة بنجاح');
            }

        } else {
            event(new NewLogCreated('لم يتم العثور على تصنيف الحالة بنجاح برقم : ', $id, 93, 0, null));
            return redirect('admin/familyTypes')->with('error', 'لم يتم العثور على تصنيف الحالة بنجاح');
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function delete($id)
    {
        if (!is_null($id)) {
            $familyType = FamilyType::find($id);

            if (!is_null($familyType)) {
                $name = $familyType->name;

                if ((($familyType->family)->isEmpty())) {
                    if ($familyType->delete()) {
                        event(new NewLogCreated('تم حذف تصنيف الحالة بنجاح ', $name, 94, 0, null));
                        return redirect('admin/familyTypes')->with('success', 'تم حذف تصنيف الحالة بنجاح');
                    }
                    event(new NewLogCreated('لم يتم حذف تصنيف الحالة بنجاح  ', $name, 94, 0, null));
                    return redirect('admin/familyTypes')->with('error', 'لم يتم حذف تصنيف الحالة بنجاح  ');
                } else {
                    event(new NewLogCreated('لم يتم حذف تصنيف الحالة بنجاح لوجود عناصر مرتبطة بها ', $name, 94, 0, null));
                    return redirect('admin/familyTypes')->with('error', 'لم يتم حذف تصنيف الحالة بنجاح لوجود عناصر مرتبطة بها ');
                }
            } else {
                event(new NewLogCreated('لم يتم العثور على تصنيف الحالة بنجاح برقم : ', $id, 94, 0, null));
                return redirect('admin/familyTypes')->with('error', 'لم يتم العثور على تصنيف الحالة بنجاح');
            }

        } else {
            event(new NewLogCreated('لم يتم العثور على تصنيف الحالة بنجاح برقم : ', $id, 94, 0, null));
            return redirect('admin/familyTypes')->with('error', 'لم يتم العثور على تصنيف الحالة بنجاح');
        }
    }
}
