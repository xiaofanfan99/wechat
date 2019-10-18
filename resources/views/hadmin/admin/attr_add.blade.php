@extends('layouts.hadmin')
@section('title')商品属性添加@endsection
@section('content')
    <br>
    <h2>商品属性添加</h2>
    <br>
    <form method="post" action="{{url('hadmin/attr_do')}}">
        @csrf
        <div class="form-group">
            <label for="exampleInputEmail1">商品属性</label>
            <input type="text" class="form-control" id="exampleInputEmail1" placeholder="CateName" name="attr_name">
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">所属商品类型</label>
            <select class="form-control" name="type_id">
                <option value="0">请选择.....</option>
                @foreach($type as $v)
                <option value="{{$v->type_id}}">{{$v->type_name}}</option>
                    @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">属性是否可选：</label>
            <label class="radio-inline">
                <input type="radio" name="optional" id="inlineRadio3" value="2">参数
            </label>
            <label class="radio-inline">
                <input type="radio" name="optional" id="inlineRadio3" value="1">规格
            </label>
        </div>
        <button type="submit" class="btn btn-default">Submit</button>
    </form>
@endsection
