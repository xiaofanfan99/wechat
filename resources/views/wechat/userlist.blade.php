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
    <form action="{{url('wechat/tag_openid')}}" method="post">
        @csrf
        <table style="background-color:pink;">
            <h1>粉丝列表</h1>
            @if($tagid)
                <input type="submit" value="  确认  "><br><br><br>
            @endif
            <tr>
                @if($tagid)
                    <th>批量添加标签</th>
                @endif
                <th>昵称</th>
                <th>微信号</th>
                <th>操作</th>
            </tr>
            @foreach ($info as $v)
                <tr>
{{--                    <input type="hidden" value="{{$v['openid']}}" name="openid[]">--}}
{{--                    <td><input type="checkbox" value="{{$tagid}}" name="tagid"></td>--}}
                    @if($tagid)
                        <input type="hidden" value="{{$tagid}}" name="tagid">
                        <td><input type="checkbox" value="{{$v['openid']}}" name="openid[]"></td>
                    @endif
                    <td>{{$v['nickname']}}</td>
                    <td>{{$v['openid']}}</td>
                    <td>
                        <a href="{{url('wechat/get_user_info/'.$v['openid'])}}">用户信息</a>
                        <a href="{{url('wechat/tag_user_list')}}?openid={{$v['openid']}}">查看用户下标签列表</a>
                    </td>
                </tr>
            @endforeach
        </table>
    </form>
</center>
</body>
</html>
