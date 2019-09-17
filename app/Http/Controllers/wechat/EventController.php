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
        $xml_string = file_get_contents('php://input');//是个可以访问请求的原始数据的只读流
        $wechat_log_path=storage_path('logs/wechat/').date('Y-m-d').'.log';
        file_put_contents($wechat_log_path,"--------------------------\n",FILE_APPEND);
        file_put_contents($wechat_log_path,$xml_string,FILE_APPEND);
        file_put_contents($wechat_log_path,"\n--------------------------\n\n",FILE_APPEND);
        $xml_obj=simplexml_load_string($xml_string,'SimpleXMLElement',LIBXML_NOCDATA);
        $xml_arr=(array)$xml_obj;
        \Log::Info(json_encode($xml_arr,JSON_UNESCAPED_UNICODE));
//        echo $_GET['echostr'];
        //业务逻辑
        if($xml_arr['MsgType']=='event'){
            //判断event=="subscribe"说明用户第一次扫码
            if($xml_arr['Event']=='subscribe'){
                //取出二维码专属推荐码 取第一个元素专属码
                $share_code = explode('_',$xml_arr['EventKey'])[1];
                //数据库share_code字段自增加一
                DB::table('regist')->where(['regist_id'=>$share_code])->increment('share_code',1);
            }
        }
    }
}
