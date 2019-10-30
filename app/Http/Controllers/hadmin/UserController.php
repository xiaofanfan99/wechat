<?php

namespace App\Http\Controllers\hadmin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\hadmin\User;
use App\Model\Test;
class UserController extends Controller
{
    /**
     * 前台用户登录
     */
    public function login(Request $request)
    {
        //接收用户名密码
        $username = $request->input('username');
        $password = $request->input('password');
        //验证数据库 用户名密码 有没有
        $db_user = User::where(['username'=>$username])->first();
        if(empty($db_user)){
            //判断用户名名不存在
            echo "<script>alert('用户名不存在');history.go(-1);</script>";
        }else{
            //判断密码
            if($password != $db_user->password){
                echo "<script>alert('密码错误，请重新输入！');history.go(-1);</script>";
            }
        }
        //生成token 用户id拼接上时间戳
        $token =md5($db_user->user_id.time());
        //登录成功 修改数据库字段 token 过期时间
        $db_user->token=$token; //token字段
        $db_user->expire_time=time()+7200;//过期时间 7200两小时  3600 一小时
        $db_user->save();//进行数据库修改
        //吧token返还给前台
        return json_encode(['ret'=>1,'msg'=>'登录成功','token'=>$token]);
    }

    /**
     * @param Request $request
     * @return false|mixed|string
     * 获取用户信息
     */
    public function getUser(Request $request)
    {
        $token =$request->input('token');
        //判断有没有token
        if(empty($token)){
            return json_encode(['ret'=>201,'msg'=>'请先登录']);
        }
        //判断数据库token字段对不对
        $db_user=User::where(['token'=>$token])->first();
        if(empty($db_user)){
            return json_encode(['ret'=>201,'msg'=>'请先登录']);
        }
        //判断过期时间
        if( time() > $db_user['expire_time']){
            return json_encode(['ret'=>201,'msg'=>'请先登录']);
        }
        //延长token的有效期
        $db_user->expire_time=time()+7200;//过期时间 7200两小时  3600 一小时
        $db_user->save();//进行数据库修改
        //业务操作
        $data=['xxx'=>'xxxx'];
        return json_encode(['ret'=>1,'data'=>$data]);
    }

    /**
     *用户接口测试
     */
    public function test(Request $request)
    {
        $name=$request->input('name');
        $age=$request->input('age');
        $sign=$request->input('sign');
        if(empty($name)||empty($age)){
            return json_encode(['ret'=>000,'msg'=>'必传参数不能为空'],JSON_UNESCAPED_UNICODE);
        }

        if(empty($sign)){
            return json_encode(['ret'=>002,'msg'=>'请带上签名参数'],JSON_UNESCAPED_UNICODE);
        }

        $MySign=MD5('1902a'.$name.$age);
        if($sign != $MySign) {
            return json_encode(['ret' => 003, 'msg' => '签名参数错误'], JSON_UNESCAPED_UNICODE);
        }

        //添加入库
        $res=Test::create([
            'name'=>$name,
            'age'=>$age
        ]);
        if($res){
            return json_encode(['ret'=>001,'msg'=>'OK！']);
        }
    }

    /**
     * 调用线上接口
     */
    public function user()
    {
        $name="fanhanxiao";
        $age='19';
        $sign=md5('1902a'.$name.$age);
        $url="http://www.fanhanxiao.cn/api/hadmin/test?name={$name}&age={$age}&sign={$sign}";
        $res=file_get_contents($url);
        var_dump($res);
    }

}
