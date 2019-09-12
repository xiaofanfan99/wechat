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
        <h1>微信标签管理列表</h1>
        <br>
        <a href="{{url('wechat/add_tag')}}">微信标签添加</a> &ensp;&ensp;&ensp;&ensp;&ensp;&ensp;
        <a href="{{url('wechat/get_user_list')}}">粉丝列表</a>
        <br>
        <br>
        <table border="1">
            <tr>
                <th>ID</th>
                <th>标签名称</th>
                <th>标签下粉丝数</th>
                <th>操作</th>
            </tr>
            @foreach($info as $v)
            <tr>
                <td>{{$v['id']}}</td>
                <td>{{$v['name']}}</td>
                <td>{{$v['count']}}</td>
                <td>
                    <a href="{{url('wechat/del_tag/'.$v['id'])}}">删除</a>||
                    <a href="{{url('wechat/upd_tag/'.$v['id'],$v['name'])}}">编辑</a>||
                    <a href="{{url('wechat/tag_fans_list')}}?tagid={{$v['id']}}">查看标签下粉丝列表</a>||
                    <a href="{{url('wechat/get_user_list')}}?tagid={{$v['id']}}">批量给用户打标签</a>||
                    <a href="{{url('wechat/push_tag_message')}}?tagid={{$v['id']}}">推送消息</a>
                </td>
            </tr>
            @endforeach
        </table>
    </center>
</body>
</html>
