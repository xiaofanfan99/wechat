@extends('layouts.hadmin')
@section('title')--微信开发登录@endsection
@section('content')
    <h2>微信开发登录</h2>
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
                url:"http://www.wxlaravel.com/api/wechat/login_do",
                data:{username:username,password:password},
                dataType:"json",
                success:function (res) {
                    if(res.ret==0){
                        alert(res.msg);
                        //跳转新闻展示页
                        location.href="http://www.wxlaravel.com/api/wechat/wechat_list";
                    }
                }
            })
        })
    </script>
@endsection
