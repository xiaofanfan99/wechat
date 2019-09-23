<?php

namespace App\Http\Controllers\wechat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use const http\Client\Curl\Features\LARGEFILE;
use DB;
class EventController extends Controller
{
    //接收微信发过来的消息[用户互动] 被动回复
    public function event()
    {
        //把数据存在logs里
        $xml_string = file_get_contents('php://input');//是个可以访问请求的原始数据的只读流
//        dd($xml_string);
        // storage_path路径定位在跟目录下的storage下
        $wechat_log_path=storage_path('logs/wechat/').date('Y-m-d').'.log';
        //file_put_contents('写入文件的路径','文件内容','FILE_APPEND 意思不覆盖上次的文件 在文件末尾追加内容') 将内容写入文件中
        file_put_contents($wechat_log_path,"--------------------------\n",FILE_APPEND);
        //把请求微信返回回来的数据存入日志
        file_put_contents($wechat_log_path,$xml_string,FILE_APPEND);
        file_put_contents($wechat_log_path,"\n--------------------------\n\n",FILE_APPEND);
        //把微信返回回来的数据转换为能看懂的对象类型
        $xml_obj=simplexml_load_string($xml_string,'SimpleXMLElement',LIBXML_NOCDATA);
        //再强制转换为数组类型
        $xml_arr=(array)$xml_obj;
//        dd($xml_arr['EventKey']);

        //把日志写入laravel框架
        \Log::Info(json_encode($xml_arr,JSON_UNESCAPED_UNICODE));
//        echo $_GET['echostr'];
        //业务逻辑
        if($xml_arr['MsgType']=='event'){
            if($xml_arr['Event']=='subscribe'){
                $share_code=explode('_',$xml_arr['EventKey'])[1];
                $user_openid=$xml_arr['FromUserName'];//粉丝openid
                //判断是否已经关注过
                $wechat_openid=DB::table('regist')->where(['regist_id'=>$user_openid])->first();
                if(empty($wechat_openid)){
                    DB::table('regist')->where(['regist_id'=>$share_code])->increment('share_num',1);
                    DB::table('wechat_openid')->insert([
                        'openid'=>$user_openid,
                    ]);
                }
            }else{
                $xml_str='<xml><ToUserName><![CDATA['.$xml_arr['FromUserName'].']]></ToUserName><FromUserName><![CDATA['.$xml_arr['ToUserName'].']]></FromUserName><CreateTime>'.time().'</CreateTime><MsgType><![CDATA[text]]></MsgType><Content><![CDATA[欢迎回来❥(^_-)]]></Content></xml>';
                echo $xml_str;
            }
        }
        $message='欢迎关注 撒拉嘿呦！';
        $xml_str='<xml><ToUserName><![CDATA['.$xml_arr['FromUserName'].']]></ToUserName><FromUserName><![CDATA['.$xml_arr['ToUserName'].']]></FromUserName><CreateTime>'.time().'</CreateTime><MsgType><![CDATA[text]]></MsgType><Content><![CDATA['.$message.']]></Content></xml>';
        echo $xml_str;
    }
}
