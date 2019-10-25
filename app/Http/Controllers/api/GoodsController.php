<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\api\Goods;
use Illuminate\Support\Facades\Cache;
class GoodsController extends Controller
{
    /**
     * k780天气查询接口
     */
    public function weather(Request $request)
    {
        //根据天气查询
        $city=$request->input('city');
        if(empty($city)){
            $city="北京";
        }
        //判断缓存 有缓存读缓存没有缓存获取信息
        $Cache_key="weather_key_".$city;
        $value = Cache::get($Cache_key);
        if(!isset($value)){
            echo "接口信息";
            //调用k780天气接口
            $value=file_get_contents("http://api.k780.com:88/?app=weather.future&weaid={$city}&&appkey=10003&sign=b59bc3ef6191eb9f747dd4e83c99f2a4&format=json");
            //存入缓存
            //时间存当天凌晨
            $date=date('Y-m-d');// 2019-10-14 00:00:00
            $time24=strtotime($date)+86400;//把格式化时间转为时间戳
            //获取当前时间 凌晨时间减去当期时间
            $Cache_time=$time24-time();
            Cache::put($Cache_key,$value,$Cache_time);
        }
        return json_encode(['ret'=>0,'msg'=>'查询成功','data'=>json_decode($value,1)]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // echo "index";
        //查询商品 分页
        $data=Goods::paginate(2);
        if(!empty($data)){
            return json_encode(['ret'=>0,'msg'=>'查询成功','data'=>$data]);
        }else{
            return json_encode(['ret'=>1,'msg'=>'查询失败']);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        echo "create";
    }

    /**
     *商品添加执行页
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // echo "store";
        //商品添加
        $goods_name=$request->input('goods_name');
        $goods_price=$request->input('goods_price');
        //接收文件上传
        if ($request->hasFile('goods_img') && $request->file('goods_img')->isValid()) {
            $photo = $request->file('goods_img');
            $extension = $photo->extension();
            $store_result = $photo->store('photo');
            }
        $data=Goods::create([
            'goods_name'=>$goods_name,
            'goods_price'=>$goods_price,
            'goods_img'=>'/storage/'.$store_result,
        ]);
        if(!empty($data)){
            return json_encode(['ret'=>0,'msg'=>'商品添加成功']);
        }else{
            return json_encode(['ret'=>1,'msg'=>'商品添加有误']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        echo "show";
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        echo "edit";
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        echo "update";
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        echo "destory";
    }
}
