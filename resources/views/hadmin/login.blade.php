<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> - 登录</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <base href="/hadmin/">
    <link rel="shortcut icon" href="favicon.ico"> <link href="css/bootstrap.min.css?v=3.3.6" rel="stylesheet">
    <link href="css/font-awesome.css?v=4.4.0" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css?v=4.1.0" rel="stylesheet">
</head>
<body class="gray-bg">
<div class="middle-box text-center loginscreen  animated fadeInDown">
    <div>
        <div>
            <h1 class="logo-name">h</h1>
        </div>
        <h3>欢迎使用 hAdmin</h3>
        <form class="m-t" role="form" action="{{url('hadmin/do_login')}}" method="post">
            @csrf
            <div class="form-group">
                <input type="text" class="form-control" placeholder="用户名" name="username"  required="">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" placeholder="密码" name="password" required="">
            </div>
            <div class="form-group">
                <input type="password" placeholder="微信验证码" name="code" required="">
                <input type="button" class="send" value="发送验证码">
            </div>
            <button type="submit" class="btn btn-primary block full-width m-b">登 录</button>
            <h4>关注公众号进行账号绑定，账号绑定成功后才能使用微信验证码功能</h4>
            <img src="{{asset('/hadmin/wechat.jpg')}}" width="200" height="200">
            <p class="text-muted text-center"> <a href="login.html#"><small>忘记密码了？</small></a> | <a href="register.html">注册一个新账号</a> |<a
                    href="{{url('hadmin/scanning')}}">扫码登录</a>
            </p>
        </form>
    </div>
</div>
<!-- 全局js -->
<script src="js/jquery.min.js?v=2.1.4"></script>
<script src="js/bootstrap.min.js?v=3.3.6"></script>
<script src="{{asset('/jq.js')}}"></script>
<script>
    $('.send').click(function(){
        //获取用户名
        var name=$('[name="username"]').val();
        //获取密码
        var pwd=$('[name="password"]').val();
        $.ajax({
            url:"{{asset('hadmin/send')}}",
            data:{username:name,password:pwd},
        })
    })
</script>
</body>

</html>
