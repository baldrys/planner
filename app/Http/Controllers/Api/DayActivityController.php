<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\DayActivityService;
use Illuminate\Http\Request;
use App\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\Http\Requests\TimePeriodDayActivityRequest;
use App\Http\Resources\DayActivityResource;
use App\Support\DatePicker;
use App\Managers\DayActivityManager;

class DayActivityController extends Controller
{
    public function getDayActivities(User $user, DayActivityManager $manager) {

        $userDayActivities = $manager->getDayActivities($user);
        return DayActivityResource::collection($userDayActivities);
    }
}
