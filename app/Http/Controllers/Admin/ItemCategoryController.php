<?php

namespace App\Http\Controllers\Admin;

use App\Events\NewLogCreated;
use App\Http\Requests\ItemCategoryRequest;
use App\ItemCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ItemCategoryController extends Controller
{

    public function index(Request $request)
    {
        $min_id = ItemCategory::first()->id ?? 1;
        $max_id = ItemCategory::orderByDesc('id')->first()->id ?? 1;
        $from_id = $request["from_id"] ?? $min_id;
        $to_id = $request["to_id"] ?? $max_id;
        $name = $request["name"] ?? "";
        $status = $request["status"] ?? "";

        $item_categories = ItemCategory::when($name, function ($query) use ($name) {
            return $query->where('name', 'like', '%'.$name.'%');
        })->when(($status || $status == '0'), function ($query) use ($status) {
            return $query->where('status', $status);
        })->when($from_id && $to_id, function ($query) use ($from_id, $to_id) {
            return $query->whereBetween('id', [$from_id,$to_id ]);
        })->orderBy("item_categories.id",'desc')->paginate(20)
            ->appends([
                "name" => $name, "from_id" => $from_id, "to_id" => $to_id]);


        return view('admin.item_category.index', compact('item_categories', 'from_id', 'to_id',
            'name', 'max_id', 'min_id','status'
        ));

    }

    public function create()
    {
        return view('admin.item_category.create');
    }

    public function store(ItemCategoryRequest $request)
    {
        request()['status'] = 1;
        $item_category = ItemCategory::create(request()->all());

        event(new NewLogCreated('تم انشاء صنف بنجاح', $item_category->name, 147, 0, null));
        return back()->with('success', 'تم انشاء صنف بنجاح');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $item_category = ItemCategory::find($id);

        if (!is_null($item_category)) {
            return view('admin.item_category.edit', compact('item_category'));

        } else {
            event(new NewLogCreated('المحاولة للوصول لصنف غير موجود برقم : ', $id, 148, 1, null));
            return redirect("/admin/item_categories")->with('error', 'الصنف غير موجود');
        }
    }

    public function update(ItemCategoryRequest $request, $id)
    {
        $item_category = ItemCategory::find($id);

        if (!is_null($item_category)) {
            $item_category->update(request()->all());

            event(new NewLogCreated('تعديل البيانات بنجاح', $item_category->name, 148, 1, null));
            return redirect("/admin/item_categories")->with('success', 'تم تعديل البيانات بنجاح');

        } else {
            event(new NewLogCreated('المحاولة للوصول لصنف غير موجود برقم : ', $id, 148, 1, null));
            return redirect("/admin/item_categories")->with('error', 'الصنف غير موجود');
        }
    }

    public function destroy($id)
    {
        //
    }

    public function delete($id)
    {
        $item_category = ItemCategory::find($id);

        if (!is_null($item_category)) {
            if ($item_category->item_types->first()) {
                event(new NewLogCreated('لا يمكن حذف صنف مرتبط بأنوع : ', $id, 149, 1, null));
                return redirect("/admin/item_categories")->with('error', 'لا يمكن حذف صنف مرتبط بوحدات');
            }
            $item_category->delete();
            event(new NewLogCreated('حذف صنف بنجاح', $item_category->name, 149, 1, null));
            return redirect("/admin/item_categories")->with('success', 'تم حذف صنف بنجاح');

        } else {
            event(new NewLogCreated('المحاولة للوصول لصنف غير موجود برقم : ', $id, 149, 1, null));
            return redirect("/admin/item_categories")->with('error', 'الصنف غير موجود');
        }
    }

    public function approve($id)
    {
        $item_category = ItemCategory::find($id);


        if (!(auth()->user()->hasPermissionTo('item_categories'))) {
            return response()->json([
                'message' => 'ليس لك صلاحية تعديل صنف',
            ], 401);
        }

        if ($item_category) {
            if ($item_category->status == 1) {
                $item_category->update(['status' => 0]);
                event(new NewLogCreated('تم الغاء قبول الصنف بنجاح', $item_category->name, 148, 1, null));
                return response()->json([
                    'message' => 'تم إلغاء قبول صنف بنجاح',
                ], 200);
            } else {
                $item_category->update(['status' => 1]);
                event(new NewLogCreated('تم قبول الصنف بنجاح', $item_category->name, 148, 1, null));
                return response()->json([
                    'message' => 'تم قبول صنف بنجاح',
                ], 200);
            }

        } else {

            event(new NewLogCreated('المحاولة للوصول لصنف غير موجود برقم : ', $id, 148, 1, null));
            return response()->json([
                'message' => 'المحاولة للوصول لصنف غير موجود',
            ], 401);
        }
    }

    public function item_types($id)
    {
        $item_category = ItemCategory::find($id);

        if (!is_null($item_category)) {
            $min_id = $item_category->item_types->first()->id ?? 1;
            $max_id = $item_category->item_types->orderByDesc('id')->first()->id ?? 1;
            $from_id = $request["from_id"] ?? $min_id;
            $to_id = $request["to_id"] ?? $max_id;
            $name = $request["name"] ?? "";
            $item_category_id = $request["item_category_id"] ?? "";
            $status = $request["status"] ?? "";

            $item_types = $item_category->item_types()->when($name, function ($query) use ($name) {
                return $query->where('name', 'like', '%'.$name.'%');
            })->when($item_category_id, function ($query) use ($item_category_id) {
                return $query->where('item_category_id', $item_category_id);
            })->when(($status || $status == '0'), function ($query) use ($status) {
                return $query->where('status', $status);
            })->when($from_id && $to_id, function ($query) use ($from_id, $to_id) {
                return $query->whereBetween('id', [$from_id,$to_id ]);
            })->orderBy("item_types.id",'desc')->paginate(20)
                ->appends([
                    "name" => $name, "from_id" => $from_id, "item_category_id" => $item_category_id, "to_id" => $to_id]);

            $item_categories = ItemCategory::orderBy('name')->get();
            return view('admin.category.item_types', compact('item_types', 'item_category',
                'item_categories', 'from_id', 'to_id',
                'name', 'max_id', 'max_id', 'item_category_id'
            ));
        } else {
            event(new NewLogCreated('المحاولة للوصول لصنف غير موجود برقم : ', $id, 149, 1, null));
            return redirect("/admin/item_categories")->with('error', 'الصنف غير موجود');
        }
    }
    public function item_types_ajaxs($id)
    {
        if (!is_null($id)) {
            $item_category = ItemCategory::find($id);

            if (!is_null($item_category)) {
                return $item_category->item_types()->get();
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
