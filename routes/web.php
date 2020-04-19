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

Route::get('/', 'Client\ClientController@index')->name('main');
Route::get('/reprint-voucher', 'Client\ClientController@reprint')->name('reprint');

//Auth::routes(['register' => false]);
//Route::get('staff-login')->name('login')->uses('Auth\LoginController@showLoginForm');
Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
