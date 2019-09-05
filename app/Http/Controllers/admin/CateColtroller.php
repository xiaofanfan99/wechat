<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
class CateColtroller extends Controller
{
    public function cate_add()
    {
        $data=DB::table('cate')->get();
        // dd($data);
        $data = createtree($data);
        return view('admin/cate/cate_add',['data'=>$data]);
    }

    public function cate_do()
    {
        $post=request()->except('_token');
        // dd($post);
        $stu= DB::table('cate')->insert($post);
        // dd($stu);
        if($stu){
            return redirect('cate/cate_list');
        }
    }

    //分类列表展示
    public function cate_list()
    {
        $data=DB::table('cate')->get();
        // dd($data);
        //调用无限极分类
        $data = createtree($data);
        return view('admin/cate/cate_list',['data'=>$data]);
    }

    //分类删除
    public function delete($id)
    {
        //判断分类id下有子分类 不能删除
        $count=DB::table('cate')->where(['parent_id'=>$id])->count();
        if($count){
            //提示信息 第一种方式
            echo "<script>alert('分类下有子分类,不能删除');history.go(-1);</script>";exit;
            //提示信息 第二种方式 存session 展示页面取出session输出
        //    return redirect('cate/cate_list')->with('msg','不能删除');
        }
        //删除
        $data = DB::table('cate')->where('cate_id',$id)->delete();
        if($data){
            return redirect('cate/cate_list');
        }
    }

    //js验证分类唯一性
    public function changename()
    {
        $cate_name=request()->cate_name;
        // dd($cate_name);
        $count = DB::table('cate')->where('cate_name',$cate_name)->count();
        echo $count;
        // dd($count);
        // if($count>0){
        //     return ['ret'=>'00001','msg'=>'分类名称已存在'];die;
        // }
    }
}
