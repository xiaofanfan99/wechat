@extends('layouts.hadmin')
@section('title')分类添加@endsection
@section('content')
    <br>
    <h2>分类展示</h2>
    <br>
    <table class="table table-bordered">
        <tr>
            <th>分类ID</th>
            <th>分类名称</th>
            <th>是否显示</th>
            <th>操作</th>
        </tr>
        @foreach($data as $v)
        <tr>
            <td>{{$v->cate_id}}</td>
            <td>{{$v->cate_name}}</td>
            <td>@if($v->is_show==1) 显示 @else 隐藏 @endif </td>
            <td><a href="">删除</a></td>
        </tr>
            @endforeach
    </table>
@endsection
