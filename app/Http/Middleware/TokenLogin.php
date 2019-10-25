<?php

namespace App\Http\Middleware;

use App\Model\hadmin\User;
use Closure;

class TokenLogin
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
        //未登录判断token
        $token=$request->input('token');//用户token
        if(empty($token)){
            return json_encode(['ret'=>201,'msg'=>'请先登录']);
        }
        //判断数据库token字段对不对
        $user_data=User::where(['token'=>$token])->first();
        if(empty($user_data)){
            return json_encode(['ret'=>201,'msg'=>'请先登录']);
        }
        //判断过期时间
        if( time() > $user_data['expire_time']){
            return json_encode(['ret'=>201,'msg'=>'请先登录']);
        }
        //延长token的有效期
        $user_data->expire_time=time()+7200;//过期时间 7200两小时  3600 一小时
        $user_data->save();//进行数据库修改
        //向控制器传参数
        $mid_params = ['user_data'=>$user_data];
        $request->attributes->add($mid_params);//添加参数

        return $next($request);
    }
}
