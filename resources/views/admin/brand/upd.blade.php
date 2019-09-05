<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>商品品牌添加-有点</title>
<link rel="stylesheet" type="text/css" href="/admin/css/css.css" />
<script type="text/javascript" src="/admin/js/jquery.min.js"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
<form action="{{url('brand/update/'.$data->brand_id)}}" method="post" enctype="multipart/form-data">
	@csrf
	<div id="pageAll">
		<div class="pageTop">
			<div class="page">
				<img src="/admin/img/coin02.png" /><span><a href="{{url('admin/main')}}">首页</a>&nbsp;-&nbsp;<a
					href="">商品品牌管理</a>&nbsp;-</span>&nbsp;品牌添加
			</div>
		</div>
		<div class="page ">
			<!-- 上传广告页面样式 -->
			<div class="banneradd bor">
				<div class="baTopNo">
					<span>品牌添加</span>
				</div>
				<div class="baBody">
					<div class="bbD">
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;品牌LOGO：
						<div class="vipHead vipHead1">
							<img src="{{env('UPLOAD_URL')}}{{$data->brand_logo}}"/>
                            <!-- <img src="{{env('UPLOAD_URL')}}{{$data->brand_logo}}" alt=""> -->
							<p class="vipP">上传LOGO</p>
                            <input type="hidden" name="oldimg" value="{{$data->brand_logo}}">
							<input class="file1" type="file" name="brand_logo" />
						</div>
					</div>
					<div class="bbD">
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;品牌名称：<input type="text"
							class="input3" name="brand_name" value="{{$data->brand_name}}" />
                            @php echo $errors->first('brand_name'); @endphp
					</div>
					<div class="bbD">
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;品牌网址：<input type="text"
							class="input3" name="brand_url" value="{{$data->brand_url}}" />
                            @php echo $errors->first('brand_url'); @endphp
					</div>
					<div class="bbD">
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;排序：<input
							class="input3" type="text" name="brand_order" value="{{$data->brand_order}}" />按照倒序排序 
                            @php echo $errors->first('brand_order'); @endphp
					</div>
					<div class="bbD">
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;品牌描述：
						<div class="btext2">
							<textarea class="text2" name="brand_desc">{{$data->brand_desc}}</textarea>
                            @php echo $errors->first('brand_desc'); @endphp
						</div>
					</div>
					<div class="bbD">
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;是否显示：<label><input
							type="radio" name="is_show" value="1" @if($data->is_show==1) checked="checked" @endif/>&nbsp;是</label><label><input
							type="radio" name="is_show" value="0" @if($data->is_show==0) checked="checked" @endif />&nbsp;否</label>
					</div>
					<div class="bbD">
						<p class="bbDP">
						<!-- class="btn_ok btn_yes" -->
							<input type="button" class="btn_ok btn_yes" id="sub" value="提交">
							<!-- <button class="btn_ok btn_yes" href="#" class="sub">提交</button> -->
							<a class="btn_ok btn_no" href="#">取消</a>
						</p>
					</div>
				</div>
			</div>
			<!-- 上传广告页面样式end -->
		</div>
	</div>
	</form>
