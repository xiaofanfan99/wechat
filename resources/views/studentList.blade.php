<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>学生表</title>
	 <link rel="stylesheet" href="{{ URL::asset('bootstrap.min.css') }}">
</head>
<body>
	<center>
		<h1>学生列表</h1>
		<h2><a href="{{url('student/add')}}">去添加学生</a></h2>
		<form action="{{url('student/index')}}" method="get">
			
			姓名：<input type="text" name="search" value="{{$search}}">
			<input type="submit" name="" value="搜索">
		</form>
		<table width="600" border="1">
			<tr align="center">
				<td width="50">ID</td>
				<td width="70">姓名</td>
				<td width="70">年龄</td>
				<td>电话</td>
				<td>添加时间</td>
				<td>操作</td>
			</tr>
			@foreach($student as $v)
			<tr align="center">
				<td>{{ $v->s_id }}</td>
				<td>{{ $v->s_name }}</td>
				<td>{{ $v->s_age }}</td>
				<td>{{ $v->s_tel }}</td>
				<td>{{ date('Y-m-d H:i:s',$v->create_time) }}</td>
				<td>
					<a href="{{url('student/update')}}?id={{$v->s_id}}">修改</a>|
					<a href="{{url('student/delete')}}?id={{$v->s_id}}">删除</a>
				</td>
			</tr>
			@endforeach
		</table>
		{{ $student->appends(['search'=>$search])->links() }}
	</center>
</body>
</html>