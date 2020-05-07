<?php

namespace App\Http\Controllers\Admin;

use App\Events\NewLogCreated;
use App\HouseOwnership;
use App\Http\Requests\HouseOwnershipRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

/**
 * Class HouseOwnershipController
 * @package App\Http\Controllers\Admin
 */
class HouseOwnershipController extends Controller
{

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $houseOwnerships = HouseOwnership::all();
        return view('admin.houseOwnership.list', compact('houseOwnerships'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('admin.houseOwnership.create');
    }

    /**
     * @param HouseOwnershipRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(HouseOwnershipRequest $request)
    {
        $message = null;

        $item = HouseOwnership::where('name', '=', $request['name'])->first();

        if(is_null($item)) {
        $request['created_by'] = Auth::user()->id;
        if ($houseOwnership = HouseOwnership::create($request->all())) {
            $message = 'تم إضافة ملكية السكن بنجاح';

            event(new NewLogCreated($message, $request['name'], 34, 1, url('admin/houseOwnerships/' . $houseOwnership->id . '/edit')));
            return back()->with('success', $message);

        } else {

            $message = 'لم يتم إضافة ملكية السكن بنجاح';

            event(new NewLogCreated($message, $request['name'], 34, 0, null));
            return back()->with('error', $message);
        } } else {

            $message = 'لم يتم إضافة ملكية السكن بنجاح لتكرار البيانات';

            event(new NewLogCreated($message, $request['name'], 34, 0, null));
            return back()->with('error', $message);
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function edit($id)
    {
        if (!is_null($id)) {
            $houseOwnership = HouseOwnership::find($id);

            if (!is_null($houseOwnership)) {

                return view('admin.houseOwnership.edit', compact('houseOwnership'));
            } else {
                event(new NewLogCreated('لم يتم العثور على  ملكية السكن بنجاح برقم : ', $id, 35, 0, null));
                return redirect('admin/houseOwnerships')->with('error', 'لم يتم العثور على  ملكية السكن بنجاح');
            }

        } else {
            event(new NewLogCreated('لم يتم العثور على  ملكية السكن بنجاح برقم : ', $id, 35, 0, null));
            return redirect('admin/houseOwnerships')->with('error', 'لم يتم العثور على  ملكية السكن بنجاح');
        }
    }

    /**
     * @param HouseOwnershipRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(HouseOwnershipRequest $request, $id)
    {
        $message = null;

        if (!is_null($id)) {
            $houseOwnership = HouseOwnership::find($id);

            if (!is_null($houseOwnership)) {

                $request['updated_by'] = Auth::user()->id;
                if ($houseOwnership->update($request->all())) {
                    $message = 'تم تحديث ملكية السكن بنجاح';

                    event(new NewLogCreated($message, $request['name'], 35, 1, url('admin/houseOwnerships/' . $houseOwnership->id . '/edit')));
                    return redirect('admin/houseOwnerships')->with('success', $message);

                } else {
                    $message = 'لم يتم تحديث ملكية السكن بنجاح';

                    event(new NewLogCreated($message, $request['name'], 35, 0, null));
                    return redirect('admin/houseOwnerships')->with('error', $message);
                }
            } else {
                event(new NewLogCreated('لم يتم العثور على  ملكية السكن بنجاح برقم : ', $id, 35, 0, null));
                return redirect('admin/houseOwnerships')->with('error', 'لم يتم العثور على  ملكية السكن بنجاح');
            }

        } else {
            event(new NewLogCreated('لم يتم العثور على  ملكية السكن بنجاح برقم : ', $id, 35, 0, null));
            return redirect('admin/houseOwnerships')->with('error', 'لم يتم العثور على  ملكية السكن بنجاح');
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function delete($id)
    {
        if (!is_null($id)) {
            $houseOwnership = HouseOwnership::find($id);

            if (!is_null($houseOwnership)) {
                $name = $houseOwnership->name;

                if ((($houseOwnership->family)->isEmpty())) {
                    if ($houseOwnership->delete()) {
                        event(new NewLogCreated('تم حذف ملكية السكن بنجاح ', $name, 36, 0, null));
                        return redirect('admin/houseOwnerships')->with('success', 'تم حذف ملكية السكن بنجاح');
                    }
                    event(new NewLogCreated('لم يتم حذف ملكية السكن بنجاح  ', $name, 36, 0, null));
                    return redirect('admin/houseOwnerships')->with('error', 'لم يتم حذف ملكية السكن بنجاح  ');
                } else {
                    event(new NewLogCreated('لم يتم حذف ملكية السكن بنجاح لوجود عناصر مرتبطة بها ', $name, 36, 0, null));
                    return redirect('admin/houseOwnerships')->with('error', 'لم يتم حذف ملكية السكن بنجاح لوجود عناصر مرتبطة بها ');
                }
            } else {
                event(new NewLogCreated('لم يتم العثور على  ملكية السكن بنجاح برقم : ', $id, 36, 0, null));
                return redirect('admin/houseOwnerships')->with('error', 'لم يتم العثور على  ملكية السكن بنجاح');
            }

        } else {
            event(new NewLogCreated('لم يتم العثور على  ملكية السكن بنجاح برقم : ', $id, 36, 0, null));
            return redirect('admin/houseOwnerships')->with('error', 'لم يتم العثور على  ملكية السكن بنجاح');
        }
    }
}
