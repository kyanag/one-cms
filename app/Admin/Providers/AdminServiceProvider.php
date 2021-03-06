<?php


namespace App\Admin\Providers;


use App\Admin\Middleware\JsonWithJsonMiddleware;
use App\Admin\Supports\Admin;
use App\Admin\Grid\ColumnFactory;
use App\Exceptions\Handler;
use App\Models\Site;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class AdminServiceProvider extends ServiceProvider
{

    protected $routeMiddleware = [

    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'admin' => [
            \App\Admin\Middleware\AdminBootstrap::class,
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            // \Illuminate\Session\Middleware\AuthenticateSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            \App\Admin\Middleware\AdminAuth::class,
        ],
    ];

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        define("ORDER_BY_QUERY_NAME", "orderBy");

        app('view')->prependNamespace('admin', resource_path('views/admin'));

        $this->registerMiddleware();
        $this->mapAdminRoutes();
        $this->registerServices();

        $this->registerMock();
    }


    public function registerServices(){
        $this->app->singleton(Admin::class, function(){
            return new Admin();
        });

        $admin = app(Admin::class);
        $admin->setup();
    }


    public function registerMiddleware(){
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


    protected function mapAdminRoutes(){
        Route::prefix('admin')
            ->namespace("App\\Admin\\Controllers")
            ->middleware("admin")
            ->group(app_path('Admin/routes.php'));
    }



    public function registerMock(){
        if(app()->environment('local')){
            $this->app->singleton("admin.site", function(){
                $attributes = [
                    'id' => 0,
                    'title' => "默认门店",
                ];
                $store = new Site($attributes);
                $store->exists = true;

                return $store;
            });
        }
    }
}