<?php

namespace App\Services;

use Aloha\Twilio\Twilio as AlohaTwilio;

class Twilio
{
    public static function getClient()
    {
        return new AlohaTwilio(
            config('services.twilio.account_id'),
            config('services.twilio.token'),
            config('services.twilio.number')
        );
    }

    public static function sendMessage($to, $message)
    {
        return self::getClient()->message(
            $to,
            $message
        );
    }
}
