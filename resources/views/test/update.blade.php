@extends('layouts.hadmin')
@section('title')接口测试修改@endsection
@section('content')
    <h2>测试接口修改</h2>
    <div class="form-group">
        <input type="text" class="form-control" placeholder="用户名" name="name"  required="">
    </div>
    <div class="form-group">
        <input type="text" class="form-control" placeholder="年龄" name="age" required="">
    </div>
    <button type="button" id="but" class="btn btn-success"> 修改 </button>
    <script>
        function GetQueryString(name) {
            var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i");
            var r = window.location.search.substr(1).match(reg);
            if (r != null) return unescape(r[2]); return null;}
            var id=GetQueryString('id');
            var url="http://www.wxlaravel.com/api/user";
            $.ajax({
                url:url+'/'+id,
                type:"GET",
                dataType:'json',
                success:function (res) {
                    var name=$('[name="name"]').val(res.data.test_name);
                    var name=$('[name="age"]').val(res.data.test_age);
                }
            })
            $('#but').click(function(){
                var name=$('[name="name"]').val();
                var age=$('[name="age"]').val();
                $.ajax({
                    url:url+'/'+id,
                    // type:"PUT",
                    type:"POST",
                    dataType: "json",
                    data:{name:name,age:age,'_method':'PUT'},
                    success:function (res) {
                        if(res.ret==1){
                            alert(res.msg);
                            location.href="http://www.wxlaravel.com/test/test_list";
                        }
                    }

                })

            })
    </script>
@endsection

