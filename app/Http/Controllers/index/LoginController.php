<?php

namespace App\Http\Controllers\index;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
class LoginController extends Controller
{
    //接收邮箱号
    public function email()
    {
        $email=request()->email;
        // dd($email);
        if($email){
            $this->send($email);
        }
    }
    //发送验证码
    public function send($email){
        $rand=rand(100000,999999);
        \Mail::raw('您的验证码是'.$rand ,function($message)use($email){
            //设置主题(
            $message->subject("邮箱注册获取验证码");
            //设置接收方
            $message->to($email);
        });
        session(['email'=>$rand]);
    }
    //前台注册
    public function regist()
    {
        return view('index/regist');
    }
    
    //前台注册执行页
    public function regist_do()
    {
        $data=request()->except('_token');
        //判断验证码是否正确
        if($data['mil']!=session('email')){
            echo '<script> alert("验证码不正确"); history.go(-1);</script>';die;
        }
        //判断密码和确认密码是否一致
        if($data['passwords']!=$data['password']){
            echo '<script> alert("密码和确密码不一致"); history.go(-1);</script>';die;
        }
        unset($data['mil']);
        unset($data['passwords']);
        $stu=DB::table('regist')->insert($data);
        if($stu){
            return redirect('index/login');
        }
    }

    //登录页
    public function login()
    {
        // dump(session('email'));
        return view('index/login');
    }
    //登录执行页面
    public function login_do()
    {
        //接收登录页传过来的值
        $data=request()->except('_token');
        //dump($data);  
        //进行单条查询
        $stu=DB::table('regist')->where(['email'=>$data['email']])->first();
        //吧$stu转换成数组
        $stu = json_decode(json_encode($stu), true);
        //判断手机号或邮箱是否存在
        if(!$stu){
            echo "<script> alert('手机号码或者邮箱号不存在');history.go(-1);</script>";die;
        }
        //判断密码是否正确
        if($data['password']!=$stu['password']){
            echo "<script> alert('密码不正确');history.go(-1);</script>";die;                
        }
        //存session数据
        session(['userIndex'=>$stu]);
        return redirect('/');
    }
}
