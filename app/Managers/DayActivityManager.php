<?php

namespace App\Managers;

use App\User;
use Carbon\CarbonPeriod;
use App\DayActivity;
use App\Support\DateTime;
use App\Activity;

class DayActivityManager {

    protected function getLastActivityDay(Activity $activity) {
        $dayActivities = $activity
            ->userActivity
            ->dayActivities()
            ->where('is_free_day', 0)
            ->orderBy('date', 'desc');
            // dd($dayActivities->exists());
        return ($dayActivities->exists()) ? DateTime::formatDate(strtotime($dayActivities->first()->date)) : null;
    }

    public function getDayActivities(User $user) {
        $to = DateTime::formatDate(time());
        $from = DateTime::formatDate(DateTime::getStartDate($user->days_to_show));
        $this->setDefaultDayActivitiesForUser($user, $from, $to);
        return $user->dayActivities()
            ->whereDate('date', '>=', $from)
            ->whereDate('date', '<=', $to)
            ->get();
    }

    /**
     * Алгоритм
     * 0. Цикл по активностям пользователя
     * 1. Получаем последний день когда была ативность, если ее не было(результат null), то
     *    то начало активности сегодня
     * 2. Инициализация. Цикл начиная последнего дня активности прибавляем период активности и идем до
     *    сегодняшнего дня, инициализируем соответуствующими значениями.
     * 3. Выдаем данные до сегодняшнего дня минус user->days_to_show.
     *
     * @param  mixed $user
     * @param  mixed $startDate
     * @param  mixed $endDate
     *
     * @return void
     */
    private function setDefaultDayActivitiesForUser(User $user, $startDate, $endDate) {
        
        $activities = $user->activities()->get();
        foreach ($activities as $activity) {
            $activityPeriod = $activity->userActivity->activity_period;
            $i = 0;
            $lastActivityDay = $this->getLastActivityDay($activity);
            $startDate =($lastActivityDay != null) ? $lastActivityDay: $endDate;
            $timeInterval = CarbonPeriod::create($startDate, $endDate)->toArray();
            foreach ($timeInterval as $day) {
                $i++;
                $isFreeDay = ($i % $activityPeriod == 0) ? 1: 0;
                DayActivity::firstOrCreate([
                    'user_activity_id' => $activity->userActivity->id,
                    'date' => $day,
                    'is_free_day' =>  $isFreeDay
                ]);      
            }
        }
    }
}