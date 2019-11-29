<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Activity;

class ActivitiesController extends Controller
{
    public function editActivity(Request $request, Activity $activity) {
        // TODO validate request
        $activity->update($request->all());
        return response()->json($activity);
    }

    public function deleteActivity(Activity $activity) {
        $activity->delete();
        return response()->json([
            'Successefully deleted!'
        ]);
    }
}
