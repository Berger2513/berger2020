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

Route::prefix('admin')->group(function () {

    Route::post('goods/add','Admin\GoodsController@store' );
    Route::post('image/upload','Admin\GoodsController@upload' );
    Route::post('category/store','Admin\CategoryController@store' );
    Route::post('category/list','Admin\CategoryController@list' );
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


