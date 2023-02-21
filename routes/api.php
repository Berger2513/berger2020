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
//pc首页
Route::post('/home/index', 'HomeController@index')->name('home');
//pc 分类页面
Route::post('/home/category', 'HomeController@category');
// pc 活动页面
Route::post('/home/activity', 'HomeController@activity');

//专题 page
Route::post('/topic/detail', 'TopicController@detail');
/** goods */
Route::post('/goods/detail', 'GoodsController@detail');
Route::post('/user/detail', 'UserController@detail');
Route::post('/user/collect_goods', 'UserController@collect_goods');
Route::post('/user/cancle_collect_goods', 'UserController@cancle_collect_goods');


/**
 * 卡片管理
 */
Route::post('/card/bind', 'HomeController@bind');
Route::post('/card/card_add', 'HomeController@card_add');
Route::post('/card/card_detail', 'HomeController@card_detail');
Route::post('/card/identity', 'HomeController@card_identity');
Route::post('/card/identity_read', 'HomeController@card_identity_read');
//pc nfc卡片观看和编辑
Route::post('/card/action', 'CardController@action');
Route::post('/card/resource_upload', 'CardController@resource_upload');
Route::post('/card/resource_single_upload', 'CardController@resource_single_upload');
Route::post('/card/resource_delete', 'CardController@resource_delete');
Route::post('/card/get_enable_status', 'CardController@get_enable_status');
Route::post('/card/detail', 'CardController@detail');
Route::post('/card/get_code_status', 'CardController@get_code_status');

//微信回调
Route::post('/common/weixin_callback', 'CommonController@weixin_callback');
Route::get('/common/weixin', 'CommonController@weixin');
Route::post('common/get_user_by_token', 'CommonController@get_user_by_token');

//admin端接口
Route::post('/admin/login', 'Admin\UserController@login');
Route::post('/admin/login_check', 'Admin\UserController@login_check');

Route::post('admin/nfc/add','Admin\NfcController@add' );

Route::post('admin/nfc/detail','Admin\NfcController@detail' );

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
    //    页面配置
    Route::post('admin/page/update','Admin\PageController@update' );
    Route::post('admin/page/detail','Admin\PageController@detail' );
    Route::post('admin/page/banner_detail','Admin\PageController@banner_detail' );
    Route::post('admin/page/banner_update','Admin\PageController@banner_update' );
    //    nfc
    Route::post('admin/nfc/wirte_resource','Admin\NfcController@wirte_resource' );
    Route::post('admin/nfc/list','Admin\NfcController@list' );
    Route::post('admin/nfc/card_vfx_add','Admin\NfcController@card_vfx_add' );
    Route::post('admin/nfc/card_vfx_list','Admin\NfcController@card_vfx_list' );
    Route::post('admin/nfc/card_vfx_del','Admin\NfcController@card_vfx_del' );
    Route::post('admin/nfc/card_vfx_detial','Admin\NfcController@card_vfx_detial' );

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


