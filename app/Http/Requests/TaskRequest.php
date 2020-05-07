<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskRequest extends FormRequest
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
        $valid = [
            'title' => 'required|max:155',
            'nots'=> 'required|max:1000',
            'user_id' => 'required|numeric|digits_between:1,3',
            'from_date' => 'required|date',
            'to_date' => 'required|date',
        ];
        if (request()->type == 1)
            $valid['families_yes'] = 'required';
        elseif (request()->type == 2)
            $valid['expense_date'] = 'required|date';
        elseif (request()->type == 3) {
            $valid['project_id'] = 'required|numeric|digits_between:1,3';
        }

        return $valid;
    }
}