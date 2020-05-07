<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CouponItemType extends Model
{
	 protected $guarded = [];
    protected $table = 'coupon_item_type';
    public function urgent_coupon()
    {
        return $this->belongsTo(UrgentCoupon::class);
    }

    public function season_coupon()
    {
        return $this->belongsTo(SeasonCoupon::class);
    }

    public function item_type()
    {
        return $this->belongsTo(ItemType::class);
    }
}
