<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ExpensePrice
 * @package App
 */
class ExpensePrice extends Model
{
    /**
     * @var array
     */
    protected $guarded = [];

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
    public function month()
    {
        return $this->belongsTo(Month::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
   /* public function expenses()
    {
        return $this->hasMany(Expense::class);
    }*/

}
