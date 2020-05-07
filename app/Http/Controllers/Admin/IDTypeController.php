<?php

namespace App\Http\Controllers\admin;

use App\Events\NewLogCreated;
use App\Http\Requests\IDTypeRequest;
use App\IDType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class IDTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $idTypes = IDType::all();
        return view('admin.idType.list', compact('idTypes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.idType.create');
    }

    /**
     * @param IDTypeRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(IDTypeRequest $request)
    {
        $message = null;

        $item = IDType::where('name', '=', $request['name'])->first();

        if (is_null($item)) {
            $request['created_by'] = Auth::user()->id;
            if ($idType = IDType::create($request->all())) {
                $message = 'تم إضافة نوع الوثيقة بنجاح';

                event(new NewLogCreated($message, $request['name'], 124, 1, url('admin/idTypes/' . $idType->id . '/edit')));
                return back()->with('success', $message);

            } else {

                $message = 'لم يتم إضافة نوع الوثيقة بنجاح';

                event(new NewLogCreated($message, $request['name'], 124, 0, null));
                return back()->with('error', $message);
            }
        } else {

            $message = 'لم يتم إضافة نوع الوثيقة بنجاح لتكرار البيانات';

            event(new NewLogCreated($message, $request['name'], 124, 0, null));
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
            $idType = IDType::find($id);

            if (!is_null($idType)) {

                return view('admin.idType.edit', compact('idType'));
            } else {
                event(new NewLogCreated('لم يتم العثور على  نوع الوثيقة بنجاح برقم : ', $id, 125, 0, null));
                return redirect('admin/idTypes')->with('error', 'لم يتم العثور على  نوع الوثيقة بنجاح');
            }

        } else {
            event(new NewLogCreated('لم يتم العثور على  نوع الوثيقة بنجاح برقم : ', $id, 125, 0, null));
            return redirect('admin/idTypes')->with('error', 'لم يتم العثور على  نوع الوثيقة بنجاح');
        }
    }

    /**
     * @param IDTypeRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(IDTypeRequest $request, $id)
    {
        $message = null;

        if (!is_null($id)) {
            $idType = IDType::find($id);

            if (!is_null($idType)) {

                $request['updated_by'] = Auth::user()->id;
                if ($idType->update($request->all())) {
                    $message = 'تم تحديث نوع الوثيقة بنجاح';

                    event(new NewLogCreated($message, $request['name'], 125, 1, url('admin/idTypes/' . $idType->id . '/edit')));
                    return redirect('admin/idTypes')->with('success', $message);

                } else {
                    $message = 'لم يتم تحديث نوع الوثيقة بنجاح';

                    event(new NewLogCreated($message, $request['name'], 125, 0, null));
                    return redirect('admin/idTypes')->with('error', $message);
                }
            } else {
                event(new NewLogCreated('لم يتم العثور على  نوع الوثيقة بنجاح برقم : ', $id, 125, 0, null));
                return redirect('admin/idTypes')->with('error', 'لم يتم العثور على  نوع الوثيقة بنجاح');
            }

        } else {
            event(new NewLogCreated('لم يتم العثور على  نوع الوثيقة بنجاح برقم : ', $id, 125, 0, null));
            return redirect('admin/idTypes')->with('error', 'لم يتم العثور على  نوع الوثيقة بنجاح');
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function delete($id)
    {
        if (!is_null($id)) {
            $idType = IDType::find($id);

            if (!is_null($idType)) {
                $name = $idType->name;

                if ((($idType->person)->isEmpty())) {
                    if ($idType->delete()) {
                        event(new NewLogCreated('تم حذف نوع الوثيقة بنجاح ', $name, 126, 0, null));
                        return redirect('admin/idTypes')->with('success', 'تم حذف نوع الوثيقة بنجاح');
                    }
                    event(new NewLogCreated('لم يتم حذف نوع الوثيقة بنجاح  ', $name, 126, 0, null));
                    return redirect('admin/idTypes')->with('error', 'لم يتم حذف نوع الوثيقة بنجاح  ');
                } else {
                    event(new NewLogCreated('لم يتم حذف نوع الوثيقة بنجاح لوجود عناصر مرتبطة بها ', $name, 126, 0, null));
                    return redirect('admin/idTypes')->with('error', 'لم يتم حذف نوع الوثيقة بنجاح لوجود عناصر مرتبطة بها ');
                }
            } else {
                event(new NewLogCreated('لم يتم العثور على  نوع الوثيقة بنجاح برقم : ', $id, 126, 0, null));
                return redirect('admin/idTypes')->with('error', 'لم يتم العثور على  نوع الوثيقة بنجاح');
            }

        } else {
            event(new NewLogCreated('لم يتم العثور على  نوع الوثيقة بنجاح برقم : ', $id, 126, 0, null));
            return redirect('admin/idTypes')->with('error', 'لم يتم العثور على  نوع الوثيقة بنجاح');
        }
    }

}
