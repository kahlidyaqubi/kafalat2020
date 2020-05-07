<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Department
 * @package App
 */
class Department extends Model
{
    /**
     * @var string
     */
    protected $table = "departments";
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
}
