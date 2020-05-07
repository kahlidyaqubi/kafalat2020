<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LicensorRequest extends FormRequest
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
        if ($this->isMethod('post')) {

            return [
                'name' => 'required|max:155|unique:licensors,name,NULL,id,deleted_at,NULL',
            ];
        } elseif ($this->isMethod('put') || $this->isMethod('patch')) {
            $id = $this->route('licensor');
            return [
                'name' => 'required|max:155|unique:licensors,name,' . $id . ',id,deleted_at,NULL',
            ];
        }
    }
}