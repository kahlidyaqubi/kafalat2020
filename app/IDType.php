<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class IdType
 * @package App
 */
class IDType extends Model
{
    use SoftDeletes;
    protected $table = 'id_types';

    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function person()
    {
        return $this->hasMany(Person::class,'id_type_id','id');
    }

}
