<?php

namespace App\Http\Controllers\Admin;

use App\Events\NewLogCreated;
use App\HouseStatus;
use App\Http\Requests\HouseStatusRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

/**
 * Class HouseStatusController
 * @package App\Http\Controllers\Admin
 */
class HouseStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $houseStatuses = HouseStatus::all();
        return view('admin.houseStatus.list', compact('houseStatuses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.houseStatus.create');
    }
    
    /**
     * @param HouseStatusRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(HouseStatusRequest $request)
    {
        $message = null;

        $item = HouseStatus::where('name', '=', $request['name'])->first();

        if(is_null($item)) {
        $request['created_by'] = Auth::user()->id;
        if ($houseStatus = HouseStatus::create($request->all())) {
            $message = 'تم إضافة وضع السكن بنجاح';

            event(new NewLogCreated($message, $request['name'], 40, 1, url('admin/houseStatuses/' . $houseStatus->id . '/edit')));
            return back()->with('success', $message);

        } else {

            $message = 'لم يتم إضافة وضع السكن بنجاح';

            event(new NewLogCreated($message, $request['name'], 40, 0, null));
            return back()->with('error', $message);
        }  } else {

            $message = 'لم يتم إضافة وضع السكن بنجاح لتكرار البيانات';

            event(new NewLogCreated($message, $request['name'], 40, 0, null));
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
            $houseStatus = HouseStatus::find($id);

            if (!is_null($houseStatus)) {

                return view('admin.houseStatus.edit', compact('houseStatus'));
            } else {
                event(new NewLogCreated('لم يتم العثور على  وضع السكن بنجاح برقم : ', $id, 41, 0, null));
                return redirect('admin/houseStatuses')->with('error', 'لم يتم العثور على  وضع السكن بنجاح');
            }

        } else {
            event(new NewLogCreated('لم يتم العثور على  وضع السكن بنجاح برقم : ', $id, 41, 0, null));
            return redirect('admin/houseStatuses')->with('error', 'لم يتم العثور على  وضع السكن بنجاح');
        }
    }

  
    public function update(HouseStatusRequest $request, $id)
    {
        $message = null;

        if (!is_null($id)) {
            $houseStatus = HouseStatus::find($id);

            if (!is_null($houseStatus)) {

                $request['updated_by'] = Auth::user()->id;
                if ($houseStatus->update($request->all())) {
                    $message = 'تم تحديث وضع السكن بنجاح';

                    event(new NewLogCreated($message, $request['name'], 41, 1, url('admin/houseStatuses/' . $houseStatus->id . '/edit')));
                    return redirect('admin/houseStatuses')->with('success', $message);

                } else {
                    $message = 'لم يتم تحديث وضع السكن بنجاح';

                    event(new NewLogCreated($message, $request['name'], 41, 0, null));
                    return redirect('admin/houseStatuses')->with('error', $message);
                }
            } else {
                event(new NewLogCreated('لم يتم العثور على  وضع السكن بنجاح برقم : ', $id, 41, 0, null));
                return redirect('admin/houseStatuses')->with('error', 'لم يتم العثور على  وضع السكن بنجاح');
            }

        } else {
            event(new NewLogCreated('لم يتم العثور على  وضع السكن بنجاح برقم : ', $id, 41, 0, null));
            return redirect('admin/houseStatuses')->with('error', 'لم يتم العثور على  وضع السكن بنجاح');
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function delete($id)
    {
        if (!is_null($id)) {
            $houseStatus = HouseStatus::find($id);

            if (!is_null($houseStatus)) {
                $name = $houseStatus->name;

                if ((($houseStatus->family)->isEmpty())) {
                    if ($houseStatus->delete()) {
                        event(new NewLogCreated('تم حذف وضع السكن بنجاح ', $name, 42, 0, null));
                        return redirect('admin/houseStatuses')->with('success', 'تم حذف وضع السكن بنجاح');
                    }
                    event(new NewLogCreated('لم يتم حذف وضع السكن بنجاح  ', $name, 42, 0, null));
                    return redirect('admin/houseStatuses')->with('error', 'لم يتم حذف وضع السكن بنجاح  ');
                } else {
                    event(new NewLogCreated('لم يتم حذف وضع السكن بنجاح لوجود عناصر مرتبطة بها ', $name, 42, 0, null));
                    return redirect('admin/houseStatuses')->with('error', 'لم يتم حذف وضع السكن بنجاح لوجود عناصر مرتبطة بها ');
                }
            } else {
                event(new NewLogCreated('لم يتم العثور على  وضع السكن بنجاح برقم : ', $id, 42, 0, null));
                return redirect('admin/houseStatuses')->with('error', 'لم يتم العثور على  وضع السكن بنجاح');
            }

        } else {
            event(new NewLogCreated('لم يتم العثور على  وضع السكن بنجاح برقم : ', $id, 42, 0, null));
            return redirect('admin/houseStatuses')->with('error', 'لم يتم العثور على  وضع السكن بنجاح');
        }
    }
}
