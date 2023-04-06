<?php
class Common
{
    public static function getHumanTime(DateTime $time)
    {
        $today = new DateTime('today', new DateTimeZone('GMT+03:00'));
        $date = new DateTime($time->format('Y-m-d'), new DateTimeZone('GMT+03:00'));
        $date->setTime(0, 0, 0);
        $diff = (int)$today->diff($date)->format("%R%a");

        switch ($diff) {
            case 0:
                return $time->format(Locale::getValue('comment.timemasktoday'));
            case -1:
                return $time->format(Locale::getValue('comment.timemaskyesterday'));
            default:
                return $time->format(Locale::getValue('comment.timemaskfull'));
        }
    }
}
