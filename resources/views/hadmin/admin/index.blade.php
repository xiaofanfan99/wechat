<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="renderer" content="webkit">
    <title> -- Hadmin 后台</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <!--[if lt IE 9]>
    <meta http-equiv="refresh" content="0;ie.html" />
    <![endif]-->
    <link rel="shortcut icon" href="favicon.ico"> <link href="css/bootstrap.min.css?v=3.3.6" rel="stylesheet">
    <link href="css/font-awesome.min.css?v=4.4.0" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css?v=4.1.0" rel="stylesheet">
    <!-- 全局js -->
    <script src="js/jquery.min.js?v=2.1.4"></script>
    <script src="js/bootstrap.min.js?v=3.3.6"></script>
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
    <script src="js/plugins/layer/layer.min.js"></script>
    <!-- 自定义js -->
    <script src="js/hAdmin.js?v=4.1.0"></script>
    <script type="text/javascript" src="js/index.js"></script>
    <!-- 第三方插件 -->
    <script src="js/plugins/pace/pace.min.js"></script>
</head>
<body class="fixed-sidebar full-height-layout gray-bg" style="overflow:hidden">
<div id="wrapper">
    <!--左侧导航开始-->
    <nav class="navbar-default navbar-static-side" role="navigation">
        <div class="nav-close"><i class="fa fa-times-circle"></i>
        </div>
        <div class="sidebar-collapse">
            <ul class="nav" id="side-menu">
                <li class="nav-header">
                    <div class="dropdown profile-element">
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                <span class="clear">
                                    <span class="block m-t-xs" style="font-size:20px;">
                                        <i class="fa fa-area-chart"></i>
                                        <strong class="font-bold">hAdmin</strong>
                                    </span>
                                </span>
                        </a>
                    </div>
                    <div class="logo-element">hAdmin
                    </div>
                </li>
                <li class="hidden-folded padder m-t m-b-sm text-muted text-xs">
                    <span class="ng-scope">分类</span>
                </li>
                <li>
                    <a class="J_menuItem" href="javaScript:;">
                        <i class="fa fa-home"></i>
                        <span class="nav-label">主页</span>
                    </a>
                </li>
                <li>
                    <a class="J_menuItem" href="{{url('hadmin/login')}}">
                        <i class="fa fa-home"></i>
                        <span class="nav-label">微信登录扫码登录</span>
                    </a>
                </li>
                <li>
                    <a class="J_menuItem" href="{{url('/goods/weather')}}">
                        <i class="fa fa-table"></i>
                        <span class="nav-label">一周天气查看</span>
                    </a>
                </li>

                <li class="line dk"></li>
                <li class="hidden-folded padder m-t m-b-sm text-muted text-xs">
                    <span class="ng-scope">后台管理</span>
                </li>
                <li>
                    <a href="#">
                        <i class="fa fa fa-bar-chart-o"></i>
                        <span class="nav-label">后台商品管理</span>
                        <span class="fa arrow"></span>
                    </a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a class="J_menuItem" href="{{url('hadmin/goods_add')}}">商品添加</a>
                        </li>
                        <li>
                            <a class="J_menuItem" href="{{url('hadmin/goods_list')}}">商品列表</a>
                        </li>
                    </ul>
                    <ul class="nav nav-second-level">
                        <li>
                            <a class="J_menuItem" href="{{url('hadmin/sku_add')}}">货品添加</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#"><i class="fa fa-edit"></i> <span class="nav-label">商品分类</span><span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li><a class="J_menuItem" href="{{url('hadmin/cate_add')}}">分类添加</a>
                        </li>
                        <li><a class="J_menuItem" href="{{url('hadmin/cate_list')}}">分类展示</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#"><i class="fa fa-desktop"></i> <span class="nav-label">商品类型</span><span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li><a class="J_menuItem" href="{{url('hadmin/type_add')}}">类型添加</a>
                        </li>
                        <li><a class="J_menuItem" href="{{url('hadmin/type_list')}}">类型列表</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#"><i class="fa fa-flask"></i> <span class="nav-label">商品属性</span><span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li><a class="J_menuItem" href="{{url('hadmin/attr_add')}}">商品属性添加</a>
                        </li>
                        <li><a class="J_menuItem" href="{{url('hadmin/attr_list')}}">商品属性列表</a>
                        </li>
                    </ul>
                </li>
                <li class="hidden-folded padder m-t m-b-sm text-muted text-xs">
                    <span class="ng-scope">阿凡达实时新闻</span>
                </li>
                <li>
                    <a href="#"><i class="fa fa-table"></i> <span class="nav-label">用户管理</span><span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li><a class="J_menuItem" href="{{url('/api/newstset/regist')}}">用户注册</a></li>
                        <li><a class="J_menuItem" href="{{url('/api/newstset/login')}}">用户登录</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#"><i class="fa fa-table"></i> <span class="nav-label">新闻更新</span><span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li><a class="J_menuItem" href="{{url('/api/newstset/news')}}">新闻更新</a></li>
                    </ul>
                </li>
                <li class="line dk"></li>
                <li class="hidden-folded padder m-t m-b-sm text-muted text-xs">
                    <span class="ng-scope">api接口测试</span>
                </li>
                <li>
                    <a href="#"><i class="fa fa-table"></i> <span class="nav-label">api接口测试</span><span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li><a class="J_menuItem" href="{{url('/test/test_add')}}">测试接口添加</a></li>
                        <li><a class="J_menuItem" href="{{url('/test/test_list')}}">测试接口列表</a></li>

                    </ul>
                </li>
                <li>
                    <a href="#"><i class="fa fa-picture-o"></i> <span class="nav-label">api周测</span><span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li><a class="J_menuItem" href="{{url('/goods/add')}}">商品添加</a>
                        </li>
                        <li><a class="J_menuItem" href="{{url('/goods/index')}}">商品列表</a>
                        </li>
                    </ul>
                </li>
                <li class="line dk"></li>
                <li class="hidden-folded padder m-t m-b-sm text-muted text-xs">
                    <span class="ng-scope">微信</span>
                </li>
                <li>
                    <a href="#"><i class="fa fa-magic"></i><span class="nav-label">微信公众号开发</span><span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li><a class="J_menuItem" href="{{url('/wechat/get_user_list')}}">获取粉丝列表</a></li>
                    </ul>
                    <ul class="nav nav-second-level">
                        <li><a class="J_menuItem" href="{{url('/wechat/upload_list')}}">素材管理</a></li>
                    </ul>
                    <ul class="nav nav-second-level">
                        <li><a class="J_menuItem" href="{{url('/agent/agent_list')}}">生成用户专属二维码</a></li>
                    </ul>
                    <ul class="nav nav-second-level">
                        <li><a class="J_menuItem" href="{{url('/work/tag_list')}}">微信用户标签列表</a></li>
                    </ul>
                    <ul class="nav nav-second-level">
                        <li><a class="J_menuItem" href="{{url('/wechat/menu_list')}}">微信自定义菜单管理</a></li>
                    </ul>
                    <ul class="nav nav-second-level">
                        <li><a class="J_menuItem" href="{{url('/wechat/login')}}">微信登录</a></li>
                    </ul>
                <li>

                    <a href="#"><i class="fa fa-cutlery"></i> <span class="nav-label">工具 </span><span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li><a class="J_menuItem" href="form_builder.html">表单构建器</a>
                        </li>
                    </ul>
                </li>

            </ul>
        </div>
    </nav>
    <!--左侧导航结束-->
    <!--右侧部分开始-->
    <div id="page-wrapper" class="gray-bg dashbard-1">
        <div class="row border-bottom">
            <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
                <div class="navbar-header"><a class="navbar-minimalize minimalize-styl-2 btn btn-info " href="#"><i class="fa fa-bars"></i> </a>
                    <form role="search" class="navbar-form-custom" method="post" action="search_results.html">
                        <div class="form-group">
                            <input type="text" placeholder="请输入您需要查找的内容 …" class="form-control" name="top-search" id="top-search">
                        </div>
                    </form>
                </div>



            </nav>
        </div>
        <div class="row J_mainContent" id="content-main">
            <iframe id="J_iframe" width="100%" height="100%" src="/storage/photo/7oLkDtESUDQAfhJ7jPU1iEALBxI353pRuQy2CcRX.jpeg" frameborder="0" data-id="index_v1.html" seamless></iframe>
        </div>
    </div>
    <!--右侧部分结束-->
</div>
<div style="text-align:center;">
    <p>来源:<a href="http://www.mycodes.net/" target="_blank">源码之家</a></p>
</div>
</body>
</html>
