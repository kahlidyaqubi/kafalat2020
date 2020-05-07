<?php

namespace App\Http\Controllers\Admin;

use App\Events\NewLogCreated;
use App\FileType;
use App\Http\Requests\FileTypeRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

/**
 * Class FileTypeController
 * @package App\Http\Controllers\Admin
 */
class FileTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fileTypes = FileType::all();
        return view('admin.fileType.list', compact('fileTypes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.fileType.create');
    }

    /**
     * @param FileTypeRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(FileTypeRequest $request)
    {
        $message = null;

        $item = FileType::where('name', '=', $request['name'])->first();

        if(is_null($item)) {
        $request['created_by'] = Auth::user()->id;
        $request['status'] = 1;


        if ($fileType = FileType::create($request->all())) {
            $message = 'تم إضافة اسم المرفق بنجاح';

            event(new NewLogCreated($message, $request['name'], 26, 1, url('admin/fileTypes/' . $fileType->id . '/edit')));
            return back()->with('success', $message);

        } else {

            $message = 'لم يتم إضافة اسم المرفق بنجاح';

            event(new NewLogCreated($message, $request['name'], 26, 0, null));
            return back()->with('error', $message);
        }   } else {

            $message = 'لم يتم إضافة اسم المرفق بنجاح لتكرار البيانات ';

            event(new NewLogCreated($message, $request['name'], 26, 0, null));
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
            $fileType = FileType::find($id);

            if (!is_null($fileType)) {

                return view('admin.fileType.edit', compact('fileType'));
            } else {
                event(new NewLogCreated('لم يتم العثور على  اسم المرفق بنجاح برقم : ', $id, 27, 0, null));
                return redirect('admin/fileTypes')->with('error', 'لم يتم العثور على  اسم المرفق بنجاح');
            }

        } else {
            event(new NewLogCreated('لم يتم العثور على  اسم المرفق بنجاح برقم : ', $id, 27, 0, null));
            return redirect('admin/fileTypes')->with('error', 'لم يتم العثور على  اسم المرفق بنجاح');
        }
    }

    /**
     * @param FileTypeRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(FileTypeRequest $request, $id)
    {
        $message = null;

        if (!is_null($id)) {
            $fileType = FileType::find($id);

            if (!is_null($fileType)) {

                $request['updated_by'] = Auth::user()->id;
                if ($fileType->update($request->all())) {
                    $message = 'تم تحديث اسم المرفق بنجاح';
                    
                    event(new NewLogCreated($message, $request['name'], 27, 1, url('admin/fileTypes/' . $fileType->id . '/edit')));
                    return redirect('admin/fileTypes')->with('success', $message);

                } else {
                    $message = 'لم يتم تحديث اسم المرفق بنجاح';

                    event(new NewLogCreated($message, $request['name'], 27, 0, null));
                    return redirect('admin/fileTypes')->with('error', $message);
                }
            } else {
                event(new NewLogCreated('لم يتم العثور على  اسم المرفق بنجاح برقم : ', $id, 27, 0, null));
                return redirect('admin/fileTypes')->with('error', 'لم يتم العثور على  اسم المرفق بنجاح');
            }

        } else {
            event(new NewLogCreated('لم يتم العثور على  اسم المرفق بنجاح برقم : ', $id, 27, 0, null));
            return redirect('admin/fileTypes')->with('error', 'لم يتم العثور على  اسم المرفق بنجاح');
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function delete($id)
    {
        if (!is_null($id)) {
            $fileType = FileType::find($id);

            if (!is_null($fileType)) {
                $name = $fileType->name;

                if ($fileType->family_media->isEmpty() && $fileType->uesr_media->isEmpty() &&$fileType->institution_media->isEmpty() ) {
                    if ($fileType->delete()) {
                        event(new NewLogCreated('تم حذف  اسم المرفق بنجاح ', $name, 28, 0, null));
                        return redirect('admin/fileTypes')->with('success', 'تم حذف  اسم المرفق بنجاح');
                    }
                    event(new NewLogCreated('لم يتم حذف  اسم المرفق بنجاح  ', $name, 28, 0, null));
                    return redirect('admin/fileTypes')->with('error', 'لم يتم حذف  اسم المرفق بنجاح  ');
                } else {
                    event(new NewLogCreated('لم يتم حذف  اسم المرفق بنجاح لوجود عناصر مرتبطة بها ', $name, 28, 0, null));
                    return redirect('admin/fileTypes')->with('error', 'لم يتم حذف  اسم المرفق بنجاح لوجود عناصر مرتبطة بها ');
                }
            } else {
                event(new NewLogCreated('لم يتم العثور على اسم المرفق بنجاح برقم : ', $id, 28, 0, null));
                return redirect('admin/fileTypes')->with('error', 'لم يتم العثور على   اسم المرفق بنجاح');
            }

        } else {
            event(new NewLogCreated('لم يتم العثور على اسم المرفق بنجاح برقم : ', $id, 28, 0, null));
            return redirect('admin/fileTypes')->with('error', 'لم يتم العثور على   اسم المرفق بنجاح');
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function approve($id)
    {

        if (!is_null($id)) {
            $fileType = FileType::find($id);

            if (!is_null($fileType)) {
                if ($fileType->update(['status'=> 1])) {
                    $message = 'تم قبول  اسم المرفق بنجاح';

                    event(new NewLogCreated($message, $fileType->name, 29, 1, url('admin/fileTypes/' . $fileType->id . '/edit')));
                    return redirect('admin/fileTypes')->with('success', $message);

                } else {
                    $message = 'لم يتم قبول اسم المرفق بنجاح';

                    event(new NewLogCreated($message, $fileType->name, 29, 1, url('admin/fileTypes/' . $fileType->id . '/edit')));
                    return redirect('admin/fileTypes')->with('error', $message);
                }

            } else {
                event(new NewLogCreated('لم يتم العثور على  اسم المرفق بنجاح برقم : ', $id, 29, 0, null));
                return redirect('admin/fileTypes')->with('error', 'لم يتم العثور على   اسم المرفق بنجاح');
            }
        } else {
            event(new NewLogCreated('لم يتم العثور على   اسم المرفق بنجاح برقم : ', $id, 29, 0, null));
            return redirect('admin/fileTypes')->with('error', 'لم يتم العثور على   اسم المرفق بنجاح');
        }
    }
}
