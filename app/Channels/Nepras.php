<?php

namespace App\Channels;

use Exception;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Http;

class Nepras
{
    protected $baseUrl = 'https://www.nsms.ps';    
    
    public function send($notifiable, Notification $notification)
    {
        $response = Http::baseUrl($this->baseUrl)
            ->get('api.php', [
                'comm' => 'sendsms',
                'user' => config('services.nepras.user'),
                'pass' => config('services.nepras.pass'),
                'to' => $notifiable->routeNotificationForNepras($notification),
                'message' => $notification->toNepras($notifiable),
                'sender' => config('services.nepras.sender'),
            ]);

        $code = $response->body();
        if ($code != 1) {
            throw new Exception($code);
        }
    }
}