<?php

namespace App\Managers;

use App\User;
use Carbon\CarbonPeriod;
use App\DayActivity;
use App\Support\DateTime;
use App\Activity;
use App\Repositories\UserRepository;
use App\Http\Resources\ActivitiesWithDayActivitiesResource;

class DayActivityManager {

    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    protected function getLastActivityDay(Activity $activity) {
        $dayActivities = $activity
            ->userActivity
            ->dayActivities()
            ->where('is_free_day', 0)
            ->orderBy('date', 'desc');
        return ($dayActivities->exists()) ? DateTime::formatDate(strtotime($dayActivities->first()->date)) : DateTime::formatDate(time());
    }

    public function getDayActivities(User $user, $startDate, $endDate) {
        $this->setDefaultDayActivitiesForUser($user);
        return $this->userRepository->getActivitiesWithDays($user, $startDate, $endDate);

    }


    protected function isFreeDay($period, $lastDay, $dayTocheck) {
        $daysBetween = (strtotime($dayTocheck) - strtotime($lastDay) - 1)/(60*60*24);
        return !(($daysBetween + 1)%($period + 1) == 0); 
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
    private function setDefaultDayActivitiesForUser(User $user) {
        $today = DateTime::formatDate(time());
        $activities = $user->activities()->get();
        foreach ($activities as $activity) {
            $activityPeriod = $activity->userActivity->activity_period;
            $lastActivityDay = $this->getLastActivityDay($activity);
            $timeInterval = CarbonPeriod::create($lastActivityDay, $today)->toArray();
            foreach ($timeInterval as $day) {
                DayActivity::firstOrCreate([
                    'user_activity_id' => $activity->userActivity->id,
                    'date' => $day,
                    'is_free_day' =>  $this->isFreeDay(
                            $activityPeriod, 
                            $lastActivityDay,
                            $day
                        )
                ]);      
            }
        }
    }
}