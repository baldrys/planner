<?php

namespace App\Policies;

use App\Activity;
use App\User;
use App\DayActivity;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Support\Enums\UserRoleEnum;

class DayActivityPolicy
{
    use HandlesAuthorization;

    public function update(User $user, DayActivity $dayActivity)
    {
        if( $user->isAdmin() || $user->hasActivity($dayActivity->userActivity->activity) )
            return true;
        else 
            return false;
    }

}
