<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Validator;
use Illuminate\Validation\Rule;
class IndexController extends Controller
{
    public function index(){
        return view('admin/admin');
    }
    public function head(){
        // dd(1111);
        return view('admin/head');
    }
    public function left(){
        // dd(1111);
        return view('admin/left');
    }
    public function main(){
        // dd(1111);
        return view('admin/main');
    }
    //管理员表单
    public function user_add()
    {
        $pagesize=config('app.pagesize');
        // dump(123);
        $data=DB::table('admin_user')->paginate($pagesize);
        // dump($data);
        return view('admin/user_add',['data'=>$data]);
    }
    //管理员表单处理页
    public function user_do( Request $request)
    {
         //过滤一条
        $post=Request()->except('_token');
        $post['password']=md5($post['password']);
        $post['add_time']=time();
        $validator = Validator::make($post, [
            'username' => 'required|unique:admin_user|max:50',
            'password' => 'required|alpha_dash',
        ],[
            'username.required'=>'用户名必填',
            'username.unique'=>'用户名已存在',
            'username.max'=>'用户名不能超过50位',
            'password.required'=>'密码必填',
            'password.alpha_dash'=>'密码格式不正确',
        ]);
        if ($validator->fails()) {
            echo json_encode(['ret'=>'0','msg'=>$validator->errors()]);die;
        }
        // dd($post);
        $stu = DB::table('admin_user')->insert($post);
        if($stu){
            return json_encode(['ret'=>'1','msg'=>'管理员添加成功']);die;
        }
    }
    //会员名即点即改
    public function chanceshow()
    {
        $data=request()->input();
        $name=request()->name;
        $user_id=request()->user_id;
        // dd($data);
        $where=[
            'user_id'=>$user_id,
        ];
        $res=DB::table('admin_user')->where($where)->update($data,'user_id');
        // dump($res);
    }
    //会员名修改表单页
    public function upd($id)
    {
        $data=DB::table('admin_user')->where('user_id',$id)->first();
        // dd($data);
        return view('admin/upd',['data'=>$data]);
    }

    public function update($id)
    {
        $data=request()->except('_token');
        $data['password']=md5($data['password']);
        $data['add_time']=time();
        $validator = Validator::make($data, [
            'username'=>[
                'required',
                //验证排除自己
                Rule::unique('admin_user')->ignore($id,'user_id'),
                'max:50',
            ],
            'password' => 'required|alpha_dash',
        ],[
            'username.required'=>'用户名必填',
            'username.unique'=>'用户名已存在',
            'username.max'=>'用户名不能超过50位',
            'password.required'=>'密码必填',
            'password.alpha_dash'=>'密码格式不正确',
        ]);
        if ($validator->fails()) {
            return redirect('admin/upd/'.$id)
            ->withErrors($validator)
            ->withInput();
        }
        // dd($data);
        $stu=DB::table('admin_user')->where('user_id',$id)->update($data,'user_id');
        // dd($stu);
        return redirect('admin/user_add');
    }

}
