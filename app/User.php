<?php

namespace App;

use Carbon\Carbon;
use App\Support\DaysPicker;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\DayActivity;
use App\UserActivity;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function activities()
    {
        return $this->hasMany('App\UserActivity');
    }

    public function initWeek() {
        $days = DaysPicker::getDaysInWeek();
        $userActivities = $this->activities()->get();
        $userActivitiesInWeek = [];
        foreach ($userActivities as $userActivity) {
            
            foreach ($days as $day) {
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
