<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SeasonCoupon extends Model
{
    protected $guarded = [];

    public function institution()
    {
        return $this->belongsTo(Institution::class);
    }

    public function family()
    {
        return $this->belongsTo(Family::class);
    }

    public function season_coupon_media()
    {
        return $this->hasMany(SeasonCouponMedia::class);
    }

    public function season()
    {
        return $this->belongsTo(Season::class);
    }

    public function coupon_item_types()
    {
        return $this->hasMany(CouponItemType::class);
    }

    public function coupon_reason()
    {
        return $this->belongsTo(CouponReason::class);
    }

    public function item_types()
    {
        return $this->belongsToMany(ItemType::class, CouponItemType::class);
    }

    public function season_coupon_families()
    {
        return $this->hasMany(SeasonCouponFamily::class);
    }

    public function families()
    {
        return $this->belongsToMany(Family::class, SeasonCouponFamily::class);
    }

    public function admin_status()
    {
        return $this->belongsTo(AdminStatuse::class);
    }

    public function amount_currency()
    {
        return $this->belongsTo(Currency::class, 'amount_curacy_id');
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }
}
