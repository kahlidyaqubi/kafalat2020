<?php

namespace App\Export;

use App\Expense;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExpenseExport implements FromCollection//,WithHeadings
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
     //
    public $the_collection;
    public function __construct($the_collection)
    {
        $this->the_collection = $the_collection;
    }
    /*public function headings(): array
    {
        return [
            '#',
            'الاسم الأول',
            'اسم الأب','اسم الجد','العائلة','رقم الهوية','المحافظة','المنطقة','الشارع','الهاتف'
        ];
    }*/
    public function collection()
    {
        return $this->the_collection;
    }
}
