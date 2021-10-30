<?php

namespace App\Channels;

use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log as LogFacade;

class Log
{
    public function send($notifiable, Notification $notification)
    {
        $message = $notification->toLog($notifiable);
        LogFacade::info("[$notifiable->name]: $message");
    }
}