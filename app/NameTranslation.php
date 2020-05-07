<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

/**
 * Class Family
 * @package App
 */
class NameTranslation extends Model
{

//    public function model(array $row)
//    {
//
//        dd($row);
//        return new ;
//    }

    /**
     * @var array
     */
    protected $guarded = [];

    //مكفولين اسمهم الأول مترجم

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function recipients_first_name()
    {
        return $this->hasMany(Family::class, 'first_name_tr_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function recipients_second_name()
    {
        return $this->hasMany(Family::class, 'second_name_tr_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function recipients_third_name()
    {
        return $this->hasMany(Family::class, 'third_name_tr_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function recipients_family_name()
    {
        return $this->hasMany(Family::class, 'family_name_tr_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function recipients_member_first_name()
    {
        return $this->hasMany(RecipientMember::class, 'first_name_tr_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function recipients_member_second_name()
    {
        return $this->hasMany(RecipientMember::class, 'second_name_tr_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function recipients_member_third_name()
    {
        return $this->hasMany(RecipientMember::class, 'third_name_tr_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function recipients_member_family_name()
    {
        return $this->hasMany(RecipientMember::class, 'family_name_tr_id', 'id');
    }


}
