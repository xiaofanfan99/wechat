<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
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
