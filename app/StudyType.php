<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class StudyType
 * @package App
 */
class StudyType extends Model
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
