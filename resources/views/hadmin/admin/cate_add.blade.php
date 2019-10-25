@extends('layouts.hadmin')
@section('title')分类添加@endsection
@section('content')
    <br>
    <h2>分类添加</h2>
    <br>
    <form method="post" action="{{url('hadmin/cate_do')}}">
        @csrf
        <div class="form-group">
            <label for="exampleInputEmail1">商品分类名称</label>
            <input type="text" class="form-control cate-name" id="exampleInputEmail1" placeholder="CateName" name="cate_name">
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">上级分类</label>
            <select class="form-control" name="parent_id">
                <option value="0">顶级分类</option>
                    @foreach($cateData as $v)
                        <option value="{{$v['cate_id']}}">{{$v['cate_name']}}</option>
                    @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">是否显示：</label>
            <label class="radio-inline">
                <input type="radio" name="is_show" id="inlineRadio3" value="1"> 是
            </label>
            <label class="radio-inline">
                <input type="radio" name="is_show" id="inlineRadio3" value="0"> 否
            </label>
        </div>
        <button type="button" class="sub btn btn-default">Submit</button>
    </form>
    <script>
        var flag=false;
        //分类添加失去焦点判断唯一性
        $('.cate-name').blur(function () {
            var cate_name=$('[name="cate_name"]').val();
            $.ajax({
                url:"{{url('hadmin/cate_only')}}",
                data:{cate_name:cate_name},
                dataType:"json",
                async:false,
                success:function (res) {
                   if(res.ret==0){
                       alert(res.msg);
                       flag=false;  //名重复
                   }else{
                       flag = true;
                   }
                },
            })
        })

        //点击添加
        $(".sub").on('click',function(){
            if(flag){
                //真的提交表单
                $('form').submit();
            }else{
                // 阻止表单提交
                return false;
            }
        })
    </script>
    @endsection
