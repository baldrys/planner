<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\DayActivityService;
use Illuminate\Http\Request;
use App\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\Http\Requests\TimePeriodDayActivityRequest;

class DayActivityController extends Controller
{
    public function getDayActivities(TimePeriodDayActivityRequest $request, User $user) {
        $from = $request->get('start_date');
        $to = $request->get('end_date');
        $userActivities = $user->dayActivities()->whereBetween('date', [$from, $to])->get();
        return response()->json($userActivities);
    }

    public function setDefaultDayActivities(TimePeriodDayActivityRequest $request, User $user, DayActivityService $dayActivityService) {
        $from = new Carbon($request->get('start_date'));
        $to = new Carbon($request->get('end_date'));
        $res = $dayActivityService->setDefaultDayActivitiesForUser($user, $from, $to);
        return response()->json($res);
    }
}
