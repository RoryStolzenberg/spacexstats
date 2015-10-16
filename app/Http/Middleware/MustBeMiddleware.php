<?php
namespace SpaceXStats\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use SpaceXStats\Library\Enums\UserRole;

class MustBeMiddleware {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  String $role
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {

        if ($role == 'Yourself') {
            if (Auth::guest()) {
                return redirect('home');
            } else {
                // The user must be accessing themself or alternatively the user doing the accessing is an administrator
                if (Auth::user()->role_id < UserRole::Administrator && $request->segment(2) != Auth::user()->username) {
                    return redirect('home');
                }
            }

            return $next($request);
        }

        $role = constant('SpaceXStats\Library\Enums\UserRole::'.$role);

        if (Auth::guest()) {
            return redirect()->guest('auth/login');
        }

        if (Auth::user()->role_id < $role) {
            return redirect('home');
        }

        return $next($request);
    }

}
