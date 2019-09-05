<!doctype html>
<html lang="en">
<head>
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<meta charset="UTF-8">
	<title>添加学生</title>
</head>
<body>
	<center>
		@if($errors->any())
			@foreach($errors->all() as $error)
				{{ $error }}
			@endforeach
		@endif
		<h1>学生添加</h1>
		<h2><a href="{{url('student/index')}}">回到学生列表</a></h2>
		<form method="post" action="{{url('student/do_add')}}">
			@csrf
			<tr>
				学生姓名：<input type="text" name="s_name"><br/>
			</tr>
			<tr>
				&ensp;年&ensp;&ensp;龄&ensp;：<input type="text" name="s_age"><br/>
			</tr>
			<tr>
				&ensp;电&ensp;&ensp;话&ensp;：<input type="text" name="s_tel"><br/>
			<pre></pre>
			<input type="submit" name="" value="提交">
		</form>
	</center>
	<script>
		$(function(){
			$.ajaxSetup({
	    		headers: {
	        		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	    		}
			});
		});
	</script>
</body>
</html>