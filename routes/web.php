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
Route::get('/', 'StaticPagesController@home')->name('home');
Route::get('/help', 'StaticPagesController@help')->name('help');
Route::get('/about', 'StaticPagesController@about')->name('about');

Route::get('/signup/confirm/{token}', 'UserController@confirmEmail')->name('confirm_email');
Route::get('/singup', 'UserController@create')->name('signup');

//Route::resource('users', 'UserController');
Route::get('/users', 'UserController@index')->name('users.index');
Route::get('/users/create', 'UserController@create')->name('users.create');
Route::get('/users/{user}', 'UserController@show')->name('users.show');
Route::post('/users', 'UserController@store')->name('users.store');
Route::get('/users/{user}/edit', 'UserController@edit')->name('users.edit');
Route::patch('/users/{user}', 'UserController@update')->name('users.update');
Route::delete('/users/{user}', 'UserController@destroy')->name('users.destroy');

Route::get('login', 'SessionsController@create')->name('login');
Route::post('login', 'SessionsController@store')->name('login');
Route::delete('logout', 'SessionsController@destroy')->name('logout');

Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset','Auth\ResetPasswordController@reset')->name('password.update');


