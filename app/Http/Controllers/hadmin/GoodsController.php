<?php

namespace App\Http\Controllers\hadmin;

use DemeterChain\C;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\hadmin\Type;
use App\Model\hadmin\Cate;
use App\Model\hadmin\Attr;
use App\Model\hadmin\Goods;
use App\Model\hadmin\GoodsAttr;
use App\Model\hadmin\Product;
use App\Tools\Aes;

class GoodsController extends Controller
{
    /**
     * 商品添加
     */
    public function goods_add()
    {
        $key="0987654321987654";
        $obj = new Aes($key); //秘钥
        $data = "加油，你是最棒的！";//明文
        echo $eStr = $obj->encrypt($data);  //加密后的密文
//        echo "<hr>";
//        echo $obj->decrypt($eStr);//解密后的明文

        //查询商品分类
        $cateData = Cate::get()->toArray();
        //查询商品类型
        $typeData = Type::get()->toArray();
        return view('hadmin.admin.goods_add',[
            'cateData'=>$cateData,
            'typeData'=>$typeData
        ]);
    }


    /*
     * 根据商品的类型 获取此类型下的属性
     * @param Request $request
     */
    public function goods_getattr(Request $request)
    {
        $type_id = $request->type_id;
//        dd($type_id);
        $attrData = Attr::where(['type_id'=>$type_id])->get()->toArray();
        if(!empty($attrData)){
            return json_encode(['ret'=>1,'msg'=>'查询成功','data'=>$attrData]);
        }
    }

    /**
     * 商品添加执行页
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Laravel\Lumen\Http\Redirector
     */
    public function goods_do(Request $request)
    {
        //文件上传
        $file = $request->file('file');
//        if ($request->hasFile($file) && $request->file($file)->isValid()) {
//            $store_result = $file->store('photo');
//            dd($store_result);
//        }
        if($file){
            //上传文件
            $store_result = $file->store('hadmin');
        }else{
            $store_result=0;
        }
        $postData=$request->input();
        //商品的基本信息入库
        $goodsData= Goods::create([
            'goods_name'=>$postData['goods_name'],
            'goods_price'=>$postData['goods_price'],
            'cate_id'=>$postData['cat_id'],
            'goods_img'=>'/storage/'.$store_result,
            'details'=>$postData['details']
        ]);
        $goods_id=$goodsData->goods_id;
        //添加商品属性表
        $goodsAttr=[];
        foreach ($postData['attr_value_list'] as $key => $value) {
            $goodsAttr []= [
                'goods_id'=>$goods_id,
                'attr_id'=>$postData['attr_id_list'][$key],
                'attr_value'=>$value,
                'attr_price'=>$postData['attr_price_list'][$key],
            ];
        }
//        var_dump($goodsAttr);die;
        $AttrData = GoodsAttr::insert($goodsAttr);
        if($AttrData){
            return redirect('hadmin/sku_add?goods_id='.$goods_id.'');
        }else{
            echo "<script>alert('商品添加操作有误');history.go(-1);</script>";
        }
    }

    /**
     * 商品列表展示
     */
    public function goods_list(Request $request)
    {
//        phpinfo();
        $goods_name=$request->input('goods_name');
        $cate_id=$request->input('cate_name');
        $where=[];
        if(!empty($goods_name)){
            $where[]=['goods_name','like','%'.$goods_name.'%'];
        }
        if(!empty($cate_id)){
            $where[]=['category.cate_id','=',$cate_id];
        }
        //查询分类表
        $cateData=Cate::get()->toArray();
        //查询商品表信息
        $goods_data=Goods::where($where)->join('category','category.cate_id','=','goods.cate_id')->get()->toArray();
//        dd($goods_data);
        return view('hadmin.admin.goods_list',['data'=>$goods_data,'goods_name'=>$goods_name,'catedata'=>$cateData]);
    }

    /**
     * 商品名称即点即改
     * @param Request $request
     */
    public function goods_name_change(Request $request)
    {
        $goods_data=$request->input();
//        dd($goods_data);
        $res=Goods::where(['goods_id'=>$goods_data['goods_id']])->update(['goods_name'=>$goods_data['goods_name']]);
        if($res){
            return json_encode(['ret'=>0,'msg'=>'修改成功']);
        }
    }

    /**
     * 货品添加
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function sku_add(Request $request)
    {
//        echo "<pre>";
        $goods_id=$request->input('goods_id');
        //直接进到添加货品页 默认goods_id是36
        if(empty($goods_id)){
            $goods_id=36;
        }
        //根据goods_id 查询商品名称
        $goodsData=Goods::where(['goods_id'=>$goods_id])->get()->toArray();
        //根据goods_id查询商品-属性关联表
        $goodsAttr=GoodsAttr::join('attribute','attribute.attr_id','=','goodsattr.attr_id')->where(['goods_id'=>$goods_id,'optional'=>1])->get()->toArray();
        $array=[];
        foreach ($goodsAttr as $key=>$value){
            //根据商品属性名分类
            $status=$value['attr_name'];
           $array[$status][]=$value;
        }
//        var_dump($goodsAttr);
        return view('hadmin.admin.sku_add',['goodsData'=>$goodsData,'attrData'=>$array]);
    }

    /*
     * 货品添加执行页
     * @param Request $request
     */
    public function sku_do(Request $request)
    {
        $attr_data=$request->input();
        $product_numbers=\request()->input('product_number');
        //接收商品的id
        $goods_id=$attr_data['goods_id'];
        $product_number=rand(1000,9999).time();
//        if(array_key_exists('sku_attr_list',$attr_data)){
//            echo "!23";die;
//        }else{
//            dd(1234);
//        }
//        echo "<pre>";
        //没有可选属性 判断
        if(!array_key_exists('sku_attr_list',$attr_data)){
            //没有可选属性 直接添加商品库存 商品id
            $res=Product::create([
                'goods_id'=>$goods_id,
                'product_sn'=>$product_number,//商品货号
                'product_number'=>implode(',',$product_numbers),//进货库存
            ]);
        }else{
            //计算出有几个属性值
            $size= count($attr_data['sku_attr_list']) / count($attr_data['product_number']);
            // array_chunk() 把数组分割为新的数组块 每个属性对应
            $sku_attr_list = array_chunk($attr_data['sku_attr_list'],$size);
            //添加货品sku表商品数据
            foreach ($sku_attr_list as $key=>$value){
                $res=Product::create([
                    'goods_id'=>$goods_id,
                    'sku_attr_list'=>implode(',',$value),//属性值列表
                    'product_sn'=>$product_number,//商品货号
                    'product_number'=>$attr_data['product_number'][$key]//进货库存
                ]);
            }
        }
        if($res){
//            return redirect('hadmin/sku_list');
            echo "<script>alert('货品入库成功');</script>";
        }
    }
}
