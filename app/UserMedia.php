<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class UserMedia
 * @package App
 */
class UserMedia extends Model
{
    /**
     * @var string
     */
    protected $table = "user_media";

    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function fileType()
    {
        return $this->belongsTo(FileType::class);
    }
}
