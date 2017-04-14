<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', 'StaticPagesController@home')->name('home');
Route::get('/help', 'StaticPagesController@help')->name('help');
Route::get('/about', 'StaticPagesController@about')->name('about');

Route::get('signup','UsersController@create')->name('signup');

resource('users','UsersController');
// 以上代码等同于
// 显示所有用户列表的页面
// get('/users','UsersController@index')->name('users.index');
// 显示用户个人信息的页面
// get('/users/{id}','UsersController@show')->name('users.show');
// 创建用户的页面
// get('/users/create','UsersController@create')->name('users.create');
// 创建用户
// post('/users','UsersController@store')->name('users.store');
// 编辑用户个人资料的页面
// get('/users/{id}/edit','UsersController@edit')->name('users.edit');
// 更新用户
// patch('/users/{id}','UsersController@update')->name('users.update');
// 删除用户
// delete('/users/{id}','UsersController@destroy')->name('users.destroy');

// 登录
// 显示登录页面
get('login','SessionsController@create')->name('login');
// 创建新会话（登录）
post('login','SessionsController@store')->name('login');
// 销毁会话（退出登录）
delete('logout','SessionsController@destroy')->name('logout');

get('signup/comfirm/{token}','UsersController@confirmEmail')->name('confirm_email');

// 显示重置密码的邮箱发送页面
get('password/email','Auth\PasswordController@getEmail')->name('password.reset');
// 处理重置密码的邮箱发送操作
post('password/email','Auth\PasswordController@postEmail')->name('password.reset');
// 显示重置密码的密码更新页面
get('password/reset/{token}','Auth\PasswordController@getReset')->name('password.edit');
// 显示重置密码的密码更新请求
post('password/reset','Auth\PasswordController@postReset')->name('password.update');

resource('statuses','StatusesController',['only' => ['store', 'destroy']]);
//post('/statuses','StatusesController@store'); 处理创建创建微博的请求
//delete('/statuses','StatusesController@destroy');　处理删除微博的请求

// ［关注的人］列表　和　［粉丝］列表
get('/users/{id}/followings','UsersController@followings')->name('users.followings');
get('/users/{id}/followers','UsersController@followers')->name('users.followers');

// 关注用户
post('/users/followers/{id}','FollowersController@store')->name('followers.store');
// 取消关注用户
delete('/users/followers/{id}','FollowersController@destroy')->name('followers.destroy');
