<?php

namespace App\Support;

use Carbon\Carbon;
use Carbon\CarbonPeriod;
use \Datetime;

class DatePicker
{
    public static function getStartDate($days, $endDate) {
        $daysInSec = $days*24*60*60;
        $startDateInSec = strtotime($endDate) - $daysInSec;
        return $startDateInSec;
    }
}