<?php
namespace App\Http\Controllers\wechat;

use App\Tools\Tools;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
class MenuController extends Controller
{
    public $tools;
    // 封装公共方法调用redis
    public function __construct(Tools $tools)
    {
        $this->tools = $tools;
    }

    /**
     * 菜单列表添加
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function menu_list()
    {
        //自定义菜单列表
        $info= DB::table('menu')->get();
        $info =json_decode($info,1);
        return view('menu.menu_list',['info'=>$info]);
    }

    //删除菜单
    public function menu_del(Request $request)
    {
        $id = $request->id;
        $res = DB::table('menu')->delete($id);
        $this->menu();
    }

    /*
     * 添加执行
     */
    public function create_menu(Request $request)
    {
        //接收添加菜单表单传过来的
        $re=$request->all();
        //判断name2 为空就是一级菜单 那么2不为空就是带有二级的一级菜单
        $event_type=empty($re['name2'])?1:2;
        //添加菜单表
        $res = DB::table('menu')->insert([
            'name1'=>$re['name1'],
            'name2'=>$re['name2'],
            'type'=>$re['type'],
            'menu_type'=>$event_type,
            'event_value'=>$re['event_value'],
        ]);
        if(!$res){
            echo "添加菜单失败";
        }
        $this->menu();
    }

    /**
     * 自定义菜单 根据数据库表数据来刷新菜单
     */
    public function menu()
    {
        //定义空数组 一会用来填充数据
        $data=[];
        $event_type=[1=>'click',2=>'view'];
        //查询菜单表的所有数据 查询全部的一级菜单
        $menu_list = DB::table('menu')->select(['name1'])->groupBy('name1')->get();
     //把得到的数据转为数组类型
//        $menu_list=json_decode(json_encode($menu_list),true);
        //循环遍历查到的全部一级菜单
        foreach ($menu_list as $vv){
            //根据一级菜单查询一级菜单下的全部内容
            $menu_info=DB::table('menu')->where(['name1'=>$vv->name1])->get();
            $menu=[];
            //把查询到的所有数据强制转换为数组类型
            foreach ($menu_info as $v){
                //强制转化为数组
                $menu[]=(array)$v;
            }
            $arr=[];
            //循环遍历查到的所有数据
            foreach($menu as $v){
                if($v['menu_type'] == 1){ //判断menu_type==1 普通的是一级菜单
                    //判断type类型==1是click 点击推事件
                    if($v['type'] == 1){//click
                        $arr=[
                            'type'=>'click',
                            'name'=>$v['name1'],
                            'key'=>$v['event_value'],
                        ];
                    }elseif($v['type'] == 2){//view 判断type类型==2 是view 跳转
                        $arr=[
                            'type'=>'view',
                            'name'=>$v['name1'],
                            'url'=>$v['event_value'],
                        ];
                    }
                }elseif($v['menu_type'] == 2){ //判断menu_type==2 是带有二级菜单的一级菜单
                    $arr['name']=$v['name1'];
                    //判断type类型==1是click 点击推事件
                    if($v['type'] == 1){//click
                        $button_type=[
                            'type'=>'click',
                            'name'=>$v['name2'],
                            'key'=>$v['event_value'],
                        ];
                    }elseif($v['type'] == 2){//view 判断type类型==2 是view 跳转
                        $button_type=[
                            'type'=>'view',
                            'name'=>$v['name2'],
                            'url'=>$v['event_value'],
                        ];
                    }
                    $arr['sub_button'][]=$button_type;
                }
            }
            $data['button'][]=$arr;
        }
        $url="https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$this->tools->get_wechat_access_token();
//        $data=[
//            'button'=>[
//                //一级菜单
//                [
//                    'type'=>'click',
//                    'name'=>'今日歌曲',
//                    'key'=>'V1001_TODAY_MUSIC',
//                ],
//                //一级菜单下有二级菜单
//                [
//                    'name'=>'fhx菜单',
//                    'sub_button'=>[
//                        [
//                            'type'=>'view',
//                            'name'=>'查看',
//                            'url'=>'http://baidu.com',
//                        ],
//                        [
//                            'type'=>'click',
//                            'name'=>'赞一下',
//                            'key'=>'V1001_GOOD',
//                        ]
//                    ],
//                ]
//            ]
//        ];
        $res=$this->tools->curl_post($url,json_encode($data,JSON_UNESCAPED_UNICODE));
        $re=json_decode($res,1);
        dd($re);
    }
}
