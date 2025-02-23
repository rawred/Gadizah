<?php

// app/Notifications/OrderRejected.php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderRejected extends Notification
{
    use Queueable;

    public function __construct()
    {
        //
    }

    public function via($notifiable)
    {
        return ['database']; // Send via database
    }

    public function toArray($notifiable)
    {
        return [
            'message' => 'Your order has been rejected.',
        ];
    }
}