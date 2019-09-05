<?php

namespace App\Http\Controllers\index;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
class CarController extends Controller
{
    //点击加入购物车
    public function car()
    {
        $post=request()->input();
        // dump($post);
        $where=[
            'user_id'=>session('userIndex')['regist_id'],
            'goods_id'=>$post['goods_id'],
        ];
        //查询购物车有无此商品的信息
        $car=DB::table('car')->where($where)->first();
        $car=json_decode(json_encode($car),true);//吧$car转为数组类型
        //判断有没有登录 
        if(session('userIndex')){
            //购物车表有此商品则更新加入购物车数量
            if($car){
                //购物车表的商品数量加接收的商品数量
                $car['goods_number'] +=$post['goods_number'];
                //更新加入购物车商品数量
                $car=DB::table('car')->where('car_id',$car['car_id'])->update($car,'car_id');
                if($car){
                    return ['ret'=>'00000','msg'=>'成功加入购物车'];
                }
            }else{
                //无购物车表此商品则进行添加操作
                //取出session
                $post['user_id']=session('userIndex')['regist_id'];
                //登录执行加入购物车
                $car=DB::table('car')->insert($post);
                if($car){
                    return ['ret'=>'00000','msg'=>'成功加入购物车'];
                }
            }
        }else{
            //没有登录发送数据 查询登录
            return ['ret'=>'00001','msg'=>'请先登录'];
        }
    }
    //购物车列表
    public function carlist()
    {
        //查询购物车商品表的商品信息
        $car=DB::table('car')
            ->join('goods','goods.goods_id','=','car.goods_id')
            ->get();
        //统计购物车商品数量
        $count=DB::table('car')->count();
        // dd($car);
        return view('index/car',['car'=>$car,'count'=>$count]);
    }
}
