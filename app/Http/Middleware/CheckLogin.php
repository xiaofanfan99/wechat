<?php

namespace App\Http\Middleware;

use Closure;

class CheckLogin
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
        $usersession = request()->session()->get('usersession');
//        dd($usersession);
        if(!$usersession){
            return redirect('message/login');
        }else{
            return redirect('message/user_list');
        }
        return $next($request);
    }
}