</body>
</html>
<script src="/jq.js"></script>
<script>
	$.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
       });
	//品牌名称失去焦点
	$('[name="brand_name"]').on('blur',function(){
		//获取品牌名称值
		var brand_name=$('[name="brand_name"]').val();
		$('[name="brand_name"]').next().remove();
		if(!brand_name){
			// alert('品牌名称不能为空');
			$('[name="brand_name"]').after("<b style='color:red'>品牌名称不能为空</b>");
			return false;
		}
		var flag=false;
		var brand_id={{$data->brand_id}};
		$.ajax({
			url:"{{url('brand/changeonly')}}",
			data:{brand_name:brand_name,brand_id:brand_id},
			async:false,
			success:function(msg){
				if(msg>0){
					$('[name="brand_name"]').after("<b style='color:red'>品牌名称已存在</b>");
					// alert('品牌名称已存在');
					flag=true;
				}
			}
		})
		if(flag==true){
			return false;
		}
	});
	//品牌网址失去焦点
	$('[name="brand_url"]').on('blur',function(){
		//获取品牌名称值
		var brand_url=$('[name="brand_url"]').val();
		$('[name="brand_url"]').next().remove();
		if(!brand_url){
			// alert('品牌网址不能为空');
			$('[name="brand_url"]').after("<b style='color:red'>品牌网址不能为空</b>");
			return false;
		}
		var zz=/^(http):\/\//i;
		if(!zz.test(brand_url)){
			$('[name="brand_url"]').after("<b style='color:red'>品牌网址必须是http://开头</b>");
			// alert('品牌网址必须是http://开头');
			return false;
		}
	});
	//排序失去焦点
	$('[name="brand_order"]').blur(function(){
		var brand_order=$('[name="brand_order"]').val();
		$('[name="brand_order"]').next().remove();
		// alert(brand_order);
		if(!brand_order){
			$('[name="brand_order"]').after("<b style='color:red'>品牌排序必填</b>");
			// alert('品牌排序必填');
			return false;
		}
		var zz=/^\d{1,3}/;
		if(!zz.test(brand_order)){
			$('[name="brand_order"]').after("<b style='color:red'>分类排序必须是数字1-3位</b>");
			// alert('分类排序必须是数字1-3位');
			return false;
		}
	})
	//品牌描述失去焦点验证
	$('[name="brand_desc"]').blur(function(){
		var brand_desc=$('[name="brand_desc"]').val();
		$('[name="brand_desc"]').next().remove();
		// alert(brand_desc);
		if(!brand_desc){
			$('[name="brand_desc"]').after("<b style='color:red'>品牌描述不能为空</b>");
			// alert('品牌描述不能为空');
			return false;
		}
	})

	//点击提交按钮验证
	$('#sub').on('click',function(){
		//获取品牌名称值
		var brand_name=$('[name="brand_name"]').val();
		//alert(123);
		$('[name="brand_name"]').next().remove();
		//获取品牌网址值
		var brand_url=$('[name="brand_url"]').val();
		$('[name="brand_url"]').next().remove();
		if(!brand_name){
			$('[name="brand_name"]').after("<b style='color:red'>品牌名称不能为空</b>");
			// alert('品牌名称不能为空');
			return false;
		}
		var flag=false;
		var brand_id={{$data->brand_id}};
		$.ajax({
			url:"{{url('brand/changeonly')}}",
			data:{brand_name:brand_name,brand_id:brand_id},
			async:false,
			success:function(msg){
				if(msg>0){
					$('[name="brand_name"]').after("<b style='color:red'>品牌名称已存在</b>");
					// alert('品牌名称已存在');
					flag=true;
				}
			}
		})
		if(flag==true){
			return false;
		}
		if(!brand_url){
			$('[name="brand_url"]').after("<b style='color:red'>品牌网址不能为空</b>");
			// alert('品牌网址不能为空');
			return false;
		}
		var zz=/^((http):\/\/)/i;
		if(!zz.test(brand_url)){
			$('[name="brand_url"]').after("<b style='color:red'>品牌网址必须是http://开头</b>");
			// alert('品牌网址必须是http://开头');
			return false;
		}
		var brand_order=$('[name="brand_order"]').val();
		$('[name="brand_order"]').next().remove();
		// alert(brand_order);
		if(!brand_order){
			$('[name="brand_order"]').after("<b style='color:red'>品牌排序必填</b>");
			// alert('品牌排序必填');
			return false;
		}
		var zz=/^\d{1,3}/;
		if(!zz.test(brand_order)){
			$('[name="brand_order"]').after("<b style='color:red'>分类排序必须是数字1-3位</b>");
			// alert('分类排序必须是数字1-3位');
			return false;
		}
		var brand_desc=$('[name="brand_desc"]').val();
		$('[name="brand_desc"]').next().remove();
		// alert(brand_desc);
		if(!brand_desc){
			$('[name="brand_desc"]').after("<b style='color:red'>品牌描述不能为空</b>");
			// alert('品牌描述不能为空');
			return false;
		}
		$('form').submit();
	})
</script>