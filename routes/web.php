<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
//微信接口
Route::any('/test/test_add', function () {
    return view('test.add');
});
//测试列表展示
Route::any('/test/test_list', function () {
    return view('test.test_list');
});
//测试编辑展示
Route::any('/test/update', function () {
    return view('test.update');
});
//资源控制器 接口测试
Route::resource('api/user','api\UserController');//用户测试资源控制器
//周测商品添加接口
Route::any('/goods/add', function () {
    return view('api.goods.add');
});
//商品展示
Route::any('/goods/index', function () {
    return view('api.goods.index');
});
//天气查询展示页
Route::any('/goods/weather', function () {
    return view('api.goods.weather');
});
Route::any('/api/weather','api\GoodsController@weather');//天气查询接口
Route::resource('api/goods','api\GoodsController');//商品添加资源控制器接口

Route::prefix('api/hadmin')->middleware('apiheader')->group(function () {
    Route::resource('new','hadmin\IndexController');//商品添加资源控制器接口
    Route::get('details','hadmin\IndexController@details');//前台商品详情页
    Route::get('goods_show','hadmin\IndexController@goods_show');//前台商品列表页
    Route::get('login','hadmin\UserController@login');//前台登录接口
    Route::get('get_user','hadmin\UserController@getUser');//前台传token 后台验证token
    Route::get('test','hadmin\UserController@test');//签名接口测试
    Route::middleware('tokenlogin')->group(function () {
        Route::get('goods_cart_add', 'hadmin\IndexController@GoodsCartAdd');//购物车接口
        Route::get('cart_list', 'hadmin\IndexController@cart_list');//购物车列表
    });
});

//微信添加接口
//Route::any('/api/test/add','api\TestController@test_add');//添加接口测试
//Route::any('/api/test/show','api\TestController@show');//查询接口
//Route::any('/api/test/find','api\TestController@find');//修改接口 查询默认值
//Route::any('/api/test/upd','api\TestController@upd');//执行修改接口
//Route::any('/api/test/delete','api\TestController@delete');//执行删除接口
/**
 * api项目后台
 */
Route::get('hadmin/cate_add','hadmin\CateController@cate_add');//商品分类添加
Route::post('hadmin/cate_do','hadmin\CateController@cate_do');//商品分类添加执行
Route::get('hadmin/cate_only','hadmin\CateController@cate_only');//商品分类唯一
Route::get('hadmin/cate_list','hadmin\CateController@cate_list');//商品分类列表
Route::get('hadmin/type_add','hadmin\TypeController@type_add');//商品类型添加
Route::post('hadmin/type_do','hadmin\TypeController@type_do');//商品类型添加执行
Route::get('hadmin/type_list','hadmin\TypeController@type_list');//商品类型列表
Route::get('hadmin/attr_add','hadmin\AttrController@attr_add');//商品属性添加
Route::post('hadmin/attr_do','hadmin\AttrController@attr_do');//商品属性添加
Route::get('hadmin/attr_list','hadmin\AttrController@attr_list');//商品属性列表
Route::get('hadmin/delall','hadmin\AttrController@delall');//商品属性批量删除
Route::get('hadmin/type_search','hadmin\AttrController@type_search');//根据商品类型进行搜索
Route::get('hadmin/goods_add','hadmin\GoodsController@goods_add');//商品添加
Route::get('hadmin/goods_getattr','hadmin\GoodsController@goods_getattr');//根据商品类型查询类型下的属性
Route::post('hadmin/goods_do','hadmin\GoodsController@goods_do');//商品添加执行
Route::get('hadmin/goods_list','hadmin\GoodsController@goods_list');//商品列表展示
Route::get('hadmin/goods_name_change','hadmin\GoodsController@goods_name_change');//商品名称即点即改
Route::get('hadmin/sku_add','hadmin\GoodsController@sku_add');//商品货品添加
Route::post('hadmin/sku_do','hadmin\GoodsController@sku_do');//商品货品添加执行


//api
Route::get('hadmin/login','hadmin\LoginController@login');//登录页
Route::get('hadmin/send','hadmin\LoginController@send');//接收验证码
Route::get('hadmin/index','hadmin\AdminController@index');//后台主页
Route::get('hadmin/binding','hadmin\LoginController@binding');//绑定账号
Route::any('hadmin/binding_do','hadmin\LoginController@binding_do');//绑定账号执行页
Route::post('hadmin/do_login','hadmin\LoginController@do_login');//登录执行页
Route::get('hadmin/scanning','hadmin\LoginController@scanning');//微信扫码登录
Route::get('hadmin/scanning_do','hadmin\LoginController@scanning_do');//微信扫码跳转页 网页授权
Route::get('hadmin/checkwechatlogin','hadmin\LoginController@checkwechatlogin');//js轮询检测，如果检测到用户扫码，则停止定时器并跳转


