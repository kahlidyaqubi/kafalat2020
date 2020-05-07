<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Season extends Model
{
	 protected $guarded = [];
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
    public function season_coupons()
    {
        return $this->hasMany(SeasonCoupon::class);
    }
}
