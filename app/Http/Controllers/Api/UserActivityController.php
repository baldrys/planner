<?php

namespace App\Http\Controllers\Api;

use App\User;
use App\UserActivity;
use App\Activity;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserActivityController extends Controller
{
    public function getUserActivities(User $user) {
        $userActivities = $user->activities()->get();
        return response()->json($userActivities);
    }

    public function addUserActivities(Request $request, User $user) {
        // TODO validate request
        $newActivity = $user->activities()->create($request->all());
        return response()->json($newActivity);
    }
}
