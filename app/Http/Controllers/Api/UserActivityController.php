<?php

namespace App\Http\Controllers\Api;

use App\User;
use App\UserActivity;
use App\Activity;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\AddUserActivityRequest;
use App\Http\Resources\ActivityResource;

class UserActivityController extends Controller
{
    public function getUserActivities(User $user) {
        $userActivities = $user->activities()->get();
        return ActivityResource::collection($userActivities);
    }

    public function addUserActivity(AddUserActivityRequest $request, User $user) {
        $newActivity = $user->activities()->create(['name' => $request->name]);
        return new ActivityResource($newActivity);
    }
}
