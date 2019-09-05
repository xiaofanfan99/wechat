<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Validation\Rule;
class BrandController extends Controller
{
    public function brand_add(){
        return view('admin/brand/brand_add');
    }

    public function brand_do()
    {
        request()->validate([
            'brand_name' => 'required|unique:brand|max:50',
            'brand_url' => 'required',
            'brand_order' => 'required|numeric',
            'brand_desc' => 'required',
        ],[
            'brand_name.required'=>'品牌不能为空',
            'brand_name.unique'=>'品牌名称已存在',
            'brand_name.max'=>'品牌名称最大不能超过50',
            'brand_url.required'=>'品牌网址必填',
            'brand_order.required'=>'排序必填',
            'brand_order.numeric'=>'排序必须是数字',
            'brand_desc.required'=>'描述必填',
        ]);
        $post=request()->except('_token');
        // dd($post);
        //判断有文件上传
        if(request()->hasFile('brand_logo')){
            //调用公共方法的文件上传
            $post['brand_logo'] = upload('brand_logo');
        }
        // dd($post);
        $stu = DB::table('brand')->insert($post);
        if($stu){
            return redirect("brand/brand_list");
        }
    }

    public function brand_list()
    {
        //接收列表传的搜索数据
        $query = Request()->input();
        // dd($query);
        $brand_name=$query['brand_name']??"";
        $is_show=$query['is_show']??"";
        $where=[];
        if($brand_name){
            $where[]=['brand_name','like','%'.$brand_name.'%'];
        }
        if($is_show || $is_show==='0'){
            $where[]=['is_show','=',$is_show];
        }
        $pagesize=config('app.pagesize');
        $data=DB::table('brand')->where($where)->orderby('brand_order','desc')->paginate($pagesize);
        // dd($data);
        return view('admin/brand/brand_list',compact(['data','brand_name','is_show']));
    }
    //js唯一性
    public function changeonly()
    {
        $brand_name=request()->brand_name;
        $brand_id=request()->brand_id??"";
        if($brand_id){
            $where[]=['brand_id','!=',$brand_id];
        }
        if($brand_name){
            $where[]=['brand_name','=',$brand_name];
        }
        // dd($brand_name);
        $stu= DB::table('brand')->where($where)->count();
        echo $stu;
    }

    public function upd($id)
    {
        $data=DB::table('brand')->where('brand_id',$id)->first();
        // dd($data);
        return view('admin/brand/upd',['data'=>$data]);
    }

    public function update($id)
    {
        request()->validate([
            'brand_name'=>[
                'required',
                //验证排除自己
                Rule::unique('brand')->ignore($id,'brand_id'),
                'max:50',
            ],
            // 'brand_name' => 'required|unique:brand|max:50',
            'brand_url' => 'required',
            'brand_order' => 'required|numeric',
            'brand_desc' => 'required',
        ],[
            'brand_name.required'=>'品牌不能为空',
            'brand_name.unique'=>'品牌名称已存在',
            'brand_name.max'=>'品牌名称最大不能超过50',
            'brand_url.required'=>'品牌网址必填',
            'brand_order.required'=>'排序必填',
            'brand_order.numeric'=>'排序必须是数字',
            'brand_desc.required'=>'描述必填',
        ]);
         // echo $id;
         $post=request()->except('_token');
         //判断有文件上传
        if(request()->hasFile('brand_logo')){
            //调用公共方法的文件上传
            $post['brand_logo'] = upload('brand_logo');
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
        // dd($post);
        $stu=DB::table('brand')->where('brand_id',$id)->update($post,'brand_id');
        return redirect('brand/brand_list');
    }
}
