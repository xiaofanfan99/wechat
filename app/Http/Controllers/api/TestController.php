<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
class TestController extends Controller
{
    //添加接口测试
    public function test_add(Request $request)
    {
        $name=$request->input('name');
        $age=$request->input('age');
        if(empty($name) || empty($age)){
            return json_encode(['ret'=>0,'msg'=>'参数不能为空']);
        }
        $res=DB::table('test')->insert([
            'test_name'=>$name,
            'test_age'=>$age
        ]);
        if($res){
            return json_encode(['ret'=>'1','msg'=>'添加成功']);
        }else{
            return json_encode(['ret'=>'0','msg'=>'添加有误']);
        }
    }

    /**
     * 查询接口
     */
    public function show()
    {
        $data=DB::table('test')->get();
        if(empty($data)){
            return json_encode(['ret'=>'0','msg'=>'查询有误']);
        }else{
            return json_encode(['ret'=>'1','msg'=>'查询成功','data'=>$data]);
        }
    }

    /**
 * 修改接口 查询默认值
 * @param Request $request
 */
    public function find(Request $request)
    {
        $id=$request->input('id');
        $data=DB::table('test')->where(['test_id'=>$id])->first();
        //对象转数组
//        $data = get_object_vars($data);
        if($data){
            return json_encode(['ret'=>'1','msg'=>'查找成功','data'=>$data]);
        }
    }

    /**
     * 测试接口修改执行页
     */
    public function upd(Request $request)
    {
        $name=$request->input('name');
        $age=$request->input('age');
        $id=$request->input('id');
        $res=DB::table('test')->where(['test_id'=>$id])->update([
            'test_name'=>$name,
            'test_age'=>$age
        ]);
        if($res){
            return json_encode(['ret'=>1,'msg'=>'修改成功']);
        }
    }

    /**
     * 测试删除接口
     * @param Request $request
     */
    public function delete(Request $request)
    {
        $id=$request->input('id');
        $res=DB::table('test')->where(['test_id'=>$id])->delete();
        if($res){
            return json_encode(['res'=>1,'msg'=>'删除成功']);
        }
    }

}
