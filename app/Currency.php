<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Currency
 * @package App
 */
class Currency extends Model
{
    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function expense_details()
    {
        return $this->hasMany(ExpenseDetail::class);
    }
}
