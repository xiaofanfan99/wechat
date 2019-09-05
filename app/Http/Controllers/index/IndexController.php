<?php

namespace App\Http\Controllers\index;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Support\Facades\Redis;
class IndexController extends Controller
{
    //前台首页展示
    public function index()
    {
        //redis设置值
        // Redis::set('name', 'wqer');
        //redis取值
        // echo Redis::get('name');
        // die;
        //实例化memcache
        // $mem = new \Memcache;
        //链接memcache服务 第一个参数服务地址 第二个参数端口号 默认11211
        // $mem->connect('127.0.0.1','11211');
        // //设置memcache 第一个参数键 第二个参数值 第三个默认0 第四个参数设置的时间以秒为单位
        // $mem->set('key','fhx',0,20);
        // //取值
        // echo $mem->get('key');die;
        //如何使用
        // $data= DB::table('cate')->get();
        // $mem->set('IndexController_index_cate',json_encode($data),0,20);
        // $data = $mem->get('IndexController_index_cate');

        // if(empty($data)){
        //     $data= json_encode(DB::table('cate')->get());
        //     $mem->set('IndexController_index_cate',$data,0,20);
        // }
        // dd($data);
        //查看php配置
        // echo phpinfo();



        //全局搜索
        $goods_name=request()->goods_name;
        if($goods_name){
            $where[]=['goods_name','like','%'.$goods_name.'%'];
        }
        //判断有无搜索条件
        if($goods_name){
            //有则搜索展示
            $is_recommend=DB::table('goods')->where($where)->get();
        }else{
            //无则查询首页推荐展示
            $is_recommend=DB::table('goods')->where('is_recommend',1)->limit(8)->get();
        }
        //幻灯片显示
        $is_slide=DB::table('goods')->where('is_slide',1)->orderby('goods_id','desc')->limit(5)->get();
        //查询全部商品数量
        $count=DB::table('goods')->count();
        //查询一级分类
        $cate=DB::table('cate')->where('parent_id',0)->get();
        //发送数据到试图
        return view('index/index',['count'=>$count,'is_slide'=>$is_slide,'cate'=>$cate,'is_recommend'=>$is_recommend,'goods_name'=>$goods_name]);
    }
    
    //全部商品
    public function prolist()
    {
        //全部商品进行搜索
        $goods_name=request()->goods_name;
        $where=[];
        if($goods_name){
            $where[]=['goods_name','like','%'.$goods_name.'%'];
        }
        //查询全部商品
        $data=DB::table('goods')->where($where)->orderby('goods_id','desc')->get();
        
        return view('index/prolist',['data'=>$data]);
    }

    //商品详情页展示
    public function proinfo($id)
    {
        $goods=DB::table('goods')->where('goods_id',$id)->first();
        // dd($goods);
        return view('index/proinfo',['goods'=>$goods]);
    }

    // 根据分类查询商品商品列表展示
    public function catlist($id)
    {
        // 根据id查询子类id
         $cate=DB::table('cate')->get();
         //使用递归查询分类下的子分类
         $cate = createtree($cate,$id);
        $where=[
            'cate_id'=>$id,
        ];
        //查询顶级分类
        $cates=DB::table('cate')->where($where)->get()->toarray();
        //合并子分类和顶级分类
        $cat=array_merge($cate,$cates);
        //把合并的值转换为数组
        $cat = json_decode(json_encode($cat),true);
        //取出所有的ctae_id
        $column=array_column($cat,'cate_id');
        //根据cate_id查询商品表
        $data=DB::table('goods')->where(['goods.cate_id'=>$column])->get();
        // dump($data);
        return view('index/catlist',['data'=>$data]);
    }

}
