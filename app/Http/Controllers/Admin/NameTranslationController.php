<?php

namespace App\Http\Controllers\Admin;

use App\Events\NewLogCreated;
use App\Http\Requests\NameTranslationRequest;
use App\NameTranslation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Config;

/**
 * Class NameTranslationController
 * @package App\Http\Controllers\Admin
 */
class NameTranslationController extends Controller
{
    public function __construct()
    {
        Config::set('excel.import.heading','slugged');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $nameTranslations = NameTranslation::all();
        return view('admin.nameTranslations.list', compact('nameTranslations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.nameTranslations.create');
    }

    /**
     * @param NameTranslationRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(NameTranslationRequest $request)
    {
        $message = null;

        $request['created_by'] = Auth::user()->id;

        if ($nameTranslation = NameTranslation::create($request->all())) {
            $message = 'تم إضافة الترجمة بنجاح';
            event(new NewLogCreated($message, $request['arabic'], 74, 1, url('admin/nameTranslations/' . $nameTranslation->id . '/edit')));
            return back()->with('success', $message);

        } else {
            $message = 'لم يتم إضافة الترجمة بنجاح';
            event(new NewLogCreated($message, $request['arabic'], 74, 0, null));
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
            $nameTranslation = NameTranslation::find($id);

            if (!is_null($nameTranslation)) {

                return view('admin.nameTranslations.edit', compact('nameTranslation'));
            } else {
                event(new NewLogCreated('لم يتم العثور على  الترجمة بنجاح برقم : ', $id, 75, 0, null));
                return redirect('admin/nameTranslations')->with('error', 'لم يتم العثور على الترجمة بنجاح');
            }

        } else {
            event(new NewLogCreated('لم يتم العثور على الترجمة بنجاح برقم : ', $id, 75, 0, null));
            return redirect('admin/nameTranslations')->with('error', 'لم يتم العثور على الترجمة بنجاح');
        }
    }

    /**
     * @param NameTranslationRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(NameTranslationRequest $request, $id)
    {
        $message = null;

        if (!is_null($id)) {
            $nameTranslation = NameTranslation::find($id);

            if (!is_null($nameTranslation)) {

                $request['updated_by'] = Auth::user()->id;
                if ($nameTranslation->update($request->all())) {
                    $message = 'تم تحديث الترجمة بنجاح';

                    event(new NewLogCreated($message, $request['arabic'], 75, 1, url('admin/nameTranslations/' . $nameTranslation->id . '/edit')));
                    return redirect('admin/nameTranslations')->with('success', $message);

                } else {
                    $message = 'لم يتم تحديث الترجمة بنجاح';

                    event(new NewLogCreated($message, $request['arabic'], 75, 0, null));
                    return redirect('admin/nameTranslations')->with('error', $message);
                }
            } else {
                event(new NewLogCreated('لم يتم العثور على  الترجمة بنجاح برقم : ', $id, 75, 0, null));
                return redirect('admin/nameTranslations')->with('error', 'لم يتم العثور على  الترجمة بنجاح');
            }

        } else {
            event(new NewLogCreated('لم يتم العثور على  الترجمة بنجاح برقم : ', $id, 75, 0, null));
            return redirect('admin/nameTranslations')->with('error', 'لم يتم العثور على  الترجمة بنجاح');
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function delete($id)
    {
        if (!is_null($id)) {
            $translation = NameTranslation::find($id);

            if (!is_null($translation)) {
                $name = $translation->arabic;

                if ($translation->delete()) {
                    event(new NewLogCreated('تم حذف الترجمة بنجاح ', $name, 76, 0, null));
                    return redirect('admin/nameTranslations')->with('success', 'تم حذف الترجمة بنجاح');
                }
                event(new NewLogCreated('لم يتم حذف الترجمة بنجاح  ', $name, 76, 0, null));
                return redirect('admin/nameTranslations')->with('error', 'لم يتم حذف الترجمة بنجاح  ');

            } else {
                event(new NewLogCreated('لم يتم العثور على  الترجمة بنجاح برقم : ', $id, 76, 0, null));
                return redirect('admin/nameTranslations')->with('error', 'لم يتم العثور على  الترجمة بنجاح');
            }
        } else {
            event(new NewLogCreated('لم يتم العثور على  الترجمة بنجاح برقم : ', $id, 76, 0, null));
            return redirect('admin/nameTranslations')->with('error', 'لم يتم العثور على  الترجمة بنجاح');
        }
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getImportNames()
    {
        return view('admin.nameTranslations.importNames');
    }

    /**
     *
     */
    public function exportTranslationsFile()
    {
        $header = ["الاسم بالعربي", "الاسم بالتركي"];

        Excel::create('الترجمات', function ($excel) use ($header) {
            $excel->sheet('الترجمات', function ($sheet) use ($header) {
                $sheet->setOrientation('landscape');
                $sheet->fromArray($header, NULL, 'A1');
                $sheet->freezeFirstRow();
            });

        })->download('xlsx');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function importNames(Request $request)
    {

        $message = '';
        $type = '';
        $file = $request->file('file');

        if ($request->hasFile('file')) {

            $extensions = array("xlsx");

            $result = array($request->file('file')->getClientOriginalExtension());

            if (in_array($result[0], $extensions)) {

                $path = $file->getRealPath();

                $data = \Excel::load($path)->get();

                if ($data->count()) {
                    foreach ($data as $key => $value) {

                        if ((isset($value['alasm_balaarby'])) && (isset($value['alasm_baltrky']))) {
                            if ((($value['alasm_balaarby'] != '')) && (($value['alasm_baltrky'] != ''))) {
                                $arr[] = [
                                    'arabic' => $value['alasm_balaarby'],
                                    'turkey' => $value['alasm_baltrky'],
                                ];
                            }
                        } else {
                            $message = 'لم يتم إضافة الترجمة بنجاح لعدم وجود الاعمده المطلوبه';
                            event(new NewLogCreated($message, null, 101, 0, null));
                            return redirect('admin/nameTranslations/import/names')->with('error', 'لم يتم تحميل الملف بنجاح');

                        }
                    }

                    if (!empty($arr)) {
                        $data = [];
                        foreach ($arr as $value) {

                            $data['arabic'] = $value['arabic'];
                            $data['turkey'] = $value['turkey'];
                            $name = NameTranslation::updateOrCreate($data);

                            $message = 'تم إضافة الترجمة بنجاح';
                            $type = 'success';
                            event(new NewLogCreated($message, $name->arabic, 101, 1, url('admin/nameTranslations/' . $name->id . '/edit')));
                        }
                    } else {
                        $message = 'لم يتم إضافة الترجمة بنجاح';
                        $type = 'error';
                        event(new NewLogCreated($message, $request['arabic'], 101, 0, null));
                    }

                    return redirect('admin/nameTranslations')->with($type, $message);

                } else {
                    $message = 'لم يتم إضافة الترجمة بنجاح لعدم وجود بيانات';
                    event(new NewLogCreated($message, null, 101, 0, null));
                    return redirect('admin/nameTranslations')->with('error', $message);
                }
            } else {
                event(new NewLogCreated($message, null, 101, 0, null));
                return redirect('admin/nameTranslations/import/names')->with('error', 'لم يتم تحميل الملف بنجاح يجب ان يكون نوع الملف xlsx');
            }
        } else {
            event(new NewLogCreated($message, null, 101, 0, null));
            return redirect('admin/nameTranslations/import/names')->with('error', 'لم يتم تحميل الملف بنجاح');
        }
    }

}
