<?php

namespace App\Repositories;

use App\User;
use App\DayActivity;
use App\Http\Resources\ActivitiesWithDayActivitiesResource;
use App\Support\DateTime;

class UserRepository {


    public function getActivitiesWithDays(User $user){
        $to = DateTime::formatDate(time());
        $from = DateTime::formatDate(DateTime::getStartDate($user->days_to_show));
        return $user->activities()->with(["userActivity.dayActivities" => function($q) use($to, $from) {
            $q->whereDate('date', '>=', $from)
             ->whereDate('date', '<=', $to);
        }])->get();
    }

}