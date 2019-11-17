<?php

namespace App\Support;

use Carbon\Carbon;
use Carbon\CarbonPeriod;

class DaysPicker
{
    public static function getDaysInWeek() {
        $now = Carbon::now();
        $start = $now->startOfWeek()->format('Y-m-d H:i');
        $end =  $now->endOfWeek()->format('Y-m-d H:i');
        $period = CarbonPeriod::create($start, $end);
        return $period->toArray();
    }
}