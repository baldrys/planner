<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Support\DateTime;
use Carbon\Carbon;

class Activity extends Model
{
    protected $table = 'activities';
    protected $guarded = [];

    public function userActivity(){
        return $this->hasOne('App\UserActivity');
    }

    public function getLastActivityDay() {
        $dayActivities = $this
            ->userActivity
            ->dayActivities()
            ->where('is_free_day', 0)
            ->where('is_paused', 0)
            ->orderBy('date', 'desc');
        return ($dayActivities->exists()) ? DateTime::formatDate(strtotime($dayActivities->first()->date)) : DateTime::formatDate(time());
    }


    public function isTodayFreeDay(){
        $activityPeriod = $this->userActivity->activity_period;
        $lastActivityDay = $this->getLastActivityDay();
        $today = DateTime::formatDate(time());
        $from = Carbon::parse($lastActivityDay)
            ->startOfDay()
            ->toDateTimeString();
        $to = Carbon::parse($today)
            ->startOfDay()
            ->toDateTimeString();
        $isFreeDay = $this
            ->userActivity
            ->dayActivities
            ->where('date', '>', $from)
            ->where('date', '<', $to)
            ->where('is_paused', 0)
            ->count() != $activityPeriod ? 1: 0;
            return $isFreeDay;
    }

}
