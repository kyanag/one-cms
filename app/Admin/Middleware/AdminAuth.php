<?php


namespace App\Admin\Middleware;


use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuth
{

    protected $ignoreRoutes = [
        "admin.session.create",
        "admin.session.store"
    ];


    public function handle(Request $request, Closure $next, $guard = null)
    {
        if (!$this->isIgnoreRoute() && !Auth::check()) {
//            flash("请登录!");
//            return redirect(route("admin.session.create"));
        }
        return $next($request);
    }

    protected function isIgnoreRoute(){
        return in_array(app("request")->route()->getName(), $this->ignoreRoutes);
    }
}