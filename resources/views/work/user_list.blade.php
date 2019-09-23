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
        <a href="{{url('work/add_tag')}}">创建标签</a>
        <form action="{{url('work/user_tag')}}" method="post">
            @csrf
            <input type="submit" value="提交">
            <table border="1">
                <tr>
                    <th>勾选要选择的用户</th>
                    <th>用户名</th>
                    <th>用户openid</th>
                    <th>用户所在城市</th>
                    <th>操作</th>
                </tr>
                @foreach($info as $v)
                    <tr>
                        <input type="hidden" name="tagid" value="{{$tagid}}">
                        <td><input type="checkbox" name="openid[]" value="{{$v['openid']}}"></td>
                        <td>{{$v['nikename']}}</td>
                        <td>{{$v['openid']}}</td>
                        <td>{{$v['city']}}</td>
                        <td>
                            <a href=""></a>
                        </td>
                    </tr>
                @endforeach
            </table>
        </form>
    </center>
</body>
</html>
