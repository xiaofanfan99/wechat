<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>详情页</h1>
    <h3>微信名：{{$info['nickname']}}</h3>
    <h3>性别：@if($info['sex']==1)男@endif @if($info['sex']==2)女 @endif</h3>
    <h3>城市：{{$info['country']}}{{$info['province']}}{{$info['city']}}</h3>
    <h3>头像：<img src="{{$info['headimgurl']}}" alt=""></h3>
    <h3>关注时间：{{date('Y-m-d H:i:s',$info['subscribe_time'])}}</h3>
</body>
</html>