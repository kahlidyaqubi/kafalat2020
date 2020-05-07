<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class SponsorStatus
 * @package App
 */
class SponsorStatus extends Model
{
    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sponsors()
    {
        return $this->hasMany(Sponsor::class);
    }
}
