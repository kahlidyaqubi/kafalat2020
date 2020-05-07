<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Person
 * @package App
 */
class Person extends Model
{
    /**
     * @var string
     */
    protected $table = 'persons';
    /**
     * @var array
     */
    protected $guarded = [];



    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function diseases()
    {
        return $this->hasMany(FamilyMemberDiseases::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function qualification()
    {
        return $this->belongsTo(Qualification::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function qualificationLevel()
    {
        return $this->belongsTo(QualificationLevels::class, 'qualification_level_id', 'id');
    }

    public function member()
    {
        return $this->hasOne(Member::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function social_status()
    {
        return $this->belongsTo(SocialStatus::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function family()
    {
        return $this->hasMany(Family::class);
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function birthPlace()
    {
        return $this->belongsTo(Country::class, 'date_of_birth_place', 'id');
    }
}
