<?php

namespace App\Http\Middleware;

use Closure;

class Login
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
        // 前置中间件
        $result = $request->session()->has('admin');
        if ($result) {
            echo "登陆成功!";
        }
        $response = $next($request);

        // 后置中间件
        echo 22222;
        return $response;
        // return $next($request);
    }
}
