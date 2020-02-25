<?php

namespace App\Policies;

use App\Activity;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Support\Enums\UserRoleEnum;

class ActivityPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any activities.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }
    
    /**
     * Determine whether the user can view the activity.
     *
     * @param  \App\User  $user
     * @param  \App\Activity  $activity
     * @return mixed
     */
    public function view(User $user, Activity $activity)
    {
        if( $user->isAdmin() || $user->hasActivity($activity) )
            return true;
        else 
            return false;
    }

    /**
     * Determine whether the user can create activities.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the activity.
     *
     * @param  \App\User  $user
     * @param  \App\Activity  $activity
     * @return mixed
     */
    public function update(User $user, Activity $activity)
    {
        if( $user->isAdmin() || $user->hasActivity($activity) )
            return true;
        else 
            return false;
    }

    /**
     * Determine whether the user can delete the activity.
     *
     * @param  \App\User  $user
     * @param  \App\Activity  $activity
     * @return mixed
     */
    public function delete(User $user, Activity $activity)
    {
        if( $user->isAdmin() || $user->hasActivity($activity) )
            return true;
        else 
            return false;
    }

    /**
     * Determine whether the user can restore the activity.
     *
     * @param  \App\User  $user
     * @param  \App\Activity  $activity
     * @return mixed
     */
    public function restore(User $user, Activity $activity)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the activity.
     *
     * @param  \App\User  $user
     * @param  \App\Activity  $activity
     * @return mixed
     */
    public function forceDelete(User $user, Activity $activity)
    {
        //
    }
}
