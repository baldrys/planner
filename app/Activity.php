<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $table = 'activities';
    protected $guarded = [];

    public function userActivity(){
        return $this->hasOne('App\UserActivity');
    }

}
