<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InstitutionTargetType extends Model
{
	 protected $guarded = [];
    public function target_types()
    {
        return $this->belongsTo(TargetType::class);
    }

    public function institution()
    {
        return $this->belongsTo(Institution::class);
    }
}
