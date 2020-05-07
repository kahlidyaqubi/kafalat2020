<?php

namespace App\Export;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class Expense2Export implements FromView
{
    private $coulmn;
    private $items;

    public function __construct($coulmn, $items)
    {
        $this->coulmn = $coulmn;
        $this->items = $items;
    }

    public function view(): View
    {
        $items = $this->items;
        $coulmn = $this->coulmn;
        return view('admin.expenses.printall', [
            'items' => $items,
            'coulmn' => $coulmn
        ]);
    }
}
