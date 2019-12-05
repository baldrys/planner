<?php

namespace App\Managers;

use App\User;
use Carbon\CarbonPeriod;
use App\DayActivity;
use App\Support\DateTime;

class DayActivityManager {

    public function getDayActivities(User $user) {
        $from = DateTime::formatDate(time());
        $to = DateTime::formatDate(DateTime::getStartDate($user->days_to_show));
        $this->setDefaultDayActivitiesForUser($user, $from, $to);
        return $user->dayActivities()->whereBetween('date', [$from, $to])->get();
    }

    private function setDefaultDayActivitiesForUser(User $user, $startDate, $endDate) {
        $period = CarbonPeriod::create($startDate, $endDate)->toArray();
        $userActivities = $user->activities()->get();
        foreach ($userActivities as $userActivity) {
            foreach ($period as $day) {
                DayActivity::firstOrCreate([
                    'user_activity_id' => $userActivity->id,
                    'date' => $day
                ]);                    
            }
        }
    }
}