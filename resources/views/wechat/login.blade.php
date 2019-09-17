<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <center>
        <form action="">
            <h1>登录</h1>
            <h3>用户名：<input type="text"></h3>
            <h3>密码：<input type="password"></h3>
            <h3>第三方登录：<button type="button" class="wechat_but">前往微信进行登录</button></h3>
        </form>
    </center>
</body>
</html>
<script src="/js/jq.js"></script>
<script>
    $(function(){
        $('.wechat_but').click(function(){
            window.location.href="{{asset('wechat/wechat_login')}}"
        })
    });
</script>
