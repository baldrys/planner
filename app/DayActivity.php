<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DayActivity extends Model
{
    protected $table = 'day_activity';
    protected $guarded = [];


    public function userActivity()
    {
        return $this->belongsTo('App\UserActivity', 'user_activity_id');
    }

    public function user() {
        return $this->userActivity()->first()->user();
    }

    public function activity() {
        return $this->userActivity()->first()->activity();
    }

}
