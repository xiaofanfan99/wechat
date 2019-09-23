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
        <h1>群发消息</h1>
        <form action="{{url('work/do_news')}}" method="post">
            @csrf
            <input type="hidden" name="tagid" value="{{$tagid}}">
            <textarea name="news" id="" cols="30" rows="10"></textarea>
            <br><br>
            <input type="submit" value=" 发送消息 ">
        </form>
    </center>

</body>
</html>
