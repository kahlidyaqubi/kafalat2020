<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InstitutionType extends Model
{
	 protected $guarded = [];
    public function institutions()
    {
        return $this->hasMany(Institution::class);
    }
}
