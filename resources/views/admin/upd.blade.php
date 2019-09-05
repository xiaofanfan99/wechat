<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>修改管理员-有点</title>
<link rel="stylesheet" type="text/css" href="/admin/css/css.css" />
<script type="text/javascript" src="/admin/js/jquery.min.js"></script>
</head>
<body>
	<div id="pageAll">
		<div class="pageTop">
			<div class="page">
				<img src="/admin/img/coin02.png" /><span><a href="{{url('admin/main')}}">首页</a>&nbsp;-&nbsp;<a
					href="javascript:void(0)">公共管理</a>&nbsp;-</span>&nbsp;意见管理
			</div>
		</div>
		<div class="page ">
			<!-- 会员注册页面样式 -->
			<div class="banneradd bor">
				<div class="baTopNo">
					<span>会员注册</span>
				</div>
                <form action="{{url('admin/update/'.$data->user_id)}}" method="post">
                @csrf
                    <div class="baBody">
                        <div class="bbD">
                            &nbsp;&nbsp;&nbsp;管理员名称：<input type="text" class="input3" value="{{$data->username}}"  name="username" />@php echo $errors->first('username'); @endphp
                        </div>
                        <div class="bbD">
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;密码：<input type="password"class="input3" value="{{$data->password}}" name="password" />@php echo $errors->first('password'); @endphp
                        </div>
                        <br>
                        <br>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        管理员权限：
                        <input type="radio" name="uservip" value="1" @if($data->uservip==1)checked="checked"@endif />超级管理员
                        <input type="radio" name="uservip" value="0" @if($data->uservip==0)checked="checked"@endif  />普通管理员
                        <br><br>
                        <div class="bbD">
                            <p class="bbDP">
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" value="提交">
                                <!-- <button class="btn_ok btn_yes" href="#">提交</button> -->
                                <!-- <a class="btn_ok btn_no" href="javascript:void(0)">取消</a> -->
                                <!-- <input type="reset" class="btn_ok btn_no" value="取消"> -->
                            </p>
                        </div>
                    </div>
                </form>
			</div>

			<!-- 会员注册页面样式end -->
		</div>
	</div>
</body>
</html>
