<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FamilyMedia extends Model
{
    /**
     * @var array
     */
    protected $guarded = [];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function fileType()
    {
        return $this->belongsTo(FileType::class);
    }


}

