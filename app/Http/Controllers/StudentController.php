<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index(Request $request)
	{
		$redis = new \Redis();
		$redis->connect ('127.0.0.1','6379');
		$redis->incr('num');
		$num=$redis->get('num');
		echo "浏览次数：$num";


		$req = $request->all();
		$search = "";
		if (!empty($req['search'])) {
			$search = $req['search'];
			$data = DB::table('student')->where('s_name','like','%'.$req['search'].'%')->paginate(5);
		}else{
			$data = DB::table('student')->paginate(5);
		}
		/* 展示列表 */
		
		return view('studentList',['student'=>$data,'search'=>$search]);
	}

	/* 添加学生列表 */
	public function add()
	{
		return view('studentAdd');
	}

	/* 添加学生处理 */
	public function do_add(Request $request)
	{
		$validate = $request->validate([
			's_name'=>'required',
			's_age'=>'required',
			's_tel'=>'required'
		],[
			's_name.required'=>'姓名不能为空',
			's_age.required'=>'年龄不能为空',
			's_tel.required'=>'电话不能为空'
		]);
		$req = $request->all();
		$res = DB::table('student')->insert([
			's_name'=>$req['s_name'],
			's_age'=>$req['s_age'],
			's_tel'=>$req['s_tel'],
			'create_time'=>time()
		]);
		if ($res) {
			return redirect('student/index');
		}else{
			echo "未知错误";
		}
	}

	/* 修改学生信息表单 */
	public function update(Request $request)
	{
		$req = $request->all();
		$data = DB::table('student')->where(['s_id'=>$req['id']])->first();
		return view('studentUpdate',['student_info'=>$data]);
	}

	/* 处理修改学生信息 */
	public function do_update(Request $request)
	{
		$req = $request->all();
		$res = DB::table('student')->where(['s_id'=>$req['id']])->update([
			's_name'=>$req['s_name'],
			's_age'=>$req['s_age'],
			's_tel'=>$req['s_tel'],
		]);
		dd($res);
	}

	/* 删除学生信息 */
	public function delete(Request $request)
	{
		$req = $request->all();
		$res = DB::table('student')->where(['s_id'=>$req['id']])->delete();
		dd($res);
	}

	// 登陆
	public function login()
	{
		return view('login');
	}

	// 登陆处理
	public function do_login(Request $request)
	{
		$req = $request->all();
		$request->session()->put('admin','admin');
		return redirect('student/index');
	}

	// 注册表单
	public function register()
	{
		return view('register');
	}
}
