<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExpenseAmountRequest extends FormRequest
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

        if ($this->isMethod('post')) {
            return [
                'year' => 'required|numeric',
                'amount' => 'required|numeric',
                'discount' => 'numeric',
                'currency_id' => 'required|numeric|digits_between:1,3',
                'usd_nis' => 'numeric',
                'funded_institution_ids' => 'required|required',
                'month_id' => 'required|numeric|digits_between:1,3',
                //'funded_institution_id' => 'required|numeric|digits_between:1,3',
            ];
        } elseif ($this->isMethod('put') || $this->isMethod('patch')) {
            return [
                'amount' => 'required|numeric',
                'discount' => 'numeric',
                'currency_id' => 'required|numeric|digits_between:1,3',
            ];
        }
    }
}
