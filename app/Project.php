<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
	 protected $guarded = [];
    public function seasons()
    {
        return $this->hasMany(Season::class);
    }
}
