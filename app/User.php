<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use App\Support\DaysPicker;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\DayActivity;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens;

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
