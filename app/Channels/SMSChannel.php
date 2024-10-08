<?php

namespace App\Channels;

use Illuminate\Notifications\Notification;

class SMSChannel
{
    /**
     * @param $notifiable
     * @param Notification $notification
     * @return void
     */
    public function send($notifiable, Notification $notification): void
    {
        $message = $notification->toSms($notifiable);
        $message->send();
    }
}
