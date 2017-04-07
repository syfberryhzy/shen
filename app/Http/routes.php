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
