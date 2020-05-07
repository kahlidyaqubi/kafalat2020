<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class StudyPart
 * @package App
 */
class StudyPart extends Model
{
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
    public function family()
    {
        return $this->hasMany(Family::class);
    }
}
