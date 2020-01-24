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

Route::group(['namespace' => 'Auth'], function ($auth) {
    $auth->post('/register', 'AuthController@register')->name('register');
    $auth->post('/login', 'AuthController@login')->name('login');
    $auth->middleware('auth.jwt')->patch('/me', 'AuthController@update')->name('user.update');
    $auth->middleware('auth.jwt')->get('/me', 'AuthController@getUser')->name('userinfo');

});

// Categories
Route::group(['prefix' => 'categories', 'namespace' => 'API', 'middleware' => 'auth'], function($category) {
  $category->get('/', 'CategoryController@index');
  //$category->post('/', 'CategoryController@createCategory');
});
// Banks
Route::group(['prefix' => 'banks', 'namespace' => 'API', 'middleware' => 'auth'], function($category) {
  $category->get('/', 'BankController@index');
});

// User routes
Route::group(['prefix' => 'me', 'namespace' => 'API', 'middleware' => 'auth'], function($user) {
  $user->group(['prefix' => 'accounts'], function($account) {
    $account->get('/', 'BankAccountController@index')->name('me.accounts');
  });
});
