<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Cache;
class Api
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
        //解决跨域问题
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');

        //根据ip做接口防刷
        $ip=$_SERVER['REMOTE_ADDR'];//获取用户的ip
        $cache_name='pass_time_'.$ip; //设置键'xxx_'.$ip;
        $num=Cache::get($cache_name); //取缓存 判断缓存
        if(!$num){//没有缓存数据默认0
            $num = 0;
        }
        $num += 1;
        if($num > 50){//判断当缓存大于指定的次数 拦截
            echo json_encode(['ret'=>403,'msg'=>'访问接口次数频繁,请稍后']);die;
        }
        //根据ip缓存 cache
        Cache::put($cache_name,$num,60);
        return $next($request);
    }
}
