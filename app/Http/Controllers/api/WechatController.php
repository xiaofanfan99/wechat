<?php

namespace App\Http\Controllers\api;

use DemeterChain\C;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\api\Wechat_user;
use Illuminate\Support\Facades\Cache;
class WechatController extends Controller
{
    //注册
    public function regist()
    {
        return view('api.wechat.regist');
    }
    //注册执行
    public function regist_do(Request $request)
    {
        //接收用户的名称 密码
        $username=$request->input('username');
        $password=$request->input('password');
        $appid='wx'.'1902'.'1001';
        //appsecret
        $appsecret=md5($username.time().$password);
        //注册时 生成appid 判断数据库有没有APPID 没有默认
        $appid_data = Wechat_user::orderBy('user_id','desc')->limit(1)->first('appid')->toArray();
        if(empty($appid_data['appid'])){//添加入库 appid默认1001
            Wechat_user::create([
                'username'=>$username,
                'password'=>$password,
                'appid'=>$appid,
                'appsecret'=>$appsecret
            ]);
        }else{
            //添加入库appid加一
            Wechat_user::create([
                'username'=>$username,
                'password'=>$password,
                'appid'=>$appid_data['appid']+1,
                'appsecret'=>$appsecret
            ]);
        }
        return json_encode(['ret'=>0,'msg'=>'注册成功']);
    }
    //登录
    public function login()
    {
        return view('api.wechat.login');
    }
    //登录执行
    public function login_do(Request $request)
    {
        //接收用户传过来的名称 密码
        $username=$request->input('username');
        $password=$request->input('password');
        $key="wechat_user";
        $user_data=Wechat_user::where(['username'=>$username,'password'=>$password])->first()->toArray();
        if(empty($user_data)){
            return json_encode(['ret'=>1,'msg'=>'用户名或密码不正确']);
        }else{
            //正确登录
            //存储
            Cache::put($key,$user_data);
            return json_encode(['ret'=>0,'msg'=>'登录成功']);
        }
    }
    //微信接口开发首页
    public function wechat_list()
    {
        //根据用户名密码 查询appid appsecret
        $user_data=Cache::get('wechat_user');
        $db_data=Wechat_user::where(['user_id'=>$user_data['user_id']])->first()->toArray();
//        dd($db_data);
        return view('api.wechat.wechat_list',['db_data'=>$db_data]);

    }

    //修改api_url安全域名
    public function api_url(Request $request)
    {
        //接收用户的id
        $user_id=$request->input('user_id');
        //接收用户的api_url
        $api_url=$request->input('api_url');
        //修改数据库
        $user_data=Wechat_user::where(['user_id'=>$user_id])->update(['api_url'=>$api_url]);
        return redirect('api/wechat/wechat_list');
    }
    //access_token接口
    public function set_access_token(Request $request)
    {
        //PHP执行时间超过了30秒的限制   设置php超常时间
        set_time_limit(100);
        $appid=$request->input('appid');
        $appsecret=$request->input('appsecret');
       //查询数据库 判断有无相等数据
        $wechat_data=Wechat_user::where(['appid'=>$appid])->first()->toArray();
        if(empty($wechat_data)){
            //appid错误或者不存在
            return json_encode(['ret'=>4001,'msg'=>'Appid error while getting access_token']);die;
        }
        if($appsecret !=$wechat_data['appsecret']){
            //appsecret 有误错误提示
            return json_encode(['ret'=>4002,'msg'=>'An error occurred with appsecret while obtaining access_token']);die;
        }
            //根据每个用户的appid设置access_token键名
            $token_key="access_token".$appid;
            //设置随机access_token
            $access_token=md5(time().rand(1000,9999).$appid);
            Cache::put($token_key,$access_token,7200);//存储access_token
            $get_token = Cache::get($token_key);//取出access_token
            if(!$get_token){
                //access_token 已经过期，错误提示
                return json_encode(['ret'=>4003,'msg'=>'Access_token overdue']);die;
            }
            //正确获取返回access_token
            return json_encode(['ret'=>0,'msg'=>'OK','token'=>$get_token,'Expiration'=>7200]);
    }
}
