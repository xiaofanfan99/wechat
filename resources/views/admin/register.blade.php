@extends('layout.common')

@section('title','用户注册')

@section('body')
	<!-- register -->
	<div class="pages section">
		<div class="container">
			<div class="pages-head">
				<h3>注册</h3>
			</div>
			<div class="register">
				<div class="row">
					<form class="col s12">
						<div class="input-field">
							<input type="text" class="validate" placeholder="NAME" required>
						</div>
						<div class="input-field">
							<input type="email" placeholder="EMAIL" class="validate" required>
						</div>
						<div class="input-field">
							<input type="password" placeholder="PASSWORD" class="validate" required>
						</div>
						<div class="btn button-default">注册</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<!-- end register -->
@endsection