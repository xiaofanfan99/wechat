@extends('layouts.hadmin')
@section('title')添加接口测试@endsection
@section('content')
    <div style="margin-top: 6%">
        <h2>测试接口列表</h2>
        <form class="form-inline">
            <div class="form-group">
                <label for="exampleInputName2">用户名</label>
                <input type="text" class="form-control" id="exampleInputName2" name="name" name="age" placeholder="USER NAME">
            </div>
            <button type="button" class="btn btn-default">进行搜索</button>
        </form>
        <table class="table table-condensed table-bordered bg-success ">
            <tr>
                <td>用户id</td>
                <td>用户名</td>
                <td>用户年龄</td>
                <td>操作</td>
            </tr>
            <tbody class="list">

            </tbody>
        </table>
            <nav aria-label="Page navigation">
                <ul class="pagination">
{{--                    <li><a href="#" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>--}}

{{--                    <li><a href="#" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>--}}
                </ul>
            </nav>
    </div>
    <script>
        var url="http://www.wxlaravel.com/api/user";
        //列表循环展示
        $.ajax({
            url:url,
            type:'GET',
            dataType:"json",
            success:function(res) {
                showData(res);
            }
        })
        /**
         * 点击进行搜索
         */
        $('.btn-default').click(function () {
            var name=$('[name="name"]').val();
            var age=$('[name="age"]').val();
            console.log(age)
            $.ajax({
                url:url,
                type:'GET',
                data:{name:name},
                dataType:"json",
                success:function(res) {
                    showData(res);
                }
            })
        })
        /**
         * 分页
         */
        $(document).on('click','.pagination a',function(){
            var name=$('[name="name"]').val();
            var page=$(this).text();
            $.ajax({
                url:url,
                data:{page:page,name:name},
                dataType: 'json',
                success: function (res) {
                    showData(res);
                }
            })
        })
        /**
         * 渲染页面循环展示
         * @param res
         */
        function showData(res) {

            $('.list').empty();
            //列表循环展示
            $.each(res.data.data,function(k,v){
                var tr=$('<tr  class="tr"></tr>');
                tr.append('<td>'+v.test_id+'</td>');
                tr.append('<td>'+v.test_name+'</td>');
                tr.append('<td>'+v.test_age+'</td>');
                tr.append('<td><a class="btn btn-success" href="http://www.wxlaravel.com/test/update?id='+v.test_id+'">编 辑</a>|<a class="btn btn-danger" test_id="'+v.test_id+'" >删 除</a></td>');
                $('.list').append(tr);
            })
            //分页展示
            $('.pagination').empty();
            var max_page=res.data.last_page;
            for (var i=1; i<=max_page; i++){
                var li ="<li><a  href='javaScript:;'>"+i+"</a></li>";
                $('.pagination').append(li);
            }
            //ajax点击删除
            $('.btn-danger').click(function() {
                var id = $(this).attr('test_id');
                // alert(id);
                $.ajax({
                    url:url+'/'+id,
                    type:"DELETE",
                    dataType: 'json',
                    success: function (res) {
                        if (res.res == 1) {
                            alert(res.msg);
                            location.href = "http://www.wxlaravel.com/test/test_list"
                        }
                    }
                })
            })
        }
    </script>
@endsection
