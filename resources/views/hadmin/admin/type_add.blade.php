@extends('layouts.hadmin')
@section('title')类型添加@endsection
@section('content')
    <br>
    <h2>类型添加</h2>
    <br>
    <form method="post" action="{{url('hadmin/type_do')}}">
        @csrf
        <div class="form-group">
            <label for="exampleInputEmail1">商品类型名称</label>
            <input type="text" class="form-control" id="exampleInputEmail1" placeholder="TypeName" name="type_name">
        </div>
        <button type="submit" class="btn btn-default">Submit</button>
    </form>
@endsection
