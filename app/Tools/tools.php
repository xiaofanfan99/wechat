<?php

namespace App\Tools;

class Tools {
    public $redis;
    public function __construct()
    {
        $this->redis = new \Redis();
        $this->redis->connect('127.0.0.1','6379');
    }

    //无限级分类
    public static function Createtree($data,$parent_id=0,$level=1)
    {
        foreach ($data as $key=>$value){
            if($value['parent_id']==$parent_id){

            }
        }
    }

//post获取
    public function curl_post($url,$data)
    {
        $curl=curl_init($url);//初始化
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl,CURLOPT_POST,true);// 发送post
        curl_setopt($curl,CURLOPT_POSTFIELDS,$data);//设置属性
        $erron = curl_errno($curl);//错误码
        $error = curl_error($curl);//错误信息
        $data = curl_exec($curl);//执行并获取结果
        curl_close($curl);//释放资源
        return $data;
    }

    // 储存redis access_token
    public function get_wechat_access_token()
    {
        //加入缓存
        $access_token_key='wechat_access_token';
        if($this->redis->exists($access_token_key)){
            //存在
            return $this->redis->get($access_token_key);
        }else{
            //不存在
//            $result = file_get_contents('https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=wxb57ccc35f1cd0968&secret=ade1d283ae95f9fe5b2f3f29d1bab999');
            $result = file_get_contents('https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.env('WECHAT_APPID').'&secret='.env('WECHAT_APPSECRIT').'');
            // 转化数组   1==true
            $re = json_decode($result,1);
            $this->redis->set($access_token_key,$re['access_token'],$re['expires_in']);//加入缓存
            return $re['access_token'];
        }
    }

    // 储存redis jsapi_ticket
    public function get_wechat_jsapi_ticket()
    {
        //加入缓存
        $wechat_jsapi_ticket='wechat_jsapi_ticket';
        if($this->redis->exists($wechat_jsapi_ticket)){
            //存在
            return $this->redis->get($wechat_jsapi_ticket);
        }else{
            //不存在
//            $result = file_get_contents('https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=wxb57ccc35f1cd0968&secret=ade1d283ae95f9fe5b2f3f29d1bab999');
            $result = file_get_contents('https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token='.$this->get_wechat_access_token().'&type=jsapi');
            // 转化数组   1==true
            $re = json_decode($result,1);
            $this->redis->set($wechat_jsapi_ticket,$re['ticket'],$re['expires_in']);//加入缓存
            return $re['ticket'];
        }
    }

    /**
     * 网页授权获取用户openid
     * @return [type] [description]
     */
    public static function getOpenid()
    {
        //先去session里取openid
        $openid = session('openid');
        //var_dump($openid);die;
        if(!empty($openid)){
            return $openid;
        }
        //微信授权成功后 跳转咱们配置的地址 （回调地址）带一个code参数
        $code = request()->input('code');
        if(empty($code)){
            //没有授权 跳转到微信服务器进行授权
            $host = $_SERVER['HTTP_HOST'];  //域名
            $uri = $_SERVER['REQUEST_URI']; //路由参数
            $redirect_uri = urlencode("http://".$host.$uri);  // ?code=xx
            $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=".env('WECHAT_APPID')."&redirect_uri={$redirect_uri}&response_type=code&scope=snsapi_base&state=STATE#wechat_redirect";
            header("location:".$url);die;
        }else{
            //通过code换取网页授权access_token
            $url =  "https://api.weixin.qq.com/sns/oauth2/access_token?appid=".env('WECHAT_APPID')."&secret=".env('WECHAT_APPSECRIT')."&code={$code}&grant_type=authorization_code";
            $data = file_get_contents($url);
            $data = json_decode($data,true);
            $openid = $data['openid'];
            //获取到openid之后  存储到session当中
            session(['openid'=>$openid]);
            return $openid;
            //如果是非静默授权 再通过openid  access_token获取用户信息
        }
    }

}
