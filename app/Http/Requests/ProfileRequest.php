<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProfileRequest extends FormRequest
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
            'mobile_one' => (int)ltrim((str_replace("-", "", request()['mobile_one'])), '0'),
            'mobile_two' => (int)ltrim((str_replace("-", "", request()['mobile_two'])), '0'),
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


//        return [
//            'user_name' =>Rule::unique('users')->ignore(auth()->user()->id()),
//        ];

        Validator::extend('without_spaces', function ($attr, $value) {
            return preg_match('/^\S*$/u', $value);
        });

        $id = Auth::user()->id;

       
        $valid= [
            'first_name' => 'nullable|max:30',
            'second_name' => 'nullable|max:30',
            'third_name' => 'nullable|max:30',
            'family_name' => 'nullable|max:30',
            'work_start_date' => 'nullable|date',
            'date_of_birth' => 'nullable|date',
            'address' => 'nullable|max:155',
            'governorate_id' => 'nullable|numeric|digits_between:1,3',
            'neighborhood_id' => 'nullable|numeric|digits_between:1,3',
            'university_specialty_id' => 'nullable|numeric|digits_between:1,3',
            'social_status_id' => 'nullable|numeric|digits_between:1,3',
            'user_name' => 'required|max:30|without_spaces|unique:users,id_number,' . $id. ',id,deleted_at,NULL',
            'email' => 'required|email|max:30|unique:users,email,' . $id . ',id,deleted_at,NULL',
            'id_number' => 'nullable|digits_between:9,9|numeric|unique:users,id_number,' . $id. ',id,deleted_at,NULL',

        ];
        
         if (request()->mobile_one)
        $valid['mobile_one'] = 'nullable|numeric|digits_between:8,9';
        if (request()->mobile_two)
            $valid['mobile_two'] = 'numeric|digits_between:8,9';
        if (request()->mobile)
            $valid['mobile'] = 'numeric|digits_between:7,8';

return $valid;
    
        
    }
}
