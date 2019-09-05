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
<<<<<<< HEAD
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
=======


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
>>>>>>> 79b07ba82916356e67e2497fa465680e99d306b0
