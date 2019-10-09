@extends('layouts.hadmin')
@section('title')用户绑定@endsection
@section('content')
{{--    <form class="form-horizontal" action="{{url('hadmin/binding_do')}}" method="post">--}}
{{--        @csrf--}}
{{--            <div style="margin-top:6%">--}}
{{--                <h3>用户绑定</h3>--}}
{{--                <div class="form-group">--}}
{{--                    <label for="inputEmail3" class="col-sm-2 control-label">用户名：</label>--}}
{{--                    <div class="col-xs-5">--}}
{{--                        <input type="text" class="form-control" placeholder="用户名" id="inputEmail3" placeholder="Email" name="username">--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="form-group">--}}
{{--                    <label for="inputPassword3" class="col-sm-2 control-label">密码：</label>--}}
{{--                    <div class="col-xs-5">--}}
{{--                        <input type="password" class="form-control" placeholder="密码" id="inputPassword3" placeholder="Password" name="password">--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="form-group">--}}
{{--                    <div class="col-sm-offset-2 col-sm-10">--}}
{{--                        <button type="submit" class="btn btn-primary"> 绑 定 </button>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--    </form>--}}
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-sm-6">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>用户绑定</h5>
                    </div>
                    <div class="ibox-content">
                        <form class="form-horizontal" action="{{url('hadmin/binding_do')}}" method="post">
                            @csrf
                            <div class="form-group">
                                <label class="col-sm-3 control-label">用户名：</label>
                                <div class="col-sm-8">
                                    <input type="text" placeholder="用户名" name="username" class="form-control">
                                    <span class="help-block m-b-none">请输入您注册所填的用户名</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">密码：</label>
                                <div class="col-sm-8">
                                    <input type="password" placeholder="请输入密码" name="password" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-3 col-sm-8">
                                    <button class="btn btn-sm btn-info" type="submit"> 绑 定 </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


