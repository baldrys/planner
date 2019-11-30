<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Activity;
use App\User;
use App\Http\Requests\EditActivityRequest;

class ActivitiesController extends Controller
{
    public function editActivity(EditActivityRequest $request, User $user, Activity $activity) {
        // Проверить есть ли у пользователя данная ативность
        $activity->update($request->all());
        return response()->json($activity);
    }

    public function deleteActivity(User $user, Activity $activity) {
        // Проверить есть ли у пользователя данная ативность
        $activity->delete();
        return response()->json([
            'Successefully deleted!'
        ]);
    }
}
