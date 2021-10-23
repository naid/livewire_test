<?php

// use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

//Route::livewire('/', 'home');
Route::get('/' , 'App\Http\Controllers\HomeController@index');
Route::get('/home' , 'App\Http\Controllers\HomeController@index');
// Route::get('/login' , 'App\Http\Controllers\LoginController@index');
// Route::get('/logout' , 'App\Http\Controllers\LoginController@index');
Route::get('/user' , 'App\Http\Controllers\HomeController@users');

Auth::routes();

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
