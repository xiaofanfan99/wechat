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

    <img src="http://qr.liantu.com/api.php?text={{$url}}"/>
</body>
</html>
<script src="{{asset('/jq.js')}}"></script>
<script>
    //每隔几秒
    var t= setInterval("check();",2000)
    var id = {{$id}}
    function check(){
        //js轮询
        $.ajax({
            url:'{{url('hadmin/checkwechatlogin')}}',
            dataType:'',
            data:{id:id},
            success:function (res) {
                //扫码返回提示
                if(res.ret==1){
                    //关闭定时器
                      clearInterval(t);
                      alert(res.ret);
                      location.href="{{url('hadmin/index')}}";
                }
            }

            })
    };

</script>
