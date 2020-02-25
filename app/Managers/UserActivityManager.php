<?php

namespace App\Managers;

use App\Activity;
use App\UserActivity;
use App\Http\Requests\AddUserActivityRequest;
use App\Http\Requests\EditActivityRequest;
use App\User;

class UserActivityManager{

    public function createActivity(AddUserActivityRequest $request, User $user) {
        $newActivity = UserActivity::create([
            "user_id" => $user->id,
            "activity_id" => Activity::create(['name' => $request->name])->id,
            'activity_period'=>$request->activity_period
        ])->activity;
        return $newActivity;
    }

    public function updateActivity(EditActivityRequest $request, Activity $activity) {

        $activity->update(['name' => $request->name]);
        $activity->userActivity->update([
            'activity_period'=>$request->activity_period
        ]);

        return $activity;
    }

    
    
}