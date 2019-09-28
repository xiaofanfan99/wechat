<?php

namespace App\Http\Controllers\wechat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use const http\Client\Curl\Features\LARGEFILE;
use DB;
use App\Tools\tools;
class EventController extends Controller
{
    public $tools;
    public function __construct(Tools $tools)
    {
        $this->tools=$tools;
    }
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
        //签到逻辑
        if($xml_arr['MsgType']=="event" && $xml_arr['Event']=="CLICK"){
            if($xml_arr['EventKey']=="sign"){
                //当天时间
                $today = date('Y-m-d',time());
                //昨天的日期
                $last_day = date('Y-m-d',strtotime('-1 days'));
                //查询数据库是否存在数据
                $openid_info = DB::table("wechat_openid")->where(['openid'=>$xml_arr['FromUserName']])->first();
                if(empty($openid_info)){
                    //不存在添加数据库
                    DB::table('wechat_openid')->insert([
                        'openid'=>$xml_arr['FromUserName'],
                        'add_time'=>time()
                    ]);
                }
                $openid_info = DB::table("wechat_openid")->where(['openid'=>$xml_arr['FromUserName']])->first();
                if($openid_info->sign_day == $today){
                    //已签到
                    $message='您已签到';
                    $xml_str='<xml><ToUserName><![CDATA['.$xml_arr['FromUserName'].']]></ToUserName><FromUserName><![CDATA['.$xml_arr['ToUserName'].']]></FromUserName><CreateTime>'.time().'</CreateTime><MsgType><![CDATA[text]]></MsgType><Content><![CDATA['.$message.']]></Content></xml>';
                    echo $xml_str;
                }else{
                    //未签到  积分
                    if($last_day == $openid_info->sign_day){
                        //连续签到 五天一轮
                        if($openid_info->sign_days >= 5){
                            //签到天数大于5
                            DB::table('wechat_openid')->where(['openid'=>$xml_arr['FromUserName']])->update([
                                'sign_days'=>1,
                                'score'=>$openid_info->score + 5,
                                'sign_day'=>$today
                            ]);
                        }else{
                            //小于5
                            DB::table('wechat_openid')->where(['openid'=>$xml_arr['FromUserName']])->update([
                                //连续天数=数据库签到数据+12
                                'sign_days'=>$openid_info->sign_days+1,
                                //积分=数据库的积分+5 乘 连续签到天数
                                'score'=>$openid_info->score +5 * ($openid_info->sign_days +1),
                                'sign_day'=>$today
                            ]);
                        }
                    }else{
                        //未连续签到 积分加5 签到天数变1
                        DB::table('wechat_openid')->where(['openid'=>$xml_arr['FromUserName']])->update([
                            'sign_days'=>1,
                            'score'=> $openid_info->score +5,
                            'sign_day'=>$today,
                        ]);
                    }
                    $message='签到成功';
                    $xml_str='<xml><ToUserName><![CDATA['.$xml_arr['FromUserName'].']]></ToUserName><FromUserName><![CDATA['.$xml_arr['ToUserName'].']]></FromUserName><CreateTime>'.time().'</CreateTime><MsgType><![CDATA[text]]></MsgType><Content><![CDATA['.$message.']]></Content></xml>';
                    echo $xml_str;
                }
            }
            //查积分
            if($xml_arr['EventKey']=="score"){
                //查询数据库是否存在数据
                $openid_info = DB::table("wechat_openid")->where(['openid'=>$xml_arr['FromUserName']])->first();
                if(empty($openid_info)){
                    //不存在添加数据库
                    DB::table('wechat_openid')->insert([
                        'openid'=>$xml_arr['FromUserName'],
                        'add_time'=>time()
                    ]);
                }
                //查询数据库积分
                $openid_info = DB::table("wechat_openid")->where(['openid'=>$xml_arr['FromUserName']])->first();
                $message='您的积分为'.$openid_info->score.'。';
                $xml_str='<xml><ToUserName><![CDATA['.$xml_arr['FromUserName'].']]></ToUserName><FromUserName><![CDATA['.$xml_arr['ToUserName'].']]></FromUserName><CreateTime>'.time().'</CreateTime><MsgType><![CDATA[text]]></MsgType><Content><![CDATA['.$message.']]></Content></xml>';
                echo $xml_str;
            }
        }
        //判断第一次关注被动回复消息 关注逻辑
        if($xml_arr['MsgType'] == "event"){
            if($xml_arr['Event'] == "subscribe"){
                //获取用户的详细信息
                $user_info=file_get_contents("https://api.weixin.qq.com/cgi-bin/user/info?access_token=".$this->tools->get_wechat_access_token()."&openid=".$xml_arr['FromUserName']."&lang=zh_CN");
                $user=json_decode($user_info,1);
                //关注成功将用户的信息添加数据库
                //查询数据库是否存在
                $db_user=DB::table('wechat_openid')->where(['openid'=>$xml_arr['FromUserName']])->first();
                if(empty($db_user)){
                    //不存在添加数据库
                    DB::table('wechat_openid')->insert([
                        'openid'=>$xml_arr['FromUserName'],
                        'add_time'=>time()
                    ]);
                }
                $message='您好'.$user['nickname'].'当前时间为'.date('Y-m-d H:i:s');
                $xml_str='<xml><ToUserName><![CDATA['.$xml_arr['FromUserName'].']]></ToUserName><FromUserName><![CDATA['.$xml_arr['ToUserName'].']]></FromUserName><CreateTime>'.time().'</CreateTime><MsgType><![CDATA[text]]></MsgType><Content><![CDATA['.$message.']]></Content></xml>';
                echo $xml_str;
            }
        }
        //业务逻辑
//        if($xml_arr['MsgType']=='event'){
//            if($xml_arr['Event']=='subscribe'){
//                $share_code=explode('_',$xml_arr['EventKey'])[1];
//                $user_openid=$xml_arr['FromUserName'];//粉丝openid
//                //判断是否已经关注过
//                $wechat_openid=DB::table('regist')->where(['regist_id'=>$user_openid])->first();
//                if(empty($wechat_openid)){
//                    DB::table('regist')->where(['regist_id'=>$share_code])->increment('share_num',1);
//                    DB::table('wechat_openid')->insert([
//                        'openid'=>$user_openid,
//                    ]);
//                }
//            }else{
//                $xml_str='<xml><ToUserName><![CDATA['.$xml_arr['FromUserName'].']]></ToUserName><FromUserName><![CDATA['.$xml_arr['ToUserName'].']]></FromUserName><CreateTime>'.time().'</CreateTime><MsgType><![CDATA[text]]></MsgType><Content><![CDATA[欢迎回来❥(^_-)]]></Content></xml>';
//                echo $xml_str;
//            }
//        }

    }
}
