<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AuthorizationCheck;
use App\Http\Middleware\PermissionCheck;
use App\Http\Controllers\Auth\GoogleController;



//Route::get('/', function () {
//    return view('welcome');
//});

Route::get('/admin/home','App\Http\Controllers\ClothesController@adminHome')->name('admin.home')->middleware(AuthorizationCheck::class);
Route::resource('admin/category','App\Http\Controllers\CategoryController')->middleware(AuthorizationCheck::class);
Route::resource('admin/color','App\Http\Controllers\ColorController')->middleware(AuthorizationCheck::class);
Route::resource('admin/material','App\Http\Controllers\MaterialController')->middleware(AuthorizationCheck::class);
Route::resource('admin/season','App\Http\Controllers\SeasonController')->middleware(AuthorizationCheck::class);
Route::resource('admin/size','App\Http\Controllers\SizeController')->middleware(AuthorizationCheck::class);
Route::resource('admin/supplier','App\Http\Controllers\SupplierController')->middleware(AuthorizationCheck::class);
Route::resource('admin/bodyshape','App\Http\Controllers\BodyShapeController')->middleware(AuthorizationCheck::class);
Route::resource('admin/clothes','App\Http\Controllers\ClothesController')->middleware(AuthorizationCheck::class);
Route::resource('admin/storage','App\Http\Controllers\StorageController')->middleware(AuthorizationCheck::class);
Route::post('admin/storage/deleteAll','App\Http\Controllers\StorageController@deleteAll')->name('storage.deleteAll')->middleware(AuthorizationCheck::class);
Route::post('admin/storage/photo','App\Http\Controllers\StorageController@photoDestroy')->name('storage.photoDestroy')->middleware(AuthorizationCheck::class);
Route::get('/admin/register/form','App\Http\Controllers\AdministratorController@showRegistrationForm')->name('admin.registerForm');//->middleware(AuthorizationCheck::class)->middleware(PermissionCheck::class);
Route::post('/admin/register','App\Http\Controllers\AdministratorController@register')->name('admin.register'); //->middleware(AuthorizationCheck::class)->middleware(PermissionCheck::class)
Route::get('/admin/register', function () {
    return redirect('admin.loginForm')->with('error', 'Access Denied');
});
Route::get('/admin/list','App\Http\Controllers\AdministratorController@list')->name('admin.list')->middleware(AuthorizationCheck::class);
Route::get('/admin/login/form','App\Http\Controllers\AdministratorController@showLoginForm')->name('admin.loginForm');
Route::post('/admin/login','App\Http\Controllers\AdministratorController@login')->name('admin.login');
Route::get('/admin/login', function () {
    return redirect('admin.loginForm')->with('error', 'Access Denied');
});
Route::get('/admin/user/index','App\Http\Controllers\AdministratorController@index')->name('admin.index')->middleware(AuthorizationCheck::class);
Route::get('/admin/user/logout','App\Http\Controllers\AdministratorController@logout')->name('admin.logout')->middleware(AuthorizationCheck::class);
Route::post('/admin/user/edit','App\Http\Controllers\AdministratorController@edit')->name('admin.edit')->middleware(AuthorizationCheck::class);
Route::get('/admin/edit', function () {
    return redirect('admin.loginForm')->with('error', 'Access Denied');
});
Route::post('/admin/user/changeId','App\Http\Controllers\AdministratorController@changeId')->name('admin.changeId')->middleware(AuthorizationCheck::class)->middleware(PermissionCheck::class);
Route::get('/admin/user/changeId', function () {
    return redirect('admin.loginForm')->with('error', 'Access Denied');
});
Route::delete('/admin/user/delete/{id}','App\Http\Controllers\AdministratorController@delete')->name('admin.delete')->middleware(AuthorizationCheck::class)->middleware(PermissionCheck::class);

Route::get('admin/orders','App\Http\Controllers\OrderController@admin_show_orders_list')->name('admin.orders.list')->middleware(AuthorizationCheck::class);
Route::get('admin/orders/{id}','App\Http\Controllers\OrderController@admin_show_order')->name('admin.orders.show')->middleware(AuthorizationCheck::class);
Route::get('admin/orders/archive/{id}','App\Http\Controllers\OrderController@admin_archive_order')->name('admin.orders.archive')->middleware(AuthorizationCheck::class);


// Початок Клієнтської частини

Route::get('/', 'App\Http\Controllers\HomeController@index')->name('home');
Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('home');
Route::get('/about', 'App\Http\Controllers\HomeController@about')->name('about');
Route::get('/contact', 'App\Http\Controllers\HomeController@contact')->name('contact');
Route::get('/catalog', 'App\Http\Controllers\HomeController@catalog')->name('catalog');

Route::get('/catalog/{id}/{photo_id}','App\Http\Controllers\HomeController@show')->name('catalog.show');

Auth::routes();

Route::get('/cabinet/main', 'App\Http\Controllers\Auth\UserController@index')->name('cabinet.main');
Route::get('/cabinet/settings', 'App\Http\Controllers\Auth\UserController@settings')->name('cabinet.settings');
Route::get('/cabinet/orders', 'App\Http\Controllers\Auth\UserController@orders')->name('cabinet.orders');
Route::post('/cabinet/edit', 'App\Http\Controllers\Auth\UserController@edit')->name('cabinet.edit');

Route::get('/auth/google/redirect', [GoogleController::class, 'redirect'])->name('google.auth');
Route::get('/auth/google/callback', [GoogleController::class, 'callback']);


Route::get('/basket', 'App\Http\Controllers\BasketController@index')->name('basket.index');
Route::post('/basket/add', 'App\Http\Controllers\BasketController@add')->name('basket.add');
Route::get('/basket/remove/{id}', 'App\Http\Controllers\BasketController@remove')->name('basket.remove');
Route::post('/basket/clear', 'App\Http\Controllers\BasketController@clear')->name('basket.clear');
Route::post('/basket/recalc', 'App\Http\Controllers\BasketController@recalc')->name('basket.recalc');

Route::get('/order', 'App\Http\Controllers\OrderController@index')->name('order.index');
Route::post('/order/add', 'App\Http\Controllers\OrderController@makeOrder')->name('order.add');
