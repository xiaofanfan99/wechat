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
        <h1>用户列表</h1>
        <table border="1">
            <tr>
                <th>uid</th>
                <th>用户名</th>
                <th>分享码</th>
                <th>二维码</th>
                <th>操作</th>
            </tr>
            @foreach($info as $v)
            <tr>
                <td>{{$v->regist_id}}</td>
                <td>{{$v->email}}</td>
                <td>{{$v->regist_id}}</td>
                <td><img src="{{$v->qrcode_url}}" alt="" height="120"></td>
                <td>
                    <a href="{{url('agent/create_qrcode')}}?uid={{$v->regist_id}}">生成专属二维码</a>
                </td>
            </tr>
                @endforeach
        </table>
    </center>
</body>
</html>
