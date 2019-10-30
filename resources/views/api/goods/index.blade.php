@extends('layouts.hadmin')
@section('title')--商品添加接口测试@endsection
@section('content')
<h2>商品展示</h2>
    <table class="table table-bordered table-hover bg-success">
        <tr>
            <th>商品ID</th>
            <th>商品名称</th>
            <th>商品价格</th>
            <th>商品图片</th>
            <th>操作</th>
        </tr>
        <tbody class="list">

        </tbody>
    </table>
    <nav aria-label="...">
    <nav aria-label="Page navigation">
  <ul class="pagination">
    <!-- <li>
      <a href="#" aria-label="Previous">
        <span aria-hidden="true">&laquo;</span>
      </a>
    </li> -->
    <!-- <li><a href="#">1</a></li>
    <li><a href="#">2</a></li>
    <li><a href="#">3</a></li>
    <li><a href="#">4</a></li>
    <li><a href="#">5</a></li> -->
    <!-- <li>
      <a href="#" aria-label="Next">
        <span aria-hidden="true">&raquo;</span>
      </a>
    </li> -->
  </ul>
</nav>
</nav>
    <script src='/jq.js'></script>
    <script>
        //调用接口获取数据循环展示
        var url="http://www.wxlaravel.com/api/goods";
        $.ajax({
            url:url,
            type:'GET',
            dataType:"json",
            success:function(res){
                // console.log(res)
                $.each(res.data.data,function(k,v){
                    var tr=$('<tr></tr>');
                    tr.append('<td>'+v.goods_id+'</td>');
                    tr.append('<td>'+v.goods_name+'</td>');
                    tr.append('<td>'+v.goods_price+'</td>');
                    tr.append('<td><img width="120"  src="'+v.goods_img+'"></td>');
                    tr.append('<td><a href="">删除</a></td>');
                    $('.list').append(tr);
                })
                //获取最大页码
               var max_page=res.data.last_page;
               for(var i=1; i<=max_page; i++){
                    var li ="<li><a href='javaScript:;'>"+i+"</a></li>";
                    $('.pagination').append(li);
               }
            }
        })
        //分页
        $(document).on('click','.pagination a',function(){
            var name=$('[name="name"]').val();
            var page=$(this).text();
            $.ajax({
                url:url,
                data:{page:page,name:name},
                dataType: 'json',
                success: function (res) {
                    $('.list').empty();
                    $.each(res.data.data,function(k,v){
                    var tr=$('<tr></tr>');
                    tr.append('<td>'+v.goods_id+'</td>');
                    tr.append('<td>'+v.goods_name+'</td>');
                    tr.append('<td>'+v.goods_price+'</td>');
                   tr.append('<td><img width="120"  src="'+v.goods_img+'"></td>');
                    tr.append('<td><a href="">删除</a></td>');
                    $('.list').append(tr);
                })
                //获取最大页码
               var max_page=res.data.last_page;
               $('.pagination').empty();
               for(var i=1; i<=max_page; i++){
                    var li ="<li><a href='javaScript:;'>"+i+"</a></li>";
                    $('.pagination').append(li);
               }
                }
            })
        })
    </script>
@endsection
