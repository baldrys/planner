<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\DayActivityService;
use Illuminate\Http\Request;
use App\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class DayActivityController extends Controller
{
    public function getDayActivities(Request $request, User $user) {
        // TODO: validation request
        $from = $request->get('start_date');
        $to = $request->get('end_date');
        $userActivities = $user->dayActivities()->whereBetween('date', [$from, $to])->get();
        return $userActivities;
    }

    public function setDefaultDayActivities(Request $request, User $user, DayActivityService $dayActivityService) {
        // TODO: validation request
        $from = new Carbon($request->get('start_date'));
        $to = new Carbon($request->get('end_date'));
        return $dayActivityService->setDefaultDayActivitiesForUser($user, $from, $to);
    }
}
