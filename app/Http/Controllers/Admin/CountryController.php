<?php

namespace App\Http\Controllers\Admin;

use App\Country;
use App\Events\NewLogCreated;
use App\Http\Requests\CountryRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

/**
 * Class CountryController
 * @package App\Http\Controllers\Admin
 */
class CountryController extends Controller
{

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $countries = Country::all();
        return view('admin.country.list', compact('countries'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $countries = Country::all();
        return view('admin.country.create', compact('countries'));
    }

    /**
     * @param CountryRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(CountryRequest $request)
    {
        $message = null;
        $item = Country::where('name', '=', $request['name'])->first();

        if(is_null($item)) {
        $request['created_by'] = Auth::user()->id;
        if ($country = Country::create($request->all())) {
            $message = 'تم إضافة مكان الميلاد بنجاح';

            event(new NewLogCreated($message, $request['name'], 16, 1, url('admin/countries/' . $country->id . '/edit')));
            return back()->with('success', $message);

        } else {

            $message = 'لم يتم إضافة مكان الميلاد بنجاح';

            event(new NewLogCreated($message, $request['name'], 16, 0, null));
            return back()->with('error', $message);
        } } else {

            $message = ' لم يتم إضافة مكان الميلاد بنجاح لتكرار البيانات ';

            event(new NewLogCreated($message, $request['name'], 16, 0, null));
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
            $country = Country::find($id);

            if (!is_null($country)) {

                return view('admin.country.edit', compact('country'));
            } else {
                event(new NewLogCreated('لم يتم العثور  على  المكان الميلاد بنجاح برقم : ', $id, 17, 0, null));
                return redirect('admin/countries')->with('error', 'لم يتم العثور  على  المكان الميلاد بنجاح');
            }

        } else {
            event(new NewLogCreated('لم يتم العثور  على  المكان الميلاد بنجاح برقم : ', $id, 17, 0, null));
            return redirect('admin/countries')->with('error', 'لم يتم العثور  على  المكان الميلاد بنجاح');
        }
    }


    /**
     * @param CountryRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(CountryRequest $request, $id)
    {
        $message = null;

        if (!is_null($id)) {
            $country = Country::find($id);

            if (!is_null($country)) {

                $request['updated_by'] = Auth::user()->id;
                if ($country->update($request->all())) {
                    $message = 'تم تحديث مكان الميلاد بنجاح';

                    event(new NewLogCreated($message, $request['name'], 17, 1, url('admin/countries/' . $country->id . '/edit')));
                    return redirect('admin/countries')->with('success', $message);

                } else {
                    $message = 'لم يتم تحديث مكان الميلاد بنجاح';

                    event(new NewLogCreated($message, $request['name'], 17, 0, null));
                    return redirect('admin/countries')->with('error', $message);
                }
            } else {
                event(new NewLogCreated('لم يتم العثور  على  المكان الميلاد بنجاح برقم : ', $id, 17, 0, null));
                return redirect('admin/countries')->with('error', 'لم يتم العثور  على  المكان الميلاد بنجاح');
            }

        } else {
            event(new NewLogCreated('لم يتم العثور  على  المكان الميلاد بنجاح برقم : ', $id, 17, 0, null));
            return redirect('admin/countries')->with('error', 'لم يتم العثور  على  المكان الميلاد بنجاح');
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function delete($id)
    {
        if (!is_null($id)) {
            $country = Country::find($id);

            if (!is_null($country)) {
                $name = $country->name;

                if ((($country->governorate)->isEmpty()) && (($country->sponsor)->isEmpty())) {
                    if ($country->delete()) {
                        event(new NewLogCreated('تم حذف مكان الميلاد بنجاح ', $name, 18, 0, null));
                        return redirect('admin/countries')->with('success', 'تم حذف مكان الميلاد بنجاح');
                    }
                    event(new NewLogCreated('لم يتم حذف مكان الميلاد بنجاح  ', $name, 18, 0, null));
                    return redirect('admin/countries')->with('error', 'لم يتم حذف مكان الميلاد بنجاح  ');
                } else {
                    event(new NewLogCreated('لم يتم حذف مكان الميلاد بنجاح لوجود عناصر مرتبطة بها ', $name, 18, 0, null));
                    return redirect('admin/countries')->with('error', 'لم يتم حذف مكان الميلاد بنجاح لوجود عناصر مرتبطة بها ');
                }
            } else {
                event(new NewLogCreated('لم يتم العثور  على  المكان الميلاد بنجاح برقم : ', $id, 18, 0, null));
                return redirect('admin/countries')->with('error', 'لم يتم العثور  على  المكان الميلاد بنجاح');
            }
        } else {
            event(new NewLogCreated('لم يتم العثور  على  المكان الميلاد بنجاح برقم : ', $id, 18, 0, null));
            return redirect('admin/countries')->with('error', 'لم يتم العثور  على  المكان الميلاد بنجاح');
        }
    }

}
