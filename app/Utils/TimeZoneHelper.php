<?php


namespace App\Utils;


use Carbon\Carbon;

class TimeZoneHelper
{
    const UTC_TZ = 'UTC';
    const AUSTRALIA_MELBOURNE_TZ = 'Australia/Melbourne';
    const DEFAULT_DATE_TIME_FORMAT = 'Y-m-d h:i A';
    const DEFAULT_DATE_FORMAT = 'Y-m-d';


    /**
     *  update given date time to system format
     *
     * @param $dateToFormat
     * @return string
     */
    public function formatDateTime($dateToFormat): string
    {
        return (new Carbon($dateToFormat))->format(self::DEFAULT_DATE_TIME_FORMAT);
    }

    public function formatDate($dateToFormat): string
    {
        if($dateToFormat == '' || $dateToFormat == null){
            return '';
        }
        return (new Carbon($dateToFormat))->format(self::DEFAULT_DATE_FORMAT);
    }

    /**
     *
     */
    public function getCurrentDateForDateField()
    {
        $timezone = self::AUSTRALIA_MELBOURNE_TZ;
        return (Carbon::now())->setTimezone($timezone)->toDateString();
    }
}
