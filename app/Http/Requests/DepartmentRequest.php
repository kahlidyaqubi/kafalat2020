<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DepartmentRequest extends FormRequest
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
                'name' => 'required|max:155|unique:departments,name,NULL,id,deleted_at,NULL',
            ];
        } elseif ($this->isMethod('put') || $this->isMethod('patch')) {
            $id = $this->route('department');
            return [
                'name' => 'required|max:155|unique:departments,name,' . $id . ',id,deleted_at,NULL',
            ];
        }

    }
}
