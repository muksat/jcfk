<?php

namespace Jcfk\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;
use Jcfk\Http\Middleware\Admin;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * @var array
     */
    protected $middleware = [
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
        \Jcfk\Http\Middleware\EncryptCookies::class,
        \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
        \Illuminate\Session\Middleware\StartSession::class,
        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        \Jcfk\Http\Middleware\VerifyCsrfToken::class,
    ];

    /**
     * The application's route middleware.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \Jcfk\Http\Middleware\Authenticate::class,
        'admin' => \Jcfk\Http\Middleware\Admin::class,
        'parent' => \Jcfk\Http\Middleware\Parents::class,
        'guest' => \Jcfk\Http\Middleware\RedirectIfAuthenticated::class,
    ];
}
