<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Property
 * @package App
 */
class Property extends Model
{
    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function recipients()
    {
        return $this->belongsToMany(Family::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function recipient_properties()
    {
        return $this->hasMany(FamilyProperty::class);
    }
}
