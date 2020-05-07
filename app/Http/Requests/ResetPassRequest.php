<?php

namespace App\Http\Requests;


use App\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ResetPassRequest extends FormRequest
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
            'mobile' => (int)ltrim((str_replace("-", "", request()['mobile'])), '0'),
        ]);


    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        // dd(request()->all());

        Validator::extend('without_spaces', function ($attr, $value) {
            return preg_match('/^\S*$/u', $value);
        });

       return [
           'mobile' => 'required|numeric|digits_between:8,9',
        ];
    }
}

