<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Call
 * @package App
 */
class Call extends Model
{

    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function family()
    {
        return $this->belongsTo(Family::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sponsor()
    {
        return $this->belongsTo(Sponsor::class);
    }

}
