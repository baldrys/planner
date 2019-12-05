<?php

namespace App\Support;


class DateTime
{

    private const FORMAT = 'Y-m-d H:i:s';


    public static function formatDate($date) {
        return date(self::FORMAT, $date);
    }

    public static function getStartDate($days) {
        $endDateInSec = time();
        $daysInSec = $days*24*60*60;
        return $endDateInSec - $daysInSec;
    }
}