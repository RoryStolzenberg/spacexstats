<?php

namespace SpaceXStats\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * @var array
     */
    protected $middleware = [
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
        \SpaceXStats\Http\Middleware\EncryptCookies::class,
        \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
        \Illuminate\Session\Middleware\StartSession::class,
        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        \SpaceXStats\Http\Middleware\VerifyCsrfToken::class,
    ];

    /**
     * The application's route middleware.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \SpaceXStats\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'guest' => \SpaceXStats\Http\Middleware\RedirectIfAuthenticated::class,
        'mustBe' => \SpaceXStats\Http\Middleware\MustBeMiddleware::class,
        'doesExist' => \SpaceXStats\Http\Middleware\DoesModelExistMiddleware::class,
        'isLaunchController' => \SpaceXStats\Http\Middleware\IsLaunchControllerMiddleware::class
    ];
}
