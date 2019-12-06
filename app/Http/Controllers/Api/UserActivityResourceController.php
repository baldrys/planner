<?php

namespace App\Http\Controllers\Api;

use App\Activity;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests\AddUserActivityRequest;
use App\Http\Resources\ActivityResource;
use App\Http\Requests\EditActivityRequest;

class UserActivityResourceController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(Activity::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function index(User $user)
    {
        $userActivities = $user->activities()->get();
        return ActivityResource::collection($userActivities);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function store(AddUserActivityRequest $request, User $user)
    {
        $newActivity = $user->activities()->create(['name' => $request->name]);
        return new ActivityResource($newActivity);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @param  \App\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function show(User $user, Activity $activity)
    {
        return new ActivityResource($activity);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @param  \App\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function update(EditActivityRequest $request, User $user, Activity $activity)
    {
        $activity->update(['name' => $request->name]);
        return new ActivityResource($activity);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @param  \App\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user, Activity $activity)
    {
        $activity->delete();
        return response()->json([
            'Successefully deleted!'
        ]);
    }
}
