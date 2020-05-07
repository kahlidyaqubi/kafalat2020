<?php

namespace App\Http\Controllers\admin;

use App\Events\NewLogCreated;
use App\FamilyStatus;
use App\Http\Requests\FamilyStatusRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class FamilyStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $familyStatuses = FamilyStatus::all();
        return view('admin.familyStatus.list', compact('familyStatuses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.familyStatus.create');
    }

    /**
     * @param FamilyStatusRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(FamilyStatusRequest $request)
    {
        $message = null;

        $item = FamilyStatus::where('name', '=', $request['name'])->first();

        if (is_null($item)) {
            $request['created_by'] = Auth::user()->id;
            if ($familyStatus = FamilyStatus::create($request->all())) {
                $message = 'تم إضافةوضع الحالة بنجاح';

                event(new NewLogCreated($message, $request['name'], 121, 1, url('admin/familyStatuses/' . $familyStatus->id . '/edit')));
                return back()->with('success', $message);

            } else {

                $message = 'لم يتم إضافةوضع الحالة بنجاح';

                event(new NewLogCreated($message, $request['name'], 121, 0, null));
                return back()->with('error', $message);
            }
        } else {

            $message = 'لم يتم إضافةوضع الحالة بنجاح لتكرار البيانات';

            event(new NewLogCreated($message, $request['name'], 121, 0, null));
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
            $familyStatus = FamilyStatus::find($id);

            if (!is_null($familyStatus)) {

                return view('admin.familyStatus.edit', compact('familyStatus'));
            } else {
                event(new NewLogCreated('لم يتم العثور على وضع الحالة بنجاح برقم : ', $id, 122, 0, null));
                return redirect('admin/familyStatuses')->with('error', 'لم يتم العثور على وضع الحالة بنجاح');
            }

        } else {
            event(new NewLogCreated('لم يتم العثور على وضع الحالة بنجاح برقم : ', $id, 122, 0, null));
            return redirect('admin/familyStatuses')->with('error', 'لم يتم العثور على وضع الحالة بنجاح');
        }
    }

    /**
     * @param FamilyStatusRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(FamilyStatusRequest $request, $id)
    {
        $message = null;

        if (!is_null($id)) {
            $familyStatus = FamilyStatus::find($id);

            if (!is_null($familyStatus)) {

                $request['updated_by'] = Auth::user()->id;
                if ($familyStatus->update($request->all())) {
                    $message = 'تم تحديث وضع الحالة بنجاح';

                    event(new NewLogCreated($message, $request['name'], 122, 1, url('admin/familyStatuses/' . $familyStatus->id . '/edit')));
                    return redirect('admin/familyStatuses')->with('success', $message);

                } else {
                    $message = 'لم يتم تخ وضع الحالة بنجاح';

                    event(new NewLogCreated($message, $request['name'], 122, 0, null));
                    return redirect('admin/familyStatuses')->with('error', $message);
                }
            } else {
                event(new NewLogCreated('لم يتم العثور على وضع الحالة بنجاح برقم : ', $id, 122, 0, null));
                return redirect('admin/familyStatuses')->with('error', 'لم يتم العثور على وضع الحالة بنجاح');
            }

        } else {
            event(new NewLogCreated('لم يتم العثور على وضع الحالة بنجاح برقم : ', $id, 122, 0, null));
            return redirect('admin/familyStatuses')->with('error', 'لم يتم العثور على وضع الحالة بنجاح');
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function delete($id)
    {
        if (!is_null($id)) {
            $familyStatus = FamilyStatus::find($id);

            if (!is_null($familyStatus)) {
                $name = $familyStatus->name;

                if ((($familyStatus->family)->isEmpty())) {
                    if ($familyStatus->delete()) {
                        event(new NewLogCreated('تم حذف وضع الحالة بنجاح ', $name, 123, 0, null));
                        return redirect('admin/familyStatuses')->with('success', 'تم حذف وضع الحالة بنجاح');
                    }
                    event(new NewLogCreated('لم يتم حذف وضع الحالة بنجاح  ', $name, 123, 0, null));
                    return redirect('admin/familyStatuses')->with('error', 'لم يتم حذف وضع الحالة بنجاح  ');
                } else {
                    event(new NewLogCreated('لم يتم حذف وضع الحالة بنجاح لوجود عناصر مرتبطة بها ', $name, 123, 0, null));
                    return redirect('admin/familyStatuses')->with('error', 'لم يتم حذف وضع الحالة بنجاح لوجود عناصر مرتبطة بها ');
                }
            } else {
                event(new NewLogCreated('لم يتم العثور على وضع الحالة بنجاح برقم : ', $id, 123, 0, null));
                return redirect('admin/familyStatuses')->with('error', 'لم يتم العثور على وضع الحالة بنجاح');
            }

        } else {
            event(new NewLogCreated('لم يتم العثور على وضع الحالة بنجاح برقم : ', $id, 123, 0, null));
            return redirect('admin/familyStatuses')->with('error', 'لم يتم العثور على وضع الحالة بنجاح');
        }
    }
}
