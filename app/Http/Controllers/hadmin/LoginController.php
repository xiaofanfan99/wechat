<?php

namespace App\Http\Controllers\hadmin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Tools\tools;
class LoginController extends Controller
{
    public $tools;
    public function __construct(Tools $tools)
    {
        $this->tools=$tools;
    }
    /**
     * 登录页
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function login()
    {
        return view('hadmin.login');
    }

    /**
     * 账号绑定
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function binding()
    {
        return view('hadmin.binding');
    }

    /**
     * 扫码登录
     */
    public function scanning()
    {
        $id=time().rand(1000,9999);
        $url="http://fhx.distantplace.vip/hadmin/scanning_do?id=".$id;
        //生成二维码的时候 加一个唯一标识
        return view('hadmin.scanning',['url'=>$url,'id'=>$id]);
    }

    //扫码跳转页面 网页授权
    public function scanning_do(Request $request)
    {
        $id=$request->id;
        $openid=tools::getOpenid();
        $this->tools->redis->set('wechatlogin_'.$id,$openid,10);
        return "扫码登录成功，请稍等";
    }

    /**
     * js轮询检测，如果检测到用户扫码，则停止定时器并跳转 通过唯一标识查询有没有值
     */
    public function checkwechatlogin(Request $request)
    {
        //二维码唯一标识
        $id=$request->id;
        //取缓存 缓存里面有登录成功
        $openid=$this->tools->redis->get('wechatlogin_'.$id);
        if(!$openid){
            //抛错
            return json_encode(['ret'=>0,'msg'=>'用户未扫码']);
        }
        //登录成功储存session
        session(['admmininfo'=>$openid]);
        return json_encode(['ret'=>1,'msg'=>'用户已扫码']);
    }

    /**
     * 绑定账号执行页
     */
    public function binding_do(Request $request)
    {
        $res=$request->all();
        //网页授权获取openid
        $openid = tools::getOpenid();
        // 1查询数据库表有没有此用户
        $login_db=DB::table('login')->where(['username'=>$res['username']])->first();
        if(empty($login_db)){
//            dd('用户名不存在');
            echo "<script>alert('用户名不存在');history.go(-1);</script>";
        }else{
            if($res['password']!=$login_db->password){
//                dd('密码不正确');
                echo "<script>alert('密码不正确');history.go(-1);</script>";
            }else{
                // 2判断是否已经绑定 已经绑定过提示
                if(!$login_db->openid==0){
                    echo "<script>alert('账号已经绑定过');history.go(-1);</script>";
                }else{
                    // 3没有绑定修改表openid字段
                    $data=DB::table('login')->where(['username'=>$res['username'],'password'=>$login_db->password])->update(['openid'=>$openid]);
                    echo "<script>alert('绑定成功');</script>";
                }
            }
        }
    }

    /**
     * 点击发送验证码
     * @param Request $request
     */
    public function send(Request $request)
    {
        //接收用户名 密码
        $data =$request->all();
        //查询数据表 取出openid
        $userData=DB::table('login')->where(['username'=>$data['username'],'password'=>$data['password']])->first();
        if(empty($userData)){
            dd('用户名或密码不存在');
        }
//        dd($userData->openid);
        $userData=get_object_vars($userData);
        //验证码
        $code=rand(1000,9999);
        //验证码储存redis
        $this->tools->redis->set('code',$code);
        //模板消息发送
        $url="https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".$this->tools->get_wechat_access_token();
        $data=[
            'touser'=>$userData["openid"],
            'template_id'=>"Jz6F7EvVtt6_4klItfvAxrPCqTBZCn_bZxVSkdoYm2s",
            'data'=>[
                'code'=>[
                    'value'=>$code,
                    'color'=>"#173177",
                ],
                'name'=>[
                    'value'=>$userData["username"],
                    'color'=>"#173177",
                ],
                'time'=>[
                    'value'=>time(),
                    'color'=>"#173177",
                ],
            ],
        ];
        $res=$this->tools->curl_post($url,json_encode($data,JSON_UNESCAPED_UNICODE));
    }

    public function do_login(Request $request)
    {
        $data=$request->all();
        $code=$this->tools->redis->get('code');
        if($data['code']!=$code){
//            dd('验证码有误，请重新填写');
            echo "<script>alert('验证码有误，请重新填写');history.go(-1);</script>";
        }else{
            return redirect('hadmin/index');
        }

    }
}
