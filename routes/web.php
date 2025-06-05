<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AuthorizationCheck;

//Route::get('/', function () {
//    return view('welcome');
//});

Route::get('/','App\Http\Controllers\ClothesController@index')->name('home');
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
Route::post('admin/storage/photo','App\Http\Controllers\StorageController@photoDestroy')->name('storage.photoDestroy')->middleware(AuthorizationCheck::class);
Route::get('/admin/register/form','App\Http\Controllers\UserController@showRegistrationForm')->name('admin.registerForm')->middleware(AuthorizationCheck::class);
Route::post('/admin/register','App\Http\Controllers\UserController@register')->name('admin.register')->middleware(AuthorizationCheck::class);
Route::get('/admin/register', function () {
    return redirect('admin.loginForm')->with('error', 'Access Denied');
});
Route::get('/admin/list','App\Http\Controllers\UserController@list')->name('admin.list')->middleware(AuthorizationCheck::class);
Route::get('/admin/login/form','App\Http\Controllers\UserController@showLoginForm')->name('admin.loginForm');
Route::post('/admin/login','App\Http\Controllers\UserController@login')->name('admin.login');
Route::get('/admin/login', function () {
    return redirect('admin.loginForm')->with('error', 'Access Denied');
});
Route::get('/admin/user/index','App\Http\Controllers\UserController@index')->name('admin.index')->middleware(AuthorizationCheck::class);
Route::get('/admin/user/logout','App\Http\Controllers\UserController@logout')->name('admin.logout')->middleware(AuthorizationCheck::class);
Route::post('/admin/user/edit','App\Http\Controllers\UserController@edit')->name('admin.edit')->middleware(AuthorizationCheck::class);
Route::get('/admin/edit', function () {
    return redirect('admin.loginForm')->with('error', 'Access Denied');
});
