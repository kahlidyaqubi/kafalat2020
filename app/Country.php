<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Country
 * @package App
 */
class Country extends Model
{
    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = "countries";

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
    public function governorate()
    {
        return $this->hasMany(Governorate::class);
    }


    public function families()
    {
        return $this->hasMany(Family::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sponsor()
    {
        return $this->hasMany(Sponsor::class);
    }
}
