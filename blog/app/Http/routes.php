<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::group(['middleware' => ['web']], function () {
    Route::get('/', function () {
        return view('welcome');

    });
    /*测试数据库*/
    Route::any('admin/login','Admin\LoginController@login');
    Route::any('admin/crypt','Admin\LoginController@crypt');

});
Route::group(['middleware' => ['web','admin.login'],'prefix'=>'admin','namespace'=>'Admin'], function () {
    Route::get('main','MainController@index');
    Route::get('index','IndexController@index');
    Route::get('quite','LoginController@quite');
    Route::any('pass','IndexController@pass');
    Route::resource('category','CategoryController');//用一个路由控制一堆路由


});

