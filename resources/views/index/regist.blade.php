@extends('layouts.shop')
@section('content')
     <header>
      <a href="javascript:history.back(-1)" class="back-off fl"><span class="glyphicon glyphicon-menu-left"></span></a>
      <div class="head-mid">
       <h1>会员注册</h1>
      </div>
     </header>
     <div class="head-top">
      <img src="/images/head.jpg" />
     </div><!--head-top/-->
     <form action="{{route('regist_do')}}" method="post" class="reg-login">
     @csrf
      <h3>已经有账号了？点此<a class="orange" href="{{url('index/login')}}">登陆</a></h3>
      <div class="lrBox">
       <div class="lrList"><input type="text" name="email" placeholder="输入手机号码或者邮箱号" /></div>
       <div class="lrList2"><input type="text" name="mil"  placeholder="输入短信验证码" /> <button class="email">获取验证码</button></div>
       <div class="lrList"><input type="text" name="password" placeholder="设置新密码（6-18位数字或字母）" /></div>
       <div class="lrList"><input type="text" name="passwords" placeholder="再次输入密码" /></div>
      </div><!--lrBox/-->
      <div class="lrSub">
       <input type="button" value="立即注册" />
      </div>
     </form><!--reg-login/-->
     <div class="height1"></div>
     <div class="footNav">
      <dl>
       <a href="index.html">
        <dt><span class="glyphicon glyphicon-home"></span></dt>
        <dd>微店</dd>
       </a>
      </dl>
      <dl>
       <a href="prolist.html">
        <dt><span class="glyphicon glyphicon-th"></span></dt>
        <dd>所有商品</dd>
       </a>
      </dl>
      <dl>
       <a href="car.html">
        <dt><span class="glyphicon glyphicon-shopping-cart"></span></dt>
        <dd>购物车 </dd>
       </a>
      </dl>
      <dl>
       <a href="user.html">
        <dt><span class="glyphicon glyphicon-user"></span></dt>
        <dd>我的</dd>
       </a>
      </dl>
      <div class="clearfix"></div>
     </div><!--footNav/-->
     <script src="/jq.js"></script>
     <script>
          $('.email').on('click',function(){
               event.preventDefault();
               var email = $('[name="email"]').val();
               // alert(email);
               if(!email){
                    alert('请输入正确的邮箱或者手机号');
                    return false;
               }
               var password=$('[name="password"]').val();
               $.ajax({
                    url:"{{url('index/email')}}",
                    data:{email:email},
                    success:function(msg){
                         // alert(msg);
                    }
               })
          })
          //失去焦点时间
          $('[name="password"]').blur(function(){
               var password=$('[name="password"]').val();
               // alert(password);
               if(!password){
                    alert('密码必填');
                    return ;
               }    
          })

          $('[type="button"]').click(function(){
               var email = $('[name="email"]').val();
               // alert(email);
               if(!email){
                    alert('请输入正确的邮箱或者手机号');
                    return false;
               }
               var password=$('[name="password"]').val();
               // alert(password);
               if(!password){
                    alert('密码必填');
                    return false;
               }
          })

     </script>
     @endsection
     