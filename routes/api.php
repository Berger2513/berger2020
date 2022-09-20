<?php

use Illuminate\Http\Request;

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

//admin-登录
Route::post('/admin/login', 'Admin\UserController@login');

Route::prefix('admin')->group(function () {


    Route::post('goods/add','Admin\GoodsController@store' );
    Route::post('image/upload','Admin\GoodsController@upload' );
});

Route::group(['middleware' => ['auth.api']], function () {
    Route::post('/getUser', function () {
        var_dump( Auth::guard('api')->user()->name);exit;
    });
});


