<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InstitutionMedia extends Model
{
	 protected $guarded = [];
	
	 public function institution()
    {
        return $this->belongsTo(Institution::class);
    }
	
	
     public function fileType()
    {
        return $this->belongsTo(FileType::class);
    }
}
