<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ItemCategoryRequest extends FormRequest
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
                'name' => 'required|max:155|unique:item_categories,name,NULL,id,deleted_at,NULL',
            ];
        } elseif ($this->isMethod('put') || $this->isMethod('patch')) {
            $id = $this->route('item_category');
            return [
                'name' => 'required|max:155|unique:item_categories,name,' . $id . ',id,deleted_at,NULL',
            ];
        }
    }
}