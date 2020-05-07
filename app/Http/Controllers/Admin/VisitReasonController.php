<?php

namespace App\Http\Controllers\Admin;

use App\Events\NewLogCreated;
use App\Http\Requests\VisitReasonRequest;
use App\VisitReason;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

/**
 * Class VisitReasonController
 * @package App\Http\Controllers\Admin
 */
class VisitReasonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $visitReasons = VisitReason::all();
        return view('admin.visitReason.list', compact('visitReasons'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.visitReason.create');
    }


    /**
     * @param VisitReasonRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(VisitReasonRequest $request)
    {
        $message = null;

        $item = VisitReason::where('name', '=', $request['name'])->first();

        if (is_null($item)) {
            $request['created_by'] = Auth::user()->id;
            $request['status'] = 1;

            if ($visitReason = VisitReason::create($request->all())) {
                $message = 'تم إضافة سبب  الزيارة بنجاح';

                event(new NewLogCreated($message, $request['name'], 60, 1, url('admin/visitReasons/' . $visitReason->id . '/edit')));
                return back()->with('success', $message);

            } else {

                $message = 'لم يتم إضافة سبب  الزيارة بنجاح';

                event(new NewLogCreated($message, $request['name'], 60, 0, null));
                return back()->with('error', $message);
            }
        } else {

            $message = 'لم يتم إضافة سبب  الزيارة بنجاح لتكرار البيانات';

            event(new NewLogCreated($message, $request['name'], 60, 0, null));
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
            $visitReason = VisitReason::find($id);

            if (!is_null($visitReason)) {

                return view('admin.visitReason.edit', compact('visitReason'));
            } else {
                event(new NewLogCreated('لم يتم العثور  على  سبب  الزيارة بنجاح برقم : ', $id, 61, 0, null));
                return redirect('admin/visitReasons')->with('error', 'لم يتم العثور  على  سبب  الزيارة بنجاح');
            }

        } else {
            event(new NewLogCreated('لم يتم العثور  على  سبب  الزيارة بنجاح برقم : ', $id, 61, 0, null));
            return redirect('admin/visitReasons')->with('error', 'لم يتم العثور  على  سبب  الزيارة بنجاح');
        }
    }

    public function update(VisitReasonRequest $request, $id)
    {
        $message = null;

        if (!is_null($id)) {
            $visitReason = VisitReason::find($id);

            if (!is_null($visitReason)) {

                $request['updated_by'] = Auth::user()->id;
                if ($visitReason->update($request->all())) {
                    $message = 'تم تحديث سبب  الزيارة بنجاح';

                    event(new NewLogCreated($message, $request['name'], 61, 1, url('admin/visitReasons/' . $visitReason->id . '/edit')));
                    return redirect('admin/visitReasons')->with('success', $message);

                } else {
                    $message = 'لم يتم تحديث سبب  الزيارة بنجاح';

                    event(new NewLogCreated($message, $request['name'], 61, 0, null));
                    return redirect('admin/visitReasons')->with('error', $message);
                }
            } else {
                event(new NewLogCreated('لم يتم العثور  على  سبب  الزيارة بنجاح برقم : ', $id, 61, 0, null));
                return redirect('admin/visitReasons')->with('error', 'لم يتم العثور  على  سبب  الزيارة بنجاح');
            }

        } else {
            event(new NewLogCreated('لم يتم العثور  على  سبب  الزيارة بنجاح برقم : ', $id, 61, 0, null));
            return redirect('admin/visitReasons')->with('error', 'لم يتم العثور  على  سبب  الزيارة بنجاح');
        }
    }


    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function delete($id)
    {
        if (!is_null($id)) {
            $visitReason = VisitReason::find($id);

            if (!is_null($visitReason)) {
                $name = $visitReason->name;

                if ((($visitReason->family)->isEmpty())) {
                    if ($visitReason->delete()) {
                        event(new NewLogCreated('تم حذف سبب  الزيارة بنجاح ', $name, 62, 0, null));
                        return redirect('admin/visitReasons')->with('success', 'تم حذف سبب  الزيارة بنجاح');
                    }
                    event(new NewLogCreated('لم يتم حذف سبب  الزيارة بنجاح  ', $name, 62, 0, null));
                    return redirect('admin/visitReasons')->with('error', 'لم يتم حذف سبب  الزيارة بنجاح  ');
                } else {
                    event(new NewLogCreated('لم يتم حذف سبب  الزيارة بنجاح لوجود عناصر مرتبطة بها ', $name, 62, 0, null));
                    return redirect('admin/visitReasons')->with('error', 'لم يتم حذف سبب  الزيارة بنجاح لوجود عناصر مرتبطة بها ');
                }
            } else {
                event(new NewLogCreated('لم يتم العثور  على  سبب  الزيارة بنجاح برقم : ', $id, 62, 0, null));
                return redirect('admin/visitReasons')->with('error', 'لم يتم العثور  على  سبب  الزيارة بنجاح');
            }

        } else {
            event(new NewLogCreated('لم يتم العثور  على  سبب  الزيارة بنجاح برقم : ', $id, 62, 0, null));
            return redirect('admin/visitReasons')->with('error', 'لم يتم العثور  على  سبب  الزيارة بنجاح');
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function approve($id)
    {

        if (!is_null($id)) {
            $visitReason = VisitReason::find($id);

            if (!is_null($visitReason)) {
                if ($visitReason->update(['status' => 1])) {
                    $message = 'تم قبول سبب  الزيارة بنجاح';

                    event(new NewLogCreated($message, $visitReason->name, 63, 1, url('admin/visitReasons/' . $visitReason->id . '/edit')));
                    return redirect('admin/visitReasons')->with('success', $message);

                } else {
                    $message = 'لم يتم قبول سبب  الزيارة بنجاح';

                    event(new NewLogCreated($message, $visitReason->name, 63, 1, url('admin/visitReasons/' . $visitReason->id . '/edit')));
                    return redirect('admin/visitReasons')->with('error', $message);
                }

            } else {
                event(new NewLogCreated('لم يتم العثور  على سبب  الزيارة بنجاح برقم : ', $id, 63, 0, null));
                return redirect('admin/visitReasons')->with('error', 'لم يتم العثور  على  سبب  الزيارة بنجاح');
            }
        } else {
            event(new NewLogCreated('لم يتم العثور  على  سبب  الزيارة بنجاح برقم : ', $id, 63, 0, null));
            return redirect('admin/visitReasons')->with('error', 'لم يتم العثور  على  سبب  الزيارة بنجاح');
        }
    }

}

