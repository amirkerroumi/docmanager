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
    return redirect('/login');
});

Route::get('/login', function () {
    return view('auth.login');
});

Route::post('/login', 'DocManagerAuth\LoginController@authenticate');

Route::get('/register', function () {
    return view('auth.register');
});

Route::get('/password/reset', function () {
    return view('auth.passwords.reset');
});

Route::group(['middleware' => 'docmanager_auth'], function(){

    Route::get('/home', 'HomeController@index');
});


