@extends('layouts.hadmin')
@section('title')添加接口测试@endsection
@section('content')
    <h3>测试接口添加</h3>
{{--    <form action="{{url('/api/test/add')}}" method="post">--}}
        <div class="form-group">
            <input type="text" class="form-control" placeholder="用户名" name="name"  required="">
        </div>
        <div class="form-group">
            <input type="password" class="form-control" placeholder="年龄" name="age" required="">
        </div>
        <button type="button" id="but" class="btn btn-success"> 添 加 </button>
{{--    </form>--}}
    <script>
        $('#but').click(function(){
            var name=$('[name="name"]').val();
            var age=$('[name="age"]').val();
            $.ajax({
                url:'http://www.wxlaravel.com/api/test/add',
                dataType:'json',
                data:{name:name,age:age},
                success:function(res){
                    if(res.ret == 1){
                        alert(res.msg);
                        location.href="{{url('/test/test_list')}}";
                    }
                }
            })
        })
    </script>
    @endsection

