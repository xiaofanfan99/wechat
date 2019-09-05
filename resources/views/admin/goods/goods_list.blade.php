<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>商品-有点</title>
<link rel="stylesheet" type="text/css" href="../admin/css/css.css" />
<script type="text/javascript" src="../admin/js/jquery.min.js"></script>
<!-- 分页样式 -->
<link rel="stylesheet" href="/css/bootstrap.min.css">
<!-- <script type="text/javascript" src="../admin/js/page.js" ></script> -->
</head>

<body>
	<div id="pageAll">
		<div class="pageTop">
			<div class="page">
				<img src="../admin/img/coin02.png" /><span><a href="{{url('admin/main')}}">首页</a>&nbsp;-&nbsp;<a
					href="#">商品管理</a>&nbsp;-</span>&nbsp;商品管理
			</div>
		</div>
		<div class="page">
			<!-- banner页面样式 -->
			<div class="connoisseur">
				<div class="conform">
					<form>
						<div class="bbD">
							商品名称：<input type="text" name="goods_name" class="input3" value="{{$goods_name}}"> 
                            是否上架<label><input type="radio" value="1" name="is_on_sale" @if($is_on_sale==1)checked="checked"@endif />&nbsp;上架</label> <label><input type="radio" name="is_on_sale" value="0" @if($is_on_sale==='0')checked="checked"@endif />&nbsp;下架</label> <label class="lar"> &nbsp;&nbsp;
                            是否热销：<label><input type="radio" name="is_hot" value="1" @if($is_hot==1)checked="checked"@endif />&nbsp;是</label><label><input type="radio" name="is_hot" value="0" @if($is_hot==='0')checked="checked"@endif  />&nbsp;否</label>&nbsp;&nbsp;
                            是否新品：<label><input type="radio" name="is_new" value="1" @if($is_new==1)checked="checked"@endif />&nbsp;是</label><label><input type="radio" name="is_new" @if($is_new==='0')checked="checked"@endif />&nbsp;否</label>
						</div>
						<div class="cfD">
							<button class="button">搜索</button>
							<a class="addA addA1" href="{{route('goods_add')}}">添加商品+</a>
						</div>
					</form>
				</div>
				<!-- banner 表格 显示 -->
				<div class="conShow">
					<table border="1" cellspacing="0" cellpadding="0">
						<tr>
							<td width="66px" class="tdColor tdC">序号</td>
							<td width="170px" class="tdColor">商品图片</td>
							<td width="135px" class="tdColor">商品名称</td>
							<td width="145px" class="tdColor">商品货号</td>
							<td width="140px" class="tdColor">商品分类</td>
							<td width="140px" class="tdColor">商品品牌</td>
							<td width="145px" class="tdColor">商品价格</td>
							<td width="150px" class="tdColor">商品数量</td>
							<td width="140px" class="tdColor">商品详情</td>
							<td width="140px" class="tdColor">是否上架</td>
							<td width="150px" class="tdColor">是否热销</td>
							<td width="150px" class="tdColor">是否新品</td>
							<td width="130px" class="tdColor">操作</td>
						</tr>
                        @foreach($data as $v)
						<tr>
							<td>{{$v->goods_id}}</td>
							<td><div class="onsImg">
									<img src="{{env('UPLOAD_URL')}}{{$v->goods_img}}">
								</div></td>
							<td>{{$v->goods_name}}</td>
							<td>{{$v->goods_sn}}</td>
							<td>{{$v->cate_name}}</td>
							<td>{{$v->brand_name}}</td>
							<td>{{$v->goods_price}}</td>
							<td>{{$v->goods_number}}</td>
							<td>{{$v->goods_desc}}</td>
							<td>@if($v->is_on_sale)上架 @else 下架 @endif</td>
							<td>@if($v->is_hot)热销 @else 不热销 @endif</td>
							<td>@if($v->is_new)新品 @else 不是新品 @endif</td>
							<td>
                                <a href="{{url('goods/upd/'.$v->goods_id)}}"><img class="operation"src="../admin/img/update.png"></a>
                                <a href="{{url('goods/delete/'.$v->goods_id)}}"><img class="operation "src="../admin/img/delete.png"></td></a>
                                
						</tr>
                        @endforeach
					</table>
					<div class="paging">{{$data->appends(['goods_name'=>$goods_name,'is_on_sale'=>$is_on_sale,'is_new'=>$is_new,'is_hot'=>$is_hot])->links()}}</div>
				</div>
				<!-- banner 表格 显示 end-->
			</div>
			<!-- banner页面样式end -->
		</div>
 
	<div class="banDel">
		<div class="delete">
			<div class="close">
				<a><img src="../admin/img/shanchu.png" /></a>
			</div>
			<p class="delP1">你确定要删除此条记录吗？</p>
			<p class="delP2">
				<a href="{{url('goods/delete/'.$v->goods_id)}}" class="ok yes">确定</a><a class="ok no">取消</a>
			</p>
		</div>
	</div>
	<!-- 删除弹出框  end-->
</body>

<script type="text/javascript">
// 广告弹出框
$(".delban").click(function(){
  $(".banDel").show();
});
$(".close").click(function(){
  $(".banDel").hide();
});
$(".no").click(function(){
  $(".banDel").hide();
});
// 广告弹出框 end
</script>
</html>