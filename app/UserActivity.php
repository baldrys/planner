<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserActivity extends Model
{
    protected $table = 'user_activities';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function activity()
    {
        return $this->belongsTo('App\Activity', 'activity_id');
    }

    public function dayActivities()
    {
        return $this->hasMany('App\DayActivity', 'user_activity_id');
    }
}
