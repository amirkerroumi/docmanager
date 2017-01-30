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

Route::get('/', function () {
    return view('index');
});

Route::get('/login', 'DocManagerAuth\LoginController@form');
Route::post('/login', 'DocManagerAuth\LoginController@authenticate');

Route::get('/register', 'DocManagerAuth\RegisterController@form');
Route::post('/register', 'DocManagerAuth\RegisterController@register');

Route::get('/password/reset', function () {
    return view('docmanagerauth.passwords.reset');
});

Route::post('/password/reset', 'DocManagerAuth\ResetPasswordController@sendEmail');

Route::group(['middleware' => 'docmanager_auth'], function(){

    Route::get('/home', 'HomeController@index');
});


