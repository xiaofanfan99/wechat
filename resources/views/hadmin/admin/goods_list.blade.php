@extends('layouts.hadmin')
@section('title') 商品展示 @endsection
@section('content')

    <br><br>
    <h2>商品展示列表</h2>
    <form class="form-inline">
        <div class="form-group">
            <label for="exampleInputName2">GoodsName</label>
            <input type="text" class="form-control" id="exampleInputName2" placeholder="SEARCH" name="goods_name" value="{{$goods_name}}">
        </div>

        <select class="form-control" name="cate_name">
            <option>所有分类</option>
            @foreach($catedata as $v)
            <option value="{{$v['cate_id']}}">{{$v['cate_name']}}</option>
            @endforeach
        </select>
        <button type="submit" class="btn btn-info">SEARCH</button>
    </form>
    <br><br>
    <table class="table">
        <tr>
            <th>商品ID</th>
            <th>商品名称</th>
            <th>商品价格</th>
            <th>商品分类</th>
            <th>商品详情</th>
            <th>商品图片</th>
        </tr>
        @foreach($data as $v)
        <tr>
            <td>{{$v['goods_id']}}</td>
            <td class="goods_name" ><span>{{$v['goods_name']}}</span><input goods_id="{{$v['goods_id']}}" type="text" style="display: none;"></td>
            <td>{{$v['goods_price']}}</td>
            <td>{{$v['cate_name']}}</td>
            <td>{{$v['details']}}</td>
            <td><img src="{{$v['goods_img']}}" width="120" height="120" alt=""></td>
        </tr>
            @endforeach
    </table>
    <script>
        //即点即改
        $(document).on('click','.goods_name span',function () {
            var goods_name=$(this).text();
            var input=$(this).next();
            $(this).hide();
            input.show();
            input.val(goods_name);
            input.focus();
        })
        //input失去焦点
        $(document).on('blur','.goods_name input',function () {
            //获取input框的值
            var goods_name=$(this).val();
            var goods_id=$(this).attr('goods_id');
            $(this).hide();
            $('.goods_name span').show();
            $('.goods_name span').text(goods_name);
            $.ajax({
                url:"{{url('hadmin/goods_name_change')}}",
                data:{goods_name:goods_name,goods_id:goods_id},
                dataType:"json",
                success:function (res) {

                }
            })
        })

        {{--$('[type="button"]').on('click',function () {--}}
        {{--    var goods_name=$('[name="goods_name"]').val();--}}
        {{--    $.ajax({--}}
        {{--        url:"{{url('hadmin/goods_list')}}",--}}
        {{--        data:{goods_name:goods_name},--}}
        {{--        dataType:"json",--}}
        {{--        success:function (res) {--}}
        {{--            alert(res)--}}
        {{--        }--}}
        {{--    })--}}
        {{--})--}}
    </script>

@endsection
