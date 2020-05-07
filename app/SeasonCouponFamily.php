<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SeasonCouponFamily extends Model
{
    protected $guarded = [];
    protected $table = 'season_coupon_family';

    public function family()
    {
        return $this->belongsTo(Family::class);
    }

    public function season_coupon()
    {
        return $this->belongsTo(SeasonCoupon::class);
    }
}
