<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;
use App\Http\Resources\DayActivityResource;
use App\Managers\DayActivityManager;

class DayActivityController extends Controller
{
    public function getDayActivities(User $user, DayActivityManager $manager) {

        $userDayActivities = $manager->getDayActivities($user);
        return DayActivityResource::collection($userDayActivities);
    }
}
