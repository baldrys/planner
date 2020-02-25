<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DayActivity extends Model
{
    protected $table = 'day_activity';
    protected $guarded = [];
    protected $dates = [
        'date',
    ];
    public function userActivity()
    {
        return $this->belongsTo('App\UserActivity', 'user_activity_id');
    }


}
