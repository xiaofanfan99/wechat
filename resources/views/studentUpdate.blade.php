<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>修改学生信息</title>
</head>
<body>
	<center>
		<h1>学生修改</h1>
		<form action="{{url('student/do_update')}}" method="post">
			@csrf
			<tr>
				学生姓名：<input type="text" name="s_name" value="{{$student_info->s_name}}"><br/>
			</tr>
			<tr>
				&ensp;年&ensp;&ensp;龄&ensp;：<input type="text" name="s_age" value="{{$student_info->s_age}}"><br/>
			</tr>
			<tr>
				&ensp;电&ensp;&ensp;话&ensp;：<input type="text" name="s_tel" value="{{$student_info->s_tel}}"><br/>
			</tr>
			<input type="hidden" name="id" value="{{$student_info->s_id}}">
			<input type="submit" value="修改">
		</form>
	</center>
</body>
</html>