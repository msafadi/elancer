<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class MarkNotificationAsRead
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();
        $notify_id = $request->query('notify_id');
        if ($notify_id) {
            $notification = $user->unreadNotifications()->find($notify_id);
            if ($notification) {
                $notification->markAsRead();
            }
        }

        return $next($request);
    }
}
