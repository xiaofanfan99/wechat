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
        <h1>粉丝列表</h1>
        <table border="1">
            <tr>
                <th>粉丝openID</th>
            </tr>
            @foreach($info as $v)
            <tr>
                <td>{{$v}}</td>
            </tr>
            @endforeach
        </table>
    </center>
</body>
</html>
