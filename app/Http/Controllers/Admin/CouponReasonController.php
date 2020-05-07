<?php

namespace App\Http\Controllers\Admin;

use App\CouponReason;
use App\Events\NewLogCreated;
use App\Http\Requests\CouponReasonRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CouponReasonController extends Controller
{
    public function index(Request $request)
    {
        $min_id = CouponReason::first()->id ?? 1;
        $max_id = CouponReason::orderByDesc('id')->first()->id ?? 1;
        $from_id = $request["from_id"] ?? $min_id;
        $to_id = $request["to_id"] ?? $max_id;
        $name = $request["name"] ?? "";
        $status = $request["status"] ?? "";

        $coupon_reasons = CouponReason::when($name, function ($query) use ($name) {
            return $query->where('name', 'like', '%' . $name . '%');
        })->when($status, function ($query) use ($status) {
            return $query->where('status', '!=', "");
        })->when($from_id && $to_id, function ($query) use ($from_id, $to_id) {
            return $query->whereBetween('id', [$from_id, $to_id]);
        })->orderBy("coupon_reasons.id",'desc')->paginate(20)
            ->appends([
                "name" => $name, "from_id" => $from_id, "to_id" => $to_id]);


        return view('admin.coupon_reason.index', compact('coupon_reasons', 'from_id', 'to_id',
            'name', 'max_id', 'min_id', 'status'
        ));

    }

    public function create()
    {
        return view('admin.coupon_reason.create');
    }

    public function store(CouponReasonRequest $request)
    {
        request()['status'] = 1;
        $coupon_reason = CouponReason::create(request()->all());

        event(new NewLogCreated('تم انشاء سبب مساعدة بنجاح', $coupon_reason->name, 162, 0, null));
        return back()->with('success', 'تم انشاء سبب مساعدة بنجاح');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $coupon_reason = CouponReason::find($id);

        if (!is_null($coupon_reason)) {
            return view('admin.coupon_reason.edit', compact('coupon_reason'));

        } else {
            event(new NewLogCreated('المحاولة للوصول لسبب مساعدة غير موجود برقم : ', $id, 163, 1, null));
            return redirect("/admin/coupon_reasons")->with('error', 'سبب مساعدة غير موجود');
        }
    }

    public function update(CouponReasonRequest $request, $id)
    {
        $coupon_reason = CouponReason::find($id);

        if (!is_null($coupon_reason)) {
            request()['status'] = 1;
            $coupon_reason->update(request()->all());

            event(new NewLogCreated('تعديل البيانات بنجاح', $coupon_reason->name, 163, 1, null));
            return redirect("/admin/coupon_reasons")->with('success', 'تم تعديل البيانات بنجاح');

        } else {
            event(new NewLogCreated('المحاولة للوصول لسبب مساعدة غير موجود برقم : ', $id, 163, 1, null));
            return redirect("/admin/coupon_reasons")->with('error', 'السبب مساعدة غير موجود');
        }
    }

    public function destroy($id)
    {
        //
    }

    public function delete($id)
    {
        $coupon_reason = CouponReason::find($id);

        if (!is_null($coupon_reason)) {
            if ($coupon_reason->urgent_coupons->first()) {
                event(new NewLogCreated('لا يمكن حذف سبب مساعدة مرتبط بمساعدات : ', $id, 164, 1, null));
                return redirect("/admin/coupon_reasons")->with('error', 'لا يمكن حذف سبب مساعدة مرتبط بمساعدات');
            }
            $coupon_reason->delete();
            event(new NewLogCreated('حذف سبب مساعدة بنجاح', $coupon_reason->name, 164, 1, null));
            return redirect("/admin/coupon_reasons")->with('success', 'تم حذف سبب مساعدة بنجاح');

        } else {
            event(new NewLogCreated('المحاولة للوصول لسبب مساعدة غير موجود برقم : ', $id, 164, 1, null));
            return redirect("/admin/coupon_reasons")->with('error', 'السبب مساعدة غير موجود');
        }
    }

    public function approve($id)
    {
        $coupon_reason = CouponReason::find($id);


        if (!(auth()->user()->hasPermissionTo('coupon_reasons'))) {
            return response()->json([
                'message' => 'ليس لك صلاحية تعديل سبب مساعدة',
            ], 401);
        }

        if ($coupon_reason) {
            if ($coupon_reason->status == 1) {
                $coupon_reason->update(['status' => 0]);
                event(new NewLogCreated('تم الغاء قبول سبب مساعدة بنجاح', $coupon_reason->name, 163, 1, null));
                return response()->json([
                    'message' => 'تم إلغاء قبول سبب مساعدة بنجاح',
                ], 200);
            } else {
                $coupon_reason->update(['status' => 1]);
                event(new NewLogCreated('تم قبول سبب مساعدة بنجاح', $coupon_reason->name, 163, 1, null));
                return response()->json([
                    'message' => 'تم قبول سبب مساعدة بنجاح',
                ], 200);
            }

        } else {

            event(new NewLogCreated('المحاولة للوصول لسبب مساعدة غير موجود برقم : ', $id, 163, 1, null));
            return response()->json([
                'message' => 'المحاولة للوصول لسبب مساعدة غير موجود',
            ], 401);
        }
    }
}
