<?php

namespace App\Imports;


use App\Expense;
use Maatwebsite\Excel\Concerns\ToModel;

class IgnorImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Expense([
            //
        ]);
    }
}
