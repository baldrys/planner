<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Activity;
use App\DayActivity;
use App\UserActivity;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\Http\Resources\DayActivity as DayActivityR;

class DayActivityController extends Controller
{
    public function index() {
        
        if (Auth::check()) {
            $user = Auth::user();
            $userActivitiesInWeek = $user->initWeek();
            // dd($userActivitiesInWeek[0]->user->name);
            // $dayActivitiesJson = DayActivityR::collection($userActivitiesInWeek);
            $userActivities = UserActivity::where('user_id', $user->id)->get();
            // dd($userActivities[0]->dayActivities);
            return view('index', [
                'userActivities' => $userActivities,
                'today' => Carbon::today()
                ]);
        }
    }
}
