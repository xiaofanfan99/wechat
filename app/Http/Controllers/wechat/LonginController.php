<?php

namespace App\Http\Controllers\wechat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
class LonginController extends Controller
{
    //登录表单
    public function login() 
    {
        return view('wechat/login');
    }
    // 调用微信登录
    public  function wechat_login()
    {
        $redirect_uri="http://www.wxlaravel.com/wechat/code";
        $url="https://open.weixin.qq.com/connect/oauth2/authorize?appid=".env('WECHAT_APPID')."&redirect_uri=".urlencode($redirect_uri)."&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect";
        header('Location:'.$url);
    }
    /** 
     * 第二步 接收code
     */
    public function code()
    {
        $re=request()->all();
        // dd($re['code']);
        $result=file_get_contents('https://api.weixin.qq.com/sns/oauth2/access_token?appid='.env('WECHAT_APPID').'&secret='.env("WECHAT_APPSECRET").'&code='.$re["code"].'&grant_type=authorization_code');
        $res=json_decode($result,1);
        // dump($res);
        $user_info=file_get_contents('https://api.weixin.qq.com/sns/userinfo?access_token='.$res['access_token'].'&openid='.$res['openid'].'&lang=zh_CN');
        $wechat_user_info=json_decode($user_info,1);
        // dump($wechat_user_info);
        $openid=$wechat_user_info['openid'];
        $user_id=DB::table('regist')->where(['openid'=>$openid])->first();
        // dd($user_id);
        if(!empty($user_id)){
            // 判断不为空登录
            $wechat_session=request()->session()->put('userid',$user_id->regist_id);
            // echo "ok";
            return redirect('/');
            // 跳转首页
        }else{
            // 开启事务
            // DB::beginTransaction();
            // 为空注册登录
            $user_id=DB::table('regist')->insertGetId([
                'email'=>$wechat_user_info['nickname'],
                'password'=>"",
                'openid'=>$openid
            ]);                               
            // dump($user_id);
            $wechat_result=DB::table('wechat_user')->insert([
                'user_id'=>$user_id,
                'openid'=>$openid,
            ]);
            // dump($wechat_result);
            $wechat_session=request()->session()->put('userid',$user_id['regist_id']);
            // echo "ok";
            // echo "<script>alert('注册成功');</script>";
            return redirect('/');
        }
    }

}
