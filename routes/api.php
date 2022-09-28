<?php

use Illuminate\Http\Request;
use App\Events\PodcastProcessed;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/



//pc-登录
Route::post('/login', 'UserController@login');
//pc-注册
Route::post('/register', 'UserController@register');
Route::post('/image/del', 'GoodsController@image_del');
Route::post('/image/add', 'GoodsController@image_add');



//admin端接口
Route::post('/admin/login', 'Admin\UserController@login');

Route::group(['middleware' => ['admin.api']],function () {

    //    资源管理
    Route::post('admin/image/upload','Admin\ImageController@upload' );
    Route::post('admin/image/add','Admin\ImageController@add' );
    Route::post('admin/image/list','Admin\ImageController@list' );
    Route::post('admin/image/del','Admin\ImageController@del' );
    //    分类管理
    Route::post('admin/category/store','Admin\CategoryController@store' );
    Route::post('admin/category/update','Admin\CategoryController@update' );
    Route::post('admin/category/del','Admin\CategoryController@del' );
    Route::post('admin/category/list','Admin\CategoryController@list' );
    Route::post('admin/category/detail','Admin\CategoryController@detail' );
    Route::post('admin/category/show_action','Admin\CategoryController@show_action' );
    //    商品管理
    Route::post('admin/goods/store','Admin\GoodsController@store' );
    Route::post('admin/goods/update','Admin\GoodsController@update' );
    Route::post('admin/goods/del','Admin\GoodsController@del' );
    Route::post('admin/goods/list','Admin\GoodsController@list' );
    Route::post('admin/goods/detail','Admin\GoodsController@detail' );
    Route::post('admin/goods/show_action','Admin\GoodsController@show_action' );
    //    专题管理
    Route::post('admin/topic/add','Admin\TopicController@store' );
    Route::post('admin/topic/del','Admin\TopicController@del' );
    Route::post('admin/topic/list','Admin\TopicController@list' );
    Route::post('admin/topic/update','Admin\TopicController@update' );
    Route::post('admin/topic/detail','Admin\TopicController@detail' );
    //    活动
    Route::post('admin/activity/add','Admin\ActivityController@store' );
    Route::post('admin/activity/update','Admin\ActivityController@update' );
    Route::post('admin/activity/del','Admin\ActivityController@del' );
    Route::post('admin/activity/list','Admin\ActivityController@list' );
    Route::post('admin/activity/detail','Admin\ActivityController@detail' );
    Route::post('admin/activity/open_job','Admin\ActivityController@open_job' );
});

// 测试事件执行
Route::get('/event_test', function () {

    @PodcastProcessed::dispatch(\App\Models\User::find(1));
    return 'success~';
});




Route::group(['middleware' => ['auth.api']], function () {
    Route::post('/getUser', function () {
        var_dump( Auth::guard('api')->user()->name);exit;
    });
});


