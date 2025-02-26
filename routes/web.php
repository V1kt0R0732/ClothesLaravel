<?php

use Illuminate\Support\Facades\Route;

//Route::get('/', function () {
//    return view('welcome');
//});

Route::get('/','App\Http\Controllers\ClothesController@index')->name('home');
Route::get('/admin/home','App\Http\Controllers\ClothesController@adminHome')->name('admin.home');

Route::resource('admin/category','App\Http\Controllers\CategoryController');
Route::resource('admin/color','App\Http\Controllers\ColorController');
Route::resource('admin/material','App\Http\Controllers\MaterialController');
Route::resource('admin/season','App\Http\Controllers\SeasonController');
Route::resource('admin/size','App\Http\Controllers\SizeController');
