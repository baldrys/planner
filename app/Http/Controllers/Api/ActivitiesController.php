<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Activity;
use App\User;
use App\Http\Requests\EditActivityRequest;
use App\Http\Resources\ActivityResource;

class ActivitiesController extends Controller
{
    public function editActivity(EditActivityRequest $request, User $user, Activity $activity) {
        $activity->update(['name' => $request->name]);
        return new ActivityResource($activity);
    }

    public function deleteActivity(User $user, Activity $activity) {
        $activity->delete();
        return response()->json([
            'Successefully deleted!'
        ]);
    }
}
