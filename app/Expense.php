<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Expense
 * @package App
 */
class Expense extends Model
{
    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function families()
    {
        return $this->belongsToMany(Family::class);
    }

    public function expense_details()
    {
        return $this->hasMany(ExpenseDetail::class);
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    /* public function expense_price()
     {
         return $this->belongsTo(ExpensePrice::class);
     }*/

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function family_project()
    {
        return $this->belongsTo(FamilyProject::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function funded_institution()
    {
        return $this->belongsTo(FundedInstitution::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function recipient_project()
    {
        return $this->belongsTo(FamilyProject::class);
    }
}
