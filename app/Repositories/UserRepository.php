<?php

namespace App\Repositories;

use App\User;
use App\DayActivity;
use App\Http\Resources\ActivitiesWithDayActivitiesResource;
use App\Support\DateTime;
use Illuminate\Support\Carbon\Carbon;

class UserRepository {


    public function getActivitiesWithDays(User $user, $from, $to){    
        return $user->activities()->with(["userActivity.dayActivities" => function($q) use($to, $from) {
            $q->whereDate('date', '>=', $from)
             ->whereDate('date', '<=', $to);
        }])->get();
    }

}