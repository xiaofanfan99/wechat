<?php

namespace App\Http\Controllers\wechat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use DB;
use App\Tools\tools;
use Illuminate\Support\Facades\Storage;
class WechatController extends Controller
{
    public $client;
//    封装公共方法调用redis
    public function __construct(Tools $tools)
    {
        $this->tools = $tools;
    }
// 清空调用频次
    public function clear_api()
    {
        $url="https://api.weixin.qq.com/cgi-bin/clear_quota?access_token=".$this->tools->get_wechat_access_token();
        $data=['appid'=>env('WECHAT_APPID')];
        $this->tools->curl_post($url,json_encode($data));
    }
    //微信JS-SDK签名
    public function location()
    {
        $appid=env('WECHAT_APPID');
        //当前网页的URL
        $url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        //随机字符串
        $noncestr=rand(1000,9999).'fhx';
        //时间戳
        $timestamp=time();
        //调用签名算法
        $jsapi_ticket  = $this->tools->get_wechat_jsapi_ticket();
        $sing_str = 'jsapi_ticket='.$jsapi_ticket.'&noncestr='.$noncestr.'&timestamp='.$timestamp.'&url='.$url.'';
        $signature=sha1($sing_str);
        return view('wechat.location',['appid'=>$appid,'noncestr'=>$noncestr,'signature'=>$signature,'timestamp'=>$timestamp]);
    }


    /**
     * 微信模板消息推送
     */
    public function push_template_message()
    {
//       被推送用户的id
        $openid="oReYCwm6xHPCiiUGiY9_tTZNBEf8";
        $url="https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".$this->tools->get_wechat_access_token();
        $data=[
            'touser'=>$openid,
            //模板ID
            'template_id'=>'v2I4rJMvEropL-PL3GCekSX__jgnC_2eSyD8ecDfEis',
            'url'=>'http://www.wxlaravel.com',
            'data'=>[
                'first'=>[
                    'value'=>'小可爱',
                    'color'=>'#FFC0CB'
                ],
                'keyword1'=>[
                    'value'=>'来自小范范',
                    'color'=>'#FFC0CB'
                ],
                'keyword2'=>[
                    'value'=>'你知道吗？近朱者赤，近你者甜',
                    'color'=>'#FFC0CB'
                ],
                'remark'=>[
                    'value'=>'爱你呦',
                    'color'=>'#FFC0CB'
                ],
            ]
        ];
        $re=$this->tools->curl_post($url,json_encode($data,JSON_UNESCAPED_UNICODE));
        $result=json_decode($re,1);
        dd($result);
    }
//  下载素材
    public function material(Request $request)
    {
        $req = $request->all();
        $source_info = DB::table('url_upload')->where(['upload_id'=>$req['upload_id']])->first();
        $media_id = $source_info->media_id;
        $url = 'https://api.weixin.qq.com/cgi-bin/material/get_material?access_token='.$this->tools->get_wechat_access_token();
        $re = $this->tools->curl_post($url,json_encode(['media_id'=>$media_id]));
        if( $source_info->type!= 'video'){
            Storage::put('wechat/'.$source_info->type.'/'.$source_info->file_name, $re);
            DB::table('url_upload')->where(['upload_id'=>$req['upload_id']])->update([
                'path'=>'/storage/wechat/'.$source_info->type.'/'.$source_info->file_name,
            ]);
            dd('ok');
        }
        $result = json_decode($re,1);
        //设置超时参数
        $opts=array(
            "http"=>array(
                "method"=>"GET",
                "timeout"=>3  //单位秒
            ),
        );
        //创建数据流上下文
        $context = stream_context_create($opts);
        //$url请求的地址，例如：
        $read = file_get_contents($result['down_url'],false, $context);
        Storage::put('wechat/video/'.$source_info['file_name'], $read);
        DB::table('url_upload')->where(['id'=>$req['id']])->update([
            'path'=>'/storage/wechat/'.$source_info->type.'/'.$source_info->file_name,
        ]);
        dd('ok');
        //Storage::put('file.mp3', $re);
    }

    public function upload()
    {
        return view('wechat/upload');
    }
    //新增临时素材
    public function do_upload(Request $request,Client $client)
    {
        //接收选择文件上传的类型
        $type=$request->type;
        if($type=="0"){
            dd('请选择文件类型');
        }
        $images=request()->file($type);
        $name='images';
        if(request()->hasFile($name) && request()->file($name)->isValid()) {
            $size = $request->file($name)->getClientsize() / 1024 / 1024; //获取图片大小
            $ext = $request->file($name)->getClientOriginalExtension();//文件类型
            //文件是图片类型
            if ($type == 'image') {
                //判断图片类型
                if (!in_array($ext, ['png','jpeg','gif','jpg'])) {
                    dd('文件类型不支持');
                }
                // 判断图片大小
                if ($size > 2) {
                    dd('文件过大');
                }
            }
            //判断是否是语音
            if($type=='voice') {
                if(!in_array($ext,['amr','mp3'])){
                    dd('语音类型不支持');
                }
                if($size >2){
                    dd('语音过大,播放长度不能超过60秒');
                }
            }
        if($type=="video"){
                if($ext!="mp4"){
                    dd('视频格式不正确');
                }
                if($size>10){
                    dd('视频过大');
                }
            }
            if($type=="thumb"){
                if($ext!="thumb"){
                    dd('缩略图类型不正确');
                }
                if($size >0.64 ) {
                    dd('缩略图过大');
                }
            }
            $file_name=time().rand(10000,99999).'.'.$ext;
            $path=request()->file($name)->storeAs('wechat/image',$file_name);
            $paths=realpath('./storage/'.$path);

            //  取出redis所存的access_token调用永久素材
            $url="https://api.weixin.qq.com/cgi-bin/material/add_material?access_token=".$this->tools->get_wechat_access_token()."&type=$type";
            //调用临时素材
//            $url="https://api.weixin.qq.com/cgi-bin/media/upload?access_token=".$this->Tools->get_wechat_access_token()."&type=$img_type";

              //调用文件上传方法  1
//            $result=$this->curl_upload($url,$path);

//            $photo = request()->file($name)->store('wechat');
//            dd($photo);
            //调用上传文件方法
            $result = $this->client_upload($url,$paths,$client);
//            dd($result);
            //把数据转为数组
            $result=json_decode($result,1);
//            // 拼接添加数据库路径
//            $result['path']='/storage/'.$path;
            //执行添加数据库
            $res=DB::table('url_upload')->insert([
                    'media_id'=>$result['media_id'],
                    'path'=>'/storage/'.$path,
                    'type'=>$type,
                    'created_at'=>time(),
            ]);
            if($res){
                echo "成功";
//                return redirect("{{url('wechat/upload_list')}}");
            }
        }
    }

