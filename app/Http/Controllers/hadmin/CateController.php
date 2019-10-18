<?php

namespace App\Http\Controllers\hadmin;

use DemeterChain\C;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\hadmin\Cate;

class CateController extends Controller
{
    //验证商品分类唯一性
    public function cate_only(Request $request)
    {
        $cate_name=$request->cate_name;
        if(!empty($cate_name)){
            $db_cate=Cate::where(['cate_name'=>$cate_name])->count();
            if($db_cate > 0){
                return json_encode(['ret'=>0,'msg'=>'已有分类名称']);
            }else{
                return json_encode(['ret'=>1,'msg'=>'未有分类名称']);
            }
        }
    }
    //商品分类添加
    public function cate_add()
    {
        //查询数据库分类
        $cateData=Cate::get()->toArray();
        return view('hadmin.admin.cate_add',['cateData'=>$cateData]);
    }

    public function cate_do(Request $request)
    {
        $cate_data=$request->all();
        $res=Cate::create([
            'cate_name'=>$cate_data['cate_name'],
            'parent_id'=>$cate_data['parent_id'],
            'is_show'=>$cate_data['is_show']
        ]);
        if($res){
            return redirect('hadmin/cate_list');
        }else{
            echo "<script>alert('分类添加操作有误');history.go(-1)</script>";
        }
    }

    public function cate_list()
    {
        $cate_data=Cate::all();
        return view('hadmin.admin.cate_list',['data'=>$cate_data]);
    }
}
