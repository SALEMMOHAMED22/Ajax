<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CkeckNotificationStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $notify_id = $request->query('notify_id');

        if($notify_id){
            $user = $request->user();
            $notification = $user->notifications()->where('id' , $notify_id)->first();

            if($notification){
                $notification->markAsRead();
            }
        }

        return $next($request);
    }
}
