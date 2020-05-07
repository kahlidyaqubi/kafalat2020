<?php

namespace App\Http\Controllers\Admin;

use App\Events\NewLogCreated;
use App\FundedInstitution;
use App\Http\Requests\FundedInstitutionRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use File;

/**
 * Class FundedInstitutionController
 * @package App\Http\Controllers\Admin
 */
class FundedInstitutionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fundedInstitutions = FundedInstitution::all();
        return view('admin.fundedInstitution.list', compact('fundedInstitutions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.fundedInstitution.create');
    }

    /**
     * @param FundedInstitutionRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(FundedInstitutionRequest $request)
    {
        $message = null;

        $item = FundedInstitution::where('name', '=', $request['name'])->first();

        if (is_null($item)) {
            $request['created_by'] = Auth::user()->id;
            $request['status'] = 1;

            $fundedInstitution = FundedInstitution::create($request->all());
            if ($fundedInstitution) {

                if ($request->hasFile('logo')) {

                    $request->validate([
                        'logo' => 'required|image|mimes:jpeg,png,jpg|max:2048'
                    ]);

                    $path = "uploads/logo/fundedInstitution/";
                    $filename = time() . '.' . $request['logo']->getClientOriginalExtension();
                    if (!file_exists($path)) {
                        File::makeDirectory($path, $mode = 0777, true, true);
                    }
                    Image::make($request['logo'])->resize(150, 150)->save(public_path($path . $filename));

                    $fundedInstitution->logo = 'uploads/logo/fundedInstitution/' . $filename;
                    $fundedInstitution->save();
                }

                $message = 'تم إضافة  جهة مرشحة بنجاح';

                event(new NewLogCreated($message, $request['name'], 30, 1, url('admin/fundedInstitutions/' . $fundedInstitution->id . '/edit')));
                return back()->with('success', $message);

            } else {

                $message = 'لم يتم إضافة  جهة مرشحة بنجاح';
                event(new NewLogCreated($message, $request['name'], 30, 0, null));
                return back()->with('error', $message);
            }
        } else {

            $message = 'لم يتم إضافة  جهة مرشحة بنجاح لتكرار البيانات';
            event(new NewLogCreated($message, $request['name'], 30, 0, null));
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
            $fundedInstitution = FundedInstitution::find($id);

            if (!is_null($fundedInstitution)) {

                return view('admin.fundedInstitution.edit', compact('fundedInstitution'));
            } else {
                event(new NewLogCreated('لم يتم العثور على  جهة مرشحة بنجاح برقم : ', $id, 31, 0, null));
                return redirect('admin/fundedInstitutions')->with('error', 'لم يتم العثور على  جهة مرشحة بنجاح');
            }

        } else {
            event(new NewLogCreated('لم يتم العثور على  جهة مرشحة بنجاح برقم : ', $id, 31, 0, null));
            return redirect('admin/fundedInstitutions')->with('error', 'لم يتم العثور على  جهة مرشحة بنجاح');
        }
    }


    /**
     * @param FundedInstitutionRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(FundedInstitutionRequest $request, $id)
    {
        $message = null;

        if (!is_null($id)) {
            $fundedInstitution = FundedInstitution::find($id);

            if (!is_null($fundedInstitution)) {

                $request['updated_by'] = Auth::user()->id;
                if ($fundedInstitution->update([
                    'name' => $request['name'],
                    'type' => $request['type'],
                    'code' => $request['code'],
                ])) {

                    if ($request->hasFile('logo')) {

                        $request->validate([
                            'logo' => 'required|image|mimes:jpeg,png,jpg|max:2048'
                        ]);

                        $path = "uploads/logo/fundedInstitution/";
                        $filename = time() . '.' . $request['logo']->getClientOriginalExtension();
                        if (!file_exists($path)) {
                            File::makeDirectory($path, $mode = 0777, true, true);
                        }
                        Image::make($request['logo'])->resize(150, 150)->save(public_path($path . $filename));
                        $fundedInstitution->logo = 'uploads/logo/fundedInstitution/' . $filename;
                        $fundedInstitution->save();
                    }

                    $message = 'تم تحديث  جهة مرشحة بنجاح';

                    event(new NewLogCreated($message, $request['name'], 31, 1, url('admin/fundedInstitutions/' . $fundedInstitution->id . '/edit')));
                    return redirect('admin/fundedInstitutions')->with('success', $message);

                } else {
                    $message = 'لم يتم تحديث  جهة مرشحة بنجاح';

                    event(new NewLogCreated($message, $request['name'], 31, 0, null));
                    return redirect('admin/fundedInstitutions')->with('error', $message);
                }
            } else {
                event(new NewLogCreated('لم يتم العثور على  جهة مرشحة بنجاح برقم : ', $id, 31, 0, null));
                return redirect('admin/fundedInstitutions')->with('error', 'لم يتم العثور على  جهة مرشحة بنجاح');
            }

        } else {
            event(new NewLogCreated('لم يتم العثور على  جهة مرشحة بنجاح برقم : ', $id, 31, 0, null));
            return redirect('admin/fundedInstitutions')->with('error', 'لم يتم العثور على  جهة مرشحة بنجاح');
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function delete($id)
    {
        if (!is_null($id)) {
            $fundedInstitution = FundedInstitution::find($id);

            if (!is_null($fundedInstitution)) {
                $name = $fundedInstitution->name;

                if ((($fundedInstitution->family)->isEmpty()) && (($fundedInstitution->expense_price)->isEmpty()) && (($fundedInstitution->expense)->isEmpty())) {
                    if ($fundedInstitution->delete()) {
                        event(new NewLogCreated('تم حذف جهة مرشحة بنجاح ', $name, 32, 0, null));
                        return redirect('admin/fundedInstitutions')->with('success', 'تم حذف جهة مرشحة بنجاح');
                    }
                    event(new NewLogCreated('لم يتم حذف جهة مرشحة بنجاح  ', $name, 32, 0, null));
                    return redirect('admin/fundedInstitutions')->with('error', 'لم يتم حذف جهة مرشحة بنجاح  ');
                } else {
                    event(new NewLogCreated('لم يتم حذف جهة مرشحة بنجاح لوجود عناصر مرتبطة بها ', $name, 32, 0, null));
                    return redirect('admin/fundedInstitutions')->with('error', 'لم يتم حذف جهة مرشحة بنجاح لوجود عناصر مرتبطة بها ');
                }
            } else {
                event(new NewLogCreated('لم يتم العثور على  جهة مرشحة بنجاح برقم : ', $id, 32, 0, null));
                return redirect('admin/fundedInstitutions')->with('error', 'لم يتم العثور على  جهة مرشحة بنجاح');
            }

        } else {
            event(new NewLogCreated('لم يتم العثور على  جهة مرشحة بنجاح برقم : ', $id, 32, 0, null));
            return redirect('admin/fundedInstitutions')->with('error', 'لم يتم العثور على  جهة مرشحة بنجاح');
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function approve($id)
    {

        if (!is_null($id)) {
            $fundedInstitution = FundedInstitution::find($id);

            if (!is_null($fundedInstitution)) {
                if ($fundedInstitution->update(['status' => 1])) {
                    $message = 'تم قبول جهة مرشحة بنجاح';

                    event(new NewLogCreated($message, $fundedInstitution->name, 33, 1, url('admin/fileTypes/' . $fundedInstitution->id . '/edit')));
                    return redirect('admin/fundedInstitutions')->with('success', $message);

                } else {
                    $message = 'لم يتم قبول جهة مرشحة بنجاح';

                    event(new NewLogCreated($message, $fundedInstitution->name, 33, 1, url('admin/fileTypes/' . $fundedInstitution->id . '/edit')));
                    return redirect('admin/fundedInstitutions')->with('error', $message);
                }

            } else {
                event(new NewLogCreated('لم يتم العثور على جهة مرشحة بنجاح برقم : ', $id, 33, 0, null));
                return redirect('admin/fundedInstitutions')->with('error', 'لم يتم العثور على  جهة مرشحة بنجاح');
            }
        } else {
            event(new NewLogCreated('لم يتم العثور على  جهة مرشحة بنجاح برقم : ', $id, 33, 0, null));
            return redirect('admin/fundedInstitutions')->with('error', 'لم يتم العثور على  جهة مرشحة بنجاح');
        }
    }

}
