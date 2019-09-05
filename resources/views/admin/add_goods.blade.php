<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>添加图片</title>
</head>
<body>
	<center>
		<form action="{{url('/admin/do_add_goods')}}" method="post" enctype="multipart/form-data">
			@csrf
			图片：<input type="file" name="goods_pic"><br/>
			<input type="submit" value="添加">
		</form>
	</center>
</body>
</html>