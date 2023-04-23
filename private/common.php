<?php
class Common
{
    public static function getHumanTime(DateTime $time, bool $strict = false)
    {
        $today = new DateTime('today', new DateTimeZone('GMT+03:00'));
        $date = new DateTime($time->format('Y-m-d'), new DateTimeZone('GMT+03:00'));
        $date->setTime(0, 0, 0);
        $diff = (int)$today->diff($date)->format("%R%a");

        if ($strict) {
            return $time->format('j.m.Y G:i:s');
        } else {
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

    public static function getClientIp()
    {
        $client  = @$_SERVER['HTTP_CLIENT_IP'];
        $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
        $remote  = @$_SERVER['REMOTE_ADDR'];

        return (string)(filter_var($client, FILTER_VALIDATE_IP) ? $client : (filter_var($forward, FILTER_VALIDATE_IP) ? $forward : $remote));
    }
}
