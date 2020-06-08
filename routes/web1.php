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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
// Route::get('/index','index\LoginController@showlogin');
Route::prefix('/index')->group(function () {
	Route::get('/register','Index\RegisterController@showregister')->name("index.register");
	Route::post('/register','Index\RegisterController@register');

    Route::get('/login', 'Index\LoginController@showlogin')->name('index.login');
    Route::post('/login', 'Index\LoginController@login');

    Route::get('/home', 'Index\HomeController@home');
    //退出登录
    Route::get('/loginout', 'Index\HomeController@loginout')->name('index.loginout');

    Route::get('/resetpassword', 'Index\ResetPasswordController@showresetpassword');
    Route::post('/resetpassword', 'Index\ResetPasswordController@resetpassword');//发送重置密码链接
    Route::get('/resetpwd','Index\ResetPasswordController@showresetpwd');
    Route::post('/resetpwd','Index\ResetPasswordController@resetpwd');//重置密码

    //发布博客
    Route::get('/publish','Index\PublishController@showpublish');
    Route::post('/publish','Index\PublishController@publish');

    //博客详情页
    Route::get('/detail','Index\DetailController@detail');
});
