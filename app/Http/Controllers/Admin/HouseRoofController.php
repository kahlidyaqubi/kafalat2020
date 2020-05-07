<?php

namespace App\Http\Controllers\Admin;

use App\Events\NewLogCreated;
use App\HouseRoof;
use App\Http\Requests\HouseRoofRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

/**
 * Class HouseRoofController
 * @package App\Http\Controllers\Admin
 */
class HouseRoofController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $houseRoofs = HouseRoof::all();
        return view('admin.houseRoof.list', compact('houseRoofs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.houseRoof.create');
    }

    /**
     * @param HouseRoofRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(HouseRoofRequest $request)
    {
        $message = null;

        $item = HouseRoof::where('name', '=', $request['name'])->first();

        if(is_null($item)) {
        $request['created_by'] = Auth::user()->id;
        if ($houseRoof = HouseRoof::create($request->all())) {
            $message = 'تم إضافة نوع السكن بنجاح';

            event(new NewLogCreated($message, $request['name'], 37, 1, url('admin/houseRoofs/' . $houseRoof->id . '/edit')));
            return back()->with('success', $message);

        } else {

            $message = 'لم يتم إضافة نوع السكن بنجاح';

            event(new NewLogCreated($message, $request['name'], 37, 0, null));
            return back()->with('error', $message);
        }  } else {

            $message = 'لم يتم إضافة نوع السكن بنجاح لتكرار البيانات';

            event(new NewLogCreated($message, $request['name'], 37, 0, null));
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
            $houseRoof = HouseRoof::find($id);

            if (!is_null($houseRoof)) {

                return view('admin.houseRoof.edit', compact('houseRoof'));
            } else {
                event(new NewLogCreated('لم يتم العثور على  نوع السكن بنجاح برقم : ', $id, 38, 0, null));
                return redirect('admin/houseRoofs')->with('error', 'لم يتم العثور على  نوع السكن بنجاح');
            }

        } else {
            event(new NewLogCreated('لم يتم العثور على  نوع السكن بنجاح برقم : ', $id, 38, 0, null));
            return redirect('admin/houseRoofs')->with('error', 'لم يتم العثور على  نوع السكن بنجاح');
        }
    }

    /**
     * @param HouseRoofRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(HouseRoofRequest $request, $id)
    {
        $message = null;

        if (!is_null($id)) {
            $houseRoof = HouseRoof::find($id);

            if (!is_null($houseRoof)) {

                $request['updated_by'] = Auth::user()->id;
                if ($houseRoof->update($request->all())) {
                    $message = 'تم تحديث نوع السكن بنجاح';

                    event(new NewLogCreated($message, $request['name'], 38, 1, url('admin/houseRoofs/' . $houseRoof->id . '/edit')));
                    return redirect('admin/houseRoofs')->with('success', $message);

                } else {
                    $message = 'لم يتم تحديث نوع السكن بنجاح';

                    event(new NewLogCreated($message, $request['name'], 38, 0, null));
                    return redirect('admin/houseRoofs')->with('error', $message);
                }
            } else {
                event(new NewLogCreated('لم يتم العثور على  نوع السكن بنجاح برقم : ', $id, 38, 0, null));
                return redirect('admin/houseRoofs')->with('error', 'لم يتم العثور على  نوع السكن بنجاح');
            }

        } else {
            event(new NewLogCreated('لم يتم العثور على  نوع السكن بنجاح برقم : ', $id, 38, 0, null));
            return redirect('admin/houseRoofs')->with('error', 'لم يتم العثور على  نوع السكن بنجاح');
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function delete($id)
    {
        if (!is_null($id)) {
            $houseRoof = HouseRoof::find($id);

            if (!is_null($houseRoof)) {
                $name = $houseRoof->name;

                if ((($houseRoof->family)->isEmpty())) {
                    if ($houseRoof->delete()) {
                        event(new NewLogCreated('تم حذف نوع السكن بنجاح ', $name, 39, 0, null));
                        return redirect('admin/houseRoofs')->with('success', 'تم حذف نوع السكن بنجاح');
                    }
                    event(new NewLogCreated('لم يتم حذف نوع السكن بنجاح  ', $name, 39, 0, null));
                    return redirect('admin/houseRoofs')->with('error', 'لم يتم حذف نوع السكن بنجاح  ');
                } else {
                    event(new NewLogCreated('لم يتم حذف نوع السكن بنجاح لوجود عناصر مرتبطة بها ', $name, 39, 0, null));
                    return redirect('admin/houseRoofs')->with('error', 'لم يتم حذف نوع السكن بنجاح لوجود عناصر مرتبطة بها ');
                }
            } else {
                event(new NewLogCreated('لم يتم العثور على  نوع السكن بنجاح برقم : ', $id, 39, 0, null));
                return redirect('admin/houseRoofs')->with('error', 'لم يتم العثور على  نوع السكن بنجاح');
            }

        } else {
            event(new NewLogCreated('لم يتم العثور على  نوع السكن بنجاح برقم : ', $id, 39, 0, null));
            return redirect('admin/houseRoofs')->with('error', 'لم يتم العثور على  نوع السكن بنجاح');
        }
    }
}
