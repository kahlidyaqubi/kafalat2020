<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class licensor extends Model
{
	 protected $guarded = [];
    public function institutions()
    {
        return $this->hasMany(Institution::class);
    }
}
