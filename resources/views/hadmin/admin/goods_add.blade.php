@extends('layouts.hadmin')
@section('title')商品添加@endsection
@section('content')
    <br>
    <br>
    <h3>商品添加</h3>
    <ul class="nav nav-tabs">
        <li role="presentation" class="active"><a href="javascript:;" name='basic'>基本信息</a></li>
        <li role="presentation" ><a href="javascript:;" name='attr'>商品属性</a></li>
        <li role="presentation" ><a href="javascript:;" name='detail'>商品详情</a></li>
    </ul>
    <br>
    <form action='{{url('hadmin/goods_do')}}' method="POST" enctype="multipart/form-data" id='form'>
        @csrf
        <div class='div_basic div_form'>
            <div class="form-group">
                <label for="exampleInputEmail1">商品名称</label>
                <input type="text" class="form-control" name='goods_name'>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">商品分类</label>
                <select class="form-control" name='cat_id'>
                    <option value='0'>请选择</option>
                    @foreach($cateData as $v)
                    <option value='{{$v['cate_id']}}'>{{$v['cate_name']}}</option>
                        @endforeach

                </select>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">商品货号</label>
                <input type="text" class="form-control" name='goods_price'>
            </div>

            <div class="form-group">
                <label for="exampleInputEmail1">商品价钱</label>
                <input type="text" class="form-control" name='goods_price'>
            </div>

            <div class="form-group">
                <label for="exampleInputFile">商品图片</label>
                <input type="file" name='file'>
            </div>

        </div>
        <div class='div_detail div_form' style='display:none'>
            <div class="form-group">
                <label for="exampleInputFile">商品详情</label>
                <textarea class="form-control" rows="3" name="details"></textarea>
            </div>
        </div>
        <div class='div_attr div_form' style='display:none'>
            <div class="form-group">
                <label for="exampleInputEmail1">商品类型</label>
                <select class="form-control" name='type_id' >
                    <option>请选择</option>
                    @foreach($typeData as $v)
                        <option value='{{$v['type_id']}}'>{{$v['type_name']}}</option>
                    @endforeach
                </select>
            </div>
            <br>

            <table width="100%" id="attrTable" class='table table-bordered'>
{{--                <tr>--}}
{{--                    <td>前置摄像头</td>--}}
{{--                    <td>--}}
{{--                        <input type="hidden" name="attr_id_list[]" value="211">--}}
{{--                        <input name="attr_value_list[]" type="text" value="" size="20">--}}
{{--                        <input type="hidden" name="attr_price_list[]" value="0">--}}
{{--                    </td>--}}
{{--                </tr>--}}
{{--                <tr>--}}
{{--                    <td><a href="javascript:;">[+]</a>颜色</td>--}}
{{--                    <td>--}}
{{--                        <input type="hidden" name="attr_id_list[]" value="214">--}}
{{--                        <input name="attr_value_list[]" type="text" value="" size="20">--}}
{{--                        属性价格 <input type="text" name="attr_price_list[]" value="" size="5" maxlength="10">--}}
{{--                    </td>--}}
{{--                </tr>--}}
            </table>
            <!-- <div class="form-group">
                    颜色:
                    <input type="text" name='attr_value_list[]'>
            </div> -->
            <!-- <div class="form-group" style='padding-left:26px'>
                <a href="javascript:;">[+]</a>内存:
                <input type="text" name='attr_value_list[]'>
                属性价格:<input type="text" name='attr_price_list[][]'>
            </div> -->

        </div>

        <button type="submit" class="btn btn-default" id='btn'>添加</button>
    </form>

    <script type="text/javascript">
        //标签页 页面渲染
        $(".nav-tabs a").on("click",function(){
            $(this).parent().siblings('li').removeClass('active');
            $(this).parent().addClass('active');
            var name = $(this).attr('name');  // attr basic
            $(".div_form").hide();
            $(".div_"+name).show();  // $(".div_"+name)
        })

        /**
         * 改变商品类型下拉框内容事件
         */
        $("[name='type_id']").change(function () {
            //获取类型id
            var type_id=$(this).val();
            //发送请求
            $.ajax({
                url:"{{url('hadmin/goods_getattr')}}",
                data:{type_id:type_id},
                dataType:"json",
                success:function (res) {
                    if(res.ret==1){
                        $('#attrTable').empty();
                        $.each(res.data,function(i,v) {
                            //判断是否是可选属性
                            if(v.optional==1){
                                //可选属性
                                var tr='<tr>\n' +
                        '                    <td><a href="javascript:;" class="addRow">[+]</a>'+v.attr_name+'</td>\n' +
                        '                    <td>\n' +
                        '                        <input type="hidden" name="attr_id_list[]" value="'+v.attr_id+'">\n' +
                        '                        <input name="attr_value_list[]" type="text" value="" size="20">\n' +
                        '                        属性价格 <input type="text" name="attr_price_list[]" value="" size="5" maxlength="10">\n' +
                        '                    </td>\n' +
                        '                </tr>';
                            }else{
                                //不可选属性
                            var tr='<tr>\n' +
                    '                    <td>'+v.attr_name+'</td>\n' +
                    '                    <td>\n' +
                    '                        <input type="hidden" name="attr_id_list[]" value="'+v.attr_id+'">\n' +
                    '                        <input name="attr_value_list[]" type="text" value="" size="20">\n' +
                    '                        <input type="hidden" name="attr_price_list[]" value="0">\n' +
                    '                    </td>\n' +
                    '                </tr>';
                            }
                            $('#attrTable').append(tr);
                        })
                    }
                }
            })
        })
        $(document).on('click','.addRow',function () {
            //选择谁 操作
            //获取点击a标签的值
            var val=$(this).html();
            //操作a标签的父级的父级 tr
            var tr=$(this).parent().parent();
            //判断a标签的值 是加号还是减号
            if(val=="[+]"){
                //加号 点击克隆减号
                $(this).html("[-]");
                var clo_row=tr.clone();
                //克隆后吧a 变为 加号
                $(this).html("[+]");
                //吧克隆的字符串在tr尾部插入
                tr.after(clo_row);
            }else{
                //减号直接删除点击的一行tr
                tr.remove();
            }
        })
    </script>
@endsection
