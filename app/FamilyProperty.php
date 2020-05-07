<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class RecipientProperty
 * @package App
 */
class FamilyProperty extends Model
{
    /**
     * @var string
     */
    protected $table = "recipient_property";

    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function recipient()
    {
        return $this->belongsTo(Family::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}
