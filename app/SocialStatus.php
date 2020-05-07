<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class SocialStatus
 * @package App
 */
class SocialStatus extends Model
{
    /**
     * @var string
     */
    protected $table = "social_statuses";
    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->hasMany(User::Class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function person()
    {
        return $this->hasMany(Person::class);
    }
}
