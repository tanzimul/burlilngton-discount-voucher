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

Route::redirect('/home', '/', 301);
Auth::routes(['register' => false]);

Route::get('/admin', 'Admin\AdminController@index')->name('admin')->middleware('admin');
Route::get('/report', 'Admin\AdminController@report')->name('report')->middleware('admin');
Route::post('/export', 'Admin\AdminController@export')->name('export')->middleware('admin');

Route::get('/user-management', 'Admin\AdminController@index')->name('user.management')->middleware('admin');
Route::get('/user-create', 'Admin\AdminController@create')->name('user.create')->middleware('admin');
Route::post('/user-store', 'Admin\AdminController@store')->name('user.store')->middleware('admin');
Route::post('/user-delete/{id}', 'Admin\AdminController@delete')->name('user.delete')->middleware('admin');

Route::get('/redemption', 'Staff\StaffController@index')->name('staff.show')->middleware('admin');
Route::post('/submit-discount', 'Staff\StaffController@submitDiscount')->name('staff.redeem.discount');
Route::post('/submit-record', 'Staff\StaffController@submitRecord')->name('staff.customer.record');
Route::get('/search-user', 'Staff\StaffController@searchUser')->name('staff.user.discount');

Route::get('/watch-out', function() {
    Artisan::call('key:generate');
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('route:clear');
    Artisan::call('view:clear');
    Artisan::call('optimize:clear');
    //Artisan::call('migrate:fresh --seed');
    return "All cleared";
});
