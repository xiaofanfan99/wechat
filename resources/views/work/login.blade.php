<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <center>
        <form action="{{url('work/login_do')}}" method="post">
            <h1>用户登录页</h1>
            用户名：<input type="text" name="username" ><br><br>
            密码：<input type="password" name="password"><br> <br>
            普通登录：<input type="submit" value="提交"><br><br>
            第三方登录：<input type="button" class="but" value="前往微信登录">
        </form>
    </center>
</body>
</html>
<script src="/jq.js"></script>
<script>
    $('.but').click(function(){
        window.location.href="{{asset('work/login_do')}}";
    })
</script>
