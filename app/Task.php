<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Log
 * @package App
 */
class Task extends Model
{
    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function institution()
    {
        return $this->belongsTo(Institution::class, 'institution_id', 'id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function family()
    {
        return $this->belongsTo(Family::class);
    }

    public function families()
    {
        return $this->belongsToMany(Family::class, TaskFamily::class);
    }

    public function task_families()
    {
        return $this->hasMany(TaskFamily::class);
    }
}
