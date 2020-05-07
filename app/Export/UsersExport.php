<?php

namespace App\Export;

use App\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Request;
use Maatwebsite\Excel\Concerns\FromView;

class UsersExport implements FromView
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
        return view('admin.users.printall', [
            'items' => $items,
            'coulmn' => $coulmn
        ]);
    }
}
