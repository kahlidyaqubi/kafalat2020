<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemType extends Model
{
	 protected $guarded = [];
    public function coupon_item_types()
    {
        return $this->hasMany(CouponItemType::class);
    }

    public function urgent_coupons()
    {
        return $this->belongsToMany(UrgentCoupon::class);
    }

    public function item_category()
    {
        return $this->belongsTo(ItemCategory::class);
    }
}
