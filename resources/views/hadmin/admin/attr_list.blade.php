@extends('layouts.hadmin')
@section('title')商品属性列表@endsection
@section('content')
    <br>
    <h2>商品属性列表</h2>
    <br>
    <form action="">
        <div class="form-group form-group-sm">
            <div class="col-sm-3">
                <h3>按照商品类型搜索：</h3>
                <select class="form-control type" name="type">
                    <option value="">请选择...</option>
                    @foreach($type_data as $v)
                    <option value="{{$v['type_id']}}">{{$v['type_name']}}</option>
                        @endforeach
                </select>
            </div>
        </div>
    </form>
    <br>
    <br>
    <br>
    <br>
    <table class="table table-bordered">
        <tr>
            <th><input type="checkbox" class="checkall">属性ID</th>
            <th>属性名称</th>
            <th>所属商品类型</th>
            <th>属性是否可选</th>
            <th>操作</th>
        </tr>
        <tbody class="list">
            @foreach($data as $v)
                <tr>
                    <td><input type="checkbox" name="checkboxes[]" value="{{$v->attr_id}}">{{$v->attr_id}}</td>
                    <td>{{$v->attr_name}}</td>
                    <td>{{$v->type_name}}</td>
                    <td>@if($v->optional==2) 参数 @elseif($v->optional==1) 规格 @endif </td>
                    <td><a href="">删除</a></td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <!-- Indicates a dangerous or potentially negative action -->
    <button type="button" class="btn btn-danger">批量删除</button>
    <script>
        //批量删除
        $('[type="button"]').on('click',function () {
            // 判断是否至少选择一项
            var checkedNum = $("input[name='checkboxes[]']:checked").length;
            if(checkedNum == 0) {
                alert("请选择至少一项！");
                return;
            }
            //定义一个数组
            var checkedList= new Array();
            //获取checkbox 属性是checked的 循环
            $("input[name='checkboxes[]']:checked").each(function() {
                checkedList.push($(this).val());
            });
            //发送请求
            $.ajax({
                url:"{{url('hadmin/delall')}}",
                data:{attr_id:checkedList},
                dataType:"json",
                success:function(res) {
                    if(res.ret==1){
                        alert(res.msg);
                        window.location.reload();
                    }
                }
            })
        })
        //全选反选
        $('.checkall').on('click',function () {
            $('[name="checkboxes[]"]').prop('checked',$(this).prop('checked'));
        })
        //ajax搜索
        $('.type').change(function () {
             var type_name=$(this).val();
             $.ajax({
                 url:"{{url('hadmin/type_search')}}",
                 data:{type_name:type_name},
                 dataType:"json",
                 method:"GET",
                 success:function (res) {
                         $('.list').empty();
                         $.each(res,function(k,v) {
                             var tr=$('<tr></tr>');
                             tr.append('<td><input type="checkbox" name="checkboxes[]" value="'+v.attr_id+'">'+v.attr_id+'</td>');
                             tr.append('<td>'+v.attr_name+'</td>');
                             tr.append('<td>'+v.type_name+'</td>');
                             if(v.optional==2){
                                 tr.append('<td>参数</td>');
                             }else if(v.optional==1){
                                 tr.append('<td>规格</td>');
                             }
                             tr.append('<td><a href="">删除</a></td>');
                             $('.list').append(tr);
                         })
                     }

             })
        })
    </script>
@endsection
