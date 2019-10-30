@extends('layouts.hadmin')
@section('title')--班级学生展示@endsection
@section('content')
    <h2>班级学生展示列表</h2>
    <table class="table table-bordered table-hover" >
        <tr>
            <th>班级ID</th>
            <th>班级名称</th>
            <th>班级学生信息</th>
        </tr>
        @foreach($class_data as $key => $value)
            <tr>
                <td>{{$value['class_id']}}</td>
                <td>{{$value['class_name']}}</td>

                <td>
                    <table class="table table-bordered table-hover">
                        <tr>
                            <td>学生id</td>
                            <td>学生名字</td>
                            <td>学生年龄</td>
                        </tr>
                        @foreach($class_data[$key]['studentData'] as $k => $v)
                            <tr>
                                <td>{{$v['stu_id']}}</td>
                                <td>{{$v['stu_name']}}</td>
                                <td>{{$v['stu_age']}}</td>
                            </tr>
                           @endforeach
                    </table>
                </td>

            </tr>
        @endforeach

    </table>
@endsection
