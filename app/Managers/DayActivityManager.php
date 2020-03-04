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

    public function getLastActivityDay(Activity $activity) {
        $dayActivities = $activity
            ->userActivity
            ->dayActivities()
            ->where('is_free_day', 0)
            ->orderBy('date', 'desc');
        return ($dayActivities->exists()) ? DateTime::formatDate(strtotime($dayActivities->first()->date)) : DateTime::formatDate(time());
    }

    public function getDayActivities(User $user, $startDate, $endDate) {
        return $this->userRepository->getActivitiesWithDays($user, $startDate, $endDate);

    }
}