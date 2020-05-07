<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class IncomeType
 * @package App
 */
class IncomeType extends Model
{
    use SoftDeletes;

    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function family_income()
    {
        return $this->hasMany(FamilyIncome::class);
    }
}
