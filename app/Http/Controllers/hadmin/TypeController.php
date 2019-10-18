<?php

namespace App\Http\Controllers\hadmin;

use App\Model\hadmin\Attr;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\hadmin\Type;

class TypeController extends Controller
{
    /**
     * 商品类型
     */
    //类型添加
    public function type_add()
    {
        return view('hadmin.admin.type_add');
    }

    public function type_do(Request $request)
    {
        $type_data=$request->all();
        $res=Type::create(['type_name'=>$type_data['type_name']]);
        if($res){
            return redirect('hadmin/type_list');
        }else{
            echo "<script>alert('类型添加操作有误');history.go(-1)</script>";
        }
    }

    /**
     * 类型列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function type_list()
    {
//        dd($attr_num);
        $type_data=Type::get()->toArray();
        foreach ($type_data as $k=>$v){
            //查询类型下的属性数
            $attr_num=Attr::where(['type_id'=>$v['type_id']])->count();
            $type_data[$k]['attr_num']=$attr_num;
        }
        if(!empty($type_data)){
            return view('hadmin.admin.type_list',['data'=>$type_data]);
        }
    }

}
