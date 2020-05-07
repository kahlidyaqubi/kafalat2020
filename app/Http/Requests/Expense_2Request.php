<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Expense_2Request extends FormRequest
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
            'excel_file'=>'required',
            'old_name'=>'required',
            'has_months'=>'required|numeric|between:0,1',
            'family_project_id' => 'required|numeric|digits_between:1,4',
            'recive_date'=> 'required|date',
            'the_amount_in_index'=>'required|numeric|digits_between:1,2',
            'year' => 'required|numeric|digits_between:4,4',
            'months'=>'required',
            'funded_institutions'=>'required',
            'funded_institution_id_prices' => 'required',
            'funded_institution_id_amounts'=> 'required',
            'month_amounts'=>'required',
            'month_prices' => 'required',
            'currency_id' => 'required',
            'change_type' => 'required',
            'euro_nis'=> 'required',
            'euro_usd'=>'required',
            'usd_nis_ind' => 'required',
            'usd_nis' => 'required',
            'amount_befor'=> 'required',
            'discount'=> 'required',
        ];
    }
}
