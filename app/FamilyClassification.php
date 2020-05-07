<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class RecipientClassification
 * @package App
 */
class FamilyClassification extends Model
{
    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function recipients()
    {
        return $this->hasMany(Family::class);
    }
}
