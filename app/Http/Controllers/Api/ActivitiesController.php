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

        // if ($user->can('update', $activity)) {
        //     return response()->json(['YES']);
        // } else return response()->json(['NO']);

        // Проверить есть ли у пользователя данная ативность
        $activity->update($request->all());
        return new ActivityResource($activity);
    }

    public function deleteActivity(User $user, Activity $activity) {
        // Проверить есть ли у пользователя данная ативность
        $activity->delete();
        return response()->json([
            'Successefully deleted!'
        ]);
    }
}
