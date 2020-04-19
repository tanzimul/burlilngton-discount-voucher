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

Route::get('/', 'Member\MemberController@index')->name('main');
Route::post('/store-member', 'Member\MemberController@store')->name('member.store');
Route::get('/reprint-voucher', 'Member\MemberController@reprint')->name('reprint');

//Auth::routes(['register' => false]);
//Route::get('staff-login')->name('login')->uses('Auth\LoginController@showLoginForm');
Auth::routes();
//Route::get('/home', 'HomeController@index')->name('home');

Route::get('/admin', 'Admin\AdminController@index')->name('admin')->middleware('admin');
Route::get('/staff', 'Staff\StaffController@index')->name('staff')->middleware('staff');
