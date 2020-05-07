<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CouponReason extends Model
{
    protected $guarded = [];

    public function urgent_coupons()
    {
        return $this->hasMany(UrgentCoupon::class);
    }

    public function season_coupons()
    {
        return $this->hasMany(SeasonCoupon::class);
    }
}
