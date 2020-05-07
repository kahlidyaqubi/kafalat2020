<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Relationship
 * @package App
 */
class Immovable extends Model
{
    use SoftDeletes;

    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * @var array
     */
    protected $dates = ['deleted_at'];


    public function family()
    {
        return $this->hasMany(Family::class,'immovable_id','id');
    }




}
