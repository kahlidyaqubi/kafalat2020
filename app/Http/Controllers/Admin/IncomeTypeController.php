<?php

namespace App\Http\Controllers\Admin;

use App\Events\NewLogCreated;
use App\Http\Requests\IncomeTypeRequest;
use App\IncomeType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

/**
 * Class IncomeTypeController
 * @package App\Http\Controllers\Admin
 */
class IncomeTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $incomeTypes = IncomeType::all();
        return view('admin.incomeType.list', compact('incomeTypes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.incomeType.create');
    }
    
    public function store(IncomeTypeRequest $request)
    {
        $message = null;

        $item = IncomeType::where('name', '=', $request['name'])->first();

        if(is_null($item)) {
        $request['created_by'] = Auth::user()->id;
        $request['status'] = 1;

        if ($incomeType = IncomeType::create($request->all())) {
            $message = 'تم إضافة جهات الدخل بنجاح';

            event(new NewLogCreated($message, $request['name'], 43, 1, url('admin/incomeTypes/' . $incomeType->id . '/edit')));
            return back()->with('success', $message);

        } else {

            $message = 'لم يتم إضافة جهات الدخل بنجاح';

            event(new NewLogCreated($message, $request['name'], 43, 0, null));
            return back()->with('error', $message);
        }  } else {

            $message = 'لم يتم إضافة جهات الدخل بنجاح لتكرار البيانات';

            event(new NewLogCreated($message, $request['name'], 43, 0, null));
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
            $incomeType = IncomeType::find($id);

            if (!is_null($incomeType)) {

                return view('admin.incomeType.edit', compact('incomeType'));
            } else {
                event(new NewLogCreated('لم يتم العثور على  جهات الدخل بنجاح برقم : ', $id, 44, 0, null));
                return redirect('admin/incomeTypes')->with('error', 'لم يتم العثور على  جهات الدخل بنجاح');
            }

        } else {
            event(new NewLogCreated('لم يتم العثور على  جهات الدخل بنجاح برقم : ', $id, 44, 0, null));
            return redirect('admin/incomeTypes')->with('error', 'لم يتم العثور على  جهات الدخل بنجاح');
        }
    }


    public function update(IncomeTypeRequest $request, $id)
    {
        $message = null;

        if (!is_null($id)) {
            $incomeType = IncomeType::find($id);

            if (!is_null($incomeType)) {

                $request['updated_by'] = Auth::user()->id;
                if ($incomeType->update($request->all())) {
                    $message = 'تم تحديث جهات الدخل بنجاح';

                    event(new NewLogCreated($message, $request['name'], 44, 1, url('admin/incomeTypes/' . $incomeType->id . '/edit')));
                    return redirect('admin/incomeTypes')->with('success', $message);

                } else {
                    $message = 'لم يتم تحديث جهات الدخل بنجاح';

                    event(new NewLogCreated($message, $request['name'], 44, 0, null));
                    return redirect('admin/incomeTypes')->with('error', $message);
                }
            } else {
                event(new NewLogCreated('لم يتم العثور على  جهات الدخل بنجاح برقم : ', $id, 44, 0, null));
                return redirect('admin/incomeTypes')->with('error', 'لم يتم العثور على  جهات الدخل بنجاح');
            }

        } else {
            event(new NewLogCreated('لم يتم العثور على  جهات الدخل بنجاح برقم : ', $id, 44, 0, null));
            return redirect('admin/incomeTypes')->with('error', 'لم يتم العثور على  جهات الدخل بنجاح');
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function delete($id)
    {
        if (!is_null($id)) {
            $incomeType = IncomeType::find($id);

            if (!is_null($incomeType)) {
                $name = $incomeType->name;

                if ((($incomeType->family_income)->isEmpty())) {
                    if ($incomeType->delete()) {
                        event(new NewLogCreated('تم حذف جهات الدخل بنجاح ', $name, 45, 0, null));
                        return redirect('admin/incomeTypes')->with('success', 'تم حذف جهات الدخل بنجاح');
                    }
                    event(new NewLogCreated('لم يتم حذف جهات الدخل بنجاح  ', $name, 45, 0, null));
                    return redirect('admin/incomeTypes')->with('error', 'لم يتم حذف جهات الدخل بنجاح  ');
                } else {
                    event(new NewLogCreated('لم يتم حذف جهات الدخل بنجاح لوجود عناصر مرتبطة بها ', $name, 45, 0, null));
                    return redirect('admin/incomeTypes')->with('error', 'لم يتم حذف جهات الدخل بنجاح لوجود عناصر مرتبطة بها ');
                }
            } else {
                event(new NewLogCreated('لم يتم العثور على  جهات الدخل بنجاح برقم : ', $id, 45, 0, null));
                return redirect('admin/incomeTypes')->with('error', 'لم يتم العثور على  جهات الدخل بنجاح');
            }

        } else {
            event(new NewLogCreated('لم يتم العثور على  جهات الدخل بنجاح برقم : ', $id, 45, 0, null));
            return redirect('admin/incomeTypes')->with('error', 'لم يتم العثور على  جهات الدخل بنجاح');
        }
    }
}
