<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>微信管理素材</title>
</head>
<body>
    <center>
        <h1>微信素材管理</h1>
        <a href="{{url('wechat/upload')}}">添加永久素材</a>
        <form action="">
            <select name="type" id="">
                <option value="0">请选择上传的的类型</option>
                <option value="image">图片</option>
                <option value="voice">语音</option>
                <option value="video">视频</option>
                <option value="thumb">缩略图</option>
            </select>
            <input type="submit" value="切换">
        </form>
        <table border="1">
            <tr>
                <th>ID</th>
                <th>MEDIA_ID</th>
                <th>TYPE</th>
                <th>PATH</th>
                <th>添加时间</th>
                <th>操作</th>
            </tr>
            @foreach($info as $v)
            <tr>
                <td>{{$v->upload_id}}</td>
                <td>{{$v->media_id}}</td>
                <td>{{$v->type}}</td>
                <td>{{$v->path}}</td>
                <td>{{$v->created_at}}</td>
                <td>@if($v->path=='0') <a href="{{url('wechat/material')}}?upload_id={{$v->upload_id}}">下载素材</a>@endif</td>
            </tr>
            @endforeach
        </table>
    </center>
</body>
</html>
