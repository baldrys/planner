<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Activity;
use App\DayActivity;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\Http\Resources\DayActivity as DayActivityR;

class DayActivityController extends Controller
{
    public function index() {
        
        if (Auth::check()) {
            $user = Auth::user();
            $userActivitiesInWeek = $user->initWeek();
            
            $u = $userActivitiesInWeek[0];
            return DayActivityR::collection($userActivitiesInWeek);
            dd($u);
            // return response()->json($userActivitiesInWeek);
        }
        $activities = Activity::all();
        $date = Carbon::today();
        // dd($date);
        // return $activities;
    }
}
