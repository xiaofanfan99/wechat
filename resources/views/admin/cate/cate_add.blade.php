<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>行家添加-有点</title>
<link rel="stylesheet" type="text/css" href="../admin/css/css.css" />
<script type="text/javascript" src="../admin/js/jquery.min.js"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">

</head>
<body>
	<div id="pageAll">
		<div class="pageTop">
			<div class="page">
				<img src="../admin/img/coin02.png" /><span><a href="{{url('admin/main')}}">首页</a>&nbsp;-&nbsp;<a
					href="#">商品分类分类管理</a>&nbsp;-</span>&nbsp;商品分类添加
			</div>
		</div>
		<div class="page ">
			<!-- 上传广告页面样式 -->
			<div class="banneradd bor">
				<div class="baTopNo">
					<span>商品分类添加</span>
				</div>
				<div class="baBody">
					<form action="{{route('cate_do')}}" method="post">
					<div class="bbD">
						@csrf
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;分类名称：<input type="text" name="cate_name" class="input3" />
					</div>
					<!-- <div class="bbD">
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;排序：<input type="text" name=""
							class="input3" />
					</div> -->
					<div class="bbD">
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;分&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;类：<select class="input3" name="parent_id">
						<option value="0">顶级分类</option>
						@foreach($data as $k=>$v)
							<option value="{{$v->cate_id}}">@php echo str_repeat('--',$v->level-1).$v->cate_name @endphp</option>
						@endforeach
					</select>
					</div>
					<div class="bbD">
						<p class="bbDP">
							<input type="button" value="提交" class="btn_ok btn_yes">
							<!-- <button class="btn_ok btn_yes" href="#">提交</button> -->
						</p>
					</div>
				</div>
			</div>
			</form>
			<!-- 上传广告页面样式end -->
		</div>
	</div>
</body>
</html>
<script src="/jq.js"></script>
<script>
     $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
       });
//判断失去焦点分类 提示
	$('[name="cate_name"]').blur(function(){
		var cate_name = $(this).val();
		//不为空 删除为空的提示
		$(this).next().remove();
		if(!cate_name){
			$(this).after('<b style="color:red">分类名必填</b>');
			return false;
		}
		//验证分类名称
		var reg = /^[\u4e00-\u9fa5A-Za-z]{2,12}$/;
		if(!reg.test(cate_name)){
			$(this).after('<b style="color:red">分类名称必须是汉字或者字母 2-12位</b>');
			return false;
		}

		$.ajax({
			method:'post',
			url:"/cate/changename",
			data:{cate_name:cate_name},
			success:function(msg){
				if(msg>0){
					alert('分类名称已存在');
				}
			}
		})

	});

	//点击提交按钮验证
	$('[type="button"]').on('click',function(){
		var cate_name = $('[name="cate_name"]').val();
		//不为空删除为空的提示
		$('[name="cate_name"]').next().remove();
		if(!cate_name){
			$('[name="cate_name"]').after('<b style="color:red">分类名必填</b>');
			return false;
		}
		//验证分类名称
		var reg = /^[\u4e00-\u9fa5A-Za-z]{2,12}$/;
		if(!reg.test(cate_name)){
			$('[name="cate_name"]').after('<b style="color:red">分类名称必须是汉字或者字母 2-12位</b>');
			return false;
		}
		//点击提交按钮 发送ajax 验证唯一性
		var flag=false;
		$.ajax({
			method:'post',
			url:"/cate/changename",
			async:false,
			data:{cate_name:cate_name},
			success:function(msg){
				if(msg>0){
					alert('分类名称已存在');
					flag=true;
				}
			}
		})
		if(flag==true){
			return false;
		}

		$('form').submit();
	});


</script>