<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LogCategory
 * @package App
 */
class LogCategory extends Model
{
    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function logs()
    {
        return $this->hasMany(Log::class);
    }
}
