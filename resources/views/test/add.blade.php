@extends('layouts.hadmin')
@section('title')添加接口测试@endsection
@section('content')
    <div style="margin-top: 6%">
        <h2>测试接口添加</h2>
        {{--    <form action="{{url('/api/test/add')}}" method="post">--}}
        <div class="form-group">
            <input type="text" class="form-control" placeholder="用户名" name="name"  required="">
        </div>
        <div class="form-group">
            <input type="text" class="form-control" placeholder="年龄" name="age" required="">
        </div>
        <div class="form-group">
            <label for="exampleInputFile">头 像：</label>
            <input type="file" id="exampleInputFile" name="upload">
            <p class="help-block">Please upload your Avatar</p>
        </div>
        <button type="button" id="but" class="btn btn-success"> 添 加 </button>
        {{--    </form>--}}
    </div>

    <script>
        $('#but').click(function(){
            var name=$('[name="name"]').val();
            var age=$('[name="age"]').val();
            var url="http://www.wxlaravel.com/api/user";
            $.ajax({
                url:url,
                type:'POST',
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

