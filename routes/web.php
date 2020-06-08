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

Route::get('/','Index\HomeController@home');

// Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
// Route::get('/index','index\LoginController@showlogin');
Route::prefix('/index')->group(function () {
	Route::get('/register','Index\RegisterController@showregister')->name("index.register");
	Route::post('/register','Index\RegisterController@register');

    Route::get('/login', 'Index\LoginController@showlogin')->name('index.login');
    Route::post('/login', 'Index\LoginController@login');

    Route::get('/home', 'Index\HomeController@home')->name('index.home')->middleware('checkpwdupdate');
    //退出登录
    Route::get('/loginout', 'Index\HomeController@loginout')->name('index.loginout');

    Route::get('/resetpassword', 'Index\ResetPasswordController@showresetpassword')->name('index.resetpassword');
    Route::post('/resetpassword', 'Index\ResetPasswordController@resetpassword');//发送重置密码链接
    Route::get('/resetpwd','Index\ResetPasswordController@showresetpwd');
    Route::post('/resetpwd','Index\ResetPasswordController@resetpwd');//重置密码

    //博客详情页
    Route::get('/detail','Index\DetailController@detail');
    Route::get('/detail/{content_id}/zan','Index\DetailController@zan')->middleware('checklogin');
    Route::get('/detail/{content_id}/unzan','Index\DetailController@unzan')->middleware('checklogin');
    Route::post('/addcomment','Index\DetailController@addcomment')->middleware('checklogin');

});

Route::group(['prefix' => 'index','middleware' => ['auth.login','singlesignon','checkpwdupdate']],function ()
{
    # code...
    //发布博客
    Route::get('/publish','Index\PublishController@showpublish');
    Route::post('/publish','Index\PublishController@publish');


    //文章管理
    Route::get('/personal','Index\PersonalController@showpersonal')->name('index.personal');
    Route::get('/personal1','Index\PersonalController@find_result')->name('index.find');
    Route::post('/delete','Index\PersonalController@delete_article')->name('index.delete');

    //个人中心
    Route::get('/mycenter','Index\MycenterController@index');
    Route::post('/uploadimg','Index\MycenterController@uploadimg')->name('index.uploadimg');

    //修改文章
    Route::get('/edit','Index\EditController@edit')->name('index.edit');
    Route::post('/edit','Index\EditController@update')->name('index.update');

    // //查找文章
    // Route::get('/find','Index\PersonalController@find_article')->name('index.find');
});
    


Route::group(['prefix' => 'admin'],function ()
{
    # code...
    Route::get('/login','Admin\LoginController@index');
    Route::post('/login','Admin\LoginController@login')->name('admin.login');
    Route::get('/loginout','Admin\LoginController@loginout')->name('admin.loginout');
});

Route::group(['prefix' => 'admin','middleware' => ['auth:admin','singlelogin']],function ()
{
    # code...
    // Route::get('/login','Admin\LoginController@index');
    // Route::post('/login','Admin\LoginController@login')->name('admin.login');
    // Route::get('/loginout','Admin\LoginController@loginout')->name('admin.loginout');
    Route::get('/index','Admin\HomeController@index')->name('admin.index');
    Route::get('/index1','Admin\HomeController@find_result')->name('admin.find');
    Route::post('/delete','Admin\HomeController@delete_article')->name('admin.delete');
    //修改文章
    Route::get('/edit','Admin\HomeController@edit')->name('admin.edit');
    Route::post('/edit','Admin\HomeController@update')->name('admin.update');

    Route::get('/user','Admin\UserController@index')->name('admin.user');
    Route::get('/user1','Admin\UserController@find')->name('admin.finduser');
    Route::post('/deluser','Admin\UserController@delete')->name('admin.deleteuser');
    Route::post('/deluser1','Admin\UserController@delete1')->name('admin.deleteuser1');
    Route::get('/admininfo','Admin\UserController@admininfo')->name('admin.admininfo');
});

