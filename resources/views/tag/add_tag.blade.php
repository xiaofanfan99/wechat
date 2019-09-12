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
        <h1>微信标签添加</h1>
        <form action="{{url('wechat/do_add_tag')}}" method="post">
            @csrf
            添加标签<input type="text" name="tag_name">
            <br>
            <br>
            <input type="submit" value="确认">
        </form>
    </center>
</body>
</html>
