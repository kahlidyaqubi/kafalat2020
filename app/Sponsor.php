<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Sponsor
 * @package App
 */
class Sponsor extends Model
{
    /**
     * @var array
     */
    protected $guarded = [];


    public function calls()
    {
        return $this->hasMany(Call::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sponsor_status()
    {
        return $this->belongsTo(SponsorStatus::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function expense_details()
    {
        return $this->belongsToMany(ExpenseDetail::class, 'expense_detail_sponsors');
    }

    /*public function families()
    {
        return $this->belongsToMany(Family::class, 'expense_details');
    }*/

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */

    public function expense_detail_sponsors()
    {
        return $this->hasMany(ExpenseDetailSponsor::class);
    }

    public function urgent_coupons()
    {
        return $this->hasMany(UrgentCoupon::class);
    }
}
