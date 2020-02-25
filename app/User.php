<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Activity;
use App\Support\Enums\UserRoleEnum;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function activities()
    {
        return $this->belongsToMany('App\Activity', 'user_activities');
    }

    public function userActivities()
    {
        return $this->hasMany('App\UserActivity');
    }

    public function dayActivities()
    {
        return $this->hasManyThrough('App\DayActivity', 'App\UserActivity');
    }

    public function getRole()
    {
        return $this->role;
    }

    public function isAdmin() {
        return ($this->getRole() == UserRoleEnum::Admin) ? true: false;
    }

    public function hasActivity(Activity $activity) {
        if(!($activity->userActivity->user_id == $this->id))
            return false;
        return true;
    }
}
