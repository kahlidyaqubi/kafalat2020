<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FamilyIncome extends Model
{
    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function recipient()
    {
        return $this->belongsTo(Family::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function income_type()
    {
        return $this->belongsTo(IncomeType::class);
    }
}
