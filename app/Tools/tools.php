<?php

namespace App\Tools;

class Tools {
    public $redis;
    public function __construct()
    {
        $this->redis = new \Redis();
        $this->redis->connect('127.0.0.1','6379');
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

}
