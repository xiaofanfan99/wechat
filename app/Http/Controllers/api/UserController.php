<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Model\Test;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $name=$request->input('name');
        $where=[];
        if(isset($name)){
            $where[]=['test_name','like','%'.$name.'%'];
        }
        $data=Test::where($where)->paginate(2);
        if(empty($data)){
            return json_encode(['ret'=>'0','msg'=>'查询有误']);
        }else{
            return json_encode(['ret'=>'1','msg'=>'查询成功','data'=>$data]);
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $name=$request->input('name');
        $age=$request->input('age');
        if(empty($name) || empty($age)){
            return json_encode(['ret'=>0,'msg'=>'参数不能为空']);
        }
        $res=Test::create([
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data=Test::where(['test_id'=>$id])->first();
        //对象转数组
//        $data = get_object_vars($data);
        if($data){
            return json_encode(['ret'=>'1','msg'=>'查找成功','data'=>$data]);
        }
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
        $name=$request->input('name');
        $age=$request->input('age');
        $res=Test::where(['test_id'=>$id])->update([
            'test_name'=>$name,
            'test_age'=>$age
        ]);
        if($res){
            return json_encode(['ret'=>1,'msg'=>'修改成功']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $res=Test::where(['test_id'=>$id])->delete();
        if($res){
            return json_encode(['res'=>1,'msg'=>'删除成功']);
        }
    }
}
