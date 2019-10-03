<?php

namespace App\Http;


use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * Define a lista de middlewares HTTP (TRATADORES de REQUISIÇÃO) que serão executados GLOBALMENTE
     *
     * Esses middlewares são executados durante todas as solicitações para o seu aplicativo.
     *
     * @var array
     */
    protected $middleware = [
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \App\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
        \App\Http\Middleware\TrustProxies::class,
    ];

    /**
     * Define a Lista de middlewares globais, isto é, que sempre serão executados durante uma requisição p/ arquivos de rota 'web.php'
     *
     * Obs.: Pode-se acrescentar mais Middlewares a esta lista, como é o caso de 'autenticador'
     *
     * Tbm define os middlewares tratadores de requisição p/ API's 'api.php'
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            // \Illuminate\Session\Middleware\AuthenticateSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,

            //'autenticador'
        ],

        'api' => [
            'throttle:60,1',
            'bindings',
        ],
    ];

    /**
     * O middleware de rota do aplicativo.
     *
     * Define os middlewares que poderão ser chamados individualmente sobre os arquivos de ROTAS (web, api, console, etc)
     *
     * Esses middlewares podem ser atribuídos a grupos ou usados individualmente.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \Illuminate\Auth\Middleware\Authenticate::class,    // Middleware padrão, se nenhum outro for usado
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,

        //Middleware que verifica se o usuario está autenticado
        'autenticador' => \App\Http\Middleware\Autenticador::class,
    ];
}
