<?php
namespace App\Http\Controllers\hadmin;

use App\Model\hadmin\Cart;
use App\Model\hadmin\Cate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\hadmin\Goods;
use App\Model\hadmin\GoodsAttr;
use App\Model\hadmin\User;
use App\Model\hadmin\Product;
class IndexController extends Controller
{
    /**
     * Display a listing of the resource.
     *前台商品展示
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //前台每日新款发售查询
        $new_data=Goods::orderby('goods_id','desc')->limit(4)->get()->toArray();
        foreach ($new_data as $key=>$value){
            $base_img=env('HOST_URL')."/storage/hadmin/ph6t68oEuGMUBfrcE1o2EW3Bf4diBBWOLs7Y3rpE.jpeg";//默认图片
            if(!empty($new_data[$key]['goods_img'])){
                $new_data[$key]['goods_img']=env('HOST_URL').$value['goods_img'];
            }else{
                //不上传图片 展示默认图片
                $new_data[$key]['goods_img']=$base_img;
            }
        }

        //jsonp方法解决跨域
//        $function_name=$_GET['invoker'];
//        echo "$function_name($new_data)";die;

        return json_encode(['ret'=>1,'new_data'=>$new_data]);
    }
    /**
     * 前台商品详情页
     * @param Request $request
     */
    public function details(Request $request)
    {
        //计算用户访问商品的访问量
        $traffic=0;//查看数据库没有值默认1
        //

        //获取商品详情页传过来的商品id
        $goods_id=$request->input('goods_id');
        //根据商品id查询上皮基本信息
        $goods_data=Goods::where(['goods_id'=>$goods_id])->get()->toArray();
//        var_dump($goods_data[0]['goods_img']);
        $goods_data[0]['goods_img']=env('HOST_URL').$goods_data[0]['goods_img'];
//        var_dump($goods_data);die;
//        echo "<pre>";
        //根据商品查询商品跟属性的关系表 循环处理数据分组
        $goods_attr=GoodsAttr::join('attribute','attribute.attr_id','=','goodsattr.attr_id')->where(['goods_id'=>$goods_id])->get()->toArray();
        //定义一个空的数组  循环遍历数组分组
        $spec_data=[];//可选属性 规格
        $args_data=[];//不可选属性 参数
        foreach ($goods_attr as $key=>$value){
//            var_dump($value);
            if($value['optional']==1){
                //可选属性 规格
                $status=$value['attr_name'];
                $spec_data[$status][]=$value;
            }else{
                //不可选属性 参数
                $args_data[]=$value;
            }
        }
//        echo "<pre>";
//        var_dump($spec_data);
//        var_dump($args_data);
        return json_encode([
            'ret'=>1,
            'spec_data'=>$spec_data,//可选
            'args_data'=>$args_data,//不可选
            'goods_data'=>$goods_data,//商品基本信息
        ]);
    }

    /**
     * 前台商品展示页
     */
    public function goods_show()
    {
        //查询商品表全部商品
        $goods_data=Goods::get()->toArray();
        foreach ($goods_data as  $k=>$v){
            //处理图片加上域名
            $goods_data[$k]['goods_img']=env('HOST_URL').$v['goods_img'];
        }
        return json_encode(['ret'=>1,'goods_data'=>$goods_data]);
    }

    /**
     * 加入购物车
     * @param Request $request
     */
    public function GoodsCartAdd(Request $request)
    {
        $goods_id=$request->input('goods_id');//商品id
        if(!empty($request->input('attr_list'))){
            $attr_list=implode(',',$request->input('attr_list'));//商品属性id 列表
        }
        $user_data = $request->get('user_data');//接收中间件产生的参数
        //根据token 获取用户的id
        $user_id= $user_data->user_id;
        //购物数量
        $buy_number= 1;
        //查看货品表 使用goods_id attr_list 查询库存
        $product_data = Product::where(['goods_id'=>$goods_id,'sku_attr_list'=>$attr_list])->first();
        $goods_number=$product_data['product_number'];//商品库存
        if(empty($product_data) || $buy_number >= $goods_number){//货品表没有值 或者商品库存小于用户添加的数量 都表示没有货
            //没货
            $is_stock=0;
        }else{
            //有货
            $is_stock=1;
        }
        //查询数据库 判断数据库是否有相同商品 有加入购物车数量加一 无新增一条数据
        $cart_data = Cart::where(['goods_id'=>$goods_id,'user_id'=>$user_id,'goods_attr_list'=>$attr_list,])->first();
        if(empty($cart_data)){
            //数据库没有相同数据 新增数据
            Cart::create([
                'goods_id'=>$goods_id,
                'user_id'=>$user_id,
                'goods_attr_list'=>$attr_list,
                'buy_number'=>$buy_number,
                'product_id'=>$product_data['product_id'],
            ]);
        }else{
            //再判断是否有货
            $product_data = Product::where(['goods_id'=>$goods_id,'sku_attr_list'=>$attr_list])->first();
            $goods_number=$product_data['product_number'];//商品库存
            if(empty($product_data) || $buy_number >= $goods_number){//货品表没有值 或者商品库存小于用户添加的数量 都表示没有货
                //没货
                $is_stock=0;
            }else{
                //有货
                $is_stock=1;
            }
            //数据库有相同数据 更新商品数量
            $cart_data->buy_number=$cart_data->buy_number+$buy_number;
            $cart_data->save();
        }
        return json_encode(['ret'=>1,'msg'=>'加入购物车成功']);
    }

    /**
     * 购物车列表
     * @param Request $request
     */
    public function cart_list(Request $request)
    {
        //接收token 通过token获取用户的id
        $user_data = $request->get('user_data');//接收中间件产生的参数
        //根据token 获取用户的id
        $user_id= $user_data->user_id;
        //根据用户的id查询购物车表
        $data=Cart::join('goodsattr','goodsattr.goods_attr_id','=','cart.goods_attr_list')->join('goods','goods.goods_id','=','cart.goods_id')->where(['user_id'=>$user_id])->get()->toArray();
        $goods_attr_list=[];
        //循环购物车数据
        foreach ($data as $key =>$value){
            $data[$key]['goods_img'] = env('HOST_URL').$data[$key]['goods_img'];//拼接商品图片域名
            $goods_attr_list=$value['goods_attr_list'];
            //根据商品属性值id 查询属性值表信息
            $attr_list=GoodsAttr::join('attribute','attribute.attr_id','=','goodsattr.attr_id')->whereIn('goods_attr_id',explode(',',$goods_attr_list))->get()->toArray();
            //把属性值 数据处理成颜色：蓝色 ，内存：128G 的数据
            $attr_group='';
//            echo "<pre>";
//            var_dump($value);
//            var_dump($attr_list);
            foreach($attr_list as $k=>$v){
//                var_dump($v);
                //拼接数据
                $attr_group .=$v['attr_name'].':'.$v['attr_value'].',';
                //计算总价钱
                $total_price=$value['goods_price'] + $v['attr_price'];
            }
            //把拼接好的数据 放入购物车信息数组
            $data[$key]['attr_group']=rtrim($attr_group,',');
            //总价
            $data[$key]['goods_price']=$total_price;
        }
//        var_dump($data);
        return json_encode(['ret'=>1,'msg'=>'成功','data'=>$data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

}
