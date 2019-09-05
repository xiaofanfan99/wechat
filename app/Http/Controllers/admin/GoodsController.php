<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
<<<<<<< HEAD
use DB;
class GoodsController extends Controller
{
    public function goods_add()
    {
        $brand=DB::table('brand')->get();
        // dd($brand);
        $data=DB::table('cate')->get();
        // dd($data);
        //调用无限极分类
        $data = createtree($data);
        return view('admin/goods/goods_add',['data'=>$data,'brand'=>$brand]);
    }

    public function goods_do()
    {
        $post=request()->except('_token');
        $post['goods_sn']='ff'.'1902'.rand(1000,9999).date('Ymd');
        //判断是否有文件上传
        if(request()->hasFile('goods_img'))
        {
            //调用upload文件上传方法 
            $post['goods_img'] = upload('goods_img');
        }
        // dd($post);
        $stu=DB::table('goods')->insert($post);
        // dd($stu);
        if($stu){
            return redirect('goods/goods_list');
        }
    }

    public function goods_list()
    {
        $post=request()->input();
        // dd($post);
        $goods_name=$post['goods_name']??"";
        $is_on_sale=$post['is_on_sale']??"";
        $is_new=$post['is_new']??"";
        $is_hot=$post['is_hot']??"";
        $where=[];
        if($goods_name){
            $where[]=['goods_name','like','%'.$goods_name.'%'];
        }
        if($is_on_sale==1 || $is_on_sale==='0'){
            $where[]=['is_on_sale','=',$is_on_sale];
        }
        if($is_new==1 || $is_new==='0'){
            $where[]=['is_new','=',$is_new];
        }
        if($is_hot==1 || $is_hot==='0'){
            $where[]=['is_hot','=',$is_hot];
        }
        $pagesize=config('app.pagesize');
        $data=DB::table('goods')->where($where)
            ->join('cate','cate.cate_id','=','goods.cate_id')
            ->join('brand','brand.brand_id','=','goods.brand_id')
            ->paginate($pagesize);
        // dd($data);
        return view('admin/goods/goods_list',compact(['data','goods_name','is_on_sale','is_new','is_hot']));
    }

    public function changeonly(){
        $goods_name=request()->goods_name;
        $goods_id=request()->goods_id??"";
        // dd($goods_id);
        if($goods_id){
            $where[]=['goods_id','!=',$goods_id];
        }
        if($goods_name){
            $where[]=['goods_name','=',$goods_name];
        }
        // dd($goods_name);
        $msg=DB::table('goods')->where($where)->count();
        echo $msg;
    }

    public function delete($id)
    {
        dd($id);
    } 
    //商品修改
    public function upd($id)
    {
        $brand=DB::table('brand')->get();
        // dd($brand);
        $cate=DB::table('cate')->get();
        // dd($data);
        //调用无限极分类
        $cate = createtree($cate);
        // dd($id);
        $id=request()->id;
        $data=DB::table('goods')->where('goods_id',$id)->first();
        // dd($stu);
        return view('admin/goods/upd',['data'=>$data,'cate'=>$cate,'brand'=>$brand]);
    }

    public function update($id)
    {
        // dd($id);
        $id=request()->id;
        $post=request()->except('_token');
        //货号
        $post['goods_sn']='ff'.'1902'.rand(1000,9999).date('Ymd');
        //判断是否有文件上传
        if(request()->hasFile('goods_img'))
        {
            //调用upload文件上传方法 
            $post['goods_img'] = upload('goods_img');
            if($post['oldimg']){
                //使用函数拼接图片路径
                $filename = storage_path('app/public').'/'.$post['oldimg'];
                //检测图片是否存在
                if(file_exists($filename)){
                    //存在则删除图片
                    unlink($filename);
                }
            }
        }
        //入库前删除隐藏域传过来得到旧图片的值
        unset($post['oldimg']);

        $stu=DB::table('goods')->where('goods_id',$id)->update($post,'goods_id');

        if($stu){
            return redirect('goods/goods_list');
        }
    }
    
=======

class GoodsController extends Controller
{
    public function add_goods()
    {
    	return view('admin.add_goods');
    }

    public function do_add_goods(Request $request)
    {
    	$path = $request->file('goods_pic')->store('goods_pic');
    	echo asset('storage').'/'.$path;
    }
>>>>>>> 79b07ba82916356e67e2497fa465680e99d306b0
}