    public function upload_list(Request $request,Client $client)
    {
        $type=$request->input('type');
////        dd($req);
//        empty($req['source_type'])?$source_type="image":$source_type=$req['source_type'];
////        dd($source_type);
//        if(!in_array($source_type,['image','voice','video','thumb'])){
//            dd('文件类型不正确');
//        }
//        if(!empty($req['page']) && $req['page']<=0){
//            dd('页码错误');
//        }
//        empty($req['page'])?$page=1:$page=$req['page'];
//        if($page<=0){
//            dd('页码错误');
//        }
//        $pre_page = $page-1;
//        $pre_page<= 0 && $pre_page = 1;//上一页
//        $next_page=$page + 1;//下一页
//        获取素材列表
        $url="https://api.weixin.qq.com/cgi-bin/material/batchget_material?access_token=".$this->tools->get_wechat_access_token();
        $data=[
            'type'=>$type,
            'offset'=>0,
            'count'=>20
        ];
        //guzzle使用方法
//        $r=$client->request('post',$url,[
//            'body'=>json_encode($data)
//        ]);
//        $re=$r->getBody();
//        $info=json_decode($re,1);
//        $media_id_list = [];
//        foreach($info['item'] as $v){
//            //同步数据库
//            $media_info = DB::table('url_upload')->where(['media_id'=>$v['media_id']])->first();
//            if(empty($media_info)){
//                DB::table('url_upload')->insert([
//                    'media_id'=>$v['media_id'],
//                    'type' => $type,
//                    'created_at'=>$v['update_time'],
//                    'file_name'=>$v['name'],
//                ]);
//            }
//            $media_id_list[] = $v['media_id'];
//        }
//        微信调用
//        $source_info = DB::table('url_upload')->whereIn('media_id',$media_id_list)->get();
//        数据库调用
        $source_info = DB::table('url_upload')->where('type','=',$type)->get();

        return view('wechat.upload_list',['info'=>$source_info]);
    }

//上传文件方法
    public function client_upload($url,$path,$client)
    {
        $result = $client-> request ('POST',$url,  [
            'multipart' =>[
                [
                    'name'  =>  'media' ,
                    'contents'  =>  fopen ($path,'r' )
                ]
            ]
        ]);
        return $result->getBody();
    }
//上传文件方法 1
    public function curl_upload($url,$path)
    {
        $curl = curl_init($url);
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl,CURLOPT_POST,true);  //发送post
        $form_data = [
            'meida' => new \CURLFile($path)
        ];
        curl_setopt($curl,CURLOPT_POSTFIELDS,$form_data);
        $data = curl_exec($curl);
        //$errno = curl_errno($curl);  //错误码
        //$err_msg = curl_error($curl); //错误信息
        curl_close($curl);
        return $data;
    }

    /**
     * 获取用户的详细信息
     * @param $openid
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function get_user_info($openid)
    {
        // dd($openid);
        $user_info=file_get_contents('https://api.weixin.qq.com/cgi-bin/user/info?access_token='.$this->tools->get_wechat_access_token().'&openid='.$openid.'&lang=zh_CN');
        $user=json_decode($user_info,1);
        // dd($user);
        return view('wechat/userinfo',['info'=>$user]);
    }

    /**
     * 获取用户昵称 微信号
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function get_user_list(Request $request)
    {
//        //使用 easywechat 获取用户列表
//        $app = app('wechat.official_account');
//        $user_list = $app->user->list($nextOpenId = null);  // $nextOpenId 可选
//        dd($user_list);
        //接收标签id
        $req=$request->all();
        $result = file_get_contents('https://api.weixin.qq.com/cgi-bin/user/get?access_token='.$this->tools->get_wechat_access_token().'&next_openid=');
        $re = json_decode($result,1);
        $last_info=[];
        foreach($re['data']['openid'] as $k=>$v){
            $user_info=file_get_contents('https://api.weixin.qq.com/cgi-bin/user/info?access_token='.$this->tools->get_wechat_access_token().'&openid='.$v.'&lang=zh_CN');
            $user=json_decode($user_info,1);
            $last_info[$k]['nickname']=$user['nickname'];
            $last_info[$k]['openid']=$v;
        }
        // dd($last_info);
        return view('wechat/userlist',['info'=>$last_info,'tagid'=>isset($req['tagid'])?$req['tagid']:""]);
    }

    //储存redis文件
    public function get_access_token()
    {
        return $this->tools->get_wechat_access_token();
    }
}
