<?php

namespace App\Admin\Middleware;

use App\Admin\Supports\Admin;

class AdminBootstrap
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  callable $next
     * @return mixed
     */
    public function handle($request, $next)
    {
        /** @var Admin $admin */
        $admin = app(Admin::class);
        $admin->setup();

        return $next($request);
    }
}
