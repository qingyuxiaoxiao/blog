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
//后台登录录音
Route::get('admin/login','Admin\LoginController@login');
//验证码路由
//Route::get('admin/code','Admin\LoginController@code');
//Route::post('dologin','Admin\LoginController@doLogin');
//Route::get('loginout','Home\LoginController@loginOut');
//Route::get('admin/jiami','Admin\LoginController@jiami');
Route::group(['prefix'=>'admin','namespace'=>'Admin'],function(){
//后台登录路由
    Route::get('login','LoginController@login');
//验证码路由
    Route::get('code','LoginController@code');
//处理后台登录的路由
    Route::post('dologin','LoginController@doLogin');

//加密算法
    Route::get('jiami','LoginController@jiami');
});