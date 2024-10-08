<?php

namespace App\Notifications;

use App\Channels\SMSChannel;
use App\Channels\SMSMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderListExcepNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return [
            'mail',
            SMSChannel::class
        ];
    }

    public function toSms(object $notifiable): SMSMessage
    {
        return (new SMSMessage())
            ->from(config('services.sms.from'))
            ->line('Something went wrong in the order list endpoint.')
            ->line('Please check the corresponding log file to more information.')
            ->to($notifiable->mobile);
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->line('Something went wrong in the order list and its filtering.')
            ->line('Please check the corresponding log file for more information.');
    }
}
