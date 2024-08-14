<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class Inactivity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  int  $timeout
     * @return mixed
     */
    public function handle($request, Closure $next, $timeout = 180)
    {
        if (Auth::check()) {
            $lastActivity = Session::get('lastActivityTime');
            $currentTime = now();

            if ($lastActivity && $currentTime->diffInSeconds($lastActivity) > $timeout) {
                Auth::logout();
                return redirect()->route('citas.showLoginForm')->with('message', 'Has sido desconectado por inactividad.');
            }

            Session::put('lastActivityTime', $currentTime);
        }

        return $next($request);
    }
}
