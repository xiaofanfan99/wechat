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
        <h1>标签添加</h1>
        <form action="{{url('work/tag_do')}}" method="post">
            @csrf
            标签名：<input type="text" name="tagname"><br><br>
            <input type="submit" value="标签提交">
        </form>
    </center>
</body>
</html>
