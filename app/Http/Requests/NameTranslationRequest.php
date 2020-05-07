<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NameTranslationRequest extends FormRequest
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
                'arabic' => 'required|max:155|unique:name_translations,arabic,NULL,id,deleted_at,NULL',
                'turkey' => 'required|max:155',
                ];
        } elseif ($this->isMethod('put') || $this->isMethod('patch')) {
            $id = $this->route('nameTranslation');
           return [
                'arabic' => 'required|max:155|unique:name_translations,arabic,' . $id . ',id,deleted_at,NULL',
                'turkey' => 'required|max:155',
                ];
        }
    }
}
