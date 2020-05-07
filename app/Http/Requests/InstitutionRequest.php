<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InstitutionRequest extends FormRequest
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

    public function rules()
    {
        $valid = [
            'institution_type_id' => 'required|numeric|digits_between:1,3',
            'address' => 'required|max:155',
            'licensor_number'=>'nullable|numeric|digits_between:3,15',
            'licensor_id' => 'required|numeric|digits_between:1,3',
            'responsible_person' => 'required|max:155',
            'city_id' => 'required|numeric|digits_between:1,3',
            'governorate_id' => 'required|numeric|digits_between:1,3',
            'neighborhood_id' => 'required|numeric|digits_between:1,3',
            'target_types_ids' => 'required',
        ];
        if ($this->isMethod('post')) {

            $valid ['name'] = 'required|max:155|unique:institutions,name,NULL,id,deleted_at,NULL';

        } elseif ($this->isMethod('put') || $this->isMethod('patch')) {
            $id = $this->route('institution');

            $valid ['name'] = 'required|max:155|unique:institutions,name,' . $id . ',id,deleted_at,NULL';
        }

        $valid['mobile_one'] = 'nullable|numeric|digits_between:8,9';
        if (request()->mobile_two)
            $valid['mobile_two'] = 'numeric|digits_between:8,9';
        if (request()->mobile)
            $valid['mobile'] = 'numeric|digits_between:7,8';

        return $valid;
    }
}