//微信
Route::get('wechat/tag_list','wechat\TagController@tag_list');//微信标签管理
Route::get('wechat/add_tag','wechat\TagController@add_tag');//微信标签添加
Route::post('wechat/do_add_tag','wechat\TagController@do_add_tag');//执行标签添加
Route::get('wechat/del_tag/{id}','wechat\TagController@del_tag');//微信标签删除
Route::get('wechat/upd_tag/{id}/{name}','wechat\TagController@upd_tag');//标签修改表单页
Route::post('wechat/do_upd_tag/{id}','wechat\TagController@do_upd_tag');//标签修改执行
Route::get('wechat/tag_fans_list','wechat\TagController@tag_fans_list');//获取标签下的粉丝列表
Route::post('wechat/tag_openid','wechat\TagController@tag_openid');//批量给用户打标签
Route::get('wechat/tag_user_list','wechat\TagController@tag_user_list');//获取粉丝下的标签列表
Route::get('wechat/push_tag_message','wechat\TagController@push_tag_message');//微信根据标签进行消息推送
Route::post('wechat/do_push_tag_message','wechat\TagController@do_push_tag_message');//执行根据标签进行消息推送
Route::get('wechat/tag_fans_list','wechat\TagController@tag_fans_list');//获取标签下粉丝列表

//19-08月考测试题 微信签到领积分
Route::get('sign/sign','wechat\EventController@sign');//微信签到

Route::get('wechat/menu','wechat\MenuController@menu');//自定义菜单 根据数据库表数据来刷新菜单
Route::get('wechat/menu_list','wechat\MenuController@menu_list');//自定义菜单添加/列表
Route::post('wechat/create_menu','wechat\MenuController@create_menu');//添加执行页
Route::get('wechat/menu_del','wechat\MenuController@menu_del');//菜单删除
Route::get('wechat/location','wechat\WechatController@location');//JS-SDK签名

//微信群发消息
Route::get('message/login','wechat\MessageController@login');//群发留言登录页
Route::get('message/do_login','wechat\MessageController@do_login');//进行微信登录执行页
Route::get('/message/code','wechat\MessageController@code');//接收code
Route::get('message/user_list','wechat\MessageController@user_list');//留言列表 我的粉丝列表
Route::post('message/message','wechat\MessageController@message');//留言内容填写页
Route::post('message/message_do','wechat\MessageController@message_do');//群发留言执行页面
//Route::prefix('message')->middleware('checklogin')->group(function () {
//    Route::get('dcoe','wechat\MessageController@code');//接收code
//    Route::get('user_list','wechat\MessageController@user_list');//留言列表 我的粉丝列表
//    Route::post('message','wechat\MessageController@message');//留言内容填写页
//});
//Route::group(['middleware' => ['checklogin']], function () {
//    Route::get('/message/user_list','wechat\MessageController@user_list');//留言列表 我的粉丝列表
//    Route::post('message/message','wechat\MessageController@message');//留言内容填写页
//});

//2019-9-21作业
Route::get('work/login','wechat\WorkController@login');//微信登录表单页
Route::get('work/login_do','wechat\WorkController@login_do');//调用微信登录接口方法 获取code
Route::get('work/code','wechat\WorkController@code');//接收code码
Route::get('work/user','wechat\WorkController@user');//获取用户列表
Route::get('work/add_tag','wechat\WorkController@add_tag');//创建标签表单页
Route::post('work/tag_do','wechat\WorkController@tag_do');//标签添加执行
Route::get('work/tag_list','wechat\WorkController@tag_list');//标签列表
Route::post('work/user_tag','wechat\WorkController@user_tag');//给用户打标签
Route::get('work/news','wechat\WorkController@news');//根据标签跟用户进行群发消息
Route::post('work/do_news','wechat\WorkController@do_news');//发送消息执行方法

//生成专二维码
Route::get('agent/agent_list','wechat\AgentController@agent_list');//用户列表
Route::get('agent/create_qrcode','wechat\AgentController@create_qrcode');//获取专属二维码
// 获取微信粉丝 下载素材
Route::get('wechat/get_access_token','wechat\WechatController@get_access_token');
Route::get('wechat/get_wechat_access_token','wechat\WechatController@get_wechat_access_token');//获取access_token
Route::get('wechat/get_user_list','wechat\WechatController@get_user_list');//获取粉丝列表
Route::get('wechat/get_user_info/{openid}','wechat\WechatController@get_user_info');//根据openID获取粉丝详细信息
Route::get('wechat/upload_list','wechat\WechatController@upload_list');
Route::get('wechat/clear_api','wechat\WechatController@clear_api');//清空调用频次
Route::get('wechat/material','wechat\WechatController@material');//下载素材
Route::get('wechat/push_template_message','wechat\WechatController@push_template_message');//微信模板消息推送


//路由分组 路由前缀 首页
Route::prefix('admin')->group(function () {
    Route::get('index','admin\IndexController@index');
    Route::get('head','admin\IndexController@head')->name('head');
    Route::get('left','admin\IndexController@left')->name('left');
    Route::get('main','admin\IndexController@main')->name('main');
    });

