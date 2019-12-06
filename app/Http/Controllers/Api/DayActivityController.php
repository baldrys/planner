<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;
use App\Http\Resources\DayActivityResource;
use App\Managers\DayActivityManager;
use App\DayActivity;
use App\Http\Requests\DayActivityEditRequest;

class DayActivityController extends Controller
{
    public function getDayActivities(User $user, DayActivityManager $manager) {

        $userDayActivities = $manager->getDayActivities($user);
        return DayActivityResource::collection($userDayActivities);
    }

    public function editDayActivities(DayActivityEditRequest $request, User $user, DayActivity $dayActivity) {
        $dayActivity->update([
            'is_done' => $request->is_done,
        ]);
        return new DayActivityResource($$dayActivity);
    }
}
