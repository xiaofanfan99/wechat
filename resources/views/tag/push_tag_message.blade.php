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
        <h1>添加消息推送❥(^_-)</h1>
        <form action="{{url('wechat/do_push_tag_message')}}" method="post">
            @csrf
            <input type="hidden" name="tagid" value="{{$tagid}}">
            消息推送：
            <textarea name="message" id="" cols="30" rows="10"></textarea>
            <br>
            <br>
            <input type="submit" value="确认">
        </form>
    </center>
</body>
</html>
