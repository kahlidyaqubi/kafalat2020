<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FamilyMemberDiseases extends Model
{
    protected $table = 'family_member_diseases';
    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function disease()
    {
        return $this->belongsTo(Disease::class);
    }
}
