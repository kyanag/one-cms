<?php

namespace App\Providers;

use App\Admin\Middleware\AdminBootstrap;
use App\Admin\Middleware\JsonWithJsonMiddleware;
use Illuminate\Support\ServiceProvider;

class AdminServiceProvider extends ServiceProvider
{

    protected $routeMiddleware = [
        'admin.bootstrap'  => AdminBootstrap::class,
        'admin.jsonHandler' => JsonWithJsonMiddleware::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'admin' => [
            'admin.bootstrap',
            'admin.jsonHandler'
        ],
    ];

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(config_path("admin.php"), "admin");


        // register route middleware.
        foreach ($this->routeMiddleware as $key => $middleware) {
            app('router')->aliasMiddleware($key, $middleware);
        }

        // register middleware group.
        foreach ($this->middlewareGroups as $key => $middleware) {
            app('router')->middlewareGroup($key, $middleware);
        }
    }
}
