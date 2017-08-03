<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
              \App\Http\Middleware\VerifyCsrfToken::class,
        ],

        'api' => [
            'throttle:60,1',
            'role:Administrator',
            'role:SuperVisor',
            'role:Operator',
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'role'  =>  \App\Http\Middleware\AuthChecking::class,
        'rolec'  =>  \App\Http\Middleware\CreateChecking::class,
        'roleu'  =>  \App\Http\Middleware\UpdateChecking::class,
        'roled'  =>  \App\Http\Middleware\DeleteChecking::class,
        'rolewas'  =>  \App\Http\Middleware\AuthwasChecking::class,
        'rolewasc'  =>  \App\Http\Middleware\CreatewasChecking::class,
        'rolewasu'  =>  \App\Http\Middleware\UpdatewasChecking::class,
        'rolewasd'  =>  \App\Http\Middleware\DeletewasChecking::class,
        'rkoperasi'  =>  \App\Http\Middleware\KoperasiMiddleware::class,
        'rpos'  =>  \App\Http\Middleware\POSMiddleware::class,
    ];
}
