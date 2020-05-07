<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UrgentCouponRequest extends FormRequest
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
    public function rules()
    {
        if (request()['coupon_type'] == 2)
            return [
                'item_types_ids' => 'required',
                'item_types_numbers' => 'required',
                'item_types_values' => 'required',
                'delivery_status' => 'required|max:30',
                'his_date' => 'required|date',
                'coupon_type' => 'required|numeric|digits_between:1,3',
                'funder_type' => 'required|numeric|digits_between:1,3',
                'admin_status_id' => 'required|numeric|digits_between:1,3',
                'coupon_reason_id' => 'required|numeric|digits_between:1,3',
                'amount' => 'required|numeric',
                'amount_currency_id' => 'required|numeric|digits_between:1,3',
            ];
        else
            return [
                'delivery_status' => 'required|max:30',
                'his_date' => 'required|date',
                'coupon_type' => 'required|numeric|digits_between:1,3',
                'funder_type' => 'required|numeric|digits_between:1,3',
                'admin_status_id' => 'required|numeric|digits_between:1,3',
                'coupon_reason_id' => 'required|numeric|digits_between:1,3',
                'amount' => 'required|numeric',
                'amount_currency_id' => 'required|numeric|digits_between:1,3',
            ];

    }
}