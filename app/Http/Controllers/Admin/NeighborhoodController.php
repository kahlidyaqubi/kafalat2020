<?php

namespace App\Http\Controllers\admin;

use App\City;
use App\Events\NewLogCreated;
use App\Http\Requests\NeighborhoodRequest;
use App\Neighborhood;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class NeighborhoodController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $neighborhoods = Neighborhood::all();
        return view('admin.neighborhood.list', compact('neighborhoods'));
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $cities = City::all();
        return view('admin.neighborhood.create', compact('cities'));
    }

    /**
     * @param NeighborhoodRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(NeighborhoodRequest $request)
    {
        $message = null;

        $item = Neighborhood::where('name', '=', $request['name'])->first();

        if (is_null($item)) {
            $request['created_by'] = Auth::user()->id;
            if ($neighborhood = Neighborhood::create($request->all())) {
                $message = 'تم إضافة منطقة بنجاح';

                event(new NewLogCreated($message, $request['name'], 95, 1, url('admin/neighborhoods/' . $neighborhood->id . '/edit')));
                return back()->with('success', $message);

            } else {

                $message = 'لم يتم إضافة منطقة بنجاح';

                event(new NewLogCreated($message, $request['name'], 95, 0, null));
                return back()->with('error', $message);
            }
        } else {

            $message = 'لم يتم إضافة منطقة بنجاح لتكرار البيانات';

            event(new NewLogCreated($message, $request['name'], 95, 0, null));
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
            $neighborhood = Neighborhood::find($id);

            if (!is_null($neighborhood)) {

                $cities = City::all();

                return view('admin.neighborhood.edit', compact('neighborhood', 'cities'));

            } else {
                event(new NewLogCreated('لم يتم العثور على  المدينة بنجاح برقم : ', $id, 96, 0, null));
                return redirect('admin/neighborhoods')->with('error', 'لم يتم العثور على  المدينة بنجاح');

            }
        } else {
            event(new NewLogCreated('لم يتم العثور على  المدينة بنجاح برقم : ', $id, 96, 0, null));
            return redirect('admin/neighborhoods')->with('error', 'لم يتم العثور على  المدينة بنجاح');

        }
    }

    /**
     * @param NeighborhoodRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(NeighborhoodRequest $request, $id)
    {
        $message = null;

        if (!is_null($id)) {
            $neighborhood = Neighborhood::find($id);

            if (!is_null($neighborhood)) {

                $request['updated_by'] = Auth::user()->id;
                if ($neighborhood->update($request->all())) {
                    $message = 'تم تحديث منطقة بنجاح';

                    event(new NewLogCreated($message, $request['name'], 96, 1, url('admin/neighborhoods/' . $neighborhood->id . '/edit')));
                    return redirect('admin/neighborhoods')->with('success', $message);

                } else {
                    $message = 'لم يتم تحديث منطقة بنجاح';

                    event(new NewLogCreated($message, $request['name'], 96, 0, null));
                    return redirect('admin/neighborhoods')->with('error', $message);
                }
            } else {
                event(new NewLogCreated('لم يتم العثور على  المدينة بنجاح برقم : ', $id, 96, 0, null));
                return redirect('admin/neighborhoods')->with('error', 'لم يتم العثور على  المدينة بنجاح');
            }

        } else {
            event(new NewLogCreated('لم يتم العثور على  المدينة بنجاح برقم : ', $id, 96, 0, null));
            return redirect('admin/neighborhoods')->with('error', 'لم يتم العثور على  المدينة بنجاح');
        }

    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function delete($id)
    {
        if (!is_null($id)) {
            $neighborhood = Neighborhood::find($id);

            if (!is_null($neighborhood)) {
                $name = $neighborhood->name;


                if ((($neighborhood->user)->isEmpty()) && (($neighborhood->family)->isEmpty()) && (($neighborhood->institution)->isEmpty())) {
                    if ($neighborhood->delete()) {
                        event(new NewLogCreated('تم حذف منطقة بنجاح ', $name, 97, 0, null));
                        return redirect('admin/neighborhoods')->with('success', 'تم حذف منطقة بنجاح');
                    }
                    event(new NewLogCreated('لم يتم حذف منطقة بنجاح  ', $name, 97, 0, null));
                    return redirect('admin/neighborhoods')->with('error', 'لم يتم حذف منطقة بنجاح  ');
                } else {
                    event(new NewLogCreated('لم يتم حذف منطقة بنجاح لوجود عناصر مرتبطة بها ', $name, 97, 0, null));
                    return redirect('admin/neighborhoods')->with('error', 'لم يتم حذف منطقة بنجاح لوجود عناصر مرتبطة بها ');
                }
            } else {
                event(new NewLogCreated('لم يتم العثور على  المدينة بنجاح برقم : ', $id, 97, 0, null));
                return redirect('admin/neighborhoods')->with('error', 'لم يتم العثور على  المدينة بنجاح');
            }
        } else {
            event(new NewLogCreated('لم يتم العثور على  المدينة بنجاح برقم : ', $id, 97, 0, null));
            return redirect('admin/neighborhoods')->with('error', 'لم يتم العثور على  المدينة بنجاح');
        }
    }

    public function approve($id)
    {
        $neighborhood = Neighborhood::find($id);


        if (!(auth()->user()->hasPermissionTo('neighborhoods'))) {
            return redirect('admin/neighborhoods')->with('error', 'ليس لك صلاحية تعديل حي');
        }

        if ($neighborhood) {
            if ($neighborhood->status == 1) {
                $neighborhood->update(['status' => 0]);
                event(new NewLogCreated('تم الغاء قبول الحي بنجاح', $neighborhood->name, 157, 1, null));
                return redirect('admin/neighborhoods')->with('success', 'تم إلغاء قبول حي بنجاح');
            } else {
                $neighborhood->update(['status' => 1]);
                event(new NewLogCreated('تم قبول الحي بنجاح', $neighborhood->name, 157, 1, null));
                return redirect('admin/neighborhoods')->with('success', 'تم قبول حي بنجاح');

            }

        } else {

            event(new NewLogCreated('المحاولة للوصول لحي غير موجود برقم : ', $id, 157, 1, null));
            return redirect('admin/neighborhoods')->with('error', 'المحاولة للوصول لحي غير موجود');

        }
    }
}
