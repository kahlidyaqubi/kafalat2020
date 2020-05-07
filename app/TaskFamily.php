<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Log
 * @package App
 */
class TaskFamily extends Model
{
    /**
     * @var array
     */
    protected $table = 'task_family';
    protected $guarded = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */


    public function family()
    {
        return $this->belongsTo(Family::class);
    }

    public function task()
    {
        return $this->belongsTo(Task::class);
    }
}
