<?php

namespace App\Http\Controllers\Admin;

use App\Call;
use App\Country;
use App\Events\NewLogCreated;
use App\Family;
use App\Http\Requests\CallRequest;
use App\Http\Controllers\Controller;
use App\Person;
use App\Sponsor;
use App\User;
use Illuminate\Http\Request;
use DB;
use App\Action;
use Notification;
use App\Notifications\NotifyUsers;
use Spatie\Permission\Models\Permission;

class CallController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //dd($request->all());
        $reason = $request["reason"] ?? "";
        $min_id = Call::first()->id ?? 1;
        $max_id = Call::orderByDesc('id')->first()->id ?? 1;
        $from_id = $request["from_id"] ?? $min_id;
        $to_id = $request["to_id"] ?? $max_id;
        $status = $request["status"] ?? "";
        $family_ids = $request["family_ids"] ? array_filter($request["family_ids"]) : [];
        $sponsor_ids = $request["sponsor_ids"] ? array_filter($request["sponsor_ids"]) : [];
        $coulmn = $request["coulmn"] ?? "";
        $from_date = $request["from_date"] ?? "";
        $to_date = $request["to_date"] ?? "";


        $calls = Call::when($family_ids, function ($query) use ($family_ids) {
            return $query->whereIn('family_id', $family_ids);
        })->when($reason, function ($query) use ($reason) {
            return $query->where('reason', $reason);
        })->when($sponsor_ids, function ($query) use ($sponsor_ids) {
            return $query->where('sponsor_id', $sponsor_ids);
        })->when(($status || $status == '0'), function ($query) use ($status) {
            return $query->where('status', $status);
        })->when($from_id && $to_id, function ($query) use ($from_id, $to_id) {
            return $query->whereBetween('id', [$from_id,$to_id ]);
        })->when($from_date && $to_date, function ($query) use ($from_date, $to_date) {
            return $query->whereBetween('his_date', [$from_date, $to_date]);
        })->orderBy("calls.id","desc")->paginate(20)
            ->appends(["from_id" => $from_id, "to_id" => $to_id, "coulmn" => $coulmn
                , "status" => $status, "family_ids" => $family_ids
                , "sponsor_ids" => $sponsor_ids
                , "from_date" => $from_date
                , "to_date" => $to_date]);

        if ($request["coulmn"] == []) {
            $coulmn = ['id', 'family', 'sponsor', 'status', 'his_date', 'operations'];
        }

        return view('admin.call.index', compact('calls', 'status', 'sponsor_ids',
            'coulmn', 'from_id', 'to_id', 'family_ids',
            'from_date', 'to_date', 'min_id', 'max_id', 'reason'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries = Country::whereNotNull('code')->orderBy('name')->get();
        return view('admin.call.create', compact('countries'));

    }

    public function store(CallRequest $request)
    {
        $request['created_by'] = auth()->user()->id;

        $calls = Call::create($request->except(['family_mobile', 'sponsor_mobile', 'code']));
        $family = Family::find($request['family_id']);

        if ($family->mobile_two != $request['family_mobile'] && $family->mobile_one != $request['family_mobile']) {
            if (!$family->mobile_one) {
                $family->update(['mobile_one' => $request['family_mobile']]);
            } else {
                $family->update(['mobile_two' => $request['family_mobile']]);
            }
        }


        Sponsor::find($request['sponsor_id'])->update(['mobile' => $request['sponsor_mobile'], 'country_id' => Country::where('code', $request['code'])->first()->id]);


        $message = 'تم إضافة الاتصال بنجاح';

        event(new NewLogCreated($message, $request['name'], 7, 1, url('admin/calls/' . $calls->id . '/edit')));

        $action = Action::create(['title' => 'تم إضافة اتصال جديد', 'type' => Permission::findByName('list calls')->title, 'link' => Permission::findByName('list calls')->link]);
        $users = User::permission('calls')->whereNotIn('id', [auth()->user()->id])->get();
        if ($users->first())
            Notification::send($users, new NotifyUsers($action));

        return redirect('admin/calls')->with('success', $message);


    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $call = Call::find($id);
        $countries = Country::whereNotNull('code')->orderBy('name')->get();
        if ($call) {
            return view('admin.call.show', compact('call', 'countries'));
        } else {
            event(new NewLogCreated('المحاوله للوصول لاتصال غير موجود برقم : ', $id, 8, 0, null));
            return redirect("/admin/calls")->with('error', 'الاتصال غير موجود');
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
        $call = Call::find($id);
        $countries = Country::whereNotNull('code')->orderBy('name')->get();
        if ($call) {
            return view('admin.call.edit', compact('call', 'countries'));
        } else {
            event(new NewLogCreated('المحاوله للوصول لاتصال غير موجود برقم : ', $id, 8, 0, null));
            return redirect("/admin/calls")->with('error', 'الاتصال غير موجود');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(CallRequest $request, $id)
    {
        $call = Call::find($id);
        $request['updated_by'] = auth()->user()->id;
        if ($call) {
            $call->update($request->except(['family_mobile', 'sponsor_mobile', 'code']));
            $family = Family::find($request['family_id']);

            if ($family->mobile_two != $request['family_mobile'] && $family->mobile_one != $request['family_mobile']) {
                if (!$family->mobile_one) {
                    $family->update(['mobile_one' => $request['family_mobile']]);
                } else {
                    $family->update(['mobile_two' => $request['family_mobile']]);
                }
            }


            Sponsor::find($request['sponsor_id'])->update(['mobile' => $request['sponsor_mobile'], 'country_id' => Country::where('code', $request['code'])->first()->id]);


            event(new NewLogCreated('تم تعديل اتصال بنجاح ', $id, 8, 0, null));

            $action = Action::create(['title' => 'تم تعديل اتصال', 'type' => Permission::findByName('list calls')->title, 'link' => Permission::findByName('list calls')->link]);
            $users = User::permission('calls')->whereNotIn('id', [auth()->user()->id])->get();
            if ($users->first())
                Notification::send($users, new NotifyUsers($action));

            return redirect('admin/calls')->with('success', 'تم تعديل اتصال بنجاح');
        } else {
            event(new NewLogCreated('المحاوله للوصول لاتصال غير موجود برقم : ', $id, 8, 0, null));
            return redirect("/admin/calls")->with('error', 'الاتصال غير موجود');
        }
    }

    public function delete($id)
    {
        $call = Call::find($id);

        if ($call) {
            $call->delete();
            event(new NewLogCreated('تم حذف اتصال بنجاح ', $id, 9, 0, null));


            $action = Action::create(['title' => 'تم حذف اتصال', 'type' => Permission::findByName('list calls')->title, 'link' => Permission::findByName('list calls')->link]);
            $users = User::permission('calls')->whereNotIn('id', [auth()->user()->id])->get();
            if ($users->first())
                Notification::send($users, new NotifyUsers($action));
            return redirect('admin/calls')->with('success', 'تم حذف اتصال بنجاح');
        } else {
            event(new NewLogCreated('المحاوله للوصول لاتصال غير موجود برقم : ', $id, 9, 0, null));
            return redirect("/admin/calls")->with('error', 'الاتصال غير موجود');
        }
    }
}
