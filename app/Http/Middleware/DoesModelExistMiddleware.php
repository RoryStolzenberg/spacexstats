<?php
namespace SpaceXStats\Http\Middleware;

use Closure;

class DoesModelExistMiddleware {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  String $model
     * @return mixed
     */
    public function handle($request, Closure $next, $model)
    {

        if ($model == 'Mission') {
            Mission::whereSlug(Route::input('slug'))->firstOrFail();
        } elseif ($model == 'Object') {
            Object::findOrFail(Route::input('object_id'));
        }

        return $next($request);
    }
}
