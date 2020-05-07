<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExpenseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'year'=>'required|numeric',
            'recive_date'=>'required|date',
            'mounth_count' => 'required|numeric|between:1,4',
            'family_project_id'=> 'required|numeric|between:1,2',
            'excel_file'=>'required',//|mimes:csv,xlsx,xls',
            //'month_id' => 'required|numeric|digits_between:1,3',
            //'funded_institution_id' => 'required|numeric|digits_between:1,3',
        ];
    }
}
