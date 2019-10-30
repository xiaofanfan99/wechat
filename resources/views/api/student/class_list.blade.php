@extends('layouts.hadmin')
@section('title')--班级展示@endsection
@section('content')
<h2>班级展示列表</h2>
    <table class="table table-bordered table-hover" >
        <tr>
            <th>班级ID</th>
            <th>班级名称</th>
            <th>班级学生人数</th>
        </tr>
        @foreach($class_data as $key=>$value)
            <tr>
                <td>{{$value['class_id']}}</td>
                <td>{{$value['class_name']}}</td>
                <td>{{$value['student_count']}}</td>
            </tr>
        @endforeach
    </table>
@endsection
