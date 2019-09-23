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
        <h1>留言列表</h1>
        <form action="{{url('message/message')}}" method="post">
            @csrf
            <input type="submit" value="确认群发留言">
            <table border="1">
                <tr>
                    <th>勾选被发送人</th>
                    <th>用户openid</th>
                    <th>用户名称</th>
                </tr>
                @foreach($info as $v)
                    <tr>
                        <td><input type="checkbox" value="{{$v['openid']}}" name="openid[]" ></td>
                        <td>{{$v['openid']}}</td>
                        <td>{{$v['nickname']}}</td>
                    </tr>
                @endforeach
            </table>
        </form>
    </center>
</body>
</html>
