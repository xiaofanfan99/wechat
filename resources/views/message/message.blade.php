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
    <h1>写留言</h1>
    <form action="{{url('message/message_do')}}" method="post">
        @csrf
            <input type="hidden" name="openid" value="{{$openid}}">
        编写留言：<textarea name="menu" id="" cols="30" rows="10"></textarea>
        <input type="submit" value="提交留言">
    </form>
</center>
</body>
</html>
