<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class FileType
 * @package App
 */
class FileType extends Model
{
    use SoftDeletes;

    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function family_media()
    {
        return $this->hasMany(FamilyMedia::class);
    }


public function institution_media()
    {
        return $this->hasMany(InstitutionMedia::class);
    }
    public function uesr_media()
    {
        return $this->hasMany(UserMedia::class);
    }
}