//管理员
Route::get('admin/user_add','admin\IndexController@user_add')->name('user_add');
//及点即该
Route::get('chanceshow','admin\IndexController@chanceshow')->name('chanceshow');
Route::post('admin/user_do','admin\IndexController@user_do')->name('user_do');
Route::get('admin/upd/{id}','admin\IndexController@upd');
Route::post('admin/update/{id}','admin\IndexController@update');


//商品品牌添加
Route::prefix('brand')->group(function () {
    //唯一性验证
    Route::get('changeonly','admin\BrandController@changeonly');
    Route::get('brand_add','admin\BrandController@brand_add')->name('brand_add');
    Route::post('brand_do','admin\BrandController@brand_do')->name('brand_do');
    Route::get('brand_list','admin\BrandController@brand_list')->name('brand_list');
    Route::get('upd/{id}','admin\BrandController@upd');
    Route::post('update/{id}','admin\BrandController@update');
});

//商品分类添加
Route::prefix('cate')->group(function () {
    Route::get('cate_add','admin\CateColtroller@cate_add')->name('cate_add');
    Route::post('cate_do','admin\CateColtroller@cate_do')->name('cate_do');
    Route::get('cate_list','admin\CateColtroller@cate_list')->name('cate_list');
    Route::get('delete/{id}','admin\CateColtroller@delete');
    Route::post('changename','admin\CateColtroller@changename');
});

//商品添加
Route::prefix('goods')->group(function () {
    Route::get('goods_add','admin\GoodsController@goods_add')->name('goods_add');
    Route::post('goods_do','admin\GoodsController@goods_do')->name('goods_do');
    Route::get('goods_list','admin\GoodsController@goods_list')->name('goods_list');
    Route::get('upd/{id}','admin\GoodsController@upd');
    Route::post('update/{id}','admin\GoodsController@update');
    Route::post('changeonly','admin\GoodsController@changeonly');
});
// Route::get('cookie/add', function () {
//         $minutes = 24 * 60;
//         return response('欢迎来到 Laravel 学院')->cookie('name', '学院君', $minutes);
//     });
//     Route::get('cookie/get', function(\Illuminate\Http\Request $request) {
//         $cookie = $request->cookie('name');
//         dd($cookie);
//     });

//发送邮件
Route::get('mail','MailController@sendemail');
Auth::routes();

//laravel框架自带登陆
Route::get('/home', 'HomeController@index')->name('home');

//考试试题 链接管理  分组路由
Route::prefix('web')->middleware('auth')->group(function () {
    Route::get('web_add','WebColtroller@web_add')->name('web_add');
    //唯一性
    Route::get('chenkonly','WebColtroller@chenkonly')->name('chenkonly');
    Route::post('web_do','WebColtroller@web_do')->name('web_do');
    Route::get('web_list','WebColtroller@web_list')->name('web_list');
    Route::get('delete','WebColtroller@delete');
    Route::get('upd/{id}','WebColtroller@upd');
    Route::post('update/{id}','WebColtroller@update');
});
//前台首页
Route::get('/','index\IndexController@index');
//前台登录页
Route::prefix('index')->group(function(){
    Route::get('login','index\LoginController@login');
    Route::post('login_do','index\LoginController@login_do')->name('login_do');
    Route::get('regist','index\LoginController@regist');
    Route::get('email','index\LoginController@email');
    Route::post('regist_do','index\LoginController@regist_do')->name('regist_do');
    Route::get('prolist','index\IndexController@prolist');
    // 根据分类展示商品
    Route::get('catlist/{id}','index\IndexController@catlist');
    Route::get('proinfo/{id}','index\IndexController@proinfo');
    Route::get('car','index\CarController@car');
    // 购物车列表展示
    Route::get('carlist','index\CarController@carlist');
});

Route::get('wechat/login','wechat\LonginController@login');
Route::get('wechat/wechat_login','wechat\LonginController@wechat_login');
Route::get('wechat/code','wechat\LonginController@code');
Route::get('wechat/upload','wechat\WechatController@upload');
Route::post('wechat/do_upload','wechat\WechatController@do_upload');


// 展示学生信息
Route::get('/student/index','StudentController@index');

// 处理添加学生信息
Route::post('/student/do_add','StudentController@do_add');

// 修改学生信息
Route::get('/student/update','StudentController@update');
Route::post('/student/do_update','StudentController@do_update');

// 删除学生信息
Route::get('/student/delete','StudentController@delete');

// 登陆
// Route::get('/student/login','StudentController@login');
// Route::post('/student/do_login','StudentController@do_login');


// 注册
// Route::get('/student/register','StudentController@register');
// Route::get('/student/do_register','StudentController@do_register');

// 添加商品
Route::get('/admin/add_goods','admin\GoodsController@add_goods');
Route::post('/admin/do_add_goods','admin\GoodsController@do_add_goods');

// 登陆
Route::get('/admin/login','admin\LoginController@login');
Route::post('/admin/do_login','admin\LoginController@do_login');

// 注册
Route::get('/admin/register','admin\LoginController@register');
Route::post('/admin/do_register','admin\loginController@do_register');


// 调用中间件
Route::group(['middleware'=>['login']],function(){
	// 展示添加学生信息表单
	Route::get('/student/add','StudentController@add');
});
