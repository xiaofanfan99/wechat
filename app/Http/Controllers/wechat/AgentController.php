<?php

namespace App\Http\Controllers\wechat;

use App\Tools\Tools;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Support\Facades\Storage;

class AgentController extends Controller
{
    public $tools;
    public function __construct(Tools $tools)
    {
        $this->tools=$tools;
    }
    //用户列表
    public function agent_list()
    {
        $data=DB::table('regist')->get();
//        dd($data);
        return view('agent.user_list',['info'=>$data]);
    }
    //生成二维码
    public function create_qrcode(Request $request)
    {
        //获取 uid
        $scene_id = $request->all();
        $url="https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=".$this->tools->get_wechat_access_token();
        $data=[
            'expire_seconds'=>'604800',
            'action_name'=>'QR_SCENE',
            'action_info'=>[
                    'scene'=>[
                        'scene_id'=>$scene_id['uid']
                    ]
            ]
        ];
        $re=$this->tools->curl_post($url,json_encode($data,JSON_UNESCAPED_UNICODE));
        $res=json_decode($re,1);
        $qrcode_info = file_get_contents('https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket='.UrlEncode($res['ticket']));

        $path = '/wechat/qrcode/'.time().rand(10000,99999).'.jpg';
        Storage::put($path,$qrcode_info);
        DB::table('regist')->where(['regist_id'=>$scene_id['uid']])->update([
            'qrcode_url'=>'/storage'.$path,
        ]);
        return redirect('agent/agent_list');
    }

}
