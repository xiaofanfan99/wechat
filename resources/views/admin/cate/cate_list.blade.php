<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>约见管理-有点</title>
<link rel="stylesheet" type="text/css" href="../admin/css/css.css" />
<script type="text/javascript" src="../admin/js/jquery.min.js"></script>
<!-- <script type="text/javascript" src="../admin/js/page.js" ></script> -->
</head>
<body>
	<div id="pageAll">
		<div class="pageTop">
			<div class="page">
				<img src="../admin/img/coin02.png" /><span><a href="{{url('admin/main')}}">首页</a>&nbsp;-&nbsp;<a
					href="#">商品分类管理</a>&nbsp;-</span>&nbsp;商品分类列表
			</div>
		</div>
        @if (session('msg'))
        <div class="alert alert-success">
        {{ session('msg') }}
        </div>
        @endif
		<div class="page">
				<!-- bbalance 表格 显示 -->
				<div class="conShow">
					<table border="1" cellspacing="0" cellpadding="0">
						<tr>
							<td width="235px" class="tdColor tdC">序号</td>
							<td width="235px" class="tdColor">分类</td>
							<td width="235px" class="tdColor">更多</td>
						</tr>
						@foreach ($data as $v)
						<tr>
							<td>{{$v->cate_id}}</td>
							<td>{{str_repeat('--',$v->level-1).$v->cate_name}}</td>
							<td><a href="{{url('cate/delete/'.$v->cate_id)}}">删除</a></td>
						</tr>
						@endforeach
					</table>
					<div class="paging"></div>
				</div>
				<!-- balance 表格 显示 end-->
			</div>
			<!-- balance页面样式end -->
		</div>
	</div>
</body>
</html>