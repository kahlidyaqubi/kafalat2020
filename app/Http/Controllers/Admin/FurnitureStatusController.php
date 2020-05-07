<?php

namespace App\Http\Controllers\admin;

use App\Events\NewLogCreated;
use App\FurnitureStatus;
use App\Http\Requests\FurnitureStatusesRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class FurnitureStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $furnitureStatuses = FurnitureStatus::all();
        return view('admin.furnitureStatus.list', compact('furnitureStatuses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.furnitureStatus.create');
    }

    /**
     * @param FurnitureStatusesRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(FurnitureStatusesRequest $request)
    {
        $message = null;

        $item = FurnitureStatus::where('name', '=', $request['name'])->first();

        if (is_null($item)) {
            $request['created_by'] = Auth::user()->id;
            if ($furnitureStatus = FurnitureStatus::create($request->all())) {
                $message = 'تم إضافةوضع الأثاث  بنجاح';

                event(new NewLogCreated($message, $request['name'], 127, 1, url('admin/furnitureStatuses/' . $furnitureStatus->id . '/edit')));
                return back()->with('success', $message);

            } else {

                $message = 'لم يتم إضافةوضع الأثاث  بنجاح';

                event(new NewLogCreated($message, $request['name'], 127, 0, null));
                return back()->with('error', $message);
            }
        } else {

            $message = 'لم يتم إضافةوضع الأثاث  بنجاح لتكرار البيانات';

            event(new NewLogCreated($message, $request['name'], 127, 0, null));
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
            $furnitureStatus = FurnitureStatus::find($id);

            if (!is_null($furnitureStatus)) {

                return view('admin.furnitureStatus.edit', compact('furnitureStatus'));
            } else {
                event(new NewLogCreated('لم يتم العثور على وضع الأثاث  بنجاح برقم : ', $id, 128, 0, null));
                return redirect('admin/furnitureStatuses')->with('error', 'لم يتم العثور على وضع الأثاث  بنجاح');
            }

        } else {
            event(new NewLogCreated('لم يتم العثور على وضع الأثاث  بنجاح برقم : ', $id, 128, 0, null));
            return redirect('admin/furnitureStatuses')->with('error', 'لم يتم العثور على وضع الأثاث  بنجاح');
        }
    }

    /**
     * @param FurnitureStatusesRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(FurnitureStatusesRequest $request, $id)
    {
        $message = null;

        if (!is_null($id)) {
            $furnitureStatus = FurnitureStatus::find($id);

            if (!is_null($furnitureStatus)) {

                $request['updated_by'] = Auth::user()->id;
                if ($furnitureStatus->update($request->all())) {
                    $message = 'تم تحديث وضع الأثاث  بنجاح';

                    event(new NewLogCreated($message, $request['name'], 129, 1, url('admin/furnitureStatuses/' . $furnitureStatus->id . '/edit')));
                    return redirect('admin/furnitureStatuses')->with('success', $message);

                } else {
                    $message = 'لم يتم تحديث وضع الأثاث  بنجاح';

                    event(new NewLogCreated($message, $request['name'], 129, 0, null));
                    return redirect('admin/furnitureStatuses')->with('error', $message);
                }
            } else {
                event(new NewLogCreated('لم يتم العثور على وضع الأثاث  بنجاح برقم : ', $id, 129, 0, null));
                return redirect('admin/furnitureStatuses')->with('error', 'لم يتم العثور على وضع الأثاث  بنجاح');
            }

        } else {
            event(new NewLogCreated('لم يتم العثور على وضع الأثاث  بنجاح برقم : ', $id, 129, 0, null));
            return redirect('admin/furnitureStatuses')->with('error', 'لم يتم العثور على وضع الأثاث  بنجاح');
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function delete($id)
    {
        if (!is_null($id)) {
            $furnitureStatus = FurnitureStatus::find($id);

            if (!is_null($furnitureStatus)) {
                $name = $furnitureStatus->name;

                if ((($furnitureStatus->family)->isEmpty())) {
                    if ($furnitureStatus->delete()) {
                        event(new NewLogCreated('تم حذف وضع الأثاث  بنجاح ', $name, 129, 0, null));
                        return redirect('admin/furnitureStatuses')->with('success', 'تم حذف وضع الأثاث  بنجاح');
                    }
                    event(new NewLogCreated('لم يتم حذف وضع الأثاث  بنجاح  ', $name, 129, 0, null));
                    return redirect('admin/furnitureStatuses')->with('error', 'لم يتم حذف وضع الأثاث  بنجاح  ');
                } else {
                    event(new NewLogCreated('لم يتم حذف وضع الأثاث  بنجاح لوجود عناصر مرتبطة بها ', $name, 129, 0, null));
                    return redirect('admin/furnitureStatuses')->with('error', 'لم يتم حذف وضع الأثاث  بنجاح لوجود عناصر مرتبطة بها ');
                }
            } else {
                event(new NewLogCreated('لم يتم العثور على وضع الأثاث  بنجاح برقم : ', $id, 129, 0, null));
                return redirect('admin/furnitureStatuses')->with('error', 'لم يتم العثور على وضع الأثاث  بنجاح');
            }

        } else {
            event(new NewLogCreated('لم يتم العثور على وضع الأثاث  بنجاح برقم : ', $id, 129, 0, null));
            return redirect('admin/furnitureStatuses')->with('error', 'لم يتم العثور على وضع الأثاث  بنجاح');
        }
    }
}
