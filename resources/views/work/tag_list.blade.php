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
        <h1>微信标签列表</h1>
        <a href="{{url('work/user')}}">用户列表</a>
        <table border="1">
            <tr>
                <th>标签id</th>
                <th>标签名称</th>
                <th>标签下粉丝数</th>
                <th>操作</th>
            </tr>
            @foreach($info['tags'] as $v)
            <tr>
                <td>{{$v['id']}}</td>
                <td>{{$v['name']}}</td>
                <td>{{$v['count']}}</td>
                <td>
                    <a href="{{url('work/user')}}?tagid={{$v['id']}}">批量给用户添加标签</a>
                    <a href="{{url('work/news')}}?tagid={{$v['id']}}">给标签下的用户群发消息</a>
                </td>
            </tr>
                @endforeach
        </table>
    </center>
</body>
</html>
