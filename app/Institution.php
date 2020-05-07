<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

class Institution extends Model
{
	 protected $guarded = [];
    public function target_types()
    {
        return $this->belongsToMany(TargetType::class);
    }

    public function institution_media()
    {
        return $this->hasMany(InstitutionMedia::class);
    }

    public function institution_target_types()
    {
        return $this->hasMany(InstitutionTargetType::class);
    }

    public function licensor()
    {
        return $this->belongsTo(licensor::class);
    }

    public function institution_type()
    {
        return $this->belongsTo(InstitutionType::class);
    }

    public function season_coupons()
    {
        return $this->hasMany(SeasonCoupon::class);
    }

    public function urgent_coupons()
    {
        return $this->hasMany(UrgentCoupon::class);
    }
	
	 public function neighborhood()
    {
        return $this->belongsTo(Neighborhood::class);
    }
}
