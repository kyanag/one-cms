<?php


namespace App\Admin\Middleware;


use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AdminAuth
{

    protected $ignoreRoutes = [
        "admin.session.loginEntry",
        "admin.session.login"
    ];


    public function handle(Request $request, Closure $next, $guard = null)
    {
        if (!$this->isIgnoreRoute() && !\auth("admin")->check()) {
            Log::debug("session {$request->route()->getName()}", $request->session()->all());
            flash("请登录!");
            return redirect(route("admin.session.loginEntry"));
        }
        return $next($request);
    }

    protected function isIgnoreRoute(){
        return in_array(app("request")->route()->getName(), $this->ignoreRoutes);
    }
}