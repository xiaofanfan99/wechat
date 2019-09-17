<?php

namespace App\Http\Controllers\wechat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Tools\tools;
class MessageController extends Controller
{
    public $tools;
    // 封装公共方法调用redis
    public function __construct(Tools $tools)
    {
        $this->tools = $tools;
    }
    /**
     * 群发留言登录
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function login()
    {
        return view('message.login');
    }

    /**
     *登录执行
     */
    public function do_login()
    {
        $redirect_url="http://www.wxlaravel.com/message/code";
        $url="https://open.weixin.qq.com/connect/oauth2/authorize?appid=".env('WECHAT_APPID')."&redirect_uri=".urlEncode($redirect_url)."&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect";
        header('Location:'.$url);
    }

    //接收code码
    public function code(Request $request)
    {
        $re=$request->all();
        $result=file_get_contents("https://api.weixin.qq.com/sns/oauth2/access_token?appid=".env('WECHAT_APPID')."&secret=".env('WECHAT_APPSECRIT')."&code=".$re['code']."&grant_type=authorization_code");
        $resu=json_decode($result,1);
        $user_info=file_get_contents("https://api.weixin.qq.com/sns/userinfo?access_token=".$resu['access_token']."&openid=".$resu['openid']."&lang=zh_CN");
        $info=json_decode($user_info,1);
//        dd($info);
        $openid=$info['openid'];
        $data=DB::table('regist')->where('openid',$openid)->first();
//        $dat=json_encode($data);
//        $da=json_decode($dat,1);
       if(!empty($data)){
            //数据库存在则登录 存session
            $request->session()->put('usersession',$data->regist_id);
//            echo "ok";
           return redirect('message/user_list');
       }else{
            //为空则添加
            $user_id=DB::table('regist')->insertGetId([
                'email'=>$info['nickname'],
                'password'=>"",
                'openid'=>$openid,
            ]);
            $wechat_result=DB::table('wechat_user')->insert([
                'user_id'=>$user_id,
                'openid'=>$openid,
            ]);
           $request->session()->put('usersession',$data->regist_id);
//           echo "ok";
           return redirect('message/user_list');
       }
    }
    //留言主页 我的粉丝列表
    public function user_list(Request $request)
    {
        //获取粉丝列表
        $user_info=file_get_contents("https://api.weixin.qq.com/cgi-bin/user/get?access_token=".$this->tools->get_wechat_access_token()."&next_openid=");
        $info=json_decode($user_info,1);
        return view('message.user_list',['info'=>$info['data']]);
    }

    public function mess()
    {
        $data=\request()->all();
        dd($data);
        return view('message.message');
    }

    public function message(Request $request)
    {
        $openid = $request->all()['openid'];
        foreach($openid as $v){
            echo $v."<br />";
        }
        $url="https://api.weixin.qq.com/cgi-bin/message/mass/send?access_token=".$this->tools->get_wechat_access_token();
        $data=[
            'touser'=>[
                $openid
            ],
            'msgtype'=>'text',
            'text'=>[
                'content'=>'hello from boxer'
            ]
        ];
        $re=$this->tools->curl_post($url,json_encode($data,JSON_UNESCAPED_UNICODE));
        dd($re);
    }
}
