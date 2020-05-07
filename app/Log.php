<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Log
 * @package App
 */
class Log extends Model
{
    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function log_category()
    {
        return $this->belongsTo(LogCategory::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
