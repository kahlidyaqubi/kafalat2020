<?php

namespace App\Http\Controllers\admin;

use App\Events\NewLogCreated;
use App\Http\Requests\SocialStatusRequest;
use App\SocialStatus;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SocialStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $socialStatuses = SocialStatus::all();
        return view('admin.socialStatus.list', compact('socialStatuses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.socialStatus.create');
    }

    /**
     * @param SocialStatusRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(SocialStatusRequest $request)
    {
        $message = null;

        $item = SocialStatus::where('name', '=', $request['name'])->first();

        if(is_null($item)) {
            $request['created_by'] = Auth::user()->id;

            if ($socialStatus = SocialStatus::create($request->all())) {
                $message = 'تم إضافة الحالة الاجتماعية بنجاح';

                event(new NewLogCreated($message, $request['name'], 103, 1, url('admin/socialStatuses/' . $socialStatus->id . '/edit')));
                return back()->with('success', $message);

            } else {

                $message = 'لم يتم إضافة الحالة الاجتماعية بنجاح';

                event(new NewLogCreated($message, $request['name'], 103, 0, null));
                return back()->with('error', $message);
            }   } else {

            $message = 'لم يتم إضافة الحالة الاجتماعية بنجاح لتكرار البيانات ';

            event(new NewLogCreated($message, $request['name'], 103, 0, null));
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
            $socialStatus = SocialStatus::find($id);

            if (!is_null($socialStatus)) {

                return view('admin.socialStatus.edit', compact('socialStatus'));
            } else {
                event(new NewLogCreated('لم يتم العثور على  الحالة الاجتماعية بنجاح برقم : ', $id, 104, 0, null));
                return redirect('admin/socialStatuses')->with('error', 'لم يتم العثور على  الحالة الاجتماعية بنجاح');
            }

        } else {
            event(new NewLogCreated('لم يتم العثور على  الحالة الاجتماعية بنجاح برقم : ', $id, 104, 0, null));
            return redirect('admin/socialStatuses')->with('error', 'لم يتم العثور على  الحالة الاجتماعية بنجاح');
        }
    }

    /**
     * @param SocialStatusRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(SocialStatusRequest $request, $id)
    {
        $message = null;

        if (!is_null($id)) {
            $socialStatus = SocialStatus::find($id);

            if (!is_null($socialStatus)) {

                $request['updated_by'] = Auth::user()->id;
                if ($socialStatus->update($request->all())) {
                    $message = 'تم تحديث الحالة الاجتماعية بنجاح';

                    event(new NewLogCreated($message, $request['name'], 104, 1, url('admin/socialStatuses/' . $socialStatus->id . '/edit')));
                    return redirect('admin/socialStatuses')->with('success', $message);

                } else {
                    $message = 'لم يتم تحديث الحالة الاجتماعية بنجاح';

                    event(new NewLogCreated($message, $request['name'], 104, 0, null));
                    return redirect('admin/socialStatuses')->with('error', $message);
                }
            } else {
                event(new NewLogCreated('لم يتم العثور على  الحالة الاجتماعية بنجاح برقم : ', $id, 104, 0, null));
                return redirect('admin/socialStatuses')->with('error', 'لم يتم العثور على  الحالة الاجتماعية بنجاح');
            }

        } else {
            event(new NewLogCreated('لم يتم العثور على  الحالة الاجتماعية بنجاح برقم : ', $id, 104, 0, null));
            return redirect('admin/socialStatuses')->with('error', 'لم يتم العثور على  الحالة الاجتماعية بنجاح');
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function delete($id)
    {
        if (!is_null($id)) {
            $socialStatus = SocialStatus::find($id);

            if (!is_null($socialStatus)) {
                $name = $socialStatus->name;

                if ((($socialStatus->users)->isEmpty()) && (($socialStatus->person)->isEmpty())) {
                    if ($socialStatus->delete()) {
                        event(new NewLogCreated('تم حذف  الحالة الاجتماعية بنجاح ', $name, 105, 0, null));
                        return redirect('admin/socialStatuses')->with('success', 'تم حذف  الحالة الاجتماعية بنجاح');
                    }
                    event(new NewLogCreated('لم يتم حذف  الحالة الاجتماعية بنجاح  ', $name, 105, 0, null));
                    return redirect('admin/socialStatuses')->with('error', 'لم يتم حذف  الحالة الاجتماعية بنجاح  ');
                } else {
                    event(new NewLogCreated('لم يتم حذف  الحالة الاجتماعية بنجاح لوجود عناصر مرتبطة بها ', $name, 105, 0, null));
                    return redirect('admin/socialStatuses')->with('error', 'لم يتم حذف  الحالة الاجتماعية بنجاح لوجود عناصر مرتبطة بها ');
                }
            } else {
                event(new NewLogCreated('لم يتم العثور على الحالة الاجتماعية بنجاح برقم : ', $id, 105, 0, null));
                return redirect('admin/socialStatuses')->with('error', 'لم يتم العثور على   الحالة الاجتماعية بنجاح');
            }

        } else {
            event(new NewLogCreated('لم يتم العثور على الحالة الاجتماعية بنجاح برقم : ', $id, 105, 0, null));
            return redirect('admin/socialStatuses')->with('error', 'لم يتم العثور على   الحالة الاجتماعية بنجاح');
        }
    }

}
