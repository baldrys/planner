<?php

namespace App\Observers;

use App\Activity;
use App\Support\DateTime;
use Carbon\Carbon;

class ActivityObserver
{
    /**
     * Handle the activity "created" event.
     *
     * @param  \App\Activity  $activity
     * @return void
     */
    public function created(Activity $activity)
    {
    }

    /**
     * Handle the activity "updated" event.
     *
     * @param  \App\Activity  $activity
     * @return void
     */
    public function updated(Activity $activity)
    {
        $today = Carbon::parse(DateTime::formatDate(time()))
            ->startOfDay()
            ->toDateTimeString();
        $todayActivity = $activity->userActivity
            ->dayActivities
            ->where('date', $today)
            ->first();
        $updatedParams = [
            'is_paused' => $activity->is_paused,
        ];    

        if(!$activity->is_paused){
            array_merge($updatedParams, ['is_free_day' => $activity->isTodayFreeDay()]);
        }
        $todayActivity->update($updatedParams);
    }

    /**
     * Handle the activity "deleted" event.
     *
     * @param  \App\Activity  $activity
     * @return void
     */
    public function deleted(Activity $activity)
    {
    }

    /**
     * Handle the activity "restored" event.
     *
     * @param  \App\Activity  $activity
     * @return void
     */
    public function restored(Activity $activity)
    {
        //
    }

    /**
     * Handle the activity "force deleted" event.
     *
     * @param  \App\Activity  $activity
     * @return void
     */
    public function forceDeleted(Activity $activity)
    {
        //
    }
}
