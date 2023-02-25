<?php

namespace App\Utils;

use DateTime;
use DateTimeZone;

class AppHelpers
{
    /**
     * @throws \Exception
     */
    public static function getCurrentDate($format = 'Y-m-d H:i:s',$timeZoneInput = 'Europe/Sofia'): string
    {
        $timezone = new DateTimeZone($timeZoneInput);
        $datetime = new DateTime('now', $timezone);
        return $datetime->format($format);
    }
}
