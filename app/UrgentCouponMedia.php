<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UrgentCouponMedia extends Model
{
    /**
     * @var array
     */
    protected $guarded = [];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function fileType()
    {
        return $this->belongsTo(FileType::class);
    }

    public function urgent_coupon()
    {
        return $this->belongsTo(UrgentCoupon::class);
    }


}

