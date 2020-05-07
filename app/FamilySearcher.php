<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class FamilySearcher
 * @package App
 */
class FamilySearcher extends Model
{
    use SoftDeletes;
    /**
     * @var array
     */
    protected $guarded = [];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function family()
    {
        return $this->belongsTo(Family::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function searcher()
    {
        return $this->belongsTo(User::class);
    }
}
