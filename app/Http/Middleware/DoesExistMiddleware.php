<?php
namespace SpaceXStats\Http\Middleware;

use Closure;

class DoesExistMiddleware {

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
        /* Check if a mission page exists before directing user to the page */
        Route::filter('doesMissionExist', function() {
            Mission::whereSlug(Route::input('slug'))->firstOrFail();
        });

        Route::filter('doesObjectExist', function() {
            Object::findOrFail(Route::input('object_id'));
        });

        return $next($request);
    }

}
