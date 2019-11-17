<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Activity;
use App\DayActivity;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class DayActivityController extends Controller
{
    public function index() {
        
        if (Auth::check()) {
            $user = Auth::user();
            $userActivities = $user->dayActivities()->get();
            
        }
        $activities = Activity::all();
        $date = Carbon::today();
        // dd($date);
        // return $activities;
    }
}
