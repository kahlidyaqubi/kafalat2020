<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ExpenseDetail
 * @package App
 */
class ExpenseDetail extends Model
{
    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function expense()
    {
        return $this->belongsTo(Expense::class);
    }

    public function family()
    {
        return $this->belongsTo(Family::class);
    }

    public function funded_institution()
    {
        return $this->belongsTo(FundedInstitution::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function sponsors()
    {
        return $this->belongsToMany(Sponsor::class , 'expense_detail_sponsors');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function expense_detail_sponsors()
    {
        return $this->hasMany(ExpenseDetailSponsor::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function months()
    {
        return $this->belongsToMany(Month::class);
    }
    public function expense_detail_months()
    {
        return $this->hasMany(ExpenseDetailMonth::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }
}
