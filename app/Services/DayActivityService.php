<?php

namespace App\Services;

use App\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class DayActivityService{

    // private $user;

    // public function __construct(User $user)
    // {
    //     $this->user = $user;
    // }


    public function setDefaultDayActivitiesForUser(User $user, Carbon $startDate, Carbon $endDate) {
        $period = CarbonPeriod::create($startDate, $endDate)->toArray();
        
        $userActivities = $user->activities()->get();
        $userActivitiesInWeek = [];
        foreach ($userActivities as $userActivity) {
            
            foreach ($period as $day) {
                $dayActivity = DayActivity::where('user_activity_id', $userActivity->id)
                    ->where('date', $day);
                if (!$dayActivity->exists()) {
                    $dayActivity = DayActivity::create([
                        'user_activity_id' => $userActivity->id,
                        'date' => $day
                    ]);
                    
                }
                array_push($userActivitiesInWeek, $dayActivity->first());                           
            }
        }
        return collect($userActivitiesInWeek);


    }
}