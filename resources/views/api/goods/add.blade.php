@extends('layouts.hadmin')
@section('title')--商品添加接口测试@endsection
@section('content')
<h2>商品添加</h2>
    <form action="" method="post">
        商品名称：<input type="text" name="goods_name"> <br>    <br>    
        商品价格：<input type="text" name="goods_price"> <br> <br>
        商品图片：<input type="file" name="goods_img"> <br> <br>
        <input type="button" class="but" value="  SUBMIT  ">
    </form>
    <script src='/jq.js'></script>
    <script>
        $('.but').click(function(){
            var goods_name=$('[name="goods_name"]').val();
            var goods_price=$('[name="goods_price"]').val();
            var url="http://www.wxlaravel.com/api/goods";
            var fd= new FormData();
            var upload = $('[name="goods_img"]')[0].files[0];
            fd.append('goods_img',upload);
            fd.append('goods_name',goods_name);
            fd.append('goods_price',goods_price);
            $.ajax({
                url:url,
                data:fd,
                type:"POST",
                dataType:"json",
                processData:false, // 使数据不做处理
                contentType:false, // 不要设置Content-Type请求头
                success:function(res){
                    if(res.ret==0){
                        alert(res.msg);
                        location.href="{{url('/goods/index')}}";
                    }
                }
            })
        })
    </script>
@endsection 