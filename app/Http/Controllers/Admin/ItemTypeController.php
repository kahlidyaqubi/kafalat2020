<?php

namespace App\Http\Controllers\Admin;

use App\Events\NewLogCreated;
use App\Http\Requests\ItemTypeRequest;
use App\ItemCategory;
use App\ItemType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;

class ItemTypeController extends Controller
{
    public function index(Request $request)
    {
        $min_id = ItemType::first()->id ?? 1;
        $max_id = ItemType::orderByDesc('id')->first()->id ?? 1;
        $from_id = $request["from_id"] ?? $min_id;
        $to_id = $request["to_id"] ?? $max_id;
        $name = $request["name"] ?? "";
        $item_category_ids = $request["item_category_ids"] ? array_filter($request["item_category_ids"]) : [];
        $status = $request["status"] ?? "";

        $item_types = ItemType::when($name, function ($query) use ($name) {
            return $query->where('name', 'like', '%' . $name . '%');
        })->when($item_category_ids, function ($query) use ($item_category_ids) {
            return $query->whereIn('item_category_id', $item_category_ids);
        })->when(($status || $status == '0'), function ($query) use ($status) {
            return $query->where('status', $status);
        })->when($from_id && $to_id, function ($query) use ($from_id, $to_id) {
            return $query->whereBetween('id', [$from_id, $to_id]);
        })->orderBy("item_types.id",'desc')->paginate(20)
            ->appends([
                "name" => $name, "from_id" => $from_id, "item_category_ids" => $item_category_ids, "to_id" => $to_id]);

        $item_categories = ItemCategory::orderBy('name')->get();
        return view('admin.item_type.index', compact('item_types', 'item_categories', 'from_id', 'to_id',
            'name', 'max_id', 'min_id', 'status', 'item_category_ids'
        ));

    }


    public function create()
    {
        $item_categories = ItemCategory::orderBy('name')->get();
        return view('admin.item_type.create', compact('item_categories'));
    }

    public function store(ItemTypeRequest $request)
    {
        request()['status'] = auth()->user()->id;
        $testeroor = $this->validate($request, [


            'name' => Rule::unique('item_types')->where(function ($query) {
                return $query->where('name', request()->name)
                    ->where('item_category_id', request()->item_category_id);
            })
        ]);
        if($request['item_category_id'] == -1){
            $testeroor = $this->validate($request, [


                'item_category_id_other' => 'required'
            ]);
        }

        if ($request['item_category_id'] == -1 && ($request['item_category_id_other'])) {
            $item_category = ItemCategory::where('name', $request['item_category_id_other'])->first();

            if ($item_category) {
                $item_category_id = $item_category->id;

            } else {
                $item_category_id = ItemCategory::create(['name' => $request['item_category_id_other'], 'status' => 0])->id;
                $request['item_category_id'] = $item_category_id;
                request()['item_category_id'] = $item_category_id;
            }
        }

        $item_type = ItemType::create(request()->except(['item_category_id_other']));

        event(new NewLogCreated('تم انشاء نوع بنجاح', $item_type->name, 150, 0, null));
        return back()->with('success', 'تم انشاء نوع بنجاح');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $item_type = ItemType::find($id);

        if (!is_null($item_type)) {
            $item_categories = ItemCategory::orderBy('name')->get();
            return view('admin.item_type.edit', compact('item_type', 'item_categories'));

        } else {
            event(new NewLogCreated('المحاولة للوصول لنوع غير موجود برقم : ', $id, 151, 1, null));
            return redirect("/admin/item_types")->with('error', 'النوع غير موجود');
        }
    }

    public function update(ItemTypeRequest $request, $id)
    {
        $item_type = ItemType::find($id);

        if (!is_null($item_type)) {

            $testeroor = $this->validate($request, [
                'name' => Rule::unique('item_types')->where(function ($query) use ($id) {
                    return $query->where('name', request()->name)->where('id', '!=', $id)
                        ->where('item_category_id', request()->item_category_id);
                })

            ]);

            $item_type->update(request()->all());

            event(new NewLogCreated('تعديل البيانات بنجاح', $item_type->name, 151, 1, null));
            return redirect("/admin/item_types")->with('success', 'تم تعديل البيانات بنجاح');

        } else {
            event(new NewLogCreated('المحاولة للوصول لمشروع غير موجود برقم : ', $id, 151, 1, null));
            return redirect("/admin/item_types")->with('error', 'المشروع غير موجود');
        }
    }


    public function destroy($id)
    {
        //
    }


    public function delete($id)
    {
        $item_type = ItemType::find($id);

        if (!is_null($item_type)) {

            //
            if ($item_type->coupon_item_types->first()) {
                event(new NewLogCreated('لا يمكن حذف نوع مرتبط بمساعدات : ', $id, 152, 1, null));
                return redirect("/admin/item_types")->with('error', 'لا يمكن حذف نوع مرتبط بمساعدات');
            }

            $item_type->delete();
            event(new NewLogCreated('حذف نوع بنجاح', $item_type->name, 152, 1, null));
            return redirect("/admin/item_types")->with('success', 'تم حذف مشروع بنجاح');

        } else {
            event(new NewLogCreated('المحاولة للوصول لنوع غير موجود برقم : ', $id, 152, 1, null));
            return redirect("/admin/item_types")->with('error', 'النوع غير موجود');
        }
    }

    public function approve($id)
    {
        $item_type = ItemType::find($id);


        if (!(auth()->user()->hasPermissionTo('item_types'))) {
            return response()->json([
                'message' => 'ليس لك صلاحية تعديل نوع',
            ], 401);
        }

        if ($item_type) {
            if ($item_type->status == 1) {
                $item_type->update(['status' => 0]);
                event(new NewLogCreated('تم الغاء قبول النوع بنجاح', $item_type->name, 151, 1, null));
                return response()->json([
                    'message' => 'تم إلغاء قبول نوع بنجاح',
                ], 200);
            } else {
                $item_type->update(['status' => 1]);
                event(new NewLogCreated('تم قبول النوع بنجاح', $item_type->name, 151, 1, null));
                return response()->json([
                    'message' => 'تم قبول نوع بنجاح',
                ], 200);
            }

        } else {

            event(new NewLogCreated('المحاولة للوصول لنوع غير موجود برقم : ', $id, 151, 1, null));
            return response()->json([
                'message' => 'المحاولة للوصول لنوع غير موجود',
            ], 401);
        }
    }
}
