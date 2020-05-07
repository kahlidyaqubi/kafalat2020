<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ExpenseDetailSponsor
 * @package App
 */
class ExpenseDetailSponsor extends Model
{
    /**
     * @var array
     */
    protected $table = 'expense_detail_sponsors';
    protected $guarded = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sponsor()
    {
        return $this->belongsTo(Sponsor::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function expense_detail()
    {
        return $this->belongsTo(ExpenseDetail::class);
    }
}
