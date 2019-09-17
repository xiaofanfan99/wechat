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
        <form action="">
            <h1>登录</h1>
            <br>
            用户名：<input type="text" name="username">
            <br>
            <br>
             密码：<input type="text" name="username">
            <br />
            <br>
            <input type="submit" value="提交"> <input type="button" class="but" value="前往微信进行登录">
        </form>
    </center>
</body>
</html>
<script src="/jq.js"></script>
<script>
    $('.but').on('click',function(){
        location.href="{{asset('message/do_login')}}"
    })
</script>
