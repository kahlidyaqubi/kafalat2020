<?php

namespace App\Http\Requests;


use App\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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

        // dd(request()->all());

        Validator::extend('without_spaces', function ($attr, $value) {
            return preg_match('/^\S*$/u', $value);
        });

        $valid = [
            'first_name' => 'required|max:30',
            'second_name' => 'required|max:30',
            'third_name' => 'required|max:30',
            'family_name' => 'required|max:30',
            'work_start_date' => 'required|date',
            'date_of_birth' => 'required|date',
            'address' => 'required|max:155',
            'city_id' => 'required|numeric|digits_between:1,3',
            'governorate_id' => 'required|numeric|digits_between:1,3',
            'neighborhood_id' => 'required|numeric|digits_between:1,3',
            'department_id' => 'required|numeric|digits_between:1,3',
            'social_status_id' => 'required|numeric|digits_between:1,3',
            'university_specialty_id' => 'required|numeric|digits_between:1,3',
        ];

        if ($this->isMethod('post')) {

            $valid['password'] = 'required|string|min:8|confirmed';

            $valid['user_name'] = 'required|max:30|without_spaces|unique:users,user_name,NULL,id,deleted_at,NULL';

            $valid['email'] = 'required|email|max:30|unique:users,email,NULL,id,deleted_at,NULL';

            $valid['id_number'] = 'required|digits_between:9,9|numeric|unique:users,id_number,NULL,id,deleted_at,NULL';

        }

        if ($this->isMethod('put') || $this->isMethod('patch')) {

            $id = $this->route('user');

            $valid['user_name'] = 'required|max:30|without_spaces|unique:users,user_name,' . $id . ',id,deleted_at,NULL';
            $valid['email'] = 'required|email|max:30|unique:users,email,' . $id . ',id,deleted_at,NULL';
            $valid['id_number'] = 'required|digits_between:9,9|numeric|unique:users,id_number,' . $id . ',id,deleted_at,NULL';
        }
        $valid['mobile_one'] = 'nullable|numeric|digits_between:8,9';
        if (request()->mobile_two)
            $valid['mobile_two'] = 'numeric|digits_between:8,9';
        if (request()->mobile)
            $valid['mobile'] = 'numeric|digits_between:7,8';

        return $valid;
    }
}

