<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TargetType extends Model
{
	 protected $guarded = [];
    public function institutions()
    {
        return $this->belongsToMany(Institution::class);
    }

    public function institution_target_types()
    {
        return $this->hasMany(InstitutionTargetType::class);
    }
}
