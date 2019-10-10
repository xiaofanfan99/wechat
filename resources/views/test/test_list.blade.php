@extends('layouts.hadmin')
@section('title')添加接口测试@endsection
@section('content')
    <h3>测试接口列表</h3>

    <table class="table table-condensed table-bordered">
        <tr>
            <td>用户id</td>
            <td>用户名</td>
            <td>用户年龄</td>
            <td>操作</td>
        </tr>
        <tbody class="list">

        </tbody>
    </table>
    <script>
        $.ajax({
            url:"http://www.wxlaravel.com/api/test/show",
            dataType:"json",
            success:function(res) {
                $.each(res.data,function(k,v){
                    var tr=$('<tr></tr>');
                    tr.append('<td>'+v.test_id+'</td>');
                    tr.append('<td>'+v.test_name+'</td>');
                    tr.append('<td>'+v.test_age+'</td>');
                    tr.append('<td><a class="btn btn-success" href="http://www.wxlaravel.com/test/update?id='+v.test_id+'">编 辑</a>|<a class="btn btn-danger" href="http://www.wxlaravel.com/api/test/delete?id='+v.test_id+'" >删 除</a></td>');
                    $('.list').append(tr);
                })
            }
        })
    </script>
@endsection

