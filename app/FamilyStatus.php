<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class RecipientStatus
 * @package App
 */
class FamilyStatus extends Model
{
    use SoftDeletes;
    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function family()
    {
        return $this->hasMany(Family::class);
    }
}
