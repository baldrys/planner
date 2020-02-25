<?php

namespace App\Observers;

use App\DayActivity;

class DayActivityObserver
{

    public function retrieved(DayActivity $dayActivity)
    {
    }

    /**
     * Handle the day activity "created" event.
     *
     * @param  \App\DayActivity  $dayActivity
     * @return void
     */
    public function created(DayActivity $dayActivity)
    {
    }

    /**
     * Handle the day activity "updated" event.
     *
     * @param  \App\DayActivity  $dayActivity
     * @return void
     */
    public function updated(DayActivity $dayActivity)
    {
        //
    }

    /**
     * Handle the day activity "deleted" event.
     *
     * @param  \App\DayActivity  $dayActivity
     * @return void
     */
    public function deleted(DayActivity $dayActivity)
    {
        //
    }

    /**
     * Handle the day activity "restored" event.
     *
     * @param  \App\DayActivity  $dayActivity
     * @return void
     */
    public function restored(DayActivity $dayActivity)
    {
        //
    }

    /**
     * Handle the day activity "force deleted" event.
     *
     * @param  \App\DayActivity  $dayActivity
     * @return void
     */
    public function forceDeleted(DayActivity $dayActivity)
    {
        //
    }
}
