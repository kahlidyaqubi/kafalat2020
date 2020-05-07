<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * Class Family
 * @package App
 */
class Family extends Model
{
    use SoftDeletes;

    /**
     * @var array
     */
    protected $guarded = [];


//    /**
//     * @param $value
//     */


    /**
     * @param $value
     */
    public function setMobileOneAttribute($value)
    {

        $number = str_replace('-', "", $value);
        $this->attributes['mobile_one'] = '+970' . $number;
    }

    /**
     * @param $value
     */
    public function setMobileTwoAttribute($value)
    {
        $number = str_replace('-', "", $value);
        $this->attributes['mobile_two'] = '+970' . $number;
    }

    /**
     * @param $value
     * @return mixed
     */
    public function getMobileOneAttribute($value)
    {
        $number = $value;
        //return substr($number, 0, 3) . "-" . substr($number, 3, 3) . "-" . substr($number, 6, 3);
        return str_replace('+970', "", $value);
    }

    /**
     * @param $value
     * @return mixed
     */
    public function getMobileTwoAttribute($value)
    {
        $number = $value;
        // return substr($number, 0, 3) . "-" . substr($number, 3, 3) . "-" . substr($number, 6, 3);
        return str_replace('+970', "", $value);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function person()
    {
        return $this->belongsTo(Person::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function project()
    {
        return $this->belongsTo(FamilyProject::class, 'family_project_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function id_type()
    {
        return $this->belongsTo(IDType::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function first_name_tr()
    {
        return $this->belongsTo(NameTranslation::class, 'id', 'first_name_tr_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function second_name_tr()
    {
        return $this->belongsTo(NameTranslation::class, 'id', 'second_name_tr_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function third_name_tr()
    {
        return $this->belongsTo(NameTranslation::class, 'id', 'third_name_tr_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function family_name_tr()
    {
        return $this->belongsTo(NameTranslation::class, 'id', 'family_name_tr_id');
    }
    //صلة القرابة المعيل

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function relationship()
    {
        return $this->belongsTo(Relationship::class);
    }
    //صلة القرابة الوكيل

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function immovable()
    {
        return $this->belongsTo(Immovable::class);
    }


    public function representative_relationship()
    {
        return $this->belongsTo(Relationship::class, 'representative_relationship_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function representative()
    {
        return $this->belongsTo(Person::class, 'representative_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function representativeJobType()
    {
        return $this->belongsTo(JobType::class, 'representative_job_type_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function city()
    {
        return $this->belongsTo(City::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function house_ownership()
    {
        return $this->belongsTo(HouseOwnership::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function house_roof()
    {
        return $this->belongsTo(HouseRoof::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function house_status()
    {
        return $this->belongsTo(HouseStatus::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function classification()
    {
        return $this->belongsTo(FamilyClassification::class, 'family_classification_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function educational_institution()
    {
        return $this->belongsTo(EducationalInstitution::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function study_part()
    {
        return $this->belongsTo(StudyPart::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function study_type()
    {
        return $this->belongsTo(StudyType::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function study_level()
    {
        return $this->belongsTo(StudyLevel::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function university_specialty()
    {
        return $this->belongsTo(UniversitySpecialty::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function fundedInstitution()
    {
        return $this->belongsTo(FundedInstitution::class, 'funded_institution_id', 'id');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function searcher()
    {
        return $this->hasMany(FamilySearcher::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user_data_entry()
    {
        return $this->belongsTo(User::class, 'data_entry_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function status()
    {
        return $this->belongsTo(FamilyStatus::class, 'family_status_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function visit_reason()
    {
        return $this->belongsTo(VisitReason::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function job_type()
    {
        return $this->belongsTo(JobType::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function familyMemberDiseases()
    {
        return $this->hasMany(FamilyMemberDiseases::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function familyMemberDiseasesPerson($parson_id)
    {
        return $this->hasMany(FamilyMemberDiseases::class)->where(['person_id' => $parson_id]);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function members()
    {
        return $this->hasMany(Member::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function wives()
    {
        return $this->hasMany(Member::class)->whereIn('relationship_id', [27, 32, 33, 34]);
    }

    public function parent()
    {
        return $this->belongsTo(Family::class, 'parent_id');
    }

    public function childs()
    {
        return $this->hasMany(Family::class, 'parent_id');
    }


//    /**
//     * @return \Illuminate\Database\Eloquent\Relations\HasMany
//     */

    public function expense()
    {
        return $this->belongsTo(Expense::class);
    }

    public function expense_details()
    {
        return $this->hasMany(ExpenseDetail::class);
    }

    public function tasks()
    {
        return $this->belongsToMany(Task::class, TaskFamily::class);
    }

    public function task_families()
    {
        return $this->hasMany(TaskFamily::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function calls()
    {
        return $this->hasMany(Call::class);
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function properties()
    {
        return $this->belongsToMany(Property::class, 'family_property');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function recipient_properties()
    {
        return $this->hasMany(FamilyProperty::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function incomes()
    {
        return $this->hasMany(FamilyIncome::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function media()
    {
        return $this->hasMany(FamilyMedia::class);
    }



//    /**
//     * @return \Illuminate\Database\Eloquent\Relations\HasMany
//     */
//    public function logs()
//    {
//        return $this->hasMany(FamilyLog::class);
//    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
//    public function visits()
//    {
//        return $this->hasMany(FamilyLog::class)->whereIn('visit_reason_id', [1, 6]);
//    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function type()
    {
        return $this->belongsTo(FamilyType::class, 'family_type_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function breadwinner()
    {
        return $this->belongsTo(Relationship::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function governorate()
    {
        return $this->belongsTo(Governorate::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function neighborhood()
    {
        return $this->belongsTo(Neighborhood::class);
    }

    public function season_coupons_indirect()
    {
        return $this->belongsToMany(SeasonCoupon::class, SeasonCouponFamily::class);
    }

    public function season_coupons()
    {
        return $this->hasMany(SeasonCoupon::class);
    }

    public function season_coupon_families()
    {
        return $this->hasMany(SeasonCouponFamily::class);
    }

    public function urgent_coupons()
    {
        return $this->hasMany(UrgentCoupon::class);
    }

}
