<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CallRequest extends FormRequest
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

    protected function prepareForValidation()
    {
        $this->merge([
            'family_mobile' => (int)ltrim((str_replace("-", "", request()['family_mobile'])), '0'),
            'sponsor_mobile' => (int)ltrim((str_replace("-", "", request()['sponsor_mobile'])), '0'),
        ]);


    }


    public function rules()
    {
        return [
            'note' => 'required|max:1000',
            'code'=>'required',
            'reason' => 'required|max:155',
            'status' => 'required',
            'his_date' => 'required',
            'family_id' => 'required|numeric|digits_between:1,5',
            'sponsor_id' => 'required|numeric|digits_between:1,5',
            'family_mobile' => 'required|numeric|digits_between:8,9',
            'sponsor_mobile' => 'required|numeric|digits_between:8,15'
        ];
    }
}
