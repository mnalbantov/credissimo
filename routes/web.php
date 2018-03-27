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



Route::get('/','ShopController@index')->name('home');
Route::get('/home','ShopController@index')->name('home');
Route::post('/home','ShopController@index')->name('home');
Route::post('review', 'ShopController@storeReview')->name('review.store');
Route::get('/products/{id}','ShopController@show')->name('show');
Route::get('/category/{id}','ShopController@category')->name('category');
Route::get('/login','Auth\LoginController@showLoginForm')->name('login');
Route::post('/login','Auth\LoginController@postLogin')->name('login');
Route::get('/register','Auth\RegisterController@showRegisterForm')->name('register');
Route::post('/register','Auth\RegisterController@create')->name('register');
Route::get('/password/reset','Auth\ResetPasswordController@showResetForm')->name('password.request');
Route::post ('/logout','Auth\LoginController@logout')->name('logout');

// all routes for admins only
Route::group(['middleware' => 'admin'],function(){
Route::get('/admin','Admin\HomeController@index')->name('admin.home');
Route::get ('/logout','Auth\LoginController@logout')->name('admin.logout');

Route::resource('admin/products','Admin\ProductController');


});
//Route::get('/home', 'HomeController@index')->name('home');
