@extends('layouts.hadmin')
@section('title')--热点新闻展示@endsection
@section('content')
    <h2>热点新闻展示</h2>
    <button type="button" class="btn btn-success">更新新闻</button>
    <table class="table table-bordered table-hover bg-success table-bordered">
        <tr>
            <th>热点新闻标题</th>
            <th>新闻内容</th>
            <th>更新时间</th>
            <th>新闻配图</th>
            <th>网站</th>
            <th>发布时间</th>
        </tr>
        <tbody class="list">
            <tr>

            </tr>
        </tbody>
{{--        @foreach($news_data as $k=>$v)--}}
{{--        <tr>--}}
{{--            <td>{{$v['title']}}</td>--}}
{{--            <td>{{$v['content']}}</td>--}}
{{--            <td>{{$v['pdate']}}</td>--}}
{{--            <td><img src="{{$v['img']}}" width="150" height="150"></td>--}}
{{--            <td>{{$v['src']}}</td>--}}
{{--            <td>{{$v['pdate_src']}}</td>--}}
{{--        </tr>--}}
{{--            @endforeach--}}
    </table>
    <nav aria-label="Page navigation">
        <ul class="pagination">
            <li><a href="javascript:;">1</a></li>
        </ul>
    </nav>
    <script>
        //更新新闻
        $('.btn-success').on('click',function () {
            $.ajax({
                url:"http://www.wxlaravel.com/api/newstset/news",
                dataType:"json",
                success:function (res) {
                    if(res.ret==1){
                        alert(res.msg);//已是最新
                        return false;
                    }else if(res.ret==2){//更新成功
                        alert(res.msg);
                        return false;
                    }
                    if(res.ret==403){//刷新超十次 禁止刷新
                        alert(res.msg);
                        return false;
                    }
                }
            })
        })
        //调用接口循环数据
        $.ajax({
            url:"{{url('/api/newstset/news_list')}}",
            dataType:"json",
            success:function (res) {
                // console.log(res.data.data);
                if(res.ret==1){
                    NewsData(res);
                }
            }
        })
        //分页
        $(document).on('click','.pagination li a',function () {
            var page=$(this).text();
            $.ajax({
                url:"{{url('/api/newstset/news_list')}}",
                data:{page:page},
                dataType:'json',
                success: function (res) {
                    NewsData(res);
                }
            })
        })

        //数据渲染
        function NewsData(res) {
            $('.list').empty();
            $.each(res.data.data,function (i,v) {
                var tr=$('<tr></tr>');
                tr.append('<td>'+v.title+'</td>');
                tr.append('<td>'+v.content+'</td>');
                tr.append('<td>'+v.pdate+'</td>');
                tr.append('<td><img src="'+v.img+'" width="150" height="150"></td>');
                tr.append('<td>'+v.src+'</td>');
                tr.append('<td>'+v.pdate_src+'</td>');
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


    </script>
@endsection
