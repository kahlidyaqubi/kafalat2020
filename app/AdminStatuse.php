<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdminStatuse extends Model
{
	 protected $guarded = [];
    public function season_coupons()
    {
        return $this->hasMany(SeasonCoupon::class);
    }

    public function urgent_coupons()
    {
        return $this->hasMany(UrgentCoupon::class);
    }
}
