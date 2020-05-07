<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SeasonCouponMedia extends Model
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

    public function season_coupon()
    {
        return $this->belongsTo(SeasonCoupon::class);
    }


}

