<?php

namespace App\Http\Controllers\wechat;

use App\Tools\Tools;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WorkController extends Controller
{
    public $tools;
    public function __construct(Tools $tools)
    {
        $this->tools = $tools;
    }

    //第三方授权登录
    public function login()
    {
        return view('work.login');
    }

    //调用微信第三方登录
    public function login_do()
    {
        $redirect_uri="http://".$_SERVER['HTTP_HOST']."/work/code";
        $url="https://open.weixin.qq.com/connect/oauth2/authorize?appid=".env('WECHAT_APPID')."&redirect_uri=".urlEncode ($redirect_uri)."&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect";
        header('Location:'.$url);
    }

    //获取微信登录code
    public function code(Request $request)
    {
        $res=$request->all();
        //通过code 获取access_token
        $url=file_get_contents("https://api.weixin.qq.com/sns/oauth2/access_token?appid=".env('WECHAT_APPID')."&secret=".env('WECHAT_APPSECRIT')."&code=".$res['code']."&grant_type=authorization_code");
        $re=json_decode($url,1);
        //拉取用户信息
        $user_info=file_get_contents("https://api.weixin.qq.com/sns/userinfo?access_token=".$re['access_token']."&openid=".$re['openid']."&lang=zh_CN");
        $user=json_decode($user_info,1);
        if($user){
            return redirect('work/user');
        }
    }

    //创建用户标签
    public function add_tag()
    {
        //测试redis
//        $redis = $this->tools->redis->get('news');
//        $redis = json_decode($redis,1);
////        dd($redis);
//        $data=[
//            'filter'=>[
//                'is_to_all'=>false,
//                'tag_id'=>$redis['filter']['tag_id'],
//            ],
//            'text'=>[
//                'content'=>$redis['text']['content'],
//            ],
//            'msgtype'=>'text',
//        ];
//        dd($data);
        return view('work/add_tag');
    }
    //添加标签执行
    public function tag_do(Request $request)
    {
        //接收添加标签表单传过来的数据
        $re=$request->all();
        //调用标签添加接口
        $url="https://api.weixin.qq.com/cgi-bin/tags/create?access_token=".$this->tools->get_wechat_access_token();
        $data=[
            'tag'=>[
                'name'=>$re['tagname']
            ],
        ];
        $res=$this->tools->curl_post($url,json_encode($data,JSON_UNESCAPED_UNICODE));
        if($res){
            //跳转标签列表
            return redirect('work/tag_list');
        }
    }
    //标签列表
    public function tag_list()
    {
        //调用标签列表接口
        $url=file_get_contents("https://api.weixin.qq.com/cgi-bin/tags/get?access_token=".$this->tools->get_wechat_access_token());
        $res=json_decode($url,1);
        //调用试图
        return view('work.tag_list',['info'=>$res]);
    }
    /**
     * 获取用户列表
     */
    public function user(Request $request)
    {
        $tagid=$request->tagid;
        empty($tagid)?"":$tagid;
        //获取用户列表
        $user=file_get_contents("https://api.weixin.qq.com/cgi-bin/user/get?access_token=".$this->tools->get_wechat_access_token()."&next_openid=");
        $user_list=json_decode($user,1);
        $laft_list=[];
        //循环获取用户详细信息
        foreach($user_list['data']['openid'] as $k=>$v){
            $user_info=file_get_contents('https://api.weixin.qq.com/cgi-bin/user/info?access_token='.$this->tools->get_wechat_access_token().'&openid='.$v.'&lang=zh_CN');
            $user_info=json_decode($user_info,1);
            $laft_list[$k]['nikename']=$user_info['nickname'];
            $laft_list[$k]['openid']=$user_info['openid'];
            $laft_list[$k]['city']=$user_info['city'];
        }
        return view('work.user_list',['info'=>$laft_list,'tagid'=>$tagid]);
    }

    //给用户打标签
    public function user_tag(Request $request)
    {
        //接收标签id @ 用户openID
        $res=$request->all();
        $url="https://api.weixin.qq.com/cgi-bin/tags/members/batchtagging?access_token=".$this->tools->get_wechat_access_token();
        $data=[
            'openid_list'=>[
                $res['openid'],
            ],
            'tagid'=>$res['tagid'],
        ];
        $re=$this->tools->curl_post($url,json_encode($data,JSON_UNESCAPED_UNICODE));
        if($re){
            return redirect('work/tag_list');
        }
    }
    //消息群发表单页
    public function news(Request $request)
    {
        $tagid=$request->all();
        return view('work.news',['tagid'=>$tagid['tagid']]);
    }

    /**
     * 微信根据标签进行消息群发执行
     */
    public function do_news(Request $request)
    {
        //接收编发传过来的值 和tagid
        $data=$request->all();
        //调用根据标签群发接口
        $url="https://api.weixin.qq.com/cgi-bin/message/mass/sendall?access_token=".$this->tools->get_wechat_access_token();
        $con=[
            'filter'=>[
                'is_to_all'=>false,
                'tag_id'=>$data['tagid'],
            ],
            'text'=>[
                'content'=>$data['news'],
            ],
            'msgtype'=>'text',
        ];
        $cont=json_encode($con,JSON_UNESCAPED_UNICODE);
        //把要发送的数据存入redis
        $this->tools->redis->set('news',$cont);
        //使用post方式
        $result=$this->tools->curl_post($url,$cont);
        $res=json_decode($result,1);
        dd($res);
    }
}
