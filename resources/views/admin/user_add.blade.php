<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>管理员管理-有点</title>
<link rel="stylesheet" type="text/css" href="css/css.css" />
<script type="text/javascript" src="js/jquery.min.js"></script>
<link rel="stylesheet" href="/css/bootstrap.min.css">
<!-- <script type="text/javascript" src="js/page.js" ></script> -->
</head>

<body>
	<div id="pageAll">
		<div class="pageTop">
			<div class="page">
				<img src="img/coin02.png" /><span><a href="{{url('admin/main')}}">首页</a>&nbsp;-&nbsp;-</span>&nbsp;管理员管理
			</div>
		</div>

		<div class="page">
			<!-- user页面样式 -->
			<div class="connoisseur">
				<div class="conform">
					<form action="{{route('user_do')}}" method="post" class="form">
                        @csrf
						<div class="cfD">
							<input class="userinput" type="text" name="username" placeholder="输入用户名" />
							&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;
							<input class="userinput vpr" type="text" name="password" placeholder="输入用户密码" /> -&nbsp;&nbsp;&nbsp;
							<input type="radio" name="uservip" value="1" />超级管理员
							<input type="radio" name="uservip" value="0" checked="checked" />普通管理员
							<button class="userbtn">添加</button>
						</div>
					</form>
				</div>
				<!-- user 表格 显示 -->
				<div class="conShow">
					<table border="1" cellspacing="0" cellpadding="0">
						<tr>
							<td width="66px" class="tdColor tdC">序号</td>
							<td width="400px" class="tdColor">用户名</td>
							<td width="400px" class="tdColor">管理员权限</td>
							<td width="630px" class="tdColor">添加时间</td>
							<td width="130px" class="tdColor">操作</td>
						</tr>
                        @foreach($data as $v)
						<tr height="40px">
							<td class="user_id" user_id="{{$v->user_id}}">{{$v->user_id}}</td>
							<td class="username">
								<span>{{$v->username}}</span>
								<input type="text" user_id="{{$v->user_id}}" style="display:none">
							</td>
							<td>@if($v->uservip==1)超级管理员 @else 普通管理员 @endif</td>
							<td>{{date('Y-m-d H:i:s'),$v->add_time}}</td>
							<td><a href="{{url('admin/upd/'.$v->user_id)}}"><img class="operation"
									src="img/update.png"></a><img class="operation delban"
								src="img/delete.png"></td>
						</tr>
                        @endforeach
					</table>
					<div class="paging">{{$data->links()}}</div>
				</div>
				<!-- user 表格 显示 end-->
			</div>
			<!-- user页面样式end -->
		</div>

	</div>


	<!-- 删除弹出框 -->
	<div class="banDel">
		<div class="delete">
			<div class="close">
				<a><img src="img/shanchu.png" /></a>
			</div>
			<input type="hidden" id="del" value="">
			<p class="delP1">你确定要删除此条记录吗？</p>
			<p class="delP2">
				<a href="" class="ok yes">确定</a><a class="ok no">取消</a>
			</p>
		</div>
	</div>
	<!-- 删除弹出框  end-->
</body>

<script type="text/javascript">
//即点即改
$(document).on('click','.username span',function(){
	var span=$(this);
	var input=span.next();
	span.hide();
	input.show();
	var name=span.text();
	// alert(name);
	input.val(name);
	input.focus();
})

$(document).on('blur','.username input',function(){
	var input=$(this);
	var span=input.prev();
	input.hide();
	span.show();
	var name = input.val();
	// alert(name);
	span.text(name);
	var user_id=$(this).attr('user_id');
	// alert(user_id);
	$.ajax({
		url:'{{route("chanceshow")}}',
			data:{username:name,user_id:user_id},
			success:function(res){

			}
	})
});
//ajax添加
$('.userbtn').on('click',function(){
    //禁止跳转
        event.preventDefault();
        var form=$('.form').serialize();
        var username=$('[name="username"]').val();
        var password=$('[name="password"]').val();
        //判断不能为空
        if(!username || !password){
            alert('添加不能为空');return false;
        }
        //发送ajax请求
        $.ajax({
            url:"{{route('user_do')}}",
            data:form,
            type:"post",
            dataType:"json",
            success:function(msg){
				if (msg.ret==1) {
					alert(msg.msg);
					window.location.reload();
				}else{
					//判断用户名不等于空并且不等null
					if ( typeof(msg.msg.username) != "undefined" && msg.msg.username !== null  ) {
						alert(msg.msg.username[0]);
					}else if ( typeof(msg.msg.password) != "undefined" && msg.msg.password!== null  ) {
						alert(msg.msg.password[0]);
					}
				}
            }
        })
    })
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