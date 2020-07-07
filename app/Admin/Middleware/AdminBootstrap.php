<?php

namespace App\Admin\Middleware;

use Closure;

class AdminBootstrap
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
        if (file_exists($bootstrap = app_path('Admin/bootstrap.php'))) {
            require $bootstrap;
        }
        return $next($request);
    }
}
