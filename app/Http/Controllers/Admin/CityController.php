<?php

namespace App\Http\Controllers\Admin;

use App\City;
use App\Governorate;
use App\Events\NewLogCreated;
use App\Http\Requests\CityRequest;
use App\Http\Controllers\Controller;
use App\Neighborhood;
use Illuminate\Support\Facades\Auth;

/**
 * Class CityController
 * @package App\Http\Controllers\Admin
 */
class CityController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $cities = City::all();
        return view('admin.city.list', compact('cities'));
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $governorates = Governorate::all();
        return view('admin.city.create', compact('governorates'));
    }

    /**
     * @param CityRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CityRequest $request)
    {
        $message = null;

        $request['created_by'] = Auth::user()->id;

        $item = City::where('name', '=', $request['name'])->first();

        if (is_null($item)) {
            if ($city = City::create($request->all())) {
                $message = 'تم إضافة مدينة بنجاح';

                event(new NewLogCreated($message, $request['name'], 13, 1, url('admin/cities/' . $city->id . '/edit')));
                return back()->with('success', $message);

            } else {

                $message = 'لم يتم إضافة مدينة بنجاح';

                event(new NewLogCreated($message, $request['name'], 13, 0, null));
                return back()->with('error', $message);
            }
        } else {
            $message = 'لم يتم إضافة مدينة بنجاح لتكرار البيانات ';

            event(new NewLogCreated($message, $request['name'], 13, 0, null));
            return back()->with('error', $message);

        }

    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        if (!is_null($id)) {
            $city = City::find($id);

            if (!is_null($city)) {
                $governorates = Governorate::all();

                return view('admin.city.edit', compact('city', 'governorates'));

            } else {
                event(new NewLogCreated('لم يتم العثور على  المدينة بنجاح برقم : ', $id, 14, 0, null));
                return redirect('admin/cities')->with('error', 'لم يتم العثور على  المدينة بنجاح');

            }
        } else {
            event(new NewLogCreated('لم يتم العثور على  المدينة بنجاح برقم : ', $id, 14, 0, null));
            return redirect('admin/cities')->with('error', 'لم يتم العثور على  المدينة بنجاح');

        }
    }

    /**
     * @param CityRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(CityRequest $request, $id)
    {
        $message = null;

        if (!is_null($id)) {
            $city = City::find($id);

            if (!is_null($city)) {

                $request['updated_by'] = Auth::user()->id;
                if ($city->update($request->all())) {
                    $message = 'تم تحديث مدينة بنجاح';

                    event(new NewLogCreated($message, $request['name'], 14, 1, url('admin/cities/' . $city->id . '/edit')));
                    return redirect('admin/cities')->with('success', $message);

                } else {
                    $message = 'لم يتم تحديث مدينة بنجاح';

                    event(new NewLogCreated($message, $request['name'], 14, 0, null));
                    return redirect('admin/cities')->with('error', $message);
                }
            } else {
                event(new NewLogCreated('لم يتم العثور على المدينة بنجاح برقم : ', $id, 14, 0, null));
                return redirect('admin/cities')->with('error', 'لم يتم العثور على المدينة بنجاح');
            }

        } else {
            event(new NewLogCreated('لم يتم العثور على المدينة بنجاح برقم : ', $id, 14, 0, null));
            return redirect('admin/cities')->with('error', 'لم يتم العثور على  المدينة بنجاح');
        }

    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function delete($id)
    {
        if (!is_null($id)) {
            $city = City::find($id);

            if (!is_null($city)) {
                $name = $city->name;

                if ((($city->neighborhood)->isEmpty())) {
                    if ($city->delete()) {
                        event(new NewLogCreated('تم حذف مدينة بنجاح ', $name, 15, 0, null));
                        return redirect('admin/cities')->with('success', 'تم حذف مدينة بنجاح');
                    }
                    event(new NewLogCreated('لم يتم حذف مدينة بنجاح  ', $name, 15, 0, null));
                    return redirect('admin/cities')->with('error', 'لم يتم حذف مدينة بنجاح  ');
                } else {
                    event(new NewLogCreated('لم يتم حذف مدينة بنجاح لوجود أحياء مرتبطة بها ', $name, 15, 0, null));
                    return redirect('admin/cities')->with('error', 'لم يتم حذف مدينة بنجاح لوجود أحياء مرتبطة بها ');
                }
            } else {
                event(new NewLogCreated('لم يتم العثور على المدينة بنجاح برقم : ', $id, 15, 0, null));
                return redirect('admin/cities')->with('error', 'لم يتم العثور على  المدينة بنجاح');
            }
        } else {
            event(new NewLogCreated('لم يتم العثور على  المدينة بنجاح برقم : ', $id, 15, 0, null));
            return redirect('admin/cities')->with('error', 'لم يتم العثور على  المدينة بنجاح');
        }
    }

    public function neighborhoods($id)
    {
        if (!is_null($id)) {
            $city = City::find($id);

            if (!is_null($city)) {
                return Neighborhood::orderBy('name')->orWhere('city_id', "=", $id)->get();
                //$city->neighborhood()->get();
            } else {
                return response()->json([
                    'message' => 'الرجاء التاكد من الرابط المطلوب'
                ], 401);
            }
        } else {
            return response()->json([
                'message' => 'الرجاء التاكد من الرابط المطلوب'
            ], 401);
        }
    }

}
