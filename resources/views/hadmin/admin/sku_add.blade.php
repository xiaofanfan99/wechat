@extends('layouts.hadmin')
@section('title') 货品添加 @endsection
@section('content')
    <h3>货品添加</h3>
    <form action="{{url('hadmin/sku_do')}}" method="post">
        @csrf
        <table width="100%" id="table_list" class='table table-bordered'>
            <tbody>
            <tr>
                <th colspan="20" scope="col">商品名称：{{$goodsData[0]['goods_name']}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;货号：ECS000075</th>
                <input type="hidden" name="goods_id" value="{{$goodsData[0]['goods_id']}}">
            </tr>
            <tr>
                <!-- start for specifications -->
                @foreach($attrData as $key=>$value)
                <td scope="col"><div align="center"><strong>{{$key}}</strong></div></td>
                @endforeach
                <!-- end for specifications -->
                <td class="label_2">货号</td>
                <td class="label_2">库存</td>
                <td class="label_2">&nbsp;</td>
            </tr>

            <tr id="attr_row">
                @foreach($attrData as $key=>$value)
                    <!-- start for specifications_value -->
                    <td align="center" style="background-color: rgb(255, 255, 255);">
                        <select name="sku_attr_list[]">
                            <option value="" selected="">请选择...</option>
                            @foreach($value as $k=>$v)
                            <option value="{{$v['goods_attr_id']}}">{{$v['attr_value']}}</option>
                            @endforeach
    {{--                        <option value="64G">64G</option>--}}
                        </select>
                    </td>
                @endforeach
    {{--            <td align="center" style="background-color: rgb(255, 255, 255);">--}}
    {{--                <select name="attr[214][]">--}}
    {{--                    <option value="" selected="">请选择...</option>--}}
    {{--                    <option value="土豪金">土豪金</option>--}}
    {{--                    <option value="太空灰">太空灰</option>--}}
    {{--                </select>--}}
    {{--            </td>--}}
                <!-- end for specifications_value -->
                <td class="label_2" style="background-color: rgb(255, 255, 255);"><input type="text" name="product_sn[]" value="" size="20"></td>
                <td class="label_2" style="background-color: rgb(255, 255, 255);"><input type="text" name="product_number[]" value="1" size="10"></td>
                <td style="background-color: rgb(255, 255, 255);"><input type="button" class="button" value=" + " ></td>
            </tr>
            <tr>
                <td align="center" colspan="5" style="background-color: rgb(255, 255, 255);">
                    <input type="submit" class="btn btn-primary" value=" 保存 ">
                </td>
            </tr>
            </tbody>
        </table>
    </form>
    <script>
        //加号减号样式
        $(document).on('click','.button',function () {
            if($(this).val()== " + "){
                $(this).val(" - ");
                //复制选中的一行
                var attr_wor=$('#attr_row').clone();
                $('#attr_row').after(attr_wor);
                $(this).val(" + ");
            }else{
                //点击减号删除一行
                $(this).parent().parent().remove();
            }
        })
    </script>
@endsection
