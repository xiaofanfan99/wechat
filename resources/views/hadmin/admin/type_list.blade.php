@extends('layouts.hadmin')
@section('title')类型展示@endsection
@section('content')
    <br>
    <h2>类型展示</h2>
    <br>
    <table class="table table-bordered">
        <tr>
            <th>类型ID</th>
            <th>类型名称</th>
            <th>属性数</th>
            <th>操作</th>
        </tr>
        @foreach($data as $v)
            <tr>
                <td>{{$v['type_id']}}</td>
                <td>{{$v['type_name']}}</td>
                <td>{{$v['attr_num']}}</td>
                <td><a href="{{url('hadmin/attr_list')}}?type_id={{$v['type_id']}}">属性列表</a></td>
            </tr>
        @endforeach
    </table>
@endsection
