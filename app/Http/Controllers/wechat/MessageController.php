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
        $tools = new Tools();
        \Log::info('测试任务调度');
        $news = $tools->redis->get('news');
        $redis = json_decode($news, 1);
        $url = "https://api.weixin.qq.com/cgi-bin/message/mass/sendall?access_token=" . $tools->get_wechat_access_token();
        $data = [
            'filter' => [
                'is_to_all' => false,
                'tag_id' => $redis['filter']['tag_id'],
            ],
            'text' => [
                'content' => date('Y-m-d H:i:s', time()) . '：' . $redis['text']['content'],
            ],
            'msgtype' => 'text',
        ];
        $result = $tools->curl_post($url, json_encode($data, JSON_UNESCAPED_UNICODE));
        dd($result);
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
    /*
     * 接收code码
     */
    public function code(Request $request)
    {
        $re=$request->all();
        $result=file_get_contents("https://api.weixin.qq.com/sns/oauth2/access_token?appid=".env('WECHAT_APPID')."&secret=".env('WECHAT_APPSECRIT')."&code=".$re['code']."&grant_type=authorization_code");
        $resu=json_decode($result,1);
        $user_info=file_get_contents("https://api.weixin.qq.com/sns/userinfo?access_token=".$resu['access_token']."&openid=".$resu['openid']."&lang=zh_CN");
        $info=json_decode($user_info,1);
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
    /**
     * 留言主页 我的粉丝列表
     */
    public function user_list(Request $request)
    {
        //获取粉丝列表 得到openID
        $user_list=file_get_contents("https://api.weixin.qq.com/cgi-bin/user/get?access_token=".$this->tools->get_wechat_access_token()."&next_openid=");
        $info=json_decode($user_list,1);
        //定义空数组
        $laft_list=[];
        //循环openID
        foreach($info['data']['openid'] as $k=>$v){
            //获取用户基本信息
            $user_info=file_get_contents("https://api.weixin.qq.com/cgi-bin/user/info?access_token=".$this->tools->get_wechat_access_token()."&openid=".$v."&lang=zh_CN");
            $user=json_decode($user_info,1);
            $laft_list[$k]['nickname']=$user['nickname'];
            $laft_list[$k]['openid']=$v;
        }
        return view('message.user_list',['info'=>$laft_list]);
    }
    /**
     * 群发留言表单页面
     */
    public function message(Request $request)
    {
        $openid = $request->all()['openid'];
        return view('message.message',['openid'=>json_encode($openid)]);
    }
    /**
     * 群发留言执行
     */
    public function message_do(Request $request)
    {
        $data = $request->all();
        $openid=$data['openid'];
        $menu=$data['menu'];
        //调用群发留言接口
        $url="https://api.weixin.qq.com/cgi-bin/message/mass/send?access_token=".$this->tools->get_wechat_access_token();
        $menu_data=[
            'touser'=>[
                json_decode($openid,1),
            ],
            'msgtype'=>'text',
            'text'=>[
                'content'=>$menu
            ]
        ];
        $re=$this->tools->curl_post($url,json_encode($menu_data,JSON_UNESCAPED_UNICODE));
        echo " 群发留言成功 ";
    }
}
