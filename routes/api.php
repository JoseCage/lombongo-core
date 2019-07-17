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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'auth', 'namespace' => 'Auth'], function ($auth) {
    $auth->post('/register', 'AuthController@register')->name('register');
    $auth->post('/login', 'AuthController@login')->name('login');
    $auth->middleware('auth.jwt')->patch('/me', 'AuthController@update')->name('user.update');
    $auth->middleware('auth.jwt')->get('/me', 'AuthController@getUser')->name('userinfo');

});
