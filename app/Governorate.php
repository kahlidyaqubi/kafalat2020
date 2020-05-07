<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Governorate
 * @package App
 */
class Governorate extends Model
{
    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = "governorates";

    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function city()
    {
        return $this->hasMany(City::class);
    }

}
