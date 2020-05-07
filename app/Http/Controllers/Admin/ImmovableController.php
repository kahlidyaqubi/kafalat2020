<?php

namespace App\Http\Controllers\Admin;

use App\Events\NewLogCreated;
use App\Http\Requests\ImmovableRequest;
use App\Immovable;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

/**
 * Class ImmovableController
 * @package App\Http\Controllers\Admin
 */
class ImmovableController extends Controller
{

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $immovables = immovable::all();
        return view('admin.immovable.list', compact('immovables'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('admin.immovable.create');
    }

    /**
     * @param ImmovableRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(ImmovableRequest $request)
    {
        $message = null;

        $item = Immovable::where('name', '=', $request['name'])->first();

        if(is_null($item)) {
        $request['created_by'] = Auth::user()->id;
        $request['status'] = 1;

        if ($immovable = Immovable::create($request->all())) {
            $message = 'تم إضافة صلة القرابة بنجاح';

            event(new NewLogCreated($message, $request['name'], 52, 1, url('admin/immovables/' . $Immovable->id . '/edit')));
            return back()->with('success', $message);

        } else {

            $message = 'لم يتم إضافة صلة القرابة بنجاح';

            event(new NewLogCreated($message, $request['name'], 52, 0, null));
            return back()->with('error', $message);
        }   } else {

            $message = 'لم يتم إضافة صلة القرابة بنجاح لتكرار البيانات';

            event(new NewLogCreated($message, $request['name'], 52, 0, null));
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
            $immovable = Immovable::find($id);

            if (!is_null($immovable)) {

                return view('admin.immovable.edit', compact('immovable'));
            } else {
                event(new NewLogCreated('لم يتم العثور على  صلة القرابة بنجاح برقم : ', $id, 53, 0, null));
                return redirect('admin/immovables')->with('error', 'لم يتم العثور على  صلة القرابة بنجاح');
            }

        } else {
            event(new NewLogCreated('لم يتم العثور على  صلة القرابة بنجاح برقم : ', $id, 53, 0, null));
            return redirect('admin/immovables')->with('error', 'لم يتم العثور على  صلة القرابة بنجاح');
        }
    }

    /**
     * @param ImmovableRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(ImmovableRequest $request, $id)
    {
        $message = null;

        if (!is_null($id)) {
            $immovable = Immovable::find($id);

            if (!is_null($immovable)) {

                $request['updated_by'] = Auth::user()->id;
                if ($immovable->update($request->all())) {
                    $message = 'تم تحديث صلة القرابة بنجاح';

                    event(new NewLogCreated($message, $request['name'], 53, 1, url('admin/immovables/' . $Immovable->id . '/edit')));
                    return redirect('admin/immovables')->with('success', $message);

                } else {
                    $message = 'لم يتم تحديث صلة القرابة بنجاح';

                    event(new NewLogCreated($message, $request['name'], 53, 0, null));
                    return redirect('admin/immovables')->with('error', $message);
                }
            } else {
                event(new NewLogCreated('لم يتم العثور على  صلة القرابة بنجاح برقم : ', $id, 53, 0, null));
                return redirect('admin/immovables')->with('error', 'لم يتم العثور على  صلة القرابة بنجاح');
            }

        } else {
            event(new NewLogCreated('لم يتم العثور على  صلة القرابة بنجاح برقم : ', $id, 53, 0, null));
            return redirect('admin/immovables')->with('error', 'لم يتم العثور على  صلة القرابة بنجاح');
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function delete($id)
    {
        if (!is_null($id)) {
            $immovable = Immovable::find($id);

            if (!is_null($immovable)) {
                $name = $immovable->name;

                if (($immovable->family)->isEmpty()) {
                    if ($immovable->delete()) {
                        event(new NewLogCreated('تم حذف صلة القرابة بنجاح ', $name, 54, 0, null));
                        return redirect('admin/immovables')->with('success', 'تم حذف صلة القرابة بنجاح');
                    }
                    event(new NewLogCreated('لم يتم حذف صلة القرابة بنجاح  ', $name, 54, 0, null));
                    return redirect('admin/immovables')->with('error', 'لم يتم حذف صلة القرابة بنجاح  ');
                } else {
                    event(new NewLogCreated('لم يتم حذف صلة القرابة بنجاح لوجود عناصر مرتبطة بها ', $name, 54, 0, null));
                    return redirect('admin/immovables')->with('error', 'لم يتم حذف صلة القرابة بنجاح لوجود عناصر مرتبطة بها ');
                }
            } else {
                event(new NewLogCreated('لم يتم العثور على  صلة القرابة بنجاح برقم : ', $id, 54, 0, null));
                return redirect('admin/immovables')->with('error', 'لم يتم العثور على  صلة القرابة بنجاح');
            }

        } else {
            event(new NewLogCreated('لم يتم العثور على  صلة القرابة بنجاح برقم : ', $id, 54, 0, null));
            return redirect('admin/immovables')->with('error', 'لم يتم العثور على  صلة القرابة بنجاح');
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function approve($id)
    {

        if (!is_null($id)) {
            $immovable = Immovable::find($id);

            if (!is_null($immovable)) {
                if ($immovable->update(['status' => 1])) {
                    $message = 'تم قبول صلة القرابة بنجاح';

                    event(new NewLogCreated($message, $immovable->name, 55, 1, url('admin/immovables/' . $immovable->id . '/edit')));
                    return redirect('admin/immovables')->with('success', $message);

                } else {
                    $message = 'لم يتم قبول صلة القرابة بنجاح';

                    event(new NewLogCreated($message, $immovable->name, 55, 1, url('admin/immovables/' . $immovable->id . '/edit')));
                    return redirect('admin/immovables')->with('error', $message);
                }

            } else {
                event(new NewLogCreated('لم يتم العثور على صلة القرابة بنجاح برقم : ', $id, 55, 0, null));
                return redirect('admin/immovables')->with('error', 'لم يتم العثور على  صلة القرابة بنجاح');
            }
        } else {
            event(new NewLogCreated('لم يتم العثور على  صلة القرابة بنجاح برقم : ', $id, 55, 0, null));
            return redirect('admin/immovables')->with('error', 'لم يتم العثور على  صلة القرابة بنجاح');
        }
    }

}
