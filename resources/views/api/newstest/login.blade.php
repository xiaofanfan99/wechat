@extends('layouts.hadmin')
@section('title')--新闻用户登录@endsection
@section('content')
    <h2>新闻用户登录</h2>
    <form action="">
        <div class="form-group">
            <label for="exampleInputEmail1">NAME</label>
            <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Email" name="username">
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">PASSWORD</label>
            <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" name="password">
        </div>
        <button type="submit" class="btn btn-default">Submit</button>
    </form>
    <script>
        $('.btn-default').on('click',function () {
            var username=$('[name="username"]').val();
            var password=$('[name="password"]').val();
            if(!username){
                alert('用户名必填');
                return false;
            }
            if(!password){
                alert('密码必填');
                return false;
            }
            $.ajax({
                url:"http://www.wxlaravel.com/api/newstset/login_do",
                data:{username:username,password:password},
                dataType:"json",
                success:function (res) {
                    if(res.ret==1){
                        var token =res.token;
                        //获取token 写入cookie
                        setCookie('token',token,120);
                        alert(res.msg);
                        //跳转新闻展示页
                        location.href="http://www.wxlaravel.com/api/newstset/news_show";
                    }
                }
            })
            //设置cookie
            function setCookie(name,value,min)
            {	//分钟
                //console.log(time);
                //var msec = getMsec(time); //获取毫秒
                //console.log(msec);return;
                var exp = new Date();
                exp.setTime(exp.getTime() + min*1000*60);
                document.cookie = name + "="+ escape (value) + ";expires=" + exp.toGMTString() + ";path=/";
            }
            return false;
        })
    </script>
@endsection
