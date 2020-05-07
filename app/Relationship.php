<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Relationship
 * @package App
 */
class Relationship extends Model
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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function member()
    {
        return $this->hasMany(Member::class);
    }

    //للعميل
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function family()
    {
        return $this->hasMany(Family::class,'breadwinner_id','id');
    }

     //للوكيل
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function representative_relationships()
    {
        return $this->hasMany(Family::class,'representative_relationship_id','id');
    }


}
