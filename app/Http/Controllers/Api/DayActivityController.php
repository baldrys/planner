<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;
use App\Http\Resources\DayActivityResource;
use App\Managers\DayActivityManager;
use App\DayActivity;
use App\Http\Requests\DayActivityEditRequest;
use App\Http\Resources\DayActivityCollection;
use App\Http\Resources\ActivitiesWithDayActivitiesResource;
use App\Http\Resources\ActivitiesWithDayActivitiesResourceCollection;
use App\Support\DateTime;
use App\Http\Requests\GetDayActivitiesReqeust;

class DayActivityController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:view,user');
    }

    public function getDayActivities(GetDayActivitiesReqeust $request, User $user, DayActivityManager $manager) {
        $activities = $manager->getDayActivities($user, $request->start_date, $request->end_date);
        return new ActivitiesWithDayActivitiesResourceCollection($activities);
    }

    public function editDayActivities(DayActivityEditRequest $request, User $user, DayActivity $dayActivity) {
        $dayActivity->update([
            'is_done' => $request->is_done,
        ]);
        return new DayActivityResource($dayActivity);
    }
}
