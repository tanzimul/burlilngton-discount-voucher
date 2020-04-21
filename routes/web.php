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
Route::get('/reprint', 'Member\MemberController@reprint')->name('reprint');
Route::post('/reprint-voucher', 'Member\MemberController@reprintVoucher')->name('reprint.voucher');


//Auth::routes(['register' => false]);
//Route::get('staff-login')->name('login')->uses('Auth\LoginController@showLoginForm');
Auth::routes();
//Route::get('/home', 'HomeController@index')->name('home');

Route::get('/admin', 'Admin\AdminController@index')->name('admin')->middleware('admin');
Route::get('/report', 'Admin\AdminController@report')->name('report')->middleware('admin');
Route::get('/daily-discount-and-customer-record-inquiry', 'Staff\StaffController@index')->name('staff.show')->middleware('admin');
Route::post('/submit-discount', 'Staff\StaffController@submitDiscount')->name('staff.redeem.discount');
Route::post('/submit-record', 'Staff\StaffController@submitRecord')->name('staff.customer.record');

