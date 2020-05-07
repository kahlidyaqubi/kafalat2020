<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ExpenseDetailMonth
 * @package App
 */
class ExpenseDetailMonth extends Model
{
    /**
     * @var array
     */
    protected $table = "expense_detail_month";
    protected $guarded = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function month()
    {
        return $this->belongsTo(Month::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function expense_detail()
    {
        return $this->belongsTo(ExpenseDetail::class);
    }
}
