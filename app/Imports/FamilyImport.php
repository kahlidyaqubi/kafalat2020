<?php

namespace App\Imports;

use App\Family;
use Maatwebsite\Excel\Concerns\ToModel;

class FamilyImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Family([
            //
        ]);
    }
}
