<?php

namespace App\Http\Controllers\Admin;

use App\Currency;
use App\ExpenseAmount;
use App\FundedInstitution;
use App\Http\Requests\ExpenseAmountRequest;
use App\Month;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Action;
use Notification;
use App\Notifications\NotifyUsers;
use Spatie\Permission\Models\Permission;

class ExpenseAmountController extends Controller
{

    public function index(Request $request)
    {
        $from_date = $request['from_date'] ?? "2001-1";
        $to_date = $request['to_date'] ?? "2050-12";
        $funded_institution_ids = $request['funded_institution_ids'] ? array_filter($request['funded_institution_ids']) : [];

        $expense_amounts = ExpenseAmount::when($from_date && $to_date, function ($query) use ($to_date, $from_date) {
            return $query->whereBetween(DB::raw("CONVERT(CONCAT(`year`, '-', `month_id`,'-','1'),date)"), [$from_date . "-1", $to_date . "-2"]);
        })->when($funded_institution_ids, function ($query) use ($funded_institution_ids) {
            return $query->whereIn('funded_institution_id', $funded_institution_ids);
        })->orderBy("expense_amounts.id",'desc')->paginate(20)
            ->appends([
                "funded_institution_id" => $funded_institution_ids, "from_date" => $from_date,
                "to_date" => $to_date]);

        $funded_institutions = FundedInstitution::orderBy('name')->where('status', 1)->get();

        return view('admin.expenseAmount.index', compact('expense_amounts', 'funded_institutions', 'funded_institution_ids',
            'from_date', 'to_date'));
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
        $currencies = Currency::orderBy('name')->get();
        return view('admin.expenseAmount.create', compact('funded_institutions', 'months', 'currencies'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(ExpenseAmountRequest $request)
    {
        $currency_id = $request['currency_id'] ?? 0;;
        $year = $request['year'];
        $month_id = $request['month_id'];
        $amount = $request['amount'] ?? 0;;
        $discount = $request['discount'] ?? 0;;
        $funded_institution_ids = $request['funded_institution_ids'] ? array_filter($request['funded_institution_ids']) : [];

        DB::beginTransaction();
        foreach ($funded_institution_ids as $funded_institution) {
            $expense_amount = ExpenseAmount::where('year', $year)
                ->where('month_id', $month_id)
                ->where('funded_institution_id', $funded_institution)->first();

            if ($expense_amount) {
                DB::rollback();
                return back()->with('error', "" . FundedInstitution::find($funded_institution)->name . " يوجد لها سعر صرف في شهر $month_id / $year لم يتم الإضافة لأن الجهة")->withInput(request()->all);
            } else {
                DB::table('expense_amounts')->insert([
                    'amount' => $amount,
                    'discount' => $discount,
                    'currency_id' => $currency_id,
                    'year' => $year,
                    'month_id' => $month_id,
                    'funded_institution_id' => $funded_institution,
                ]);
            }
        }
        DB::commit();
        $action = Action::create(['title' => 'تم إضافة مبلغ صرف جديد', 'type' => Permission::findByName('list expenseAmounts')->title, 'link' => Permission::findByName('list expenseAmounts')->link]);
        $users = User::permission('expenseAmounts')->whereNotIn('id', [auth()->user()->id])->get();
        if ($users->first())
            Notification::send($users, new NotifyUsers($action));
        return redirect('admin/expense_amounts')->with('success', 'تم إضافة مبلغ صرف بنجاح');

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
        $expense_amount = ExpenseAmount::find($id);
        $funded_institutions = FundedInstitution::orderBy('name')->where('status', 1)->get();
        $months = Month::all();
        $currencies = Currency::orderBy('name')->get();
        if ($expense_amount) {
            return view('admin.expenseAmount.edit', compact('funded_institutions', 'expense_amount', 'months', 'currencies'));
        } else {
            return redirect("/admin/expense_amounts")->with('error', 'الرابط الذي تحاول الوصول له غير صحيح');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $currency_id = $request['currency_id'];
        $amount = $request['amount'];
        $discount = $request['discount'];

        $expense_amount = ExpenseAmount::find($id);

        if ($expense_amount) {
            $expense_amount->update([
                    'amount' => $amount,
                    'discount' => $discount,
                    'currency_id' => $currency_id,
                ]
            );

            $action = Action::create(['title' => 'تم تعديل مبلغ صرف', 'type' => Permission::findByName('list expenseAmounts')->title, 'link' => Permission::findByName('list expenseAmounts')->link]);
            $users = User::permission('expenseAmounts')->whereNotIn('id', [auth()->user()->id])->get();
            if ($users->first())
                Notification::send($users, new NotifyUsers($action));
            return redirect('admin/expense_amounts')->with('success', 'تم تعديل مبلغ صرف بنجاح');


        } else {
            return redirect("/admin/expense_amounts")->with('error', 'الرابط الذي تحاول الوصول له غير صحيح');
        }
    }

    public function delete($id)
    {
        $expense_amount = ExpenseAmount::find($id);
        if ($expense_amount) {
            $expense_amount->delete();
            $action = Action::create(['title' => 'تم حذف مبلغ صرف', 'type' => Permission::findByName('list expenseAmounts')->title, 'link' => Permission::findByName('list expenseAmounts')->link]);
            $users = User::permission('expenseAmounts')->whereNotIn('id', [auth()->user()->id])->get();
            if ($users->first())
                Notification::send($users, new NotifyUsers($action));
            return redirect("/admin/expense_amounts")->with('error', 'تم حذف مبلغ الصرف بنجاح');
        } else {
            return redirect("/admin/expense_amounts")->with('error', 'الرابط الذي تحاول الوصول له غير صحيح');
        }
    }

    public function delete_group(Request $request)
    {
        $ids = explode(",", $request['the_ids']);
        $expense_amount = ExpenseAmount::find($ids);
        if ($expense_amount->first()) {
            ExpenseAmount::destroy($ids);
            $action = Action::create(['title' => 'تم حذف مبلغ صرف', 'type' => Permission::findByName('list expenseAmounts')->title, 'link' => Permission::findByName('list expenseAmounts')->link]);
            $users = User::permission('expenseAmounts')->whereNotIn('id', [auth()->user()->id])->get();
            if ($users->first())
                Notification::send($users, new NotifyUsers($action));
            return redirect("/admin/expense_amounts")->with('error', 'تم حذف مبالغ الصرف بنجاح');
        } else {
            return redirect("/admin/expense_amounts")->with('error', 'لم يتم تحديد أي عنصر لحذفه');
        }
    }
}
