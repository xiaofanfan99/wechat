<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<!--  访问图片路径  -->
    <img src="{{asset('storage/wechat/Piar4SpioYHrzk1T3ZnucnFXkQWx2IxykzF9qilx.jpeg')}}" width="120" height="120"  alt="">
    <form action="{{url('wechat/do_upload')}}" method="post" enctype="multipart/form-data">
    @csrf
        <input type="file" name="images">
        <input type="submit" value="提交">
    </form>
</body>
</html>
