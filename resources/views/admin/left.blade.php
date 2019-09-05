<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>首页左侧导航</title>
<link rel="stylesheet" type="text/css" href="../admin/css/public.css" />
<script type="text/javascript" src="../admin/js/jquery.min.js"></script>
<script type="text/javascript" src="../admin/js/public.js"></script>
<head></head>

<body id="bg">
	<!-- 左边节点 -->
	<div class="container">
		<div class="leftsidebar_box">
			<a href="{{route('main')}}" target="main"><div class="line">
					<img src="../admin/img/coin01.png" />&nbsp;&nbsp;首页
				</div></a>
			<!-- <dl class="system_log">
			<dt><img class="icon1" src="../img/coin01.png" /><img class="icon2"src="../img/coin02.png" />
				首页<img class="icon3" src="../img/coin19.png" /><img class="icon4" src="../img/coin20.png" /></dt>
		</dl> -->
			<dl class="system_log">
				<dt>
					<img class="icon1" src="../admin/img/coin03.png" /><img class="icon2"
						src="../admin/img/coin04.png" /> 网站管理<img class="icon3"
						src="../admin/img/coin19.png" /><img class="icon4"
						src="../admin/img/coin20.png" />
				</dt>
				<dd>
					<img class="coin11" src="../admin/img/coin111.png" /><img class="coin22"
						src="../admin/img/coin222.png" /><a class="cks" href="{{route('user_add')}}"
						target="main">管理员管理</a><img class="icon5" src="../admin/img/coin21.png" />
				</dd>
			</dl>
			<dl class="system_log">
				<dt>
					<img class="icon1" src="../admin/img/coin05.png" /><img class="icon2"
						src="../admin/img/coin06.png" /> 商品品牌管理<img class="icon3"
						src="../admin/img/coin19.png" /><img class="icon4"
						src="../admin/img/coin20.png" />
				</dt>
				<dd>
					<img class="coin11" src="../admin/img/coin111.png" /><img class="coin22"
						src="../admin/img/coin222.png" /><a class="cks" href="{{route('brand_add')}}"
						target="main">商品品牌添加</a><img class="icon5" src="../admin/img/coin21.png" />
				</dd>
				<dd>
					<img class="coin11" src="../admin/img/coin111.png" /><img class="coin22"
						src="../admin/img/coin222.png" /><a class="cks" href="{{route('brand_list')}}"
						target="main">商品品牌管理</a><img class="icon5" src="../admin/img/coin21.png" />
				</dd>
			</dl>
			<dl class="system_log">
				<dt>
					<img class="icon1" src="../admin/img/coin05.png" /><img class="icon2"
						src="../admin/img/coin06.png" /> 商品分类管理<img class="icon3"
						src="../admin/img/coin19.png" /><img class="icon4"
						src="../admin/img/coin20.png" />
				</dt>
				<dd>
					<img class="coin11" src="../admin/img/coin111.png" /><img class="coin22"
						src="../admin/img/coin222.png" /><a class="cks" href="{{route('cate_add')}}"
						target="main">商品分类添加</a><img class="icon5" src="../admin/img/coin21.png" />
				</dd>
				<dd>
					<img class="coin11" src="../admin/img/coin111.png" /><img class="coin22"
						src="../admin/img/coin222.png" /><a class="cks" href="{{route('cate_list')}}"
						target="main">商品分类管理</a><img class="icon5" src="../admin/img/coin21.png" />
				</dd>
			</dl>
			<!-- <dl class="system_log">
				<dt>
					<img class="icon1" src="../admin/img/coin07.png" /><img class="icon2"
						src="../admin/img/coin08.png" /> 会员管理<img class="icon3"
						src="../admin/img/coin19.png" /><img class="icon4"
						src="../admin/img/coin20.png" />
				</dt>
				<dd>
					<img class="coin11" src="../admin/img/coin111.png" /><img class="coin22"
						src="../admin/img/coin222.png" /><a href="../vip.html" target="main"
						class="cks">会员管理</a><img class="icon5" src="../admin/img/coin21.png" />
				</dd>
			</dl> -->
			<dl class="system_log">
				<dt>
					<img class="icon1" src="../admin/img/coin10.png" /><img class="icon2"
						src="../admin/img/coin09.png" /> 商品管理<img class="icon3"
						src="../admin/img/coin19.png" /><img class="icon4"
						src="../admin/img/coin20.png" />
				</dt>
				<dd>
					<img class="coin11" src="../admin/img/coin111.png" /><img class="coin22"
						src="../admin/img/coin222.png" /><a href="{{route('goods_add')}}"
						target="main" class="cks">商品添加</a><img class="icon5"
						src="../admin/img/coin21.png" />
				</dd>
				<dd>
					<img class="coin11" src="../admin/img/coin111.png" /><img class="coin22"
						src="../admin/img/coin222.png" /><a href="{{route('goods_list')}}"
						target="main" class="cks">商品管理</a><img class="icon5"
						src="../admin/img/coin21.png" />
				</dd>
			</dl>
			<!-- <dl class="system_log">
				<dt>
					<img class="icon1" src="../admin/img/coin11.png" /><img class="icon2"
						src="../admin/img/coin12.png" /> 话题管理<img class="icon3"
						src="../admin/img/coin19.png" /><img class="icon4"
						src="../admin/img/coin20.png" />
				</dt>
				<dd>
					<img class="coin11" src="../admin/img/coin111.png" /><img class="coin22"
						src="../admin/img/coin222.png" /><a href="../topic.html" target="main"
						class="cks">话题管理</a><img class="icon5" src="../admin/img/coin21.png" />
				</dd>
			</dl>
			<dl class="system_log">
				<dt>
					<img class="icon1" src="../img/coin14.png" /><img class="icon2"
						src="../admin/img/coin13.png" /> 心愿管理<img class="icon3"
						src="../admin/img/coin19.png" /><img class="icon4"
						src="../admin/img/coin20.png" />
				</dt>
				<dd>
					<img class="coin11" src="../admin/img/coin111.png" /><img class="coin22"
						src="../admin/img/coin222.png" /><a href="../wish.html" target="main"
						class="cks">心愿管理</a><img class="icon5" src="../admin/img/coin21.png" />
				</dd>
			</dl>
			<dl class="system_log">
				<dt>
					<img class="icon1" src="../admin/img/coin15.png" /><img class="icon2"
						src="../admin/img/coin16.png" /> 约见管理<img class="icon3"
						src="../admin/img/coin19.png" /><img class="icon4"
						src="../admin/img/coin20.png" />
				</dt>
				<dd>
					<img class="coin11" src="../admin/img/coin111.png" /><img class="coin22"
						src="../admin/img/coin222.png" /><a href="../appointment.html"
						target="main" class="cks">约见管理</a><img class="icon5"
						src="../admin/img/coin21.png" />
				</dd>
			</dl>
			<dl class="system_log">
				<dt>
					<img class="icon1" src="../admin/img/coin17.png" /><img class="icon2"
						src="../admin/img/coin18.png" /> 收支管理<img class="icon3"
						src="../admin/img/coin19.png" /><img class="icon4"
						src="../admin/img/coin20.png" />
				</dt>
				<dd>
					<img class="coin11" src="../admin/img/coin111.png" /><img class="coin22"
						src="../admin/img/coin222.png" /><a href="../balance.html"
						target="main" class="cks">收支管理</a><img class="icon5"
						src="../admin/img/coin21.png" />
				</dd>
			</dl>
			<dl class="system_log">
				<dt>
					<img class="icon1" src="../admin/img/coinL1.png" /><img class="icon2"
						src="../admin/img/coinL2.png" /> 系统管理<img class="icon3"
						src="../admin/img/coin19.png" /><img class="icon4"
						src="../admin/img/coin20.png" />
				</dt>
				<dd>
					<img class="coin11" src="../admin/img/coin111.png" /><img class="coin22"
						src="../admin/img/coin222.png" /><a href="../changepwd.html"
						target="main" class="cks">修改密码</a><img class="icon5"
						src="../admin/img/coin21.png" />
				</dd>
				<dd>
					<img class="coin11" src="../admin/img/coin111.png" /><img class="coin22"
						src="../admin/img/coin222.png" /><a class="cks">退出</a><img
						class="icon5" src="../admin/img/coin21.png" />
				</dd>
			</dl> -->

		</div>

	</div>
</body>
</html>
