<?php

namespace App;

use App\Notifications\MailResetPasswordToken;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;

/**
 * Class User
 * @package App
 */
class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $guarded = [
        'password_confirmation'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * @return string
     */

    /**
     * Send a password reset email to the user
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new MailResetPasswordToken($token));
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if(($model->first_name))
            $model->full_name = "{$model->first_name} {$model->second_name} {$model->third_name} {$model->family_name}";
        });

        static::updating(function ($model) {

            if(($model->first_name))
            $model->full_name = "{$model->first_name} {$model->second_name} {$model->third_name} {$model->family_name}";
        });
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function families_searchers()
    {
        return $this->hasMany(FamilySearcher::class, 'searcher_id', 'id');
    }

    /**
     * @param $value
     */
    public function setMobileOneAttribute($value)
    {

        $number = str_replace('-', "", $value);
        $this->attributes['mobile_one'] = '+970' . $number;
    }

    /**
     * @param $value
     */
    public function setMobileTwoAttribute($value)
    {
        $number = str_replace('-', "", $value);
        $this->attributes['mobile_two'] = '+970' . $number;
    }

    public function setMobileAttribute($value)
    {

        $number = str_replace('-', "", $value);
        $this->attributes['mobile'] = '+970' . $number;
    }

    /**
     * @param $value
     * @return mixed
     */
    public function getMobileOneAttribute($value)
    {
        $number = str_replace('+970', "", $value);
        return $number;
    }

    /**
     * @param $value
     * @return mixed
     */
    public function getMobileTwoAttribute($value)
    {
        $number = str_replace('+970', "", $value);
        return $number;
    }

    public function getMobileAttribute($value)
    {
        $number = str_replace('+970', "", $value);
        return $number;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function families_data_entries()
    {
        return $this->hasMany(Family::class, 'created_by', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function logs()
    {
        return $this->hasMany(Log::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function social_status()
    {
        return $this->belongsTo(SocialStatus::class);
    }

    public function university_specialty()
    {
        return $this->belongsTo(UniversitySpecialty::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function city()
    {
        return $this->belongsTo(City::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function user_media()
    {
        return $this->hasMany(UserMedia::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function admin_tasks()
    {
        return $this->hasMany(Task::class, 'admin_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */

    public function neighborhood()
    {
        return $this->belongsTo(Neighborhood::class);
    }
}
