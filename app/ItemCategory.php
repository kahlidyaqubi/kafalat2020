<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemCategory extends Model
{
	 protected $guarded = [];
    public function item_types()
    {
        return $this->hasMany(ItemType::class);
    }
}
