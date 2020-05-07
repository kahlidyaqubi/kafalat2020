<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SeasonCouponRequest extends FormRequest
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
                'application_date' => 'required|date',
                'execution_date' => 'required|date',
                'coupon_type' => 'required|numeric|digits_between:1,3',
                'admin_status_id' => 'required|numeric|digits_between:1,3',
                'season_id' => 'required|numeric|digits_between:1,3',
                'coupon_reason_id' => 'required|numeric|digits_between:1,3',
                'amount_curacy_id' => 'required|numeric|digits_between:1,3',
                'amount' => 'required|numeric',
            ];
        else
            return [
                'delivery_status' => 'required|max:30',
                'application_date' => 'required|date',
                'execution_date' => 'required|date',
                'coupon_reason_id' => 'numeric',
                'admin_status_id' => 'required|numeric|digits_between:1,3',
                'season_id' => 'required|numeric|digits_between:1,3',
                'coupon_reason_id' => 'required|numeric|digits_between:1,3',
                'amount_curacy_id' => 'required|numeric|digits_between:1,3',
                'amount' => 'required|numeric',
            ];
    }
}