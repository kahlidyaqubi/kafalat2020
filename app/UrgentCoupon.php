<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UrgentCoupon extends Model
{
    protected $guarded = [];

    public function institution()
    {
        return $this->belongsTo(Institution::class);
    }

    public function urgent_coupon_media()
    {
        return $this->hasMany(UrgentCouponMedia::class);
    }

    public function family()
    {
        return $this->belongsTo(Family::class);
    }

    public function coupon_reason()
    {
        return $this->belongsTo(CouponReason::class);
    }

    public function sponsor()
    {
        return $this->belongsTo(Sponsor::class);
    }

    public function coupon_item_types()
    {
        return $this->hasMany(CouponItemType::class);
    }

    public function item_types()
    {
        return $this->belongsToMany(ItemType::class, CouponItemType::class);
    }

    public function admin_status()
    {
        return $this->belongsTo(AdminStatuse::class);
    }

    public function amount_currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

}
