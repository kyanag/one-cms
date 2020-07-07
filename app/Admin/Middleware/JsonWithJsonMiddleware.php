<?php

namespace App\Admin\Middleware;

use Closure;
use Symfony\Component\HttpKernel\Exception\HttpException;

class JsonWithJsonMiddleware
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
        try{
            $response = $next($request);
            return $response;
        }catch (\Exception $e){
            if($request->isMethod("get")){
                throw $e;
            }

            if($e instanceof HttpException){
                $response = response()->json([
                    'error' => $e->getMessage(),
                ], $e->getStatusCode());
            }else{
                $response = response()->json([
                    'error' => $e->getMessage(),
                ], 500);
            }
            return $response;
        }
    }
}
