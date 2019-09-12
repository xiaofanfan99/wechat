<?php

namespace App\Http\Controllers\wechat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Tools\tools;

class TagController extends Controller
{
    public $tools;
    public function __construct(Tools $tools)
    {
        $this->tools = $tools;
    }

    /**
     * 微信标签列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function tag_list()
    {
        //调用接口
        $url="https://api.weixin.qq.com/cgi-bin/tags/get?access_token=".$this->tools->get_wechat_access_token();
        //get获取
        $stu=file_get_contents($url);
        $result=json_decode($stu,1);
        return view('tag.tag_list',['info'=>$result['tags']]);
    }

    /**
     * 微信标签添加表单
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add_tag()
    {
        return view('tag.add_tag');
    }

    /**
     * 标签添加执行
     * @param Request $request
     */
    public function do_add_tag(Request $request)
    {
        //接收表单传过来的标签名称
        $re=$request->all();
        //调用添加接口
        $url="https://api.weixin.qq.com/cgi-bin/tags/create?access_token=".$this->tools->get_wechat_access_token();
        //取出标签名称
        $data=[
            'tag'=>[
                'name'=>$re['tag_name']
            ]
        ];
        //post请求方式
        $result = $this->tools->curl_post($url,json_encode($data,JSON_UNESCAPED_UNICODE));
//        echo "ok";
        if($result){
            return redirect('wechat/tag_list');
        }
    }

    //标签删除方法
    public function del_tag($id)
    {
        //调用标签删除接口
        $url="https://api.weixin.qq.com/cgi-bin/tags/delete?access_token=".$this->tools->get_wechat_access_token();
        //获取要删除标签的id
        $ids=[
            'tag'=>[
                'id'=>$id,
            ]
        ];

        //使用post请求方式 不可以使用get
        $res = $this->tools->curl_post($url,json_encode($ids));
        if($res){
            return redirect('wechat/tag_list');
        }

    }

    /**
     * 修改
     * @param $id
     */
    public function upd_tag($id,$name)
    {
        return view('tag.upd_tag',['id'=>$id,'name'=>$name]);
    }

    /**
     * 微信修改标签执行
     * @param $id
     * @param Request $request
     */
    public function do_upd_tag($id ,Request $request)
    {
        //接收要修改的标签id和要修改的标签名称
        $name=$request->all();
        //调用标签修改接口
        $url="https://api.weixin.qq.com/cgi-bin/tags/update?access_token=".$this->tools->get_wechat_access_token();
        $data=[
                'tag'=>[
                    'id'=>$id,
                    'name'=>$name['tag_name']
                ]
        ];
        //使用post请求方式
        $res = $this->tools->curl_post($url,json_encode($data,JSON_UNESCAPED_UNICODE));
        if($res){
            return redirect('wechat/tag_list');
        }
    }

    /**
     * 获取标签下粉丝列表
     */
    public function tag_fans_list(Request $request)
    {
        $req=$request->all();
        $url="https://api.weixin.qq.com/cgi-bin/user/tag/get?access_token=".$this->tools->get_wechat_access_token();
        $data=[
            'tagid'=>$req['tagid'],
            'next_openid'=>""
        ];
        $result=$this->tools->curl_post($url,json_encode($data));
        $res=json_decode($result,1);

        //根据openid进行查看粉丝信息
//        $results = file_get_contents('https://api.weixin.qq.com/cgi-bin/user/get?access_token='.$this->tools->get_wechat_access_token().'&next_openid=');
//        $re = json_decode($results,1);
//
//        $last_info=[];
//        foreach($re['data']['openid'] as $k=>$v){
//            $user_info=file_get_contents('https://api.weixin.qq.com/cgi-bin/user/info?access_token='.$this->tools->get_wechat_access_token().'&openid='.$v.'&lang=zh_CN');
//            $user=json_decode($user_info,1);
//            dd($user);
//            echo $re['data']['openid']=$v;
//        }

        return view('tag.tag_fans_list',['info'=>$res['data']['openid']]);
    }

    /**
     *批量给用户打标签
     * @param Request $request
     */
    public function tag_openid(Request $request)
    {
        $req=$request->all();
//        dd($req);
        $url="https://api.weixin.qq.com/cgi-bin/tags/members/batchtagging?access_token=".$this->tools->get_wechat_access_token();
        $data=[
            'openid_list'=>$req['openid'],
            'tagid'=>$req['tagid'],
        ];
//        dd($data);
        $result=$this->tools->curl_post($url,json_encode($data));
        $res=json_decode($result,1);
        dd($res);
    }

    /**
     * 获取粉丝下的标签列表
     * @param Request $request
     */
    public function tag_user_list(Request $request)
    {
        $req=$request->all();
        //调用获取粉丝下的标签列表接口
        $url="https://api.weixin.qq.com/cgi-bin/tags/getidlist?access_token=".$this->tools->get_wechat_access_token();
        $data=[
            'openid'=>$req['openid'],
        ];
//        使用post方式
        $result=$this->tools->curl_post($url,json_encode($data));
        $res=json_decode($result,1);
//获取公众号已创建的标签
        $urls="https://api.weixin.qq.com/cgi-bin/tags/get?access_token=".$this->tools->get_wechat_access_token();
        $re=file_get_contents($urls);
        $re=json_decode($re,1);
        $tag_arr=[];
        //根据标签id把id转为标签名称
        foreach($re['tags'] as $v){
            $tag_arr[$v['id']] = $v['name'];
        }
//        dd($tag_arr);
        foreach ($res['tagid_list'] as $v){
                echo $v=$tag_arr[$v]."<br>";
        }
    }

    /**
     * 微信根据标签消息推送
     * @param Request $request
     */
    public function push_tag_message(Request $request)
    {
        //接收tagid
        $req=$request->all();
        //发送试图
        return view('tag.push_tag_message',['tagid'=>$req['tagid']]);
    }

    /**
     * 执行根据标签推送消息
     * @param Request $request
     */
    public function do_push_tag_message(Request $request)
    {
        $req=$request->all();
        //调用根据标签进行消息推送
        $url="https://api.weixin.qq.com/cgi-bin/message/mass/sendall?access_token=".$this->tools->get_wechat_access_token();
        //发送文本格式
        $data=[
            'filter'=>[
                'is_to_all'=>false,
                'tag_id'=>$req['tagid'],
            ],
            'text'=>[
                'content'=>$req['message'],
            ],
            'msgtype'=>'text',
        ];
        //使用post方式
        $result=$this->tools->curl_post($url,json_encode($data,JSON_UNESCAPED_UNICODE));
        $res=json_decode($result,1);
        dd($res);

    }

}
