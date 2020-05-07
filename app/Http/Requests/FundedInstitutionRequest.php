<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FundedInstitutionRequest extends FormRequest
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

        if ($this->isMethod('put')||$this->isMethod('patch')) {
            $valid['name'] =  'required|max:155';
//            $valid['code'] =  'required|max:155';
//            $valid['type'] =  'required|max:155';

        }else{
            $valid['name'] =  'required|max:155';
//            $valid['code'] =  'required|max:155';
//            $valid['type'] =  'required|max:155';
//            $valid['logo'] =  'required';

        }

        return $valid;
    }
}
