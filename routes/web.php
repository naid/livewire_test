<?php

// use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

//Route::livewire('/', 'home');
Route::get('/' , 'App\Http\Controllers\HomeController@index');
Route::get('/login' , 'App\Http\Controllers\LoginController@index');
