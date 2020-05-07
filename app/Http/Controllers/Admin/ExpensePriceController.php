<?php

namespace App\Http\Controllers\Admin;

use App\ExpensePrice;
use App\FundedInstitution;
use App\Http\Requests\ExpensePriceRequest;
use App\Month;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DataTables;
use DB;
use App\Action;
use Notification;
use App\Notifications\NotifyUsers;
use Spatie\Permission\Models\Permission;

class ExpensePriceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $from_date = $request['from_date'] ?? "2001-1";
        $to_date = $request['to_date'] ?? "2050-12";
        $funded_institution_ids = $request['funded_institution_ids'] ? array_filter($request['funded_institution_ids']) : [];

        $expense_prices = ExpensePrice::when($from_date && $to_date, function ($query) use ($to_date, $from_date) {
            return $query->whereBetween(DB::raw("CONVERT(CONCAT(`year`, '-', `month_id`,'-','1'),date)"), [$from_date . "-1", $to_date . "-2"]);
        })->when($funded_institution_ids, function ($query) use ($funded_institution_ids) {
            return $query->whereIn('funded_institution_id', $funded_institution_ids);
        })->orderBy("expense_prices.id",'desc')->paginate(20)
            ->appends([
                "funded_institution_id" => $funded_institution_ids, "from_date" => $from_date,
                "to_date" => $to_date]);

        $funded_institutions = FundedInstitution::orderBy('name')->where('status', 1)->get();

        return view('admin.expensePrice.index', compact('expense_prices', 'funded_institutions', 'funded_institution_ids',
            'from_date', 'to_date'));
        /*
                //funded_institution_id
                ->whereBetween(DB::raw("CONCAT(`year`, '-', `month_id`)"), [$from_date, $to_date]);
                //SELECT * FROM `expense_prices` WHERE CONCAT(`year`, '-', `month_id`) BETWEEN '2017-1' AND '2017-12'
                $funded_institutions = FundedInstitution::orderBy('name')->where('status',1)->get();
                return view('admin.expensePrice.index', compact('funded_institutions'));
        */
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $funded_institutions = FundedInstitution::orderBy('name')->where('status', 1)->get();
        $months = Month::all();
        return view('admin.expensePrice.create', compact('funded_institutions', 'months'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(ExpensePriceRequest $request)
    {

        $euro_nis = $request['euro_nis'] ?? 0;
        $euro_usd = $request['euro_usd'] ?? 0;
        $usd_nis = $request['usd_nis'] ?? 0;
        $year = $request['year'];
        $month_id = $request['month_id'];
        $funded_institution_ids = $request['funded_institution_ids'] ? array_filter($request['funded_institution_ids']) : [];

        DB::beginTransaction();
        foreach ($funded_institution_ids as $funded_institution) {
            $expense_price = ExpensePrice::where('year', $year)
                ->where('month_id', $month_id)
                ->where('funded_institution_id', $funded_institution)->first();

            if ($expense_price) {
                DB::rollback();
                return back()->with('error', "" . FundedInstitution::find($funded_institution)->name . " يوجد لها سعر صرف في شهر  / $year لم يتم الإضافة لأن الجهة")->withInput(request()->all);
            } else {
                DB::table('expense_prices')->insert([
                    'euro_usd' => $euro_usd,
                    'usd_nis' => $usd_nis,
                    'euro_nis' => $euro_nis,
                    'year' => $year,
                    'month_id' => $month_id,
                    'funded_institution_id' => $funded_institution,
                ]);
            }
        }
        DB::commit();
        $action = Action::create(['title' => 'تم إضافة سعر صرف جديد', 'type' => Permission::findByName('list expensePrices')->title, 'link' => Permission::findByName('list expensePrices')->link]);
        $users = User::permission('expensePrices')->whereNotIn('id', [auth()->user()->id])->get();
        if ($users->first())
            Notification::send($users, new NotifyUsers($action));
        return redirect('admin/expense_prices/create')->with('success', 'تم إضافة اسعار صرف بنجاح');

    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $expense_price = ExpensePrice::find($id);
        $funded_institutions = FundedInstitution::orderBy('name')->where('status', 1)->get();
        $months = Month::all();

        if ($expense_price) {
            return view('admin.expensePrice.edit', compact('funded_institutions', 'expense_price', 'months'));
        } else {
            return redirect("/admin/expense_prices")->with('error', 'الرابط الذي تحاول الوصول له غير صحيح');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(ExpensePriceRequest $request, $id)
    {
        $euro_nis = $request['euro_nis'];
        $euro_usd = $request['euro_usd'];
        $usd_nis = $request['usd_nis'];

        $expense_price = ExpensePrice::find($id);

        if ($expense_price) {

            $expense_price->update([
                    'euro_usd' => $euro_usd,
                    'usd_nis' => $usd_nis,
                    'euro_nis' => $euro_nis,
                ]
            );

            $action = Action::create(['title' => 'تم تعديل سعر صرف', 'type' => Permission::findByName('list expensePrices')->title, 'link' => Permission::findByName('list expensePrices')->link]);
            $users = User::permission('expensePrices')->whereNotIn('id', [auth()->user()->id])->get();
            if ($users->first())
                Notification::send($users, new NotifyUsers($action));
            return redirect('admin/expense_prices')->with('success', 'تم تعديل سعر صرف بنجاح');


        } else {
            return redirect("/admin/expense_prices")->with('error', 'الرابط الذي تحاول الوصول له غير صحيح');
        }
    }

    public function delete($id)
    {
        $expense_price = ExpensePrice::find($id);
        if ($expense_price) {
            $expense_price->delete();
            $action = Action::create(['title' => 'تم حذف سعر صرف', 'type' => Permission::findByName('list expensePrices')->title, 'link' => Permission::findByName('list expensePrices')->link]);
            $users = User::permission('expensePrices')->whereNotIn('id', [auth()->user()->id])->get();
            if ($users->first())
                Notification::send($users, new NotifyUsers($action));
            return redirect("/admin/expense_prices")->with('error', 'تم حذف سعر الصرف بنجاح');
        } else {
            return redirect("/admin/expense_prices")->with('error', 'الرابط الذي تحاول الوصول له غير صحيح');
        }
    }

    public function delete_group(Request $request)
    {
        $ids = explode(",", $request['the_ids']);
        $expense_price = ExpensePrice::find($ids);
        if ($expense_price->first()) {
            ExpensePrice::destroy($ids);
            $action = Action::create(['title' => 'تم حذف أسعار صرف', 'type' => Permission::findByName('list expensePrices')->title, 'link' => Permission::findByName('list expensePrices')->link]);
            $users = User::permission('expensePrices')->whereNotIn('id', [auth()->user()->id])->get();
            if ($users->first())
                Notification::send($users, new NotifyUsers($action));
            return redirect("/admin/expense_prices")->with('error', 'تم حذف اسعار الصرف بنجاح');
        } else {
            return redirect("/admin/expense_prices")->with('error', 'لم يتم تحديد أي عنصر لحذفه');
        }
    }
}
