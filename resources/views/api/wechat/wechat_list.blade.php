
@extends('layouts.hadmin')
@section('title')--微信开发@endsection
@section('content')
    <h2>微信开发</h2>
    <br>
    <table>
        <h3>APPID: {{$db_data['appid']}} </h3> <br>
        <h3>APPSECRET: {{$db_data['appsecret']}}</h3><br> <br>
    </table>
    <form action="{{url('api/wechat/api_url')}}">
        <div class="form-group">
            <label for="exampleInputPassword1">JS接口安全域名</label>
            <input type="hidden" name="user_id" value="{{$db_data['user_id']}}">
            <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Password" name="api_url" value="{{$db_data['api_url']}}">
        </div>
        <button type="submit" class="btn btn-success">提交</button>
    </form>
@endsection
