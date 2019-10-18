<?php

namespace App\Http\Controllers\hadmin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\hadmin\Attr;
use App\Model\hadmin\Type;
class AttrController extends Controller
{
    /**
     * 商品属性
     */
    //商品属性添加
    public function attr_add()
    {
        //查询所属商品类型  展示类型
        $type_data=Type::all();
        return view('hadmin.admin.attr_add',['type'=>$type_data]);
    }

    /**
     * 商品属性执行添加
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Laravel\Lumen\Http\Redirector
     */
    public function attr_do(Request $request)
    {
        $attr_data=$request->all();
        $res=Attr::create([
            'attr_name'=>$attr_data['attr_name'],
            'type_id'=>$attr_data['type_id'],
            'optional'=>$attr_data['optional']
        ]);
        if($res){
            return redirect('hadmin/attr_list');
        }else{
            echo "<script>alert('商品属性添加操作有误');history.go(-1)</script>";
        }
    }

    /**
     * 商品属性列表
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function attr_list(Request $request)
    {
        $where=[];
        //查询商品类型数据
        $type_data=Type::get()->toArray();
        $type_attr_list=$request->type_id;
        if(!empty($type_attr_list)){
            //查询类型表数据
            $where=['attribute.type_id'=>$type_attr_list];
        }
        $attr_data=Attr::where($where)->join('type','type.type_id','=','attribute.type_id')->get();
        if(!empty($attr_data)){
            return view('hadmin.admin.attr_list',['data'=>$attr_data,'type_data'=>$type_data]);
        }
    }

    /*
     * 根据商品类型搜索显示类型下的属性
     * @param Request $request
     */
    public function type_search(Request $request)
    {
        //搜索接收值
        $type=$request->type_name;
        if (!$type){
            //没有type_id 默认显示所有
            $attr_data=Attr::join('type','type.type_id','=','attribute.type_id')->get();
        }
        $typedata=Type::where(['type_id'=>$type])->get();
        foreach ($typedata as $k => $v){
            $attr_data = Type::where(['type_name'=>$v['type_name']])->join('attribute','type.type_id','=','attribute.type_id')->get();
        }
        return json_encode($attr_data);
    }

    /**
     * 批量删除
     * @param Request $request
     */
    public function delall(Request $request)
    {
        $attr_id=$request->attr_id;
        $res=Attr::destroy($attr_id);
        if($res){
            return json_encode(['ret'=>1,'msg'=>'删除成功']);
        }
    }
}
