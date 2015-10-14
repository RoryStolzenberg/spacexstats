<?php

namespace SpaceXStats\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class IsLaunchControllerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::user()->isLaunchController() || Auth::isAdmin()) {
            return $next($request);
        }
        return redirect('/');
    }
}
