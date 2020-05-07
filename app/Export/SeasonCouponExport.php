<?php

namespace App\Export;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class SeasonCouponExport implements FromView
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
        return view('admin.season_coupon.printall', [
            'items' => $items,
            'coulmn' => $coulmn
        ]);
    }
}
