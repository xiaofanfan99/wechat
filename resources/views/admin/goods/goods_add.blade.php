<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>话题添加-有点</title>
<link rel="stylesheet" type="text/css" href="../admin/css/css.css" />
<script type="text/javascript" src="../admin/js/jquery.min.js"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
	<div id="pageAll">
		<div class="pageTop">
			<div class="page">
				<img src="../admin/img/coin02.png" /><span><a href="#">首页</a>&nbsp;-&nbsp;<a
					href="#">商品管理</a>&nbsp;-</span>&nbsp;商品添加
			</div>
		</div>
		<div class="page ">
			<!-- 上传广告页面样式 -->
			<div class="banneradd bor">
				<div class="baTopNo">
					<span>商品添加</span>
				</div>
				<form action="{{route('goods_do')}}" method="post" enctype="multipart/form-data">
				<div class="baBody">
					@csrf
					<div class="bbD">
						商品名称：<input type="text" name="goods_name" class="input3" />
					</div>
					<div class="bbD">
						商品数量：<input type="text" name="goods_number" class="input3" />
					</div>
					<div class="bbD">
						商品价格：<input type="text" name="goods_price" class="input3" />
					</div>
					<div class="bbD">
						商品货号：<input type="text" name="goods_sn" class="input3" />
					</div>
					<div class="bbD">
						商品图片：<input type="file" name="goods_img" />
					</div>
					<div class="bbD">
						商品品牌：<select class="input3" name="brand_id">
									<option value="0">请选择品牌</option>
                                    @foreach($brand as $v)
									<option value="{{$v->brand_id}}">{{$v->brand_name}}</option>
                                    @endforeach
								</select>	
					</div>
                    <div class="bbD">
						商品详情：<textarea class="input3" name="goods_desc" cols="30" rows="10"></textarea>
					</div>
					<div class="bbD">
						商品分类：<select class="input3" name="cate_id">
									<option value="">请选择商品分类</option>
									@foreach ($data as $v)
										<option value="{{$v->cate_id}}">{{str_repeat('--',$v->level-1).$v->cate_name}}</option>
									@endforeach
								</select>
					</div>
					<!-- <div class="bbD">
						是否热卖：<label><input type="radio" checked="checked"
						name="is_hot" value="1" />&nbsp;是</label><label><input type="radio"
						name="is_hot" value="0" />&nbsp;否</label>
					</div>
					<div class="bbD">
						是否新品：<label><input type="radio" checked="checked"
							name="is_new" value="1"/>&nbsp;是</label><label><input type="radio"
							name="is_new" value="0"/>&nbsp;否</label>
					</div>
					<div class="bbD">
						是否上架：<label><input type="radio" checked="checked"
							name="is_on_sale" value="1"/>&nbsp;是</label><label><input type="radio"
							name="is_on_sale" value="0"/>&nbsp;否</label>
					</div>
					<div class="bbD">
						是否推荐：<label><input type="radio" checked="checked"
							name="is_recommend" value="1"/>&nbsp;是</label><label><input type="radio"
							name="is_recommend" value="0"/>&nbsp;否</label>
					</div>
					<div class="bbD">
						幻灯片：<label><input type="radio" checked="checked"
							name="is_slide" value="1"/>&nbsp;是</label><label><input type="radio"
							name="is_slide" value="0"/>&nbsp;否</label>
					</div>
					 -->
					<div class="bbD">
						<label><input type="checkbox"name="is_hot" value="1"/>&nbsp;热卖</label>
						<label><input type="checkbox" name="is_new" value="1"/>&nbsp;新品</label>
						<label><input type="checkbox" name="is_on_sale" value="1"/>&nbsp;上架</label>
						<label><input type="checkbox" name="is_recommend" value="1"/>&nbsp;推荐</label>
						<label><input type="checkbox" name="is_slide" value="1"/>&nbsp;幻灯片</label>
					</div>
					<div class="bbD">
						是否显示：<label><input type="radio" checked="checked"
							name="is_show" value="1"/>&nbsp;是</label><label><input type="radio"
							name="is_show" value="0"/>&nbsp;否</label>
					</div>
					<div class="bbD">
						<p class="bbDP">
						<input type="button" class="btn_ok btn_yes" id="sub" value="提交"/>
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
	//失去焦点 商品名称验证
	$('[name="goods_name"]').blur(function(){
		var goods_name=$('[name="goods_name"]').val();
		$('[name="goods_name"]').next().remove();
		// alert(goods_name);
		if(!goods_name){
			$('[name="goods_name"]').after('<b style="color:pink">商品名称必填</b>');
			return false;
		}
	// alert(123);
		//唯一
		var flag = false;
		$.ajax({
			method:"POST",
			url:"{{url('goods/changeonly')}}",
			data:{goods_name:goods_name},
			success:function(msg){
				if(msg>0){
					$('[name="goods_name"]').after('<b style="color:pink">商品名称已存在</b>');
					flag=true;
				}
			}
		})
		if(flag==true){
			return false;
		}
	})

	//商品数量验证
	$('[name="goods_number"]').blur(function(){
		var goods_number=$('[name="goods_number"]').val();
		$('[name="goods_number"]').next().remove();
		// alert(goods_number);
		if(!goods_number){
			$('[name="goods_number"]').after('<b style="color:pink">商品数量必填</b>');
			return false;
		}
		//正则验证
		var zz=/^\d{1,7}$/;
		if(!zz.test(goods_number)){
			$('[name="goods_number"]').after('<b style="color:pink">商品数量必须是数字 1-7位</b>');
			return false;
		}
	})

	//商品价格验证
	$('[name="goods_price"]').blur(function(){
		var goods_price=$('[name="goods_price"]').val();
		$('[name="goods_price"]').next().remove();
		// alert(goods_price);
		if(!goods_price){
			$('[name="goods_price"]').after('<b style="color:pink">商品价格必填</b>');
			return false;
		}
		//正则判断
		var zz=/^\d{1,6}$/;
		if(!zz.test(goods_price)){
			$('[name="goods_price"]').after('<b style="color:pink">商品价格必须是数字</b>');			
		}
	})
	//商品品牌验证
	// $('[name="brand_id"]').blur(function(){
	// 	var brand_id=$('[name="brand_id"]').val();
	// 	$('[name="brand_id"]').next().remove();
	// 	// alert(brand_id);
	// 	if(!brand_id==0){
	// 		$('[name="brand_id"]').after('<b style="color:pink">商品品牌必选</b>');			
	// 	}
	// })

	//点击提交验证
	$('#sub').on('click',function(){
		var goods_name=$('[name="goods_name"]').val();
		$('[name="goods_name"]').next().remove();
		// alert(goods_name);
		if(!goods_name){
			$('[name="goods_name"]').after('<b style="color:pink">商品名称必填</b>');
		}
		// alert(456);
		//唯一
		var flag=false;
		$.ajax({
			method:"POST",
			url:"{{url('goods/changeonly')}}",
			data:{goods_name:goods_name},
			success:function(msg){
				if(msg>0){
					$('[name="goods_name"]').after('<b style="color:pink">商品名称已存在</b>');
					flag=true;
				}
			}
		})
		if(flag==true){
			return false;
		}
		//商品数量验证
		var goods_number=$('[name="goods_number"]').val();
		$('[name="goods_number"]').next().remove();
		// alert(goods_number);
		if(!goods_number){
			$('[name="goods_number"]').after('<b style="color:pink">商品数量必填</b>');
			return false;
		}
		//商品数量正则验证
		var zz=/^\d{1,7}$/;
		if(!zz.test(goods_number)){
			$('[name="goods_number"]').after('<b style="color:pink">商品数量必须是数字 1-7位</b>');
			return false;
		}
		//商品价格验证
		var goods_price=$('[name="goods_price"]').val();
		$('[name="goods_price"]').next().remove();
		// alert(goods_price);
		if(!goods_price){
			$('[name="goods_price"]').after('<b style="color:pink">商品价格必填</b>');
			return false;
		}
		//商品价格正则判断
		var zz=/^\d{1,6}$/;
		if(!zz.test(goods_price)){
			$('[name="goods_price"]').after('<b style="color:pink">商品价格必须是数字1-6位</b>');	
		}
		$('form').submit();
	})

</script>