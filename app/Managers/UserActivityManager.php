<?php

namespace App\Managers;

use App\Activity;
use App\UserActivity;
use App\Http\Requests\AddUserActivityRequest;
use App\Http\Requests\EditActivityRequest;
use App\User;
use App\DayActivity;
use App\Support\DateTime;
use Carbon\Carbon;

class UserActivityManager{

    public function createActivity(AddUserActivityRequest $request, User $user) {
        $newActivity = UserActivity::create([
            "user_id" => $user->id,
            "activity_id" => Activity::create(['name' => $request->name])->id,
            'activity_period'=>$request->activity_period
        ])->activity;
        $today = DateTime::formatDate(time());
        DayActivity::firstOrCreate([
            'user_activity_id' => $newActivity->userActivity->id,
            'date' => $today,
            'is_paused' => $newActivity->is_paused
        ]);      
        return $newActivity;
    }

    public function updateActivity(EditActivityRequest $request, Activity $activity) {
        $activity->update([
            'name' => $request->name,
            'is_paused' => $request->is_paused ? $request->is_paused:0,
            ]);
        $activity->userActivity->update([
            'activity_period'=>$request->activity_period
        ]);

        $today = Carbon::parse(DateTime::formatDate(time()))
            ->startOfDay()
            ->toDateTimeString();
        $todayActivity = $activity->userActivity
            ->dayActivities
            ->where('date', $today)
            ->first();
        $updatedParams = [
            'is_paused' => $activity->is_paused,
        ];  
        if($request->is_paused == 0) {
            array_merge($updatedParams, ['is_free_day' => $activity->isTodayFreeDay()]);
        }
        $todayActivity->update($updatedParams);

        return $activity;
    }
}