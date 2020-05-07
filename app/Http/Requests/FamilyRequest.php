<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FamilyRequest extends FormRequest
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
        return [
            'first_name' => 'required',
            'second_name' => 'required',
            'third_name' => 'required',
            'family_name' => 'required',
            'first_name_tr' => 'required',
            'second_name_tr' => 'required',
            'third_name_tr' => 'required',
            'family_name_tr' => 'required',
            'id_number' => 'required|digits_between:7,9|numeric',

//            'parent_id' => 'nullable|numeric|digits_between:1,3',
//            'recipient_project_id' => 'nullable|numeric|digits_between:1,3',
//            'id_type_id' => 'nullable|numeric|digits_between:1,3',
//            'first_name_tr_id' => 'nullable|numeric|digits_between:1,3',
//            'second_name_tr_id' => 'nullable|numeric|digits_between:1,3',
//            'third_name_tr_id' => 'nullable|numeric|digits_between:1,3',
//            'family_name_tr_id' => 'nullable|numeric|digits_between:1,3',
//            'relationship_id' => 'nullable|numeric|digits_between:1,3',
//            'qualification_id' => 'nullable|numeric|digits_between:1,3',
//            'social_status_id' => 'nullable|numeric|digits_between:1,3',
//            'house_ownership_id' => 'nullable|numeric|digits_between:1,3',
//            'house_roof_id' => 'nullable|numeric|digits_between:1,3',
//            'house_status_id' => 'nullable|numeric|digits_between:1,3',
//            'recipient_classification_id' => 'nullable|numeric|digits_between:1,3',
//            'recipient_status_id' => 'nullable|numeric|digits_between:1,3',
//            'study_type_id' => 'nullable|numeric|digits_between:1,3',
//            'study_part_id' => 'nullable|numeric|digits_between:1,3',
//            'educational_institution_id' => 'nullable|numeric|digits_between:1,3',
//            'university_specialty_id' => 'nullable|numeric|digits_between:1,3',
//            'study_level_id' => 'nullable|numeric|digits_between:1,3',
//            'representative_relationship_id' => 'nullable|numeric|digits_between:1,3',
//            'funded_institution_id' => 'nullable|numeric|digits_between:1,3',
//            'searcher_id' => 'nullable|numeric|digits_between:1,3',
//            'visit_reason_id' => 'nullable|numeric|digits_between:1,3',
//            'data_entry_id' => 'nullable|numeric|digits_between:1,3',
//            'job_type_id' => 'nullable|numeric|digits_between:1,3',
//            'city_id' => 'nullable|numeric|digits_between:1,3',
//            'id_number' => 'nullable|min:9|max:9|unique:users,id_number,NULL,id,deleted_at,NULL',
//            'id_university' => 'nullable|min:9|max:9|unique:users,id_number,NULL,id,deleted_at,NULL',
//            'representative_id' => 'nullable|min:9|max:9|unique:users,id_number,NULL,id,deleted_at,NULL',
//            'first_name' => 'nullable|max:155',
//            'second_name' => 'nullable|max:155',
//            'third_name' => 'nullable|max:155',
//            'family_name' => 'nullable|max:155',
//            'full_name_tr' => 'nullable|max:155',
//            'str_evaluate' => 'nullable|max:155',
//            'gender' => 'nullable|max:1',
//            'date_of_birth' => 'nullable|date',
//            'mobile_one' => 'nullable|numeric|digits_between:6,12',
//            'mobile_two' => 'nullable|numeric|digits_between:6,12',
//            'telephone' => 'nullable|numeric|digits_between:6,12',
//            'previous_income_coupon' => 'nullable|max:155',
//            'previous_income_value' => 'nullable|max:155',
//            'address' => 'nullable|max:155',
//            'address_tr' => 'nullable|max:155',
//            'representative_first_name' => 'nullable|max:155',
//            'representative_second_name' => 'nullable|max:155',
//            'representative_third_name' => 'nullable|max:155',
//            'representative_family_name' => 'nullable|max:155',
//            'father_death_reason' => 'nullable|max:155',
//            'representative_reason' => 'nullable|max:155',
//            'mother_death_reason' => 'nullable|max:155',
//            'note' => 'nullable|max:155',
//            'note_turkey' => 'nullable|max:155',
//            'code' => 'nullable|max:155',
//            'ignore_reason' => 'nullable|max:155',
//            'father_death_date' => 'nullable|date',
//            'mother_death_date' => 'nullable|date',
//            'ignore_date' => 'nullable|date',
//            'receiving_date' => 'nullable|date',
//            'visit_date' => 'nullable|date',
//            'room_number' => 'nullable|integer',
//            'graduated_date' => 'nullable|integer',
//            'study_price' => 'nullable|integer',
        ];
    }

}
