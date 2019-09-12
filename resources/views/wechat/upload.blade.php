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
        <!--  访问图片路径  -->
        {{--    <img src="{{asset('storage/wechat/Piar4SpioYHrzk1T3ZnucnFXkQWx2IxykzF9qilx.jpeg')}}" width="120" height="120"  alt="">--}}
        <form action="{{url('wechat/do_upload')}}" method="post" enctype="multipart/form-data">
            @csrf
            <br />
            <br />
            <select name="type" id="">
                <option value="0">请选择上传的的类型</option>
                <option value="image">图片</option>
                <option value="voice">语音</option>
                <option value="video">视频</option>
                <option value="thumb">缩略图</option>
            </select>
            <br />
            <br />
            <input type="file" name="images">
            <input type="submit" value="提交">
        </form>
    </center>
</body>
</html>
