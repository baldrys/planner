<?php

namespace App\Managers;

use App\User;
use App\Support\DatePicker;
use App\Services\DayActivityService;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\DayActivity;

class DayActivityManager {

    public function getDayActivities(User $user) {
        $endDateInSec = time();
        $daysInSec = $user->days_to_show*24*60*60;
        $startDateInSec = $endDateInSec - $daysInSec;
        $from = date('Y-m-d H:i:s', $startDateInSec);
        $to = date('Y-m-d H:i:s', $endDateInSec);
        $this->setDefaultDayActivitiesForUser($user, $from, $to);
        return $user->dayActivities()->whereBetween('date', [$from, $to])->get();
    }

    private function setDefaultDayActivitiesForUser(User $user, $startDate, $endDate) {
        $period = CarbonPeriod::create($startDate, $endDate)->toArray();
        $userActivities = $user->activities()->get();
        $userActivitiesInWeek = [];
        foreach ($userActivities as $userActivity) {
            foreach ($period as $day) {
                $dayActivity = DayActivity::where('user_activity_id', $userActivity->id)
                    ->where('date', $day);
                if (!$dayActivity->exists()) {
                    $dayActivity = DayActivity::create([
                        'user_activity_id' => $userActivity->id,
                        'date' => $day
                    ]);
                }
                array_push($userActivitiesInWeek, $dayActivity->first());                           
            }
        }
        return $userActivitiesInWeek;
    }
}