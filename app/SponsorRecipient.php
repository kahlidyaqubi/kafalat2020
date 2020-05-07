<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class SponsorRecipient
 * @package App
 */
class SponsorRecipient extends Model
{
    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sponsor()
    {
        return $this->belongsTo(Sponsor::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function recipient_parent()
    {
        return $this->belongsTo(Family::class, 'id', 'recipient_parent_id');

    }
}
