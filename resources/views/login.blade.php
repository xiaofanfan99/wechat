@extends('layout.common')

@section('title','用户登陆')

@section('body')
	<!-- login -->
	<div class="pages section">
		<div class="container">
			<div class="pages-head">
				<h3>登陆</h3>
			</div>
			<div class="login">
				<div class="row">
					<form class="col s12">
						<div class="input-field">
							<input type="text" class="validate" placeholder="用户名" required>
						</div>
						<div class="input-field">
							<input type="password" class="validate" placeholder="密码" required>
						</div>
						<a href=""><h6>忘记密码 ?</h6></a>
						<a href="{{url::asset('student/do_login')}}" class="btn button-default">登陆</a>
						<a href="{{url::asset('student/register')}}" class="btn button-default">去注册</a>
					</form>
				</div>
			</div>
		</div>
	</div>
	<!-- end login -->
@endsection